<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hashids\Hashids;

use App\Http\Requests;
use App\Question;
use App\Test;
use App\Tag;
use Parsedown;
use App\Qtype;

class TestController extends Controller
{
    private $default_time;

    /**
     * TestController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        if (config('database.default') == 'pgsql') $this->default_time = "1000-01-01 00:00:00";
        else $this->default_time = "0000-00-00 00:00:00";
    }

    /**
     * show test.index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tags_all = Tag::all();
        $tags = null;
        
        foreach($tags_all as $tag)
        {
            if(count($tag->questions)!=0)
                $tags[$tag->id]=$tag->name;
        }

        return view('test.index', compact('tags'));
    }

    /**
     * 點擊確認答題後的操作，確定試卷上的題目，模型連結等。
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function prepare(Request $request)
    {
        //獲取表單中提交的答題數目以及測試方式。
        $tag_list = $request->get('tag_list');
        $testType = 0; // 1為照順序
        $totalNumber = $request->get('totalnumber');
        if ($totalNumber != 5 && $totalNumber != 10 && $totalNumber != 15 && $totalNumber != 20)
            $totalNumber = 10;
        //得到所有要答的題目的id號。
        $questionids = Test::generateQuestion($tag_list, $testType, $totalNumber);

        $totalNumber = count($questionids);//由於現在題量可能不夠，實際獲取的題目可能不是用戶設置的題目。
        $test = new Test;
        $test->user_id = $request->user()->id;
        $test->testtype = $testType;
        $test->totalnumber = $totalNumber;
        $test->tagtype = Tag::find($tag_list)->name;
        $test->save();
        foreach ($questionids as $q_id) {
            $question = Question::find($q_id);
            $test->questions()->attach($question);
        }
        $test->questionids = json_encode($questionids);
        $test->save();
        $hashids = new Hashids();
        return redirect("/test/".$hashids->encode($test->id)."/1");
    }

    /**
     * 顯示每一道題
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $test_id, $id)
    {
        $hashids = new Hashids();
        $test = Test::find($hashids->decode($test_id)[0]);
        if ($test->ended_at != $this->default_time || $request->user()->id != $test->user->id)
            return view('errors.404');
        $question_ids = json_decode($test->questionids, true);
        $parsedown = new Parsedown();
        $qtypes = Qtype::pluck('name', 'id')->toArray();
        $question = Question::find($question_ids[$id]);
        return view('test.show', array_merge($question->toArray(), ['total' => ($test->totalnumber), 'question_id' => $id, 'test_id' => $test_id, 'parsedown' => $parsedown, 'qtypes' => $qtypes]));
    }

    /**
     * 點擊next，保存當前結果，顯示下一題
     *
     * @param Request $request
     * @param $test_id
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function next(Request $request, $test_id, $id)
    {
        $hashids = new Hashids();
        $test = Test::find($hashids->decode($test_id)[0]);
        if ($test->ended_at != $this->default_time || $request->user()->id != $test->user->id)
            return view('errors.404');
        $questionids = json_decode($test->questionids, true);
        $totalNumber = $test->totalnumber;
        $useranswer = json_decode($test->useranswer, true);

        //多選的情況為了方便將陣列轉為json形式
        if ($request->qtype_id == 2)
            $useranswer[$questionids[$id]] = json_encode($request->get('answer'));
        else
            $useranswer[$questionids[$id]] = $request->get('answer');

        $test->useranswer = json_encode($useranswer);

        $test->save();
        if ($id == $totalNumber)   //達到最後一條了
            return redirect("test/$test_id/judge"); // 轉到判斷頁面
        else {
            $id = $id + 1;
            return redirect("test/$test_id/$id");
        }
    }

    /**
     * 判斷答題結果，計算分數並儲存
     *
     * @param $test_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function judge(Request $request, $test_id)
    {
        $hashids = new Hashids();
        $test = Test::find($hashids->decode($test_id)[0]);
        if ($test->ended_at != $this->default_time || $request->user()->id != $test->user->id)
            return view('errors.404');

        $test->ended_at = date("Y-m-d H:i:s");

        $total = $test->totalnumber;
        $questions = $test->questions();
        $referanswer = $questions->pluck('answer', 'id')->toArray();//獲取每道題的答案
        $qtypes = $questions->pluck('qtype_id', 'id')->toArray();//獲取每道題的類型
        $useranswer = json_decode($test->useranswer, true);//獲取每次測試的用戶答案
        $questionids = json_decode($test->questionids, true);//獲取題號

        $num = 0;

        //對每一道題目，根據不同的類型進行判斷
        foreach ($questionids as $q_id) {
            switch ($qtypes[$q_id]) {
                case 2://多選題
                    $ua = json_decode($useranswer[$q_id]);//獲取使用者答案的陣列
                    $ra = json_decode($referanswer[$q_id]);//獲取參考答案的陣列
                    $ur = array_diff($ua, $ra);
                    $ru = array_diff($ra, $ua);
                    if ($ur == [] && $ru == []) {//全答對得到全部的分數
                        $n = 1;
                        $answer[] = 1;
                    } elseif ($ur == [] && $ua != []) {//不全得一半
                        $answer[] = 0;
                        $n = 1 / 2;
                    } else {//答錯不得分
                        $answer[] = 0;
                        $n = 0;
                    }
                    $num = $num + $n;
                    break;
                case 4://填空題
                    $ua = str_replace(" ", "", $useranswer[$q_id]);//去掉所有的空格
                    $ra = str_replace(" ", "", $referanswer[$q_id]);

                    if (strcasecmp($ua, $ra) == 0) {
                        $num++;
                        $answer[] = 1;
                    } else {
                        $answer[] = 0;
                    }
                    break;

                case 5://簡答題
                    $num++;
                    $answer[] = 1;
                    break;
                default:    //單選題和判斷題，一樣的話是對的，否則答題錯誤
                    if ($useranswer[$q_id] == $referanswer[$q_id]) {
                        $num++;
                        $answer[] = 1;
                    } else
                        $answer[] = 0;
            }

        }
        $test->judges = json_encode($answer);
        $point = round((100 / $total) * $num);
        $test->point = $point;
        $test->save();
        return view('test.judge', compact('total', 'answer', 'point', 'test_id'));
    }

    /**
     * 用於顯示所有的錯題
     *
     * @param $test_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, $test_id)
    {
        return $this->detailBase($request,$test_id,'detail');
    }

    /**
     * 用於顯示所有的題目，包括正確的題目與錯誤的題目
     *
     * @param $test_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allDetail(Request $request,$test_id)
    {
        return $this->detailBase($request,$test_id,'alldetail');
    }

    /**
     * detial畫圖的基礎函數,顯示所有的錯題和顯示全部的題目僅是最後調用的範本不一樣，其餘都是一樣的。
     *
     * @param Request $request
     * @param $test_id
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function detailBase($request,$test_id,$type)
    {
        $parsedown = new Parsedown();
        $hashids = new Hashids();
        $test = Test::find($hashids->decode($test_id)[0]);

        if ($test->ended_at == $this->default_time || $request->user()->id != $test->user->id)
            return view('errors.404');
        $total = $test->totalnumber;
        $point = $test->point;
        $questions = $test->questions()->get()->toArray();

        $qid = array();
        foreach ($questions as $key => $row)
        {
            $qid[$key] = $row['id'];
        }
        array_multisort($qid, SORT_ASC, $questions);

        // dd($questions);
        $useranswer = json_decode($test->useranswer, true);
        $questionids = json_decode($test->questionids, true);
        $judges = json_decode($test->judges, true);
        return view("test.$type", compact('total', 'questions', 'useranswer', 'questionids', 'test_id', 'parsedown', 'point', 'judges'));

    }


}



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hashids\Hashids;
use App\Tag;

use App\Http\Requests;

class HistoryController extends Controller
{
    //
    /**
     * HistoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $usertests = $request->user()->tests();
        $tests = $this->history_api($request, $usertests);

        if($tests == "none")
        {
            flash()->warning("您還沒有進行測試");
            return redirect('/test');
        }

        $tags_all = Tag::all();
        foreach($tags_all as $key => $tag)
        {
            if(count($tag->questions) == 0)
                $tags_all->forget($key);
        }

        $tags_all = $tags_all->pluck('name');
        $testsavg = [];

        foreach($tags_all as $tag)
        {
            array_push( $testsavg, doubleval($request->user()->tests()->where('tagtype', $tag)->orderBy('id', 'desc')->take(10)->avg('point')));
        }

        $testsavg = json_encode($testsavg);
        // dd($tests);
        // dd($testsavg);

        return view('history.index',compact('tests', 'tags_all', 'testsavg'));
    }


    public function history_api(Request $request, $tests)
    {
        if ($request['tagtype'] != null)
            $tests = $tests->where('tagtype', $request['tagtype']);


        $tests = $tests->where('point','>',-1)->orderby('id','desc')->get(); // 只選取完整的測試。
        if(count($tests)==0) return "none";
        
        $tests = $tests->toArray();
        $hashids = new Hashids();

        foreach ($tests as $key => $test) {
            $tests[$key]['id'] = $hashids->encode($tests[$key]['id']);
            $tests[$key]['testtype'] = $tests[$key]['testtype']==0?"隨機":"順序";
            $tests[$key]['ended_at'] = gmdate("H:i:s",(strtotime($tests[$key]['ended_at'])-strtotime($tests[$key]['created_at'])));
            $tests[$key]['link'] = "<a class='text-muted' href='/test/".$tests[$key]['id']."/alldetails'>查看答題詳情</a>";
        }

        // dd($tests);
        // dd($taglist);
        return $tests;
    }

}



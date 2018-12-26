<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Question;

class Test extends Model
{
    //

    protected $guarded = ['id'];

    /**
     * 獲取該測試的用戶
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * 返回一張試卷對應的題目
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany('App\Question')->withTimestamps();
    }

    /**
     * 根據不同方式生成題目的id
     * @param int $tagList : 按照tag選擇題目範圍
     * @param int $testType :生成方式，0表示隨機，1表示順序
     * @param int $totalNumber ：題目數目,0預設為全部
     * @return array|mixed
     */
    public static function generateQuestion($tagList = 0, $testType = 0, $totalNumber = 5)
    {


        $tag=Tag::find($tagList);
        $question_all=$tag->questions->pluck('id','id')->toArray();//獲取當前的所有問題

        if($totalNumber==0||$totalNumber>count($question_all))
            $totalNumber=count($question_all);  //題量不能超過所有的限制，0時意味著取全部
        switch ($testType) {
            case 0:     //0表示隨機生成，array_rand函數只能對key隨機
                $question_ids = array_rand($question_all, $totalNumber);
                break;
            case 1:
                $question_ids = array_slice($question_all, 0, $totalNumber);//順序生成的話只需要截取前面的部分即可。
                break;
            default://其餘暫且默認為是隨機形式
                $question_ids = array_rand($question_all, $totalNumber);
                break;
        }
        $key = range(1, $totalNumber);
        asort($question_ids);
        return array_combine($key, $question_ids);//返回鍵值從1開始的關聯陣列

    }
}



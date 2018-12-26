<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable=['title','answer','useranswer','parse','options','qtype_id'];

    /**
     * 返回問題對應的標籤
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    /**
     * 返回問題對應的測試
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tests()
    {
        return $this->belongsToMany('App\Test')->withTimestamps();
    }

    /**
     * 返回問題的標籤
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qtype()
    {
        return $this->belongsTo('App\Qtype');
    }
}


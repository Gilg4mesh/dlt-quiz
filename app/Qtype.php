<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qtype extends Model
{
    /**
     * @var array
     */
    protected $fillable=['name'];

    
    /**
     * 返回問題類型對應的所有問題
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany('App\Question');
    }
}

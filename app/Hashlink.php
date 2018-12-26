<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hashlink extends Model
{
    //
    protected $fillable=['textbook_id', 'hashlink', 'orilink', 'click_time'];



    public function textbook()
    {
        return $this->belongsTo('App\Textbook');
    }
}

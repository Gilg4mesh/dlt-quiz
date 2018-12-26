<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Textbook extends Model
{
    //
    protected $fillable=['type','title','link'];



    public function hashlink()
    {
        return $this->hasOne('App\Hashlink');
    }
}

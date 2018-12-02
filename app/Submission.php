<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $guarded = [];

    public function form()
    {
        return $this->belongsTo('App\Form');
    }
}

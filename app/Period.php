<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model {

    protected $table = 'registry';
    protected $fillable = [
        'detail'
    ];
}

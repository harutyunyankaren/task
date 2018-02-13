<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HashedCity extends Model
{
    protected $table = 'hashed_cities';

    protected $fillable = ['hash'];

    public $timestamps = true;
}

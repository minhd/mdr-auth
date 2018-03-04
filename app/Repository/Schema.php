<?php

namespace MinhD\Repository;

use Illuminate\Database\Eloquent\Model;

class Schema extends Model
{
    public $fillable = ['title', 'description', 'shortcode', 'url'];
}

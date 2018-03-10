<?php

namespace MinhD\Repository;

use Illuminate\Database\Eloquent\Model;
use MinhD\User;
use MinhD\Uuids;

class DataSource extends Model
{
    use Uuids;

    public $incrementing = false;

    public $fillable = ['title', 'description', 'user_id'];

    protected $casts = [
        'meta' => 'array'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

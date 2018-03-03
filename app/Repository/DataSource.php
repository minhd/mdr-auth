<?php

namespace MinhD\Repository;

use Illuminate\Database\Eloquent\Model;
use MinhD\User;
use MinhD\Uuids;

class DataSource extends Model
{
    use Uuids;

    public $incrementing = false;

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

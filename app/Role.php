<?php

namespace MinhD;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_roles');
    }
}

<?php


namespace MinhD;

use Ramsey\Uuid\Uuid;

trait Uuids
{

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
}
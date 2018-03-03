<?php


namespace MinhD;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Uuid as Generator;

trait Uuids
{

    /**
     * Boot uuid trait.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! Generator::isValid($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Generator::uuid4()->toString();
            }
        });
    }
}
<?php

namespace MinhD\Repository;

use Illuminate\Database\Eloquent\Model;
use MinhD\Uuids;

class Version extends Model
{
    use Uuids;

    public $incrementing = false;
    public $fillable = ['status', 'data', 'meta'];

    const STATUS_CURRENT = 'current';
    const STATUS_SUPERSEDED = 'superseded';

    public function record()
    {
        return $this->belongsTo(Record::class, 'record_id');
    }

    public function getDataSourceAttribute()
    {
        return $this->record->datasource;
    }

    public function getOwnerAttribute()
    {
        return $this->datasource->owner;
    }
}

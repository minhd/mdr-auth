<?php

namespace MinhD\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MinhD\Uuids;

class Record extends Model
{
    use Uuids, SoftDeletes;

    public $incrementing = false;

    public $fillable = ['title', 'status', 'data_source_id'];
    protected $dates = ['deleted_at'];

    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';
    const STATUS_DELETED = 'deleted';

    public function datasource()
    {
        return $this->belongsTo(DataSource::class, 'data_source_id');
    }

    public function getOwnerAttribute()
    {
        return $this->datasource->owner;
    }

    public function versions()
    {
        return $this->hasMany(Version::class);
    }
}

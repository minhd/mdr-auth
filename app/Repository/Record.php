<?php

namespace MinhD\Repository;

use Illuminate\Database\Eloquent\Model;
use MinhD\Uuids;

class Record extends Model
{
    use Uuids;

    public $incrementing = false;

    public $fillable = ['title', 'status', 'data_source_id'];

    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';
    const STATUS_DELETED = 'deleted';

    public function datasource()
    {
        return $this->belongsTo(DataSource::class, 'data_source_id');
    }

    public function versions()
    {
        return $this->hasMany(Version::class);
    }
}

<?php

namespace MinhD\Repository;

use Illuminate\Database\Eloquent\Model;

class Schema extends Model
{
    public $fillable = ['title', 'description', 'shortcode', 'url'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function versions()
    {
        return $this->hasMany(SchemaVersion::class);
    }

    /**
     * @return SchemaVersion
     */
    public function currentVersion()
    {
        return $this->versions->filter(function(SchemaVersion $version){
            return $version->status === SchemaVersion::CURRENT;
        })->first();
    }

    /**
     * @return SchemaVersion
     */
    public function getCurrentVersionAttribute()
    {
        return $this->currentVersion();
    }
}

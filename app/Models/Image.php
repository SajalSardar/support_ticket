<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            Cache::forget("name_list");
        });

        static::updated(function () {
            Cache::forget("name_list");
        });
    }

    /**
     * Get all images associate with models
     * @return MorphTo
     */
    public function image(): MorphTo
    {
        return $this->morphTo('image', 'image_type', 'image_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Category extends Model {
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot() {
        parent::boot();

        static::created(function () {
            Cache::forget("category_list");
        });

        static::updated(function () {
            Cache::forget("category_list");
        });
    }

    /**
     * Define public method image
     * @return MorphTo
     */
    public function image(): MorphOne {
        return $this->morphOne(Image::class, 'image', 'image_type', 'image_id');
    }

    /**
     * Define public method ticket associate with category
     */
    public function ticket() {
        return $this->hasMany(Ticket::class, 'category_id', 'id');
    }

    /**
     * Define public method ticket() associate with category
     */
    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->whereNull('parent_id');
    }
    public function subCategory() {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}

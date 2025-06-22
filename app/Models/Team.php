<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            Cache::forget("team_list");
        });

        static::updated(function () {
            Cache::forget("team_list");
        });
    }

    /**
     * Define public method teamCategories()
     * @return BelongsToMany
     */
    public function teamCategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'team_categories');
    }

    /**
     * Get ticket associate with this model
     */
    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'category_id', 'id');
    }

    /**
     * Define public method image()
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'image', 'image_type', 'image_id');
    }

    /**
     * Define public method agents()
     * @return BelongsToMany
     */
    public function agents(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}

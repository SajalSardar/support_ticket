<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Conversation extends Model {
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot() {
        parent::boot();

        static::created(function () {
            Cache::forget("name_list");
        });

        static::updated(function () {
            Cache::forget("name_list");
        });
    }

    /**
     * Get conversation associate with parent as replay
     * @return HasMany
     */
    public function replay(): HasMany {
        return $this->hasMany(Conversation::class, "parent_id");
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}

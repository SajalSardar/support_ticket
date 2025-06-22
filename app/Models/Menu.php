<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Menu extends Model {
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected static function boot() {
        parent::boot();

        static::created(function () {
            Cache::forget("menu_list");
        });

        static::updated(function () {
            Cache::forget("menu_list");
        });
    }

    public function submneus() {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->whereNotNull('parent_id');
    }

}

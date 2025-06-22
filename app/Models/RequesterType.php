<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequesterType extends Model {
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot() {
        parent::boot();

        static::created( function () {
            Cache::forget( "requesterType_list" );
        } );

        static::updated( function () {
            Cache::forget( "requesterType_list" );
        } );
    }
}

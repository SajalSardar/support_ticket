<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class TicketStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            Cache::forget("ticketStatus_list");
        });

        static::updated(function () {
            Cache::forget("ticketStatus_list");
        });
    }

    /**
     * Define public method ticket() associate with TicketStatus
     */
    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'ticket_status_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Ticket extends Model {
    use HasFactory, SoftDeletes;
    protected $casts = [
        'due_date'    => 'date',
        'resolved_at' => 'datetime',
    ];

    protected $guarded = ['id'];

    protected static function boot() {
        parent::boot();

        static::created(function () {
            Cache::forget("ticket_" . Auth::id() . "_list");
        });

        static::updated(function () {
            Cache::forget("ticket_" . Auth::id() . "_list");
        });
        static::created(function () {
            Cache::forget("unassign_" . Auth::id() . "_ticket_list");
        });
        static::updated(function () {
            Cache::forget("unassign_" . Auth::id() . "_ticket_list");
        });
        static::created(function () {
            Cache::forget("status_" . Auth::id() . "_ticket_list");
        });
        static::updated(function () {
            Cache::forget("status_" . Auth::id() . "_ticket_list");
        });
    }

    /**
     * Define public method team() associate with Ticket
     * @return BelongsTo
     */
    public function team(): BelongsTo {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    /**
     * Define public method category() associate with Ticket
     * @return BelongsTo
     */
    public function category(): BelongsTo {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function sub_category(): BelongsTo {
        return $this->belongsTo(Category::class, 'sub_category_id', 'id');
    }

    /**
     * Define public method team() associate with Ticket
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Define public method ticket_status() associate with Ticket
     * @return BelongsTo
     */
    public function ticket_status(): BelongsTo {
        return $this->belongsTo(TicketStatus::class, 'ticket_status_id', 'id');
    }

    /**
     * Define public method requester_type() associate with Ticket
     * @return BelongsTo
     */
    public function source(): BelongsTo {
        return $this->belongsTo(Source::class, 'source_id', 'id');
    }

    /**
     * Define public method image()
     * @return MorphOne
     */
    public function image(): MorphOne {
        return $this->morphOne(Image::class, 'image', 'image_type', 'image_id');
    }

    /**
     * Define public method images()
     * @return MorphMany
     */
    public function images(): MorphMany {
        return $this->morphMany(Image::class, 'image', 'image_type', 'image_id');
    }

    /**
     * Define public method owners()
     * @return BelongsToMany
     */
    public function owners(): BelongsToMany {
        return $this->belongsToMany(User::class, 'ticket_ownerships', 'ticket_id', 'owner_id')->withTimestamps();
    }

    /**
     * Define public method ticket_note()
     * @return HasOne
     */
    public function ticket_note(): HasOne {
        return $this->hasOne(TicketNote::class, 'ticket_id', 'id')->latest();
    }

    /**
     * Define public method ticket_notes()
     * @return HasMany
     */
    public function ticket_notes(): HasMany {
        return $this->hasMany(TicketNote::class, 'ticket_id', 'id');
    }
    public function ticket_logs(): HasMany {
        return $this->hasMany(TicketLog::class, 'ticket_id', 'id');
    }

    public function conversation() {
        return $this->hasMany(Conversation::class, 'ticket_id', 'id');
    }
    public function department() {
        return $this->belongsTo(Department::class);
    }
}

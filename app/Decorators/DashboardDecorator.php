<?php

namespace App\Decorators;

use App\Models\Category;
use App\Models\Team;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardDecorator
{
    /**
     * Get all the chart collection
     * @return Collection
     */
    public static function chart(): Collection
    {
        $resource = DB::table('tickets')->select('priority', DB::raw('count(*) as total'))->groupBy('priority')->get();
        $ttlCount = $resource->map(fn($i) => $i->total)->sum();
        return $resource->map(function ($item) use ($ttlCount) {
            $color = match ($item->priority) {
                'low'    => '#10B981',
                'medium' => '#3B82F6',
                'high'   => '#EF4444',
                default  => 'orange'
            };

            return (object) [
                'value' => (int) number_format(round($item->total / $ttlCount * 100), 2),
                'color' => $color,
                'title' => ucfirst($item->priority),
            ];
        })->toBase();
    }

    /**
     * Get all the state collection
     * @return Collection
     */
    public static function state()
    {
        if (Auth::user()->hasRole(['requester', 'Requester'])) {
            return TicketStatus::withCount(['ticket as count' => function ($query) {
                $query->where('user_id', Auth::id());
            }])->get();
        } else {
            return DB::table('ticket_statuses as status')
                ->leftJoin('tickets as ticket', 'status.id', '=', 'ticket.ticket_status_id')
                ->select(DB::raw('count(ticket.id) as count, status.name'))
                ->groupBy('status.name')
                ->get();
        }
    }

    /**
     * Get all the traffic collection
     * @return Collection
     */
    public static function traffic(): Collection
    {
        $resource = User::query()
            ->withCount('requester_tickets')
            ->orderBy('requester_tickets_count', 'desc')
            ->limit(5)
            ->get();
        return $resource->map(fn($user) => [
            'name'  => $user->name,
            'total' => $user->requester_tickets_count,
        ])->toBase();
    }

    /**
     * Get all the agents collection
     * @return Collection
     */
    public static function agents()
    {
        $resource = User::query()
            ->withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->limit(5)
            ->get();
        return $resource->map(fn($user) => [
            'name'  => $user->name,
            'total' => $user->tickets_count,
        ])->toBase();
    }

    /**
     * Get all the categories collection
     * @return Collection
     */
    public static function categories()
    {
        $resource = Category::query()
            ->withCount('ticket')
            ->orderBy('ticket_count', 'desc')
            ->limit(5)
            ->get();

        return $resource->map(fn($user) => [
            'name'  => $user->name,
            'total' => $user->ticket_count,
        ])->toBase();
    }

    /**
     * Get all the teams collection
     * @return Collection
     */
    public static function teams()
    {
        $resource = Team::query()
            ->withCount('ticket')
            ->orderBy('ticket_count', 'desc')
            ->limit(5)
            ->get();

        return $resource->map(fn($user) => [
            'name'  => $user->name,
            'total' => $user->ticket_count,
        ])->toBase();
    }
}

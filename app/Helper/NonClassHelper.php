<?php

use App\Models\Ticket;
use App\Models\TicketNote;
use App\Models\TicketStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

function ISOdate($date)
{
    return $date ? date('M d, Y', strtotime($date)) : '';
}

function dayMonthYearHourMinuteSecond($date, $endDate = null)
{
    $startDate = Carbon::create($date);
    $endDate = $endDate ? Carbon::create($endDate) : Carbon::now();

    $y   = (int) $startDate->diffInYears($endDate);
    $mon = (int) $startDate->copy()->addYears($y)->diffInMonths($endDate);
    $d   = (int) $startDate->copy()->addYears($y)->addMonths($mon)->diffInDays($endDate);
    $h   = (int) $startDate->copy()->addYears($y)->addMonths($mon)->addDays($d)->diffInHours($endDate);
    $m   = (int) $startDate->copy()->addYears($y)->addMonths($mon)->addDays($d)->addHours($h)->diffInMinutes($endDate);
    $s   = (int) $startDate->copy()->addYears($y)->addMonths($mon)->addDays($d)->addHours($h)->addMinutes($m)->diffInSeconds($endDate);

    $output = [];

    if ($y > 0) {
        $output[] = $y . ' ' . ($y > 1 ? 'years' : 'year');
    }
    if ($mon > 0) {
        $output[] = $mon . ' ' . ($mon > 1 ? 'months' : 'month');
    }
    if ($d > 0) {
        $output[] = $d . ' ' . ($d > 1 ? 'days' : 'day');
    }
    if ($h > 0) {
        $output[] = $h . ' ' . ($h > 1 ? 'hours' : 'hour');
    }
    if ($m > 0) {
        $output[] = $m . ' ' . ($m > 1 ? 'mins' : 'min');
    }

    if (count($output) > 3) {
        $output = array_slice($output, 0, 3);
    }

    return implode(', ', $output);
}


/**
 * Define method for get a string to camelCase
 * @param string $string
 * @return string
 */
function camelCase($string): string
{
    $string = str_replace(
        ' ',
        ' ',
        ucwords(str_replace(
            ['-', '_'],
            ' ',
            $string
        ))
    );

    return $string;
}

function ID(?string $prefix, ?string $id)
{
    return '#' . $prefix . str_pad(string: $id, length: 2, pad_string: '0', pad_type: STR_PAD_LEFT);
}

function getTicketStatusById($id)
{
    $ticketStatus = TicketStatus::where('id', $id)->first();
    if ($ticketStatus) {

        return $ticketStatus;
    }
    return false;
}

function ticketOpenProgressHoldPermission($ticket_status_id)
{
    $ticketStatus = TicketStatus::where('id', $ticket_status_id)->first();
    return $ticketStatus->slug == 'open' || $ticketStatus->slug == 'in-progress' || $ticketStatus->slug == 'on-hold' ? true : false;
}

function getTicketNotsNotify()
{
    $query = TicketNote::query()->where('view_notification', 0)->whereNotIn('note_type', ['internal_note']);
    if (Auth::user()->hasRole(['requester', 'Requester'])) {
        $ticketId = Ticket::where('user_id', Auth::id())->pluck('id');
        $query->whereIn('ticket_id', $ticketId);
    }
    if (Auth::user()->hasRole(['agent', 'Agent'])) {
        $userTeamIds = User::find(Auth::id())->teams->pluck('id');
        $ticketId    = Ticket::whereIn('team_id', $userTeamIds)->pluck('id');
        $query->whereIn('ticket_id', $userTeamIds);
    }
    $ticketNotifyNotes = $query->orderBy('id', 'desc')->get();

    return $ticketNotifyNotes;
}

function avatar(?string $name, ?string $width = '30', ?string $height = '30'): string
{
    $colors = [
        ['letter' => '#9D0009', 'bg' => 'rgba(157, 0, 9, 0.2)'],
        ['letter' => '#E60029', 'bg' => 'rgba(230, 0, 41, 0.2)'],
        ['letter' => '#F27700', 'bg' => 'rgba(242, 119, 0, 0.2)'],
        ['letter' => '#FFA304', 'bg' => 'rgba(255, 163, 4, 0.2)'],
        ['letter' => '#FEDA00', 'bg' => 'rgba(254, 218, 0, 0.2)'],
        ['letter' => '#9E4352', 'bg' => 'rgba(158, 67, 82, 0.2)'],
        ['letter' => '#843C6E', 'bg' => 'rgba(132, 60, 110, 0.2)'],
        ['letter' => '#636CC9', 'bg' => 'rgba(99, 108, 201, 0.2)'],
        ['letter' => '#4590D3', 'bg' => 'rgba(69, 144, 211, 0.2)'],
        ['letter' => '#00EBFC', 'bg' => 'rgba(0, 235, 252, 0.2)'],
        ['letter' => '#006FE5', 'bg' => 'rgba(0, 111, 229, 0.2)'],
        ['letter' => '#6e77d2', 'bg' => 'rgba(110, 119, 210, 0.2)'],
        ['letter' => '#5700DB', 'bg' => 'rgba(87, 0, 219, 0.2)'],
        ['letter' => '#704000', 'bg' => 'rgba(112, 64, 0, 0.2)'],
        ['letter' => '#00556A', 'bg' => 'rgba(0, 85, 106, 0.2)'],
        ['letter' => '#408300', 'bg' => 'rgba(64, 131, 0, 0.2)'],
        ['letter' => '#88387F', 'bg' => 'rgba(136, 56, 127, 0.2)'],
        ['letter' => '#8701DE', 'bg' => 'rgba(135, 1, 222, 0.2)'],
        ['letter' => '#8B5474', 'bg' => 'rgba(139, 84, 116, 0.2)'],
        ['letter' => '#FF590D', 'bg' => 'rgba(255, 89, 13, 0.2)'],
        ['letter' => '#74457F', 'bg' => 'rgba(116, 69, 127, 0.2)'],
        ['letter' => '#62000D', 'bg' => 'rgba(98, 0, 13, 0.2)'],
        ['letter' => '#99ADA0', 'bg' => 'rgba(153, 173, 160, 0.2)'],
        ['letter' => '#BDB900', 'bg' => 'rgba(189, 185, 0, 0.2)'],
        ['letter' => '#E4D900', 'bg' => 'rgba(228, 217, 0, 0.2)'],
        ['letter' => '#9AE100', 'bg' => 'rgba(154, 225, 0, 0.2)'],
    ];
    $color = $colors[array_rand($colors)];

    return "<div class='flex justify-center items-center text-sm' style='width: {$height}px; height: {$height}px; border-radius: 50%; background: {$color['bg']}; color: {$color['letter']}; border: 1px solid #ddd;'>" . ucfirst(substr($name, 0, 1)) . "</div>";
}

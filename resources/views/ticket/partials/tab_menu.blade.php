<div>
    <ul class="flex justify-between md:justify-between sm:justify-center flex-wrap overflow-hidden items-center bg-[#F3F4F6]">
        <div class="flex lg:gap-10 md:gap-5 sm:gap-0 justify-between">
            <li id="homeTab" class="tab !text-primary-400 text-detail-heading py-3 lg:px-5 md:px-3 sm:px-2 border-b-2 border-primary-400 cursor-pointer">
                Details
            </li>
            <li id="settingTab" class="tab text-detail-heading py-3 lg:px-5 md:px-3 sm:px-2 border-b-2 border-transparent cursor-pointer">
                Conversations
            </li>
            <li id="profileTab" class="tab text-detail-heading py-3 lg:px-5 md:px-3 sm:px-2 border-b-2 border-transparent cursor-pointer">
                History
            </li>
        </div>

        <div class="flex lg:gap-10 md:gap-5 sm:gap-0">
            @if (!Auth::user()->hasRole(['requester', 'Requester']) && ticketOpenProgressHoldPermission($ticket->ticket_status_id))
            <li id="requesterTab" class="tab text-detail-heading py-3 lg:px-5 md:px-3 sm:px-2 border-b-2 border-transparent cursor-pointer" x-on:click="$dispatch('open-offcanvas-requester')">
                Add New Requester
            </li>
            <li id="editTab" class="tab text-detail-heading py-3 lg:px-5 md:px-3 sm:px-2 border-b-2 border-transparent cursor-pointer" x-on:click="$dispatch('open-offcanvas-request')">
                Edit Details
            </li>
            @endif
        </div>
    </ul>

    <div id="homeContent" class="tab-content">
        <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 sm:gap-3 md:gap-32 lg:gap-32 my-8">
            <div class="lg:col-span-2 md:col-span-2">
                @include('ticket/partials/details')
                @if (!Auth::user()->hasRole(['requester', 'Requester']))
                @include('ticket/partials/internal_note')
                @endif
            </div>
            @if (!Auth::user()->hasRole(['requester', 'Requester']))
            <div class="lg:col-span-1 md:col-span-1 sm:col-span-1">
                @include('ticket/partials/sidebar_form')
            </div>
            @endif
        </div>
    </div>
    <div id="settingContent" class="tab-content hidden">
        @include('ticket/partials/conversation')
    </div>
    <div id="profileContent" class="tab-content hidden">
        @include('ticket/partials/history')
    </div>
    <div id="requesterContent" class="tab-content hidden">
        <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 sm:gap-3 md:gap-32 lg:gap-32 my-8">
            <div class="lg:col-span-2 md:col-span-2">
                @include('ticket/partials/details')
                @if (!Auth::user()->hasRole(['requester', 'Requester']))
                @include('ticket/partials/internal_note')
                @endif
            </div>
            @if (!Auth::user()->hasRole(['requester', 'Requester']))
            <div class="lg:col-span-1 md:col-span-1 sm:col-span-1">
                @include('ticket/partials/sidebar_form')
            </div>
            @endif
        </div>
    </div>
    <div id="editContent" class="tab-content hidden">
        <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 sm:gap-3 md:gap-32 lg:gap-32 my-8">
            <div class="lg:col-span-2 md:col-span-2">
                @include('ticket/partials/details')
                @if (!Auth::user()->hasRole(['requester', 'Requester']))
                @include('ticket/partials/internal_note')
                @endif
            </div>
            @if (!Auth::user()->hasRole(['requester', 'Requester']))
            <div class="lg:col-span-1 md:col-span-1 sm:col-span-1">
                @include('ticket/partials/sidebar_form')
            </div>
            @endif
        </div>
    </div>
</div>
<div class="navbar sticky border z-10 border-b-base-500">
    <div class="grid lg:grid-cols-12 md:grid-cols-12 sm:grid-cols-12">
        <div class="grid lg:grid-cols-12 md:grid-cols-12 sm:grid-cols-12 lg:col-span-11 md:col-span-11 sm:col-span-11 sm:gap-5">
            <div class="hamberger lg:col-span-1 md:col-span-2 sm:col-span-2">
                <button type="button" class="text-lg text-gray-900 font-semibold sidebar-toggle">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 5H14" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M4 12H20" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M4 19H20" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            {{-- <div class="lg:col-span-5 md:col-span-6 sm:col-span-6 lg:-ml-10 md:-ml-10 sm:ml-5">
                <x-forms.text-input-icon dir="start" class="text-paragraph" placeholder="Search menu..">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#5E666E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M20.9999 21.0004L16.6499 16.6504" stroke="#5E666E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </x-forms.text-input-icon>
            </div> --}}
        </div>

        <div class="flex lg:col-span-1 gap-6 items-center justify-end mr-6">
            <div class="relative cursor-pointer mr-2 toggle-notification-button">
                <svg width="24" height="24" class="sm:w-5 sm:h-5 md:w-6 md:h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 8C18 6.4087 17.3679 4.88258 16.2426 3.75736C15.1174 2.63214 13.5913 2 12 2C10.4087 2 8.88258 2.63214 7.75736 3.75736C6.63214 4.88258 6 6.4087 6 8C6 15 3 17 3 17H21C21 17 18 15 18 8Z" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13.73 21C13.5542 21.3031 13.3019 21.5547 12.9982 21.7295C12.6946 21.9044 12.3504 21.9965 12 21.9965C11.6496 21.9965 11.3054 21.9044 11.0018 21.7295C10.6982 21.5547 10.4458 21.3031 10.27 21" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="md:w-5 md:h-5 sm:w-4 sm:h-4 bg-[#ef4444] rounded-full text-center text-white text-xs absolute -top-2 -end-2">
                    {{ getTicketNotsNotify()->count() }}
                    <div class="absolute top-0 start-0 rounded-full -z-10 bg-[#ef4444] w-full h-full"></div>
                </div>

                <div class="toggle-notification-box absolute w-96 h-96 bg-white border border-slate-300 rounded shadow top-12 right-0 sm:-right-10 overflow-auto" style="display: none">

                    @forelse (getTicketNotsNotify()->take(30) as $item)
                    <a href="{{ route('admin.ticket.show', [$item->ticket_id, 'notify_id' => $item->id]) }}">

                        <div class="p-4 flex items-center hover:bg-slate-200">
                            @php
                            echo avatar($item->note_type, 30, 30)
                            @endphp
                            <div class="ml-4">
                                @php
                                $replaceString = str_replace('_', " ", $item->note_type)
                                @endphp
                                <p class="text-heading-dark">{{ Str::ucfirst($replaceString) }}</p>
                                <p class="text-paragraph">{{ ($item->note_type === 'request_assigned' ? 'REQ' . $item->ticket_id : '') }} {!! $item->note !!}</p>
                                <p class="text-caption">{{ date('l h:i:a d M, Y', strtotime($item->created_at)) }}</p>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="p-4 flex items-center hover:bg-slate-200">
                        <div class="ml-4">
                            <p>Notification not found!</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="relative">
                <div class="toggle-menu-button flex gap-1 items-center cursor-pointer">
                    <img src="{{ Auth::user()->image?->url ? Auth::user()->image?->url : asset('assets/images/profile.png') }}" alt="profile" width="38" width="38" style="border-radius: 50%">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="toggle-menu absolute p-3 shadow w-[180px] rounded bg-white sm:right-12 z-50" style="top: 46px;display:none">
                    <ul class="px-3">
                        <li class="py-2 cursor-pointer flex items-center gap-2">
                            @php
                            echo avatar(name: Auth::user()->name, width: 24, height: 24);
                            @endphp
                            <p href="#" class="text-title">
                                {{ Auth::user()->name }}
                            </p>
                        </li>
                        <li class="py-2 cursor-pointer flex items-center gap-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="#5E666E" stroke-width="1.5" />
                                <path d="M14.75 9.5C14.75 11.0188 13.5188 12.25 12 12.25C10.4812 12.25 9.25 11.0188 9.25 9.5C9.25 7.98122 10.4812 6.75 12 6.75C13.5188 6.75 14.75 7.98122 14.75 9.5Z" stroke="#5E666E" stroke-width="1.5" />
                                <path d="M5.5 19L6.0604 18.0193C6.95061 16.4615 8.60733 15.5 10.4017 15.5H13.5984C15.3927 15.5 17.0494 16.4615 17.9396 18.0193L18.5 19" stroke="#5E666E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <a href="{{ route('profile.edit') }}" class="text-title">Profile</a>
                        </li>
                        <li class="py-2 cursor-pointer flex items-center gap-2">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M16 17L21 12L16 7" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M21 12H9" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-transparent text-title">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /**
     * Define method changeLanguage to change the local language
     * @param lang 
     */
    function changeLanguage(lang) {
        window.location.href = "{{ url('locale') }}/" + lang;
    }
</script>
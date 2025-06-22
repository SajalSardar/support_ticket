<x-app-layout>

    @if (Route::is('admin.ticket.list.active.memode'))
    @section('title', 'My Request List')
    @include('ticket.breadcrumb.index', ['value' => 'Requests Assigned to Me'])
    @elseif(request()->has('request_status'))
    @section('title', Str::ucfirst(request()->get('request_status')) . ' Requests')
    @include('ticket.breadcrumb.index', ['value' => Str::ucfirst(request()->get('request_status')) . ' Requests'])
    @else
    @section('title', 'All Request List')
    @include('ticket.breadcrumb.index', ['value' => 'All Requests'])
    @endif

    <div class="lg:flex md:flex lg:justify-between md:justify-between lg:items-center md:items-center">
        <div class="flex flex-wrap lg:gap-3 md:gap-2 sm:gap-3 lg:justify-end md:justify-end sm:justify-start">
            <div style="width: 265px;">
                <input type="hidden" id="me_mode_search" value="{{ Route::is('admin.ticket.list.active.memode') ? 'me_mode' : '' }}">
                <x-forms.text-input-icon dir="start" id="ticket_id_search" class="text-paragraph" placeholder="Search Request ID or Requester">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#5E666E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M20.9999 21.0004L16.6499 16.6504" stroke="#5E666E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </x-forms.text-input-icon>
            </div>
            <div style="width:106px" class="relative" x-data="{ priority: '' }">
                <div>
                    <div style="width: 100%;" class="relative custom-select">
                        <div>
                            <div class="selected" data-placeholder="Priority">Priority</div>
                            <input type="hidden" id="priority_search" name="priority_search" value="">
                            <div class="options">
                                <div class="option" data-value="low">Low</div>
                                <div class="option" data-value="medium">Medium</div>
                                <div class="option" data-value="high">High</div>
                            </div>
                        </div>
                        <div class="absolute top-[50%] translate-y-[-50%] -right-5">
                            <svg class="text-[#5e666e] ri-arrow-down-s-line ml-auto group-[.selected]:rotate-90 mr-[24px]" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 9L12 15L18 9" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </div>
                <span x-show="priority" class="absolute top-1 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base" tabindex="0" style="display: block;" @click="priority = '';$nextTick(() => $('#priority_search').trigger('change'))">✕</span>
            </div>
            <div style="width:110px" class="relative" x-data="{ status: '' }">
                <div style="width: 100%;" class="relative custom-select">
                    <div>
                        <div class="selected" data-placeholder="Status">Status</div>
                        <input type="hidden" id="status_search" name="status_search" value="">
                        <div class="options">
                            @foreach ($ticketStatus as $item)
                            <div class="option" data-value="{{ $item->id }}">{{ $item->name }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="absolute top-[50%] translate-y-[-50%] -right-5">
                        <svg class="text-[#5e666e] ri-arrow-down-s-line ml-auto group-[.selected]:rotate-90 mr-[24px]" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9L12 15L18 9" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <span x-show="status" class="absolute top-1 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base" tabindex="0" style="display: block;" @click="status = '';$nextTick(() => $('#status_search').trigger('change'))">✕</span>
            </div>
            <div style="width:175px" class="relative" x-data="{ category: '' }">
                <div style="width: 100%;" class="relative custom-select">
                    <div>
                        <div class="selected" data-placeholder="Category">Category</div>
                        <input type="hidden" id="category_search" name="category_search" value="">
                        <div class="options">
                            @foreach ($categories as $item)
                            <div class="option" data-value="{{ $item->id }}">{{ $item->name }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="absolute top-[50%] translate-y-[-50%] -right-5">
                        <svg class="text-[#5e666e] ri-arrow-down-s-line ml-auto group-[.selected]:rotate-90 mr-[24px]" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9L12 15L18 9" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <span x-show="category" class="absolute top-1 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base" tabindex="0" style="display: block;" @click="category = '';$nextTick(() => $('#category_search').trigger('change'))">✕</span>
            </div>
            <div style="width:150px" class="relative" x-data="{ department: '' }">
                <div style="width: 100%;" class="relative custom-select">
                    <div>
                        <div class="selected" data-placeholder="Department">Department</div>
                        <input type="hidden" id="department_search" name="department_search" value="">
                        <div class="options">
                            @foreach ($departments as $item)
                            <div class="option" data-value="{{ $item->id }}">{{ $item->name }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="absolute top-[50%] translate-y-[-50%] -right-5">
                        <svg class="text-[#5e666e] ri-arrow-down-s-line ml-auto group-[.selected]:rotate-90 mr-[24px]" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9L12 15L18 9" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <span x-show="department" class="absolute top-1 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base" tabindex="0" style="display: block;" @click="team = '';$nextTick(() => $('#team_search').trigger('change'))">✕</span>
            </div>
            <div style="width:120px" class="relative" x-data="{ team: '' }">
                <div style="width: 100%;" class="relative custom-select">
                    <div>
                        <div class="selected" data-placeholder="Team">Team</div>
                        <input type="hidden" id="team_search" name="team_search" value="">
                        <div class="options">
                            @foreach ($teams as $item)
                            <div class="option" data-value="{{ $item->id }}">{{ $item->name }}</div>
                            @endforeach
                        </div>
                    </div>

                    <div class="absolute top-[50%] translate-y-[-50%] -right-5">
                        <svg class="text-[#5e666e] ri-arrow-down-s-line ml-auto group-[.selected]:rotate-90 mr-[24px]" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9L12 15L18 9" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <span x-show="team" class="absolute top-1 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base" tabindex="0" style="display: block;" @click="team = '';$nextTick(() => $('#team_search').trigger('change'))">✕</span>
            </div>
            <div style="width:120px" class="relative" x-data="{ due_date_x: '' }">
                <div style="width: 100%;" class="relative custom-select">
                    <div>
                        <div class="selected" data-placeholder="Due Date">Due Date</div>
                        <input type="hidden" id="due_date_search" name="due_date_search" value="">
                        <div class="options">
                            <div class="option" data-value="today">Today</div>
                            <div class="option" data-value="tomorrow">Tomorrow</div>
                            <div class="option" data-value="this_week">This Week</div>
                            <div class="option" data-value="this_month">This Month</div>
                        </div>
                    </div>
                    <div class="absolute top-[50%] translate-y-[-50%] -right-5">
                        <svg class="text-[#5e666e] ri-arrow-down-s-line ml-auto group-[.selected]:rotate-90 mr-[24px]" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9L12 15L18 9" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <span x-show="due_date_x" class="absolute top-1 end-9 text-surface cursor-pointer focus:text-primary outline-none dark:text-white text-base" tabindex="0" style="display: block;" @click="due_date_x = '';$nextTick(() => $('#due_date_search').trigger('change'))">✕</span>
            </div>
            <div>
                <x-buttons.secondary id="resetButton">Reset All</x-buttons.secondary>
            </div>
        </div>

        <div class="flex justify-start items-center sm:mt-3 md:mt-0 lg:mt-0">
            <x-actions.href href="{{ route('admin.ticket.create') }}" class="flex items-center gap-1">
                <span>Create A Request</span>
                <svg fill="none" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </x-actions.href>
        </div>
    </div>

    <div class="relative">
        <form action="{{ route('admin.ticket.bulk.delete') }}" method="POST" onsubmit="return confirm('Are you sure?')">
            @csrf
            <table class="display nowrap" id="data-table" style="width: 100%;border:none;">
                <thead style="background:#F3F4F6; border:none">
                    <tr>
                        <th class="text-heading-dark !text-end w-[50px]">
                            <span class="flex gap-2 !justify-center !items-center">
                                <button type="submit">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.5 5H4.16667H17.5" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M15.8332 4.99984V16.6665C15.8332 17.1085 15.6576 17.5325 15.345 17.845C15.0325 18.1576 14.6085 18.3332 14.1665 18.3332H5.83317C5.39114 18.3332 4.96722 18.1576 4.65466 17.845C4.3421 17.5325 4.1665 17.1085 4.1665 16.6665V4.99984M6.6665 4.99984V3.33317C6.6665 2.89114 6.8421 2.46722 7.15466 2.15466C7.46722 1.8421 7.89114 1.6665 8.33317 1.6665H11.6665C12.1085 1.6665 12.5325 1.8421 12.845 2.15466C13.1576 2.46722 13.3332 2.89114 13.3332 3.33317V4.99984" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8.3335 9.1665V14.1665" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M11.6665 9.1665V14.1665" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <input id="checkbox1" type="checkbox" class="w-4 h-4 mr-3 rounded border border-base-500 focus:ring-transparent text-primary-400" />
                            </span>
                        </th>
                        <th class="text-heading-dark w-[50px]">ID</th>
                        <th class="text-heading-dark">Title</th>
                        <th class="text-heading-dark">Priority</th>
                        <th class="text-heading-dark">Status</th>
                        <th class="text-heading-dark">Category</th>
                        <th class="text-heading-dark">Sub Category</th>
                        <th class="text-heading-dark">Requester</th>
                        <th class="text-heading-dark">Department</th>
                        <th class="text-heading-dark">Assigned Team</th>
                        <th class="text-heading-dark">Assigned Agent</th>
                        <th class="text-heading-dark">Created</th>
                        <th class="text-heading-dark">Age</th>
                        <th class="text-heading-dark">Due</th>
                        <th class="text-heading-dark"></th>
                    </tr>
                </thead>

                <tbody class="mt-5">
                </tbody>
            </table>
        </form>
    </div>

    @section('script')

    <script>
        $(function() {
            const hiddenInput = document.getElementById('status_search');
            const priority_search = document.getElementById('priority_search');
            const category_search = document.getElementById('category_search');
            const department_search = document.getElementById('department_search');
            const team_search = document.getElementById('team_search');
            const due_date_search = document.getElementById('due_date_search');

            var dTable = $('#data-table').DataTable({
                stripeClasses: [],
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                scrollX: true,
                lengthChange: false,
                pageLength: 50,
                lengthMenu: [
                    [20, 30, 50, 100, -1],
                    [20, 30, 50, 100, 'All']
                ],
                order: [
                    1, 'desc'
                ],
                ajax: {
                    url: "{{ route('admin.ticket.all.list.datatable') }}",
                    type: "GET",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.query_status = "{{ $queryStatus }}";
                        d.me_mode_search = $('#me_mode_search').val();
                        d.ticket_id_search = $('#ticket_id_search').val();
                        d.priority_search = $('#priority_search').val();
                        d.category_search = $('#category_search').val();
                        d.department_search = $('#department_search').val();
                        d.team_search = $('#team_search').val();
                        d.status_search = $('#status_search').val();
                        d.due_date_search = $('#due_date_search').val();
                    }
                },
                columns: [{
                        data: 'select',
                        name: 'select',
                        sortable: false,
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'priority',
                        name: 'priority'
                    },
                    {
                        data: 'ticket_status_id',
                        name: 'ticket_status_id'
                    },
                    {
                        data: 'category_id',
                        name: 'category_id'
                    },
                    {
                        data: 'sub_category_id',
                        name: 'sub_category_id'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'department_id',
                        name: 'department_id'
                    },
                    {
                        data: 'team_id',
                        name: 'team_id'
                    },
                    {
                        data: 'agent',
                        name: 'agent'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'request_age',
                        name: 'request_age'
                    },
                    {
                        data: 'due_date',
                        name: 'due_date'
                    },
                    {
                        data: 'action_column',
                        name: 'action_column',
                        sortable: false
                    }
                ]
            });

            $(document).on('change keyup',
                '#priority_search, #category_search, #team_search,#department_search, #status_search, #due_date_search, #ticket_id_search',
                function(e) {
                    dTable.draw();
                    e.preventDefault();
                });
            hiddenInput.addEventListener('change', () => {
                $('#status_search').trigger('change');
            });
            priority_search.addEventListener('change', () => {
                $('#priority_search').trigger('change');
            });
            category_search.addEventListener('change', () => {
                $('#category_search').trigger('change');
            });
            department_search.addEventListener('change', () => {
                $('#department_search').trigger('change');
            });
            team_search.addEventListener('change', () => {
                $('#team_search').trigger('change');
            });
            due_date_search.addEventListener('change', () => {
                $('#due_date_search').trigger('change');
            });


        });
    </script>

    <script>
        let resetButton = document.querySelector('#resetButton');

        function initCustomSelect() {
            const customSelects = document.querySelectorAll('.custom-select');
            customSelects.forEach(customSelect => {
                customSelect.addEventListener('click', function(event) {
                    event.stopPropagation();
                    customSelect.classList.toggle('active');
                    const input = customSelect.querySelector('input');
                    const data = event.target.getAttribute('data-value');

                    if (data) {
                        input.value = data;
                        input.dispatchEvent(new Event('change'));
                        customSelect.querySelector('.selected').textContent = event.target.textContent;
                        customSelect.classList.remove('active');
                    }
                });
            });

            document.addEventListener('click', function() {
                customSelects.forEach(customSelect => customSelect.classList.remove('active'));
            });
        }

        function resetCustomSelects() {
            const customSelects = document.querySelectorAll('.custom-select');
            customSelects.forEach(customSelect => {
                const input = customSelect.querySelector('input');
                const selected = customSelect.querySelector('.selected');
                if (input) {
                    input.value = '';
                    input.dispatchEvent(new Event('change'));
                }
                if (selected) {
                    let placeholder = selected.getAttribute('data-placeholder');
                    selected.textContent = placeholder;
                }
                customSelect.classList.remove('active');
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            initCustomSelect();
            resetButton.addEventListener('click', function() {
                resetCustomSelects();
            });
        });
    </script>


    <script>
        const masterCheckbox = document.getElementById('checkbox1');
        masterCheckbox.addEventListener('change', function() {
            const childCheckboxes = document.querySelectorAll('.child-checkbox');
            childCheckboxes.forEach(checkbox => {
                checkbox.checked = masterCheckbox.checked;
            });
        });
    </script>

    <script>
        document.querySelectorAll('table.dataTable tbody tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'inherit';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = 'inherit';
            });
        });
    </script>
    @endsection

    @section('style')
    <style>
        .custom-select {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 4px;
            height: 40px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .custom-select .selected {
            padding: 10px;
            background: #fff;
            color: #5e666e;
            color: #5e666e;
            font-family: "Inter", "sans-serif";
            font-size: 14px;
        }

        .custom-select .options {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            border: 1px solid #ddd;
            background: #fff;
            z-index: 1000;
        }

        .custom-select .option {
            padding: 10px;
            cursor: pointer;
            color: #5e666e;
            font-family: "Inter", "sans-serif";
            font-size: 14px;
        }

        .custom-select .option:hover {
            background: #FFF7F2;
            color: #F36D00;
        }

        .custom-select.active .options {
            display: block;
        }
    </style>
    @endsection
</x-app-layout>
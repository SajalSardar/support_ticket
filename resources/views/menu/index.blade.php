<x-app-layout>
    @section('title', 'Menu List')
    @include('menu.breadcrumb.index')
    <div class="flex justify-between items-center !mt-3">
        <div class="flex-1 mt-1">
            <div class="flex justify-end gap-3">
                <div>
                    <x-forms.text-input-icon dir="start" id="unser_name_search" class="text-paragraph" placeholder="Search">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#5E666E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M20.9999 21.0004L16.6499 16.6504" stroke="#5E666E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </x-forms.text-input-icon>
                </div>
                @can('menu create')
                <div>
                    <x-actions.href href="{{ route('admin.menu.create') }}" class="inline-block">
                        Create Menu
                        <svg class="inline-block" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.5 8V16M16.5 12H8.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12.5 22C18.0228 22 22.5 17.5228 22.5 12C22.5 6.47715 18.0228 2 12.5 2C6.97715 2 2.5 6.47715 2.5 12C2.5 17.5228 6.97715 22 12.5 22Z" stroke="white" stroke-width="1.5" />
                        </svg>
                    </x-actions.href>
                </div>
                @endcan
            </div>
        </div>
    </div>

    <div class="relative">
        <table class="display nowrap" id="data-table" style="width: 100%;border:none;">
            <thead style="background:#F3F4F6; border:none">
                <tr>
                    <th class="text-heading-dark !text-end w-[50px]">
                        <span class="flex gap-2 !justify-center !items-center">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 5H4.16667H17.5" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15.8332 4.99984V16.6665C15.8332 17.1085 15.6576 17.5325 15.345 17.845C15.0325 18.1576 14.6085 18.3332 14.1665 18.3332H5.83317C5.39114 18.3332 4.96722 18.1576 4.65466 17.845C4.3421 17.5325 4.1665 17.1085 4.1665 16.6665V4.99984M6.6665 4.99984V3.33317C6.6665 2.89114 6.8421 2.46722 7.15466 2.15466C7.46722 1.8421 7.89114 1.6665 8.33317 1.6665H11.6665C12.1085 1.6665 12.5325 1.8421 12.845 2.15466C13.1576 2.46722 13.3332 2.89114 13.3332 3.33317V4.99984" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8.3335 9.1665V14.1665" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11.6665 9.1665V14.1665" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <input id="checkbox1" type="checkbox" class="w-4 h-4 mr-3 rounded border border-base-500 focus:ring-transparent text-primary-400" />
                        </span>
                    </th>
                    <th class="text-heading-dark w-[50px]">Id</th>
                    <th class="text-heading-dark">Menu</th>
                    <th class="text-heading-dark !text-start">Order</th>
                    <th class="text-heading-dark">Route</th>
                    <th class="text-heading-dark">Roles</th>
                    <th class="text-heading-dark">Permissions</th>
                    <th class="text-heading-dark">Url</th>
                    <th class="text-heading-dark">Created</th>
                </tr>
            </thead>

            <tbody class="mt-5">

            </tbody>
        </table>
    </div>
    @section('script')
    <script>
        $(function() {
            var dTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                scrollX: true,
                lengthChange: false,
                order: [
                    1, 'desc'
                ],
                ajax: {
                    url: "{{ route('admin.menu.list.datatable') }}",
                    type: "GET",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.unser_name_search = $('#unser_name_search').val();
                    }
                },
                columns: [{
                        data: 'select',
                        name: 'select',
                        sortable: false
                    }, {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'order',
                        name: 'order'
                    },
                    {
                        data: 'route',
                        name: 'route'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'permission',
                        name: 'permission'
                    },
                    {
                        data: 'url',
                        name: 'url'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action_column',
                        name: 'action_column',
                        sortable: false
                    }
                ]
            });
            $(document).on('change keyup',
                '#unser_name_search, #unser_email_search',
                function(e) {
                    dTable.draw();
                    e.preventDefault();
                });
        });
    </script>
    @endsection
</x-app-layout>
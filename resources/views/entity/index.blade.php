<x-app-layout>
    @section('title', camelCase(request()->entity))
    @include('entity.breadcrumb', ['value' => camelCase(request()->entity)])

    <div class="relative">
        <table class="display nowrap" id="data-table" style="width: 100%;border:none;">
            <thead style="background:#F3F4F6; border:none">
                <tr>
                    <th class="text-heading-dark !text-end w-[50px]">
                        <span class="flex gap-1 !justify-center !items-center">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 5H4.16667H17.5" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15.8332 4.99984V16.6665C15.8332 17.1085 15.6576 17.5325 15.345 17.845C15.0325 18.1576 14.6085 18.3332 14.1665 18.3332H5.83317C5.39114 18.3332 4.96722 18.1576 4.65466 17.845C4.3421 17.5325 4.1665 17.1085 4.1665 16.6665V4.99984M6.6665 4.99984V3.33317C6.6665 2.89114 6.8421 2.46722 7.15466 2.15466C7.46722 1.8421 7.89114 1.6665 8.33317 1.6665H11.6665C12.1085 1.6665 12.5325 1.8421 12.845 2.15466C13.1576 2.46722 13.3332 2.89114 13.3332 3.33317V4.99984" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8.3335 9.1665V14.1665" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11.6665 9.1665V14.1665" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <input id="checkbox1" type="checkbox" class="w-4 h-4 mr-3 rounded border border-base-500 focus:ring-transparent text-primary-400" />
                        </span>
                    </th>
                    <th class="text-heading-dark pl-5 text-start">ID</th>
                    <th class="text-heading-dark pl-2 text-start">{{ camelCase(request()->entity) }}</th>
                    @php
                    $heading = match (request()->entity) {
                    'requesters' => 'Requests',
                    'agents' => 'Resolved',
                    'categories' => 'Requests',
                    'teams' => 'Agents',
                    default => 'Total'
                    }
                    @endphp
                    <th class="text-heading-dark pl-2 !text-start">{{ $heading }}</th>
                </tr>
            </thead>

            <tbody>


            </tbody>

        </table>

    </div>
    @section('script')
    <script>
        $(function() {
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                responsive: true,
                scrollX: true,
                lengthChange: true,
                pageLength: 50,
                lengthMenu: [
                    [20, 30, 50, 100, -1],
                    [20, 30, 50, 100, 'All']
                ],
                order: [
                    1, 'desc'
                ],
                ajax: {
                    url: "{{ route('admin.entity.list.datatable', ['entity' => request()->entity]) }}",
                    type: "GET",
                },
                columns: [{
                        data: 'select',
                        name: 'select',
                        sortable: false
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'action_column',
                        name: 'action_column',
                        sortable: false
                    }
                ]
            });
        });
    </script>
    @endsection
</x-app-layout>
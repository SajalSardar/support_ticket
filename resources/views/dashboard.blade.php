<x-app-layout>
    @section('title', 'Dashboard')
    @include('breadcrumb')
    <div class="mb-8 flex justify-between">
        <div>
            <h1 class="!text-2xl text-detail-heading !font-semibold">Hello {{ auth()->user()->name }}!</h1>
            <p class="text-paragraph">Welcome to explore your dashboard here.</p>
        </div>
        @can('request create')
        <div>
            <x-actions.href href="{{ route('admin.ticket.create') }}" class="flex items-center gap-1 text-heading-light">
                <span>Create A Request</span>
                <svg fill="none" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </x-actions.href>
        </div>
        @endcan
    </div>

    @can('request card view')
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('admin.ticket.all.list') }}">
            <div class="border border-base-500 rounded py-10">
                <div class="flex justify-center items-center gap-12">
                    <div class="w-[80px] h-[80px] rounded-full bg-primary-600 border border-base-500 flex justify-center items-center">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M29.6249 16.5V15C29.6249 9.34314 29.6249 6.51473 27.8675 4.75736C26.1101 3 23.2817 3 17.6249 3H16.1251C10.4682 3 7.63983 3 5.88248 4.75734C4.12512 6.51468 4.12509 9.34308 4.12505 14.9999L4.125 21C4.12494 26.6568 4.12493 29.4852 5.88222 31.2426C7.63958 32.9998 10.4681 33 16.1249 33" stroke="#F36D00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M10.875 10.5H22.8749M10.875 18H22.8749" stroke="#F36D00" stroke-width="2" stroke-linecap="round" />
                            <path d="M19.875 31.2402V33H21.6351C22.2492 33 22.5562 33 22.8322 32.8857C23.1084 32.7712 23.3254 32.5542 23.7597 32.1201L30.9951 24.8841C31.4046 24.4746 31.6093 24.2698 31.7188 24.049C31.9272 23.6287 31.9272 23.1354 31.7188 22.7151C31.6093 22.4941 31.4046 22.2894 30.9951 21.8799C30.5855 21.4704 30.3807 21.2656 30.1598 21.1561C29.7395 20.948 29.246 20.948 28.8257 21.1561C28.6049 21.2656 28.3999 21.4704 27.9904 21.8799L20.755 29.1159C20.3208 29.55 20.1037 29.767 19.9894 30.043C19.875 30.3192 19.875 30.6261 19.875 31.2402Z" stroke="#F36D00" stroke-width="2" stroke-linejoin="round" />
                        </svg>
                    </div>
                    @php
                    $allRequests = $state?->pluck('count')->sum();
                    @endphp
                    <div class="mt-3">
                        <h4 class="!text-2xl text-detail-heading">{{ $allRequests }}</h4>
                        <p class="text-paragraph">All Requests</p>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ asset('dashboard/status-wise-request-list?request_status=resolved') }}">
            <div class="border border-base-500 rounded py-10">
                <div class="flex justify-center items-center gap-12">
                    <div class="w-[80px] h-[80px] rounded-full bg-primary-600 border border-base-500 flex justify-center items-center">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.5 3.75H18C11.2825 3.75 7.92373 3.75 5.83686 5.83686C3.75 7.92373 3.75 11.2825 3.75 18C3.75 24.7175 3.75 28.0763 5.83686 30.1632C7.92373 32.25 11.2825 32.25 18 32.25C24.7175 32.25 28.0763 32.25 30.1632 30.1632C32.25 28.0763 32.25 24.7175 32.25 18V15" stroke="#F36D00" stroke-width="2" stroke-linecap="round" />
                            <path d="M12.75 15L18 20.25L31.5003 5.25" stroke="#F36D00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="mt-3">
                        <h4 class="!text-2xl text-detail-heading">{{ $state?->pluck('count')[0] ?? '0' }}</h4>
                        <p class="text-paragraph">{{ ucfirst($state?->pluck('name')[0] ?? '') }} Requests</p>

                    </div>
                </div>
            </div>
        </a>
        <a href="{{ asset('dashboard/status-wise-request-list?request_status=closed') }}">
            <div class="border border-base-500 rounded py-10">
                <div class="flex justify-center items-center gap-12">
                    <div class="w-[80px] h-[80px] rounded-full bg-primary-600 border border-base-500 flex justify-center items-center">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.75 33H14.25C9.30026 33 6.82538 33 5.2877 31.3814C3.75 29.7627 3.75 27.1577 3.75 21.9474V14.0526C3.75 8.84236 3.75 6.23724 5.2877 4.61862C6.82538 3 9.30026 3 14.25 3H18.75C23.6997 3 26.1745 3 27.7123 4.61862C29.25 6.23724 29.25 8.84236 29.25 14.0526V18.75" stroke="#F36D00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M33 24L28.5 28.5M28.5 28.5L24 33M28.5 28.5L33 33M28.5 28.5L24 24" stroke="#F36D00" stroke-width="2" stroke-linecap="round" />
                            <path d="M10.5 3L10.6233 3.7398C10.9226 5.53566 11.0723 6.43359 11.7017 6.96679C12.3311 7.5 13.2414 7.5 15.0621 7.5H17.9379C19.7586 7.5 20.669 7.5 21.2984 6.96679C21.9278 6.43359 22.0774 5.53566 22.3767 3.7398L22.5 3" stroke="#F36D00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M10.5 24H16.5M10.5 16.5H22.5" stroke="#F36D00" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <div class="mt-3">
                        <h4 class="!text-2xl text-detail-heading">{{ $state?->pluck('count')[1] ?? '0' }}</h4>
                        <p class="text-paragraph">{{ ucfirst($state?->pluck('name')[1] ?? '') }} Requests</p>

                    </div>
                </div>
            </div>
        </a>

        <div class="row-span-2 border border-base-500 rounded px-11 py-10">
            <h3 class="text-detail-heading">Priority Analytics</h3>
            <div class="mt-11 flex items-center justify-between">
                <div class="value">
                    @foreach ($chart as $item)
                    <p class="text-paragraph pb-2">{{ $item?->title }} :
                        <span class="text-sm font-semibold" style="color: {{ $item?->color }};">
                            {{ $item?->value }}%
                        </span>
                    </p>
                    @endforeach
                </div>
                <div class="chart-container">
                    <svg id="circularChart" width="152" height="152" viewBox="0 0 36 36" class="circular-chart">
                        <text x="18" y="20.35" text-anchor="middle" font-size="4" fill="#5E666E">Requests</text>
                    </svg>
                </div>
            </div>
        </div>

        <a href="{{ asset('dashboard/status-wise-request-list?request_status=open') }}">
            <div class="border border-base-500 rounded  py-10">
                <div class="flex justify-center items-center gap-12">
                    <div class="w-[80px] h-[80px] rounded-full bg-primary-600 border border-base-500 flex justify-center items-center">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.6498 4.50293C11.1765 4.51277 8.3103 4.64714 6.47864 6.47878C4.50195 8.4554 4.50195 11.6367 4.50195 17.9994C4.50195 24.3621 4.50195 27.5434 6.47864 29.52C8.45531 31.4967 11.6367 31.4967 17.9997 31.4967C24.3624 31.4967 27.5439 31.4967 29.5206 29.52C31.3522 27.6885 31.4866 24.8224 31.4965 19.3492" stroke="#F36D00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M30.7204 5.27657L22.3965 13.5776M30.7204 5.27657C29.9794 4.53481 24.988 4.60396 23.9328 4.61896M30.7204 5.27657C31.4613 6.01834 31.3923 11.0152 31.3773 12.0716" stroke="#F36D00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="mt-3">
                        <h4 class="!text-2xl text-detail-heading">{{ $state?->pluck('count')[2] ?? '0' }}</h4>
                        <p class="text-paragraph">{{ ucfirst($state?->pluck('name')[2] ?? '') }} Requests</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ asset('dashboard/status-wise-request-list?request_status=in-progress') }}">
            <div class="border border-base-500 rounded  py-10">
                <div class="flex justify-center gap-12 items-center">
                    <div class="w-[80px] h-[80px] rounded-full bg-primary-600 border border-base-500 flex justify-center items-center">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 18C3 26.2842 9.71572 33 18 33C26.2842 33 33 26.2842 33 18C33 9.71572 26.2842 3 18 3" stroke="#F36D00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 18.75L15.75 22.5L24 13.5" stroke="#F36D00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M3.75 12.75C4.29359 11.5058 4.97835 10.3375 5.78401 9.26516M9.26521 5.78397C10.3375 4.97832 11.5059 4.29359 12.75 3.75" stroke="#F36D00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="mt-3">
                        <h4 class="!text-2xl text-detail-heading">{{ $state?->pluck('count')[3] ?? '0' }}</h4>
                        <p class="text-paragraph">{{ ucfirst($state?->pluck('name')[3] ?? '') }} Requests</p>
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ asset('dashboard/status-wise-request-list?request_status=on-hold') }}">
            <div class="border border-base-500 rounded py-10">
                <div class="flex justify-center gap-12 items-center">
                    <div class="w-[80px] h-[80px] rounded-full bg-primary-600 border border-base-500 flex justify-center items-center">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 4.98057C10.1258 4.23495 5.51042 4.28408 4.14716 5.64716C0.889292 8.90543 5.13734 30.741 9.80246 30.2868C12.3619 30.0284 14.1484 25.9181 16.2513 24.6342C17.0798 24.1284 17.8142 24.6422 18.333 25.3176L23.3535 31.8522C24.2282 32.9909 24.8442 33.3297 26.1632 32.6544C28.1909 31.6162 30.1178 29.6867 31.1544 27.6627C31.8297 26.3442 31.4909 25.728 30.3525 24.8535L27 22.2779" stroke="#F36D00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M25.5 7.5V10.5L27.75 12M33 10.5C33 14.6421 29.6421 18 25.5 18C21.3579 18 18 14.6421 18 10.5C18 6.35787 21.3579 3 25.5 3C29.6421 3 33 6.35787 33 10.5Z" stroke="#F36D00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="mt-3">
                        <h4 class="!text-2xl text-detail-heading">{{ $state?->pluck('count')[4] ?? '0' }}</h4>
                        <p class="text-paragraph">{{ ucfirst($state?->pluck('name')[4] ?? 'Requests') }} Requests</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endcan

    @canany(['top requesters section view', 'top agents section view', 'top categories section view', 'top teams section view'])
    <div class="border border-base-500 rounded px-8 py-6 mt-[25px]">
        <div class="grid sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-6">
            @can('top requesters section view')
            <div>
                <div class="flex justify-between items-center mb-[15px]">
                    <h3 class="text-title font-medium">Top 5 Requesters</h3>
                    <a href="{{ route('admin.entity.index',['entity' => 'requesters']) }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 17L17 7" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 7H17V15" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>

                </div>
                <table class="w-full">
                    <thead class="w-full bg-[#F3F4F6]" style="border:1px solid #F3F4F6;border-radius:10px !important">
                        <th class="text-start ps-10 text-title font-medium">Requesters</th>
                        <th class="text-start text-title font-medium">Request</th>
                    </thead>

                    <tbody>
                        @foreach ($traffic as $each)
                        <tr style="border:1px solid #ddd">
                            <td class="text-start ps-10 text-paragraph">{{ ucfirst($each['name']) }}</td>
                            <td class="text-start text-paragraph">{{ ucfirst($each['total']) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endcan
            @can('top agents section view')
            <div>
                <div class="flex justify-between items-center mb-[15px]">
                    <h3 class="text-title font-medium">Top 5 Agents</h3>
                    <a href="{{ route('admin.entity.index',['entity' => 'agents']) }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 17L17 7" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 7H17V15" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
                <table class="w-full">
                    <thead class="w-full bg-[#F3F4F6]" style="border:1px solid #F3F4F6;border-radius:10px !important">
                        <th class="text-start ps-12 text-title font-medium">Agents</th>
                        <th class="text-start text-title font-medium">Resolved</th>
                    </thead>

                    <tbody>
                        @foreach ($agents as $each)
                        <tr style="border:1px solid #ddd">
                            <td class="text-start ps-12 text-paragraph">{{ ucfirst($each['name']) }}</td>
                            <td class="text-start text-paragraph">{{ ucfirst($each['total']) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endcan
            @can('top categories section view')
            <div>
                <div class="flex justify-between items-center mb-[15px]">
                    <h3 class="text-title font-medium">Request by Categories</h3>
                    <a href="{{ route('admin.entity.index',['entity' => 'categories']) }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 17L17 7" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 7H17V15" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
                <table class="w-full">
                    <thead class="w-full bg-[#F3F4F6]" style="border:1px solid #F3F4F6;border-radius:10px !important">
                        <th class="text-start ps-12 text-title font-medium">Categories</th>
                        <th class="text-start text-title font-medium">Request</th>
                    </thead>

                    <tbody>
                        @foreach ($categories as $each)
                        <tr style="border:1px solid #ddd">
                            <td class="text-start ps-12 text-paragraph">{{ ucfirst($each['name']) }}</td>
                            <td class="text-start text-paragraph">{{ ucfirst($each['total']) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endcan
            @can('top teams section view')
            <div>
                <div class="flex justify-between items-center mb-[15px]">
                    <h3 class="text-title font-medium">Teams</h3>
                    <a href="{{ route('admin.entity.index',['entity' => 'teams']) }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 17L17 7" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 7H17V15" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
                <table class="w-full">
                    <thead class="w-full bg-[#F3F4F6]" style="border:1px solid #F3F4F6;border-radius:10px !important">
                        <th class="text-start ps-10 text-title font-medium">Teams</th>
                        <th class="text-start text-title font-medium">Agents</th>
                    </thead>

                    <tbody>
                        @foreach ($teams as $each)
                        <tr style="border:1px solid #ddd">
                            <td class="text-start ps-10 text-paragraph">{{ ucfirst($each['name']) }}</td>
                            <td class="text-start text-paragraph">{{ ucfirst($each['total']) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endcan
        </div>
    </div>
    @endcanany

    @section('style')
    <style>
        .chart-container {
            width: 152px;
            height: 152px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .circular-chart {
            transform: rotate(-360deg);
        }

        .circle {
            fill: none;
            stroke-width: 4.0;
            stroke-linecap: round;
        }
    </style>
    @endsection

    @section('script')
    <script>
        const data = JSON.parse('<?= json_encode($chart); ?>');

        function createCircularChart(data) {
            const total = data.reduce((sum, segment) => sum + segment.value, 0);
            let offset = 0;

            data.forEach(segment => {
                const percentage = (segment.value / total) * 100;
                const dashArray = `${percentage} ${100 - percentage}`;

                const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
                path.setAttribute("class", "circle");
                path.setAttribute("d", "M18 2 a 16 16 0 1 1 0 32 a 16 16 0 1 1 0 -32");
                path.setAttribute("stroke", segment.color);
                path.setAttribute("stroke-dasharray", dashArray);
                path.setAttribute("stroke-dashoffset", -offset);
                offset += percentage;
                document.getElementById("circularChart").appendChild(path);
            });
        }
        window.addEventListener('DOMContentLoaded', () => createCircularChart(data));
    </script>
    @endsection
</x-app-layout>
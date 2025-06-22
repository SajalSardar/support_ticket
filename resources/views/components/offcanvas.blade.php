<!-- Offcanvas -->
<div x-data="{
    open: false,
    mobileFullWidth: false,

    // 'start', 'end', 'top', 'bottom'
    position: '{{ $position }}',

    // 'xs', 'sm', 'md', 'lg', 'xl'
    size: '{{ $size }}',

    // Set transition classes based on position
    transitionClasses: {
        'x-transition:enter-start'() {
            if (this.position === 'start') {
                return '-translate-x-full rtl:translate-x-full';
            } else if (this.position === 'end') {
                return 'translate-x-full rtl:-translate-x-full';
            } else if (this.position === 'top') {
                return '-translate-y-full';
            } else if (this.position === 'bottom') {
                return 'translate-y-full';
            }
        },
        'x-transition:leave-end'() {
            if (this.position === 'start') {
                return '-translate-x-full rtl:translate-x-full';
            } else if (this.position === 'end') {
                return 'translate-x-full rtl:-translate-x-full';
            } else if (this.position === 'top') {
                return '-translate-y-full';
            } else if (this.position === 'bottom') {
                return 'translate-y-full';
            }
        },
    },
}" x-on:open-{{ $eventname }}.window="open = true" x-on:keydown.esc.prevent="open = false">

    <!-- Offcanvas Backdrop -->
    <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-bind:aria-hidden="!open" tabindex="-1" role="dialog" aria-labelledby="pm-offcanvas-title" class="z-40 fixed inset-0 overflow-hidden bg-zinc-700/75 backdrop-blur-s">
        <!-- Offcanvas Sidebar -->
        <div x-cloak x-show="open" x-bind="transitionClasses" x-transition:enter="transition ease-out duration-300" x-transition:enter-end="translate-x-0 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0 translate-y-0" role="document" class="absolute flex w-full flex-col bg-white shadow-lg will-change-transform" x-bind:class="{
                'h-dvh top-0 end-0': position === 'end',
                'h-dvh top-0 start-0': position === 'start',
                'bottom-0 start-0 end-0': position === 'top',
                'bottom-0 start-0 end-0': position === 'bottom',
                'h-64': position === 'top' || position === 'bottom',
                'sm:max-w-xs': size === 'xs' && !(position === 'top' || position === 'bottom'),
                'sm:max-w-sm': size === 'sm' && !(position === 'top' || position === 'bottom'),
                'sm:max-w-md': size === 'md' && !(position === 'top' || position === 'bottom'),
                'sm:max-w-lg': size === 'lg' && !(position === 'top' || position === 'bottom'),
                'sm:max-w-xl': size === 'xl' && !(position === 'top' || position === 'bottom'),
                'max-w-72': !mobileFullWidth && !(position === 'top' || position === 'bottom'),
            }">
            <!-- Header -->
            <div class="flex min-h-16 flex-none items-center justify-between border-b border-zinc-100 px-3 md:px-5">
                <h3 id="pm-offcanvas-title" class="py-5 font-bold">{{ $header ?? '' }}</h3>

                <!-- Close Button -->
                <button x-on:click="open = false" type="button" class="inline-flex items-center justify-center gap-2 rounded-lg border border-zinc-200 bg-white px-3 py-2 text-xs font-semibold leading-5 text-paragraph hover:border-zinc-300 hover:text-paragraph hover:shadow-sm focus:text-paragraph active:border-zinc-200 active:shadow-none">
                    <svg class="hi-solid hi-x -mx-1 inline-block size-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <!-- END Close Button -->
            </div>
            <!-- END Header -->

            <!-- Content -->
            <div class="flex grow flex-col overflow-y-auto p-3 md:p-5">
                <!-- Placeholder -->
                <div class="h-full text-sm font-medium">
                    {{ $body ?? '' }}
                </div>
            </div>
            <!-- END Content -->
        </div>
        <!-- END Offcanvas Sidebar -->
    </div>
    <!-- END Offcanvas Backdrop -->
</div>
<!-- END Offcanvas -->
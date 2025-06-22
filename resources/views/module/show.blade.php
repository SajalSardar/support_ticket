<x-app-layout>
    <div class="border border-slate-300 p-5 rounded">
        <header class="flex justify-between mb-5">
            <h4>Create</h4>
            <x-buttons.primary>
                Create
            </x-buttons.primary>
        </header>
        <form action="#">
            <div class="flex justify-between">
                <div class="p-2 w-full">
                    <x-forms.text-input type="text" placeholder="Enter Event Name" />
                </div>

                <div class="p-2 w-full">
                    <x-forms.text-input type="date" />
                </div>
            </div>
            <div class="flex justify-between">
                <div class="p-2 w-full">
                    <x-forms.text-input type="time" />
                </div>

                <div class="p-2 w-full">
                    <x-forms.text-input type="text" placeholder="Enter event address" />
                </div>
            </div>

            <div class="p-2">
                <x-buttons.primary>
                    Save
                </x-buttons.primary>
            </div>

        </form>
    </div>
</x-app-layout>

<x-app-layout>
    @section('title', 'Profile')
    @section('breadcrumb')
    <x-breadcrumb>
        Update Profile
    </x-breadcrumb>

    <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1">
        <div class="mt-[13px]">
            <h3 class="text-heading-dark">Profile Settings</h3>
            <div class="w-full h-[2px] bg-[#ddd] mt-5"></div>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1">
            <div class="flex justify-between items-center py-6">
                <div class="flex gap-3 items-center">
                    <img src="{{ Auth::user()->image?->url ? Auth::user()->image?->url : asset('assets/images/profile.png') }}" alt="{{ $user->image?->url }}" class="w-[72px] h-[72px] rounded-full">
                    <div>
                        <h3 class="text-heading-dark">{{ $user->name }}</h3>
                        <p class="text-paragraph">{{ $user?->designation }}</p>
                    </div>
                </div>
                <div>
                    <input id="changeImage" name="image" hidden type="file">
                    <label class="hover:bg-primary-400 hover:text-gray-100 border border-base-500 px-8 py-2 inline-block bg-background-gray text-paragraph rounded" for="changeImage">
                        Add/Change Image
                    </label>
                    <div class="text-paragraph pt-1 text-center">
                        <span>PNG,JPG Upto 1 MB</span>
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    </div>
                </div>
            </div>
        </div>
        <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1">
            <div class="w-full h-[2px] bg-[#ddd]"></div>
        </div>

        <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1">
            @include('profile.partials.update-profile-information-form')
        </div>
    </form>
    <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1">
        <div class="w-full h-[2px] bg-[#ddd] mt-5"></div>
    </div>
    <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1">
        @include('profile.partials.update-password-form')
    </div>
</x-app-layout>
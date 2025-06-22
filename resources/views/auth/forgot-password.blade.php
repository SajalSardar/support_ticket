<x-guest-layout>
    <div class="h-screen">
        <div class="flex justify-center h-full items-center">
            <div class="bg-white lg:w-2/6 border border-base-500 p-12 rounded">
                <h2 class="text-detail-heading mb-2">Forgot Password?</h2>
                <div class="mb-6 text-paragraph">
                    {{ __('No worries. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div>
                        <x-forms.label for="email">
                            Email
                        </x-forms.label>
                        <x-forms.text-input id="email" type="email" name="email" :value="old('email')" placeholder="Enter Email" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-buttons.primary>
                            {{ __('Email Password Reset Link') }}
                        </x-buttons.primary>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
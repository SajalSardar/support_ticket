<section>
    <div class="grid md:grid-cols-2 sm:grid-cols-1 lg:gap-3 sm:gap-1 md:gap-2 mb-3">
        <div class="w-full">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div class="w-full">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>
    </div>

    <div class="grid md:grid-cols-2 sm:grid-cols-1 lg:gap-3 sm:gap-1 md:gap-2 mb-3">
        <div class="w-full">
            <x-input-label for="requester_type_id" :value="__('Requester Type')" />
            <x-forms.select-input name="requester_type_id" id="requester_type_id" class="mt-1">
                <option value="">Select Type</option>
                @foreach ($requester_type as $type)
                <option value="{{ $type->id }}" {{ $type->id == $user->requester_type_id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
                @endforeach
            </x-forms.select-input>

            <x-input-error class="mt-2" :messages="$errors->get('requester_type_id')" />
        </div>
        <div class="w-full">
            <x-input-label for="requester_id" :value="__('Requester Id')" />
            <x-text-input id="requester_id" name="requester_id" type="text" class="mt-1 block w-full"
                :value="old('requester_id', $user->requester_id)" autofocus autocomplete="requester_id" />
            <x-input-error class="mt-2" :messages="$errors->get('requester_id')" />
        </div>
    </div>

    <div class="grid md:grid-cols-2 sm:grid-cols-1 lg:gap-3 sm:gap-1 md:gap-2 mb-3">
        <div class="w-full">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="number" class="mt-1 block w-full" :value="old('phone', $user->phone)"
                autofocus autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>
        <div class="w-full">
            <x-input-label for="designation" :value="__('Designation')" />
            <x-text-input id="designation" name="designation" type="text" class="mt-1 block w-full"
                :value="old('designation', $user->designation)" autofocus autocomplete="designation" />
            <x-input-error class="mt-2" :messages="$errors->get('designation')" />
        </div>
    </div>
    <div class="grid md:grid-cols-2 sm:grid-cols-1 lg:gap-3 sm:gap-1 md:gap-2 mb-3">
        <div class="w-full">
            <x-input-label for="department" :value="__('Department')" />
            <x-forms.select-input name="department" id="department" class="mt-1">
                <option value="">Select Department</option>
                @foreach ($departments as $each)
                <option value="{{ $each->id }}">
                    {{ $each->name }}
                </option>
                @endforeach
            </x-forms.select-input>
            <x-input-error class="mt-2" :messages="$errors->get('department')" />
        </div>

        <div class="w-full">
            <x-input-label for="team" :value="__('Team')" />
            <x-forms.select-input name="team" id="team" class="mt-1">
                <option value="">Select Team</option>
                @foreach ($teams as $each)
                <option value="{{ $each->id }}">
                    {{ $each?->name }}
                </option>
                @endforeach
            </x-forms.select-input>
            <x-input-error class="mt-2" :messages="$errors->get('team')" />
        </div>

    </div>

    <div class="mt-6">
        <x-primary-button>{{ __('Save') }}</x-primary-button>
    </div>
</section>
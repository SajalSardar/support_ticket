<x-guest-layout>
    @section('title', 'Login')

    <div class="flex h-full sm:justify-center lg:justify-center md:justify-center items-center">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
            <div class="flex justify-center sm:px-5 sm:py-12 md:px-10 md:py-24 lg:px-20 lg:py-32 items-center lg:-mr-14">
                <form method="POST" action="{{ route('login') }}" class="border border-base-500 rounded p-6 w-full">
                    @csrf
                    <h3 class="font-semibold font-inter text-[#333] text-[28px] mb-6">SIGN IN</h3>
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <div class="mt-3">
                        <x-forms.text-input-icon type="email" name="email" placeholder="Email Address" :value="old('email')" dir="start">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1_4773)">
                                    <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M22 6L12 13L2 6" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_1_4773">
                                        <rect width="24" height="24" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </x-forms.text-input-icon>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password Field -->
                    <div class="mt-3">
                        <x-forms.password type="password" id="passTypeChange" name="password" placeholder="Password" dir="start" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-3 flex justify-between">
                        <p class="flex items-center gap-2">
                            <x-forms.checkbox-input name="remember" />
                            <span class="text-paragraph">
                                {{ __('Remember me') }}
                            </span>
                        </p>
                        <p class="">
                            <span>
                                <a class="text-paragraph" href="{{ route('password.request') }}">{{ __('Forgot Password ?') }}</a>
                            </span>
                        </p>
                    </div>

                    <div class="mt-3">
                        <x-buttons.primary class="w-full font-inter font-semibold text-base text-[#5e666e]">
                            SIGN IN
                        </x-buttons.primary>
                    </div>

                    <div class="mt-3 text-center">
                        <span class="text-paragraph">Or</span>
                    </div>

                    <div class="mt-3">
                        <a href="#" class="inline-block border border-base-500 rounded-lg p-[6px] w-full text-center">
                            <svg class="inline-block" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect x="3" y="3" width="18" height="18" fill="url(#pattern0_810_3051)" />
                                <defs>
                                    <pattern id="pattern0_810_3051" patternContentUnits="objectBoundingBox" width="1" height="1">
                                        <use xlink:href="#image0_810_3051" transform="scale(0.0416667)" />
                                    </pattern>
                                    <image id="image0_810_3051" width="24" height="24"
                                        xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAAsQAAALEBxi1JjQAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAMvSURBVEiJpZZPbBR1FMc/b2a2LFIrWStr1/4xFBaNtF404WAjGkVZLZ4kG9ISPRqMhoPeUKBEExNivWqIMS1Gi8R/SbVEYgnBpMFoQimHlt2YiEvZtgvVXVncmXkeaJud2dndJnyTubzve5/3e/ll3oxQQ/r8Qw9iuEmEJ4FuIHI5b4cNoRQSboSEsyHL/KD51MxENYYEghMPd2C476GaBIxybzpf8gIE7jJlOozV13x6+ryfZfgDmti8B3EuoLonyK/IVyjYGr/hlCZmn9n4fs0JNBHfj3C02mRBE/hh98ut+5rGM/MVE+gL8WQdeAY4Gza4bonYQQmNljFeDl+ZQF/qbMM2J4F7fDWKMoS6g/LD5d/LjeyzGxP/uXxYsDUOcHfIOBP7KbU9aCr0vHmMk9HNTDY+DoSXvDyqr8jozMkqE91utKPzDXU0Hj2dfj3IF71EB0oKMMlZV/i0Nc21hh5U+2R05vNa8FVJL/G2TqGe5+t1g3cMXpKF8lRFdFNhuFZR5OBCk1PMm/Xgi+H2f0Sn+BNoLYtn5BEeqFa04UCmD2GoHnxJvxhAsy+YqlUh0L5KOEBX3Tf1DtVgAPO+YGetChfc1fNlwQIm8d5BTCd5TLr4NbBEzRMYdhuI5Ym7tKqQ8GbrlIUwjrKzPPyHs64fCoENskeiKWCfP77h3cxnqO8wcEZ0inYgDZi2ypUDC1vSH//d0aNo//XeU8eDR/cq+s5fvYp8i3ePuWo4WwSgeNH45Pt/o5venNu6regay6uigMiruRd/PLEK+JfAWo+hfJUdiL0sAJHRna047kUClp3CsAmD871jv5Ub648/3S+lNa+F0se2UbmB82KYj147GE2vGJHvntuN8EVA8rKuAilnrtgtjjaqe3vVW07PtDm7L+45u7I3OxAbhrLvQW7X2AiwH/xXtaIW4AlK2rQMB7AbznVi5W+uwJG3luGeBgC53rGPUJLAYpUmlXJcsxQ7NAssqkoye7jlaLld8Sbndo2N4GiXwhDg1G0g4IZmi7bhbp0baBkJsKsr8s2ONjWNpOBuB+kGvde5WlyLiCOW5DCZMJEjC3t/rvrb8j9aeDScVZZt1AAAAABJRU5ErkJggg==" />
                                </defs>
                            </svg>
                            <span class="sm:hidden md:inline-block text-center text-paragraph">Sign in with Google</span>
                            <span class="pl-1 md:hidden">Sign In</span>
                        </a>
                    </div>

                    <div class="mt-2">
                        <p class="text-paragraph sm:mt-0">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-primary-400 font-bold">Sign Up</a>
                        </p>
                    </div>
                </form>
            </div>

            <div class="sm:hidden md:hidden lg:block">
                <div class="flex justify-center items-center h-full">
                    <div class="relative">
                        <img src="{{ asset('assets/images/login-register.png') }}" alt="signup">
                        <div class="absolute top-10 left-12 pe-14">
                            <h3 class="font-inter text-2xl font-semibold text-[#333]">Welcome Back!</h3>
                            <p class="text-title">
                                <span class="!text-primary-400 !font-semibold">LogmyRequest</span>
                                is a customer service platform designed to help businesses efficiently track, manage, and resolve customer requests in real time. Our mission is to streamline communication and ensure every query is addressed promptly, enhancing customer satisfaction.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script>
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Tab') {
                const container = document.querySelector('form');
                const focusableElements = container.querySelectorAll('input, select, textarea, a[href]');
                const focusable = Array.from(focusableElements);
                const currentIndex = focusable.indexOf(document.activeElement);
                if (currentIndex !== -1) {
                    event.preventDefault();
                    const nextIndex = event.shiftKey ?
                        (currentIndex - 1 + focusable.length) % focusable.length
                        :
                        (currentIndex + 1) % focusable.length;
                    focusable[nextIndex].focus();
                }
            }
        });
    </script>
    @endpush
</x-guest-layout>
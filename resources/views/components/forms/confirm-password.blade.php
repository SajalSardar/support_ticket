<div class="relative">
    <!-- Password Input Field -->
    <input id="passTypeChangeConfirm" style="height: 40px;" type="password" {!! $attributes->merge([
    'class' => 'text-paragraph w-full ps-10 border border-[#dddddd] focus:ring-transparent focus:border-primary-400 rounded-lg bg-transparent',
    ]) !!} />

    <!-- Eye Button on the Right for Toggling Password Visibility -->
    <span class="absolute inset-y-0 right-0 grid w-10 place-content-center">
        <button id="eyeButtonConfirm" style="z-index: 99999;" type="button" class="text-gray-600 hover:text-gray-700">
            <!-- Default "eye-off" SVG Icon -->
            <svg id="eyeIconConfirm" class="eye-off" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19.439 15.439C20.3636 14.5212 21.0775 13.6091 21.544 12.955C21.848 12.5287 22 12.3155 22 12C22 11.6845 21.848 11.4713 21.544 11.045C20.1779 9.12944 16.6892 5 12 5C11.0922 5 10.2294 5.15476 9.41827 5.41827M6.74742 6.74742C4.73118 8.1072 3.24215 9.94266 2.45604 11.045C2.15201 11.4713 2 11.6845 2 12C2 12.3155 2.15201 12.5287 2.45604 12.955C3.8221 14.8706 7.31078 19 12 19C13.9908 19 15.7651 18.2557 17.2526 17.2526" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M9.85786 10C9.32783 10.53 9 11.2623 9 12.0711C9 13.6887 10.3113 15 11.9289 15C12.7377 15 13.47 14.6722 14 14.1421" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" />
                <path d="M3 3L21 21" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </span>

    <!-- Optional Left Icon Button -->
    <span class="absolute inset-y-0 left-0 grid w-10 place-content-center">
        <button type="button" class="text-gray-600 hover:text-gray-700">
            <!-- Optional Lock Icon SVG -->
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 11H5C3.89543 11 3 11.8954 3 13V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V13C21 11.8954 20.1046 11 19 11Z" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M7 11V7C7 5.67392 7.52678 4.40215 8.46447 3.46447C9.40215 2.52678 10.6739 2 12 2C13.3261 2 14.5979 2.52678 15.5355 3.46447C16.4732 4.40215 17 5.67392 17 7V11" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </span>
</div>

@push('script')
<script>
    document.getElementById('eyeButtonConfirm').addEventListener('click', function() {
        const passTypeChangeConfirm = document.getElementById('passTypeChangeConfirm');
        const eyeIconConfirm = document.getElementById('eyeIconConfirm');

        if (eyeIconConfirm.classList.contains('eye-off')) {
            passTypeChangeConfirm.setAttribute('type', 'text');
            eyeIconConfirm.outerHTML = `
                        <svg id="eyeIconConfirm" class="eye-on" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5C7.31078 5 3.8221 9.12944 2.45604 11.045C2.15201 11.4713 2 11.6845 2 12C2 12.3155 2.15201 12.5287 2.45604 12.955C3.8221 14.8706 7.31078 19 12 19C16.6892 19 20.1779 14.8706 21.544 12.955C21.848 12.5287 22 12.3155 21.544 11.045C20.1779 9.12944 16.6892 5 12 5Z" stroke="#5e666e" stroke-width="1.5"/>
                            <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#5e666e" stroke-width="1.5"/>
                        </svg>
                    `;
        } else {
            passTypeChangeConfirm.setAttribute('type', 'password');
            eyeIconConfirm.outerHTML = `
                        <svg id="eyeIconConfirm" class="eye-off" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.439 15.439C20.3636 14.5212 21.0775 13.6091 21.544 12.955C21.848 12.5287 22 12.3155 22 12C22 11.6845 21.848 11.4713 21.544 11.045C20.1779 9.12944 16.6892 5 12 5C11.0922 5 10.2294 5.15476 9.41827 5.41827M6.74742 6.74742C4.73118 8.1072 3.24215 9.94266 2.45604 11.045C2.15201 11.4713 2 11.6845 2 12C2 12.3155 2.15201 12.5287 2.45604 12.955C3.8221 14.8706 7.31078 19 12 19C13.9908 19 15.7651 18.2557 17.2526 17.2526" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9.85786 10C9.32783 10.53 9 11.2623 9 12.0711C9 13.6887 10.3113 15 11.9289 15C12.7377 15 13.47 14.6722 14 14.1421" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M3 3L21 21" stroke="#5e666e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    `;
        }
    });
</script>
@endpush
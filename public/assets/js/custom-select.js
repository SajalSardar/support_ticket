// function initCustomSelect() {
//     const customSelects = document.querySelectorAll('.custom-select');
//     customSelects.forEach(customSelect => {
//         customSelect.addEventListener('click', function (event) {
//             event.stopPropagation();
//             customSelect.classList.toggle('active');
//             const input = customSelect.querySelector('input');
//             const data = event.target.getAttribute('data-value');

//             if (data) {
//                 input.value = data;
//                 input.dispatchEvent(new Event('change'));
//                 customSelect.querySelector('.selected').textContent = event.target.textContent;
//                 customSelect.classList.remove('active');
//             }
//         });
//     });

//     document.addEventListener('click', function () {
//         customSelects.forEach(customSelect => customSelect.classList.remove('active'));
//     });
// }

// document.addEventListener('DOMContentLoaded', initCustomSelect);



function initCustomSelect() {
    const customSelects = document.querySelectorAll('.custom-select');
    customSelects.forEach(customSelect => {
        customSelect.addEventListener('click', function (event) {
            event.stopPropagation();
            customSelect.classList.toggle('active');

            const input = customSelect.querySelector('input');
            const data = event.target.getAttribute('data-value');

            if (data) {
                input.value = data;
                input.dispatchEvent(new Event('input', { bubbles: true }));

                customSelect.querySelector('.selected').textContent = event.target.textContent;
                customSelect.classList.remove('active');
            }
        });
    });

    document.addEventListener('click', function () {
        customSelects.forEach(customSelect => customSelect.classList.remove('active'));
    });
}

document.addEventListener('DOMContentLoaded', initCustomSelect);
Livewire.hook('message.processed', initCustomSelect);

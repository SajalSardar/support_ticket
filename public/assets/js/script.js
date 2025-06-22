// start: Sidebar
const hamberger = document.querySelector(".hamberger button");
const sidebarToggle = document.querySelector(".sidebar-toggle");
const sidebarOverlay = document.querySelector(".sidebar-overlay");
const sidebarMenu = document.querySelector(".sidebar-menu");
const main = document.querySelector(".main");
sidebarToggle.addEventListener("click", function (e) {
    e.preventDefault();
    main.classList.toggle("active");
    sidebarOverlay.classList.toggle("hidden");
    sidebarMenu.classList.toggle("-translate-x-full");
});

sidebarOverlay.addEventListener("click", function (e) {
    e.preventDefault();
    main.classList.add("active");
    sidebarOverlay.classList.add("hidden");
    sidebarMenu.classList.add("-translate-x-full");
});
document.querySelectorAll(".sidebar-dropdown-toggle").forEach(function (item) {
    item.addEventListener("click", function (e) {
        e.preventDefault();
        const parent = item.closest(".group");
        if (parent.classList.contains("selected")) {
            parent.classList.remove("selected");
        } else {
            document
                .querySelectorAll(".sidebar-dropdown-toggle")
                .forEach(function (i) {
                    i.closest(".group").classList.remove("selected");
                });
            parent.classList.add("selected");
        }
    });
});


const popperInstance = {};
document.querySelectorAll(".dropdown").forEach(function (item, index) {
    const popperId = "popper-" + index;
    const toggle = item.querySelector(".dropdown-toggle");
    const menu = item.querySelector(".dropdown-menu");
    menu.dataset.popperId = popperId;
    popperInstance[popperId] = Popper.createPopper(toggle, menu, {
        modifiers: [
            {
                name: "offset",
                options: {
                    offset: [0, 8],
                },
            },
            {
                name: "preventOverflow",
                options: {
                    padding: 24,
                },
            },
        ],
        placement: "bottom-end",
    });
});
document.addEventListener("click", function (e) {
    const toggle = e.target.closest(".dropdown-toggle");
    const menu = e.target.closest(".dropdown-menu");
    if (toggle) {
        const menuEl = toggle
            .closest(".dropdown")
            .querySelector(".dropdown-menu");
        const popperId = menuEl.dataset.popperId;
        if (menuEl.classList.contains("hidden")) {
            hideDropdown();
            menuEl.classList.remove("hidden");
            showPopper(popperId);
        } else {
            menuEl.classList.add("hidden");
            hidePopper(popperId);
        }
    } else if (!menu) {
        hideDropdown();
    }
});

function hideDropdown() {
    document.querySelectorAll(".dropdown-menu").forEach(function (item) {
        item.classList.add("hidden");
    });
}

function showPopper(popperId) {
    popperInstance[popperId].setOptions(function (options) {
        return {
            ...options,
            modifiers: [
                ...options.modifiers,
                {
                    name: "eventListeners",
                    enabled: true,
                },
            ],
        };
    });
    popperInstance[popperId].update();
}

function hidePopper(popperId) {
    popperInstance[popperId].setOptions(function (options) {
        return {
            ...options,
            modifiers: [
                ...options.modifiers,
                {
                    name: "eventListeners",
                    enabled: false,
                },
            ],
        };
    });
}

document.querySelectorAll("[data-tab]").forEach(function (item) {
    item.addEventListener("click", function (e) {
        e.preventDefault();
        const tab = item.dataset.tab;
        const page = item.dataset.tabPage;
        const target = document.querySelector(
            '[data-tab-for="' + tab + '"][data-page="' + page + '"]'
        );
        document
            .querySelectorAll('[data-tab="' + tab + '"]')
            .forEach(function (i) {
                i.classList.remove("active");
            });
        document
            .querySelectorAll('[data-tab-for="' + tab + '"]')
            .forEach(function (i) {
                i.classList.add("hidden");
            });
        item.classList.add("active");
        target.classList.remove("hidden");
    });
});


let toggleMenuButton = document.querySelector(".toggle-menu-button");
let toggleMenu = document.querySelector(".toggle-menu");

toggleMenuButton.addEventListener("click", function (e) {
    if (toggleMenu.style.display == "none") {
        toggleMenu.style.display = "block";
    } else {
        toggleMenu.style.display = "none";
    }
});

/**
 * Dropdown item in notification and email notification
 */
let toggleNotificationButton = document.querySelector(
    ".toggle-notification-button"
);
let toggleNotificationBox = document.querySelector(".toggle-notification-box");

toggleNotificationButton.addEventListener("click", function (e) {
    if (toggleNotificationBox.style.display == "none") {
        toggleNotificationBox.style.display = "block";
    } else {
        toggleNotificationBox.style.display = "none";
    }
});
let toggleEmailNotificationButton = document.querySelector(
    ".toggle-email-notification-button"
);
let toggleEmailNotificationBox = document.querySelector(
    ".toggle-email-notification-box"
);



document.addEventListener('DOMContentLoaded', function () {
    let tabs = document.querySelectorAll('.tab');
    let contents = document.querySelectorAll('.tab-content');

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function (e) {
            let targetId = tab.id.replace('Tab', 'Content');

            contents.forEach(function (content) {
                content.classList.add('hidden');
            });

            tabs.forEach(function (tab) {
                tab.classList.remove('border-primary-400', '!text-primary-400');
                tab.classList.add('border-transparent', 'text-gray-400');
            });

            document.getElementById(targetId).classList.remove('hidden');

            tab.classList.add('border-primary-400', '!text-primary-400');
            tab.classList.remove('border-transparent', 'text-gray-400');
        });
    });
});


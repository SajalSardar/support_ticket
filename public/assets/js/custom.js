function submitSwitchAccount(event) {
    event.target.closest("form").submit();
}

function initSelect2(eliment_id_and_name = "") {
    $(`#${eliment_id_and_name}`)
        .select2({
            allowClear: true,
        })
        .on("change", function (e) {
            let data = $(this).val();
            let componentId = $(`#${eliment_id_and_name}`)
                .closest("[wire\\:id]")
                .attr("wire:id");
            Livewire.find(componentId).set(eliment_id_and_name, data);
        });
}

function initSelect2form(eliment_id_and_name = "") {
    $(`#${eliment_id_and_name}`)
        .select2({
            allowClear: true,
        })
        .on("change", function (e) {
            let data = $(this).val();
            let componentId = $(`#${eliment_id_and_name}`)
                .closest("[wire\\:id]")
                .attr("wire:id");
            Livewire.find(componentId).set("form." + eliment_id_and_name, data);
        });
}

// Toggle action
let currentlyOpenAction = null;
function toggleAction(ticketId) {
    let actionDiv = document.getElementById("action-" + ticketId);

    if (currentlyOpenAction === actionDiv) {
        actionDiv.style.display = "none";
        currentlyOpenAction = null;
        return;
    }

    if (currentlyOpenAction) {
        currentlyOpenAction.style.display = "none";
    }
    actionDiv.style.display = "block";
    currentlyOpenAction = actionDiv;
}

document.addEventListener("click", function (event) {
    if (
        currentlyOpenAction &&
        !event.target.closest(".action-container") &&
        !event.target.closest("button")
    ) {
        currentlyOpenAction.style.display = "none";
        currentlyOpenAction = null;
    }
});

function activeCkEditor(eliment) {
    const editor = ClassicEditor.create(document.querySelector(`#${eliment}`), {
        toolbar: [
            "heading",
            "bold",
            "italic",
            "link",
            "bulletedList",
            "numberedList",
            "blockQuote",
        ],
        fontFamily: {
            options: ['default', 'Inter'],
            supportAllValues: true,
        },
        fontSize: {
            options: [14, 'default'],
            default: 14,
        },
        fontColor: {
            colors: [
                {
                    color: '#5e666e',
                    label: '#5e666e',
                },
            ],
            columns: 5,
        },

    })
        .then((editor) => {
            const editorContentStyles = `
                .ck-content {
                    font-family: 'Inter', sans-serif;
                    font-size: 14px;
                    font-weight: 400;
                }
            `;
            const styleElement = document.createElement('style');
            styleElement.textContent = editorContentStyles;
            document.head.appendChild(styleElement);
        })
        .catch((error) => {
            console.error(error);
        });
}

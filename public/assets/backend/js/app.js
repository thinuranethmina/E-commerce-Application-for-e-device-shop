document.addEventListener('DOMContentLoaded', function() {

    function highlightActiveMenu(selector) {
        let url = window.location.href.split(/[?#]/)[0];
        let active = document.querySelector(`.${selector}[href="${url}"]`);

        if (active) {
            document
                .querySelectorAll(`.${selector}.active`)
                .forEach((el) => el.classList.remove("active"));
            active.classList.add("active");
            var accordion = active.closest('div.accordion-collapse');
            if (accordion) {
                accordion.classList.add("show");
            }
        }
    }
    highlightActiveMenu("side-menu__item");

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    loadChoices = function() {
        const choices = document.querySelectorAll('.choices');
        choices.forEach(choice => {
            if (
                (choice.tagName === 'SELECT') ||
                (choice.tagName === 'INPUT' && choice.type === 'text')
            ) {
                choice.choicesInstance = new Choices(choice, {
                    shouldSort: false,
                    itemSelectText: '',
                    searchEnabled: true,
                });
            }
        });
    };

    loadChoices();

    loadAjaxForm();
});

const searchForm = document.getElementById('searchForm');
if (searchForm) {
    searchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        if (document.getElementById('search').value == '') {
            window.location.href = searchForm.action;
        } else {
            searchForm.submit();
        }
    });
}

const filterToggle = document.getElementById('filterToggle');
if (filterToggle) {
    filterToggle.addEventListener('click', (e) => {
        e.preventDefault();
        if (filter = document.getElementById('filter')) {
            if (filter.classList.contains('d-none')) {
                e.target.innerHTML = 'Clear Filter';
            } else {
                e.target.innerHTML = '<i class="fi fi-rr-filter"></i> Filter';
                window.location.href = window.location.href.split(/[?#]/)[0];
            }
            filter.classList.toggle('d-none');
        }
    });
}

if (document.getElementById('filter')) {
    document.getElementById('filter').querySelectorAll('select').forEach(item => {
        item.addEventListener('change', function() {
            searchForm.submit();
        });
    })
    document.getElementById('filter').querySelectorAll('input').forEach(item => {
        item.addEventListener('change', function() {
            searchForm.submit();
        });
    })
}


function formatPrice(element) {

    let price = element.value.toString().replaceAll(',', '').replace(/^0+(?!$)/, '');

    let f_price = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    element.value = f_price;

}

function keyBlocker(event, type) {
    if (type == "price") {
        var charCode = (event.which) ? event.which : event.keyCode;
        if ((charCode > 47 && charCode < 58) || (charCode > 95 && charCode < 106) || charCode == 8 || charCode == 110 || charCode == 188) {
            return true;
        }

        event.preventDefault();
    } else if (type == "qty") {
        var charCode = (event.which) ? event.which : event.keyCode;
        if ((charCode > 47 && charCode < 58) || (charCode > 95 && charCode < 106) || charCode == 8 || charCode == 110) {
            return true;
        }

        event.preventDefault();
    }
}


let previousFile = null;

function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);

    if (!input.files || input.files.length === 0) {
        input.files = previousFile;
        return false;
    }

    const file = input.files[0];
    const reader = new FileReader();

    if (file.type.startsWith('image/')) {
        previousFile = input.files;
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        input.value = '';
    }
}

function scrollIntoViewIfNeeded(element) {
    if (!element) return;

    const rect = element.getBoundingClientRect();

    if (rect.top < 0) {
        element.scrollIntoView({
            behavior: "smooth",
            block: "start",
            inline: "nearest",
        });
    } else if (rect.bottom > window.innerHeight) {
        element.scrollIntoView({
            behavior: "smooth",
            block: "end",
            inline: "nearest",
        });
    }
}

// TOASTIFY
function showToast(message) {
    Toastify({
        text: message,
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
    }).showToast();
}


// TINYMCE
function initTinyMce() {
    // Select all elements with the class .editor and initialize TinyMCE for each
    document.querySelectorAll(".editor").forEach((editorElement) => {
        tinymce.init({
            target: editorElement, // Target each individual element
            plugins: "advlist autolink lists link image charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table directionality template importcss",
            toolbar: "undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify outdent indent | numlist bullist | forecolor backcolor removeformat | subscript superscript | link image media | table | charmap emoticons | code | tinydrive",
            automatic_uploads: true,
            file_picker_types: "image",
            file_picker_callback: (cb, value, meta) => {
                const input = document.createElement("input");
                input.setAttribute("type", "file");
                input.setAttribute("accept", "image/*");

                input.addEventListener("change", (e) => {
                    const file = e.target.files[0];
                    const reader = new FileReader();

                    reader.addEventListener("load", () => {
                        const id = "blobid" + new Date().getTime();
                        const blobCache =
                            tinymce.activeEditor.editorUpload.blobCache;
                        const base64 = reader.result.split(",")[1];
                        const blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        cb(blobInfo.blobUri(), {
                            title: file.name,
                        });
                    });

                    reader.readAsDataURL(file);
                });

                input.click();
            },
            content_style: "body { font-family:Helvetica,Arial,sans-serif; font-size:16px }",
        });
    });
}
initTinyMce();


function loadAjaxForm() {
    // document.querySelectorAll(".ajaxForm").forEach(form => {
    //     form.addEventListener('submit', (e) => {
    //         e.preventDefault();

    //         const submitButton = form.querySelector('[type="submit"]');
    //         if (submitButton) {
    //             submitButton.disabled = true;
    //             submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' + submitButton.innerHTML;
    //         }

    //         const formData = new FormData(form);

    //         for (var i = 0; i < imageArray.length; i++) {
    //             formData.append('image' + i, imageArray[i].image);
    //             formData.append('imageStatus' + i, imageArray[i].status);
    //         }
    //         formData.append('length', imageArray.length);



    //         fetch(form.action, {
    //                 method: form.method,
    //                 headers: {
    //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    //                 },
    //                 body: formData,
    //             })
    //             .then(response => response.json())
    //             .then(data => {
    //                 if (submitButton) {
    //                     submitButton.disabled = false;
    //                     submitButton.innerHTML = submitButton.textContent;
    //                 }

    //                 showToast(data.message);

    //                 if (data.success) {
    //                     if (data.redirect) {
    //                         setTimeout(() => {
    //                             window.location.href = data.redirect;
    //                         }, 1500);
    //                     }
    //                 }
    //             })
    //             .catch(error => {
    //                 if (submitButton) {
    //                     submitButton.disabled = false;
    //                 }
    //                 console.error('Error:', error);
    //                 showToast('An error occurred.');
    //             });
    //     });
    // });

    document.querySelectorAll(".ajaxForm").forEach(form => {
        let actionType = "save";

        form.querySelectorAll("[type='submit']").forEach(button => {
            button.addEventListener("click", function() {
                actionType = this.value || "save";
            });
        });

        form.addEventListener("submit", (e) => {
            e.preventDefault();

            const submitButton = form.querySelector('[type="submit"]:focus');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' + submitButton.innerHTML;
            }

            const formData = new FormData(form);
            formData.append('action', actionType);

            fetch(form.action, {
                    method: form.method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = submitButton.textContent;
                    }

                    showToast(data.message);

                    if (data.success) {

                        if (data.redirect) {
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 1500);
                        } else if (actionType == "save_exit") {

                            let url = window.location.href.split(/[?#]/)[0];
                            let exitUrl = window.location.origin + "/admin/" + url.match(/\/admin\/([^\/]+)/)[1];

                            setTimeout(() => {
                                window.location.href = exitUrl;
                            }, 1500);
                        }
                    }
                })
                .catch(error => {
                    if (submitButton) {
                        submitButton.disabled = false;
                    }
                    console.error('Error:', error);
                    showToast('An error occurred.');
                });
        });
    });
}

function loadModal(page, type, id = null) {
    let url;
    let requestMethod = 'GET';

    if (type === 'create') {
        url = `/admin/${page}/create`;
    } else if (type === 'edit') {
        url = `/admin/${page}/${id}/edit`;
    } else {
        url = `/admin/${page}/${id}`;
    }

    fetch(url, {
            method: requestMethod,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            openModal(data.html);
            loadAjaxForm();
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function deleteItem(id, page) {

    Swal.fire({
        title: 'Heads up!',
        text: "Are you sure?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Continue'
    }).then((result) => {
        if (result.isConfirmed) {

            fetch(`/admin/${page}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    showToast(data.message);

                    if (data.success) {
                        if (data.redirect) {
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 1500);
                        }
                    }

                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred while submitting the form.');
                });
        }
    });
}

function openModal(data) {
    const modal = document.getElementById("mainModal");
    if (modal) {
        const modalContentElement = modal.querySelector('#modalContent');
        if (modal.classList.contains('show')) {
            modalContentElement.innerHTML = data;
        } else {
            modalContentElement.innerHTML = data;

            // const existingBackdrop = document.querySelector('.modal-backdrop');
            // if (existingBackdrop) {
            //     existingBackdrop.remove();
            //     document.body.style.overflow = 'auto';
            // }

            new bootstrap.Modal(modal).show();
        }

        $('input[data-role="tagsinput"]').tagsinput();

    } else {
        console.error('Modal not found');
    }
}

function closeModal() {
    const modal = document.getElementById('mainModal');
    if (modal) {
        const bootstrapModal = bootstrap.Modal.getInstance(modal);
        bootstrapModal.hide();
        document.body.style.overflow = 'auto';
        const modalContentElement = modal.querySelector('#modalContent');
        modalContentElement.innerHTML = '';

    } else {
        console.error('Modal not found');
    }
}

function addVariationValue() {

    const container = document.getElementById('variationContainer');

    container.insertAdjacentHTML('beforeend', `
                        <div class="row mb-2">
                            <div class="col pe-0">
                                <input type="text" id="name" name="values[]" class="form-control">
                            </div>
                            <div class="col-2 pe-0">
                                <input type="color" id="color" name="colors[]" class="form-control">
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-dark h-100" onclick="removeVariationValue(this)">
                                    <span class="fi fi-rr-minus-circle d-flex"></span>
                                </button>
                            </div>
                        </div>
    `);

}

function removeVariationValue(button) {
    const row = button.closest('.row');
    const container = button.closest('.variationContainer');
    if (row) row.remove();

    const remainingSelect = container.querySelector('.variationName');
    if (remainingSelect) {
        validateVariationAttribute(remainingSelect);
    }
}

function validateVariationAttribute(element) {

    let selected = [];

    const container = element.closest('.variationContainer');
    if (!container) {
        console.error('Variation container not found.');
        return;
    }
    container.querySelectorAll('.variationName').forEach((select) => {
        if (select.value !== "") {
            selected.push(select.value);
        }
    });

    container.querySelectorAll('.variationName').forEach((select) => {

        select.querySelectorAll('option').forEach((option) => {
            option.disabled = false;
        });

        selected.forEach((value) => {
            if (value !== "" && value !== select.value) {
                const optionToDisable = select.querySelector(`option[value="${value}"]`);
                if (optionToDisable) {
                    optionToDisable.disabled = true;
                }
            }
        });
    });

}

function getVariationValue(element) {

    validateVariationAttribute(element);

    fetch(`/admin/variation/${element.value}/values`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const variationValueSelect = element
                    .closest('.row')
                    .querySelector('.variationValue');

                variationValueSelect.innerHTML = data.html;

            } else {
                showToast(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function addVariationAttribute(element, index) {


    fetch(`/admin/product/variation/row/${index}`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const variationValueSelect = element
                    .closest('.variationContainer');

                variationValueSelect.insertAdjacentHTML('beforeend', data.html);

                validateVariationAttribute(element);

                scrollIntoViewIfNeeded(variationValueSelect);

            } else {
                showToast(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}


function addProductVariation(element) {
    fetch(`/admin/product/variation/content`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const content = element
                    .closest('#productVariationContainer');

                content.insertAdjacentHTML('beforeend', data.html);

                scrollIntoViewIfNeeded(content);

            } else {
                showToast(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

document.addEventListener('DOMContentLoaded', function() {

    const {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Font,
        Paragraph
    } = CKEDITOR;

    ClassicEditor
        .create(document.querySelector('#editor'), {
            licenseKey: '<YOUR_LICENSE_KEY>',
            plugins: [Essentials, Bold, Italic, Font, Paragraph],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        })
        .then( /* ... */ )
        .catch( /* ... */ );

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

    // TAG INPUT
    const tagInput = document.querySelector('.bootstrap-tagsinput');
    if (tagInput) {
        tagInput.classList.add('form-control');
    }


    document.getElementById('main-modal').addEventListener('click', function(e) {

        // ADD ITEM FORM
        const addItemForm = document.getElementById('addItemForm');

        // if (e.target === this) {
        //     closeModal();
        // }

        if (addItemForm && !addItemForm.hasEventListener) {
            addItemForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(addItemForm);

                fetch(addItemForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message);
                            closeModal();
                            window.location.reload();
                        } else {
                            showToast(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred while submitting the form.');
                    });
            });

            addItemForm.hasEventListener = true;
        }

        // EDIT ITEM FORM
        const editItemForm = document.getElementById('editItemForm');

        if (editItemForm && !editItemForm.hasEventListener) {
            editItemForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);


                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message);
                            closeModal();
                            window.location.reload();
                        } else {
                            showToast(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred while submitting the form.');
                    });
            });

            editItemForm.hasEventListener = true;
        }
    });

    // TABLE SEARCH FILTER
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

    function highlightActiveMenu(selector) {

        // let url = `${window.location.origin}${window.location.pathname}`;
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

});


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


// PREVIEW IMAGE (previewImage(this, 'faviconPreview'))
function previewImage(input, previewId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    const reader = new FileReader();

    if (file && file.type.startsWith('image/')) {
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
    }
}

function loadModal(id, page, type) {
    const modal = document.getElementById('main-modal');
    let url;

    if (type === 'create') {
        url = `/admin/${page}/create`;
    } else if (type === 'edit') {
        url = `/admin/${page}/${id}/edit`;
    } else {
        url = `/admin/${page}/${id}`;
    }

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            modal.innerHTML = data.html;
            openModal();
        })
        .catch(error => {
            console.error('Error:', error);
            modal.innerHTML = `<p>Error loading data: ${error.message}. Please try again.</p>`;
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
                    if (data.success) {
                        showToast(data.message);
                        window.location.reload();
                    } else {
                        showToast(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred while submitting the form.');
                });
        }
    });
}


function openModal() {
    var modal = document.getElementById('main-modal');
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        loadChoices();
    } else {
        alert('Modal not found');
    }
}



let currentTab = 0; // Track the current tab index
function navigateTabs(step) {
    const tabs = document.querySelectorAll('.nav-tabs .nav-link');
    tabs[currentTab].classList.remove('active');
    document.querySelector(tabs[currentTab].getAttribute('href')).classList.remove('show', 'active');

    currentTab += step; // Move to next or previous tab

    // Enable/disable buttons based on tab position
    document.getElementById("backBtn").disabled = (currentTab === 0);
    document.getElementById("nextBtn").classList.toggle("d-none", currentTab === tabs.length - 1);
    document.getElementById("submitBtn").classList.toggle("d-none", currentTab !== tabs.length - 1);

    tabs[currentTab].classList.add('active');
    document.querySelector(tabs[currentTab].getAttribute('href')).classList.add('show', 'active');
}

function submitForm() {
    alert("Form Submitted!");
}

function closeModal() {
    var modal = document.getElementById('main-modal');
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    } else {
        alert('Modal not found');
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

function getSubjects(element) {

    fetch(`/admin/grade/${element.value}/subjects`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const subjects = document.getElementById("subject-selector");

                if (subjects.choicesInstance) {
                    subjects.choicesInstance.destroy();
                    subjects.choicesInstance = null;
                }

                subjects.innerHTML = data.html;

                const choicesInstance = new Choices(subjects, {
                    shouldSort: false,
                    itemSelectText: '',
                    searchEnabled: true,
                });

                subjects.choicesInstance = choicesInstance;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

}

function addVideoLinkRow() {
    const videoLinksRows = document.getElementById("videoLinksRows");
    const newRow = document.createElement("div");
    newRow.classList.add("d-flex", "gap-2", "my-2");
    newRow.innerHTML = `
        <input type="text" id="video_url" name="video_title[]" class="form-control"
                                    placeholder="Title">
                                <input type="text" id="video_url" name="video_url[]" class="form-control"
                                    placeholder="https://...">
                                <button type="button" class="btn close-btn px-3" onclick="removeVideoLinkRow(this)"><i
                                        class="fi fi-rr-minus-circle"></i></button>`;
    videoLinksRows.appendChild(newRow);
}

function addPdfRow() {
    const pdfRows = document.getElementById("pdfRows");
    const newRow = document.createElement("div");
    newRow.classList.add("d-flex", "gap-2", "my-2");
    newRow.innerHTML = `
        <input type="text" id="pdf_url" name="pdf_title[]" class="form-control"
                                    placeholder="Title">
                                <input type="file" id="pdf_file" name="pdf_file[]" class="form-control"
                                    accept="application/pdf">
                                <button type="button" class="btn close-btn px-3" onclick="removePdfRow(this)"><i
                                        class="fi fi-rr-minus-circle"></i></button>`;
    pdfRows.appendChild(newRow);
}

function removeVideoLinkRow(button) {
    button.closest("div").remove();
}

function removePdfRow(button) {
    button.closest("div").remove();
}

function deleteMedia(element, id) {

    Swal.fire({
        title: 'Warning!',
        text: "Are you sure? Do you want to delete this?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Continue'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/meetings/media/delete/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        element.closest("tr").remove();
                    } else {
                        showToast(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    });

}

function changeMeetingStatus(id, status) {
    Swal.fire({
        title: 'Heads up!',
        text: "Are you sure?",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Continue'
    }).then((result) => {
        if (result.isConfirmed) {

            fetch(`/admin/meetings/change-status/${status}/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                }).then(response => response.json())
                .then(data => {

                    if (data.success) {
                        window.location.reload();
                    } else {
                        showToast(data.message);
                    }

                }).catch(error => {
                    console.error('Error:', error);
                });
        }
    });
}


function classHasStudents(id) {

    const modal = document.getElementById('main-modal');

    fetch(`/admin/classes/${id}/has-students`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        }).then(response => response.json())
        .then(data => {

            if (data.success) {
                modal.innerHTML = data.html;
                openModal();
            } else {
                showToast(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}


function instructorHasClasses(id) {
    const modal = document.getElementById('main-modal');

    fetch(`/admin/instructors/${id}/has-classes`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        }).then(response => response.json())
        .then(data => {

            if (data.success) {
                modal.innerHTML = data.html;
                openModal();
            } else {
                showToast(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

}

function studentHasClasses(id) {
    const modal = document.getElementById('main-modal');
    fetch(`/admin/students/${id}/has-classes`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        }).then(response => response.json())
        .then(data => {

            if (data.success) {
                modal.innerHTML = data.html;
                openModal();
            } else {
                showToast(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function studentHasPayments(id) {

    const modal = document.getElementById('main-modal');

    fetch(`/admin/students/${id}/has-payments`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        }).then(response => response.json())
        .then(data => {

            if (data.success) {
                modal.innerHTML = data.html;
                openModal();
            } else {
                showToast(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

}

function exportData(url) {

    var type = document.getElementById('export_type').value;

    if (type == '') {
        showToast('Please select a file type');
        return;
    }

    var search = document.getElementById('search').value;

    var form = new FormData();
    form.append('search', search);
    form.append('type', type);

    fetch(`/admin/${url}/export`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: form,
        })
        .then(response => response.blob())
        .then(blob => {
            var downloadUrl = window.URL.createObjectURL(blob);
            var link = document.createElement('a');
            link.href = downloadUrl;
            link.download = `${url}.${type}`;
            document.body.appendChild(link);
            link.click();
            link.remove();
            window.URL.revokeObjectURL(downloadUrl);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
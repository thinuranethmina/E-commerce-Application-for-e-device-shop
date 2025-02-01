document.addEventListener('scroll', () => {
    const header = document.getElementById('navbar');
    const cartDetail = document.getElementById('header-cart-detail');
    if (window.scrollY > 85) {
        header.classList.add('scrolled');
        cartDetail.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
        cartDetail.classList.remove('scrolled');
    }
});

var $owl = $('.owl-carousel');

$owl.children().each(function(index) {
    $(this).attr('data-position', index);
});

$owl.owlCarousel({
    center: true,
    loop: true,
    items: 2,
    dots: true,
    responsive: {
        0: {
            items: 1
        },
        700: {
            items: 1.5
        },
        800: {
            items: 2
        }
    }
});

$(document).on('click', '.owl-item>div', function() {
    var $speed = 300;
    $owl.trigger('to.owl.carousel', [$(this).data('position'), $speed]);
});

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

function openModal(html) {
    const modal = document.getElementById("mainModal");
    if (modal) {
        const modalContentElement = modal.querySelector('#modalContent');
        if (modalContentElement) {
            modalContentElement.innerHTML = html;

            const existingBackdrop = document.querySelector('.modal-backdrop');
            if (existingBackdrop) {
                existingBackdrop.remove();
                document.body.style.overflow = 'auto';
            }

            new bootstrap.Modal(modal).show();
        }
    } else {
        console.error('Modal not found');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        const bootstrapModal = bootstrap.Modal.getInstance(modal);
        // bootstrapModal.hide();
        if (modal.classList.contains('show')) {
            bootstrapModal.hide();
            document.body.style.overflow = 'auto';
        }
    } else {
        console.error('Modal not found');
    }
}


let sidecart = document.getElementById('sidecart');
let overlay = document.getElementById('overlay');

function cartToggle() {
    sidecart.classList.toggle('show');

    if (sidecart.classList.contains('show')) {
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    } else {
        overlay.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
}


if (overlay) {
    overlay.addEventListener('click', function() {
        cartToggle();
    });
}

$('.navbar-section .dropdown-toggle').mouseover(function() {
    $(this).siblings('.dropdown-menu').show();
});

$('.navbar-section .dropdown-toggle').mouseout(function() {
    const dropdownMenu = $(this).siblings('.dropdown-menu');
    let t = setTimeout(function() {
        dropdownMenu.hide();
    }, 100);

    dropdownMenu.on('mouseenter', function() {
        $(this).show();
        clearTimeout(t);
    }).on('mouseleave', function() {
        $(this).hide();
    });
});

document.getElementById('navbar-offcanvas').addEventListener('click', function(e) {
    if (e.target.classList.contains('navbar-offcanvas')) {
        e.target.classList.toggle('show');
    }
});

function toggleNavBar() {
    document.getElementById('navbar-offcanvas').classList.toggle('show');
}

function cartItemQuantityUpdate(id, qty) {
    fetch(`/cart/change/qty/${id}/${qty}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {} else {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}


// Detail Page Product Functions
function changeQty(action) {
    var qtyInput = document.getElementById('qty');
    var currentQty = parseInt(qtyInput.value);
    var maxQty = parseInt(qtyInput.getAttribute('max'));

    if (action === '-') {
        if (currentQty > 1) {
            currentQty--;
        }
    } else if (action === '+') {
        if (currentQty < maxQty) {
            currentQty++;
        } else {
            showToast('Product out of stock');
        }
    }

    qtyInput.value = currentQty;
    if (maxQty > 0) {
        updatePrice(null, currentQty);
    }
}

// function changeCartQty(action, id) {
//     var qtyInput = document.getElementById('item-quantity-' + id);
//     var currentQty = parseInt(qtyInput.value);
//     alert(currentQty);
//     if (action === '-') {
//         if (currentQty > 1) {
//             currentQty--;
//         }
//     } else if (action === '+') {
//         currentQty++;
//     }
//     qtyInput.value = currentQty;
// }

function updatePrice(price, qty = 1) {

    var originalPrice = document.getElementById('original-price');
    var productPrice = document.getElementById('product-price');

    if (price > 0) {
        originalPrice.value = price;
    }

    const unitPrice = originalPrice.value;
    const totalPrice = unitPrice * qty;

    var formatPrice = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(totalPrice);

    if (productPrice) {
        productPrice.innerHTML = 'RS ' + formatPrice + '/=';
    }
}


function addToCart(element) {

    var productVariationIdInput = document.getElementById('product_variation_id');
    var id = productVariationIdInput ? productVariationIdInput.value : element.getAttribute('data-variation-id');

    var qtyInput = document.getElementById('qty');
    var qty = qtyInput ? qtyInput.value : 1;

    if (id) {
        var formData = new FormData();
        formData.append('product_id', id);
        formData.append('qty', qty);

        fetch(`/cart/add`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    var cartContainer = document.getElementById('cart-items');
                    cartContainer.innerHTML = data.html;

                    document.getElementById('header-cart-qty').textContent = data.total;
                    document.getElementById('header-cart-total').textContent = data.total_price;
                    document.getElementById('sidebar-cart-total').textContent = data.total_price;

                    // cartToggle();
                } else {
                    showToast(data.message);
                }
                reloadCartFunction();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        showToast('Product not found');
    }
}

function removeCartItem(id) {

    fetch(`/cart/remove/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const cartItem = document.getElementById(`cart-item-${id}`);
                if (cartItem) {
                    cartItem.remove();
                }
                if (data.total || data.total == 0) {
                    let total = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    }).format(data.total);
                    document.getElementById('header-cart-total').innerHTML = total;
                    document.getElementById('sidebar-cart-total').innerHTML = total;
                }
                if (data.item_count || data.item_count == 0) {
                    document.getElementById('header-cart-qty').innerHTML = data.item_count;
                }
                if (orderSummeryCard = document.querySelector('.order-summery-card')) {
                    let total = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    }).format(data.total);
                    let grand_total = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    }).format(data.total + data.grand_total);
                    orderSummeryCard.querySelector('.sub-total').innerHTML = total;
                    orderSummeryCard.querySelector('.total-price').innerHTML = grand_total;
                }
                showToast('Item removed successfully.');
            } else {
                showToast(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}


function searchResult() {
    var search = document.getElementById('main-search').value;

    var form = new FormData();
    form.append('search', search);

    fetch(`/search`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: form,
        })
        .then(response => response.text())
        .then(data => {
            if (search == '') {
                let container = document.getElementById('searchResult');
                container.classList.add('d-none');
                container.innerHTML = '';
                return;
            }
            let container = document.getElementById('searchResult');
            container.classList.remove('d-none');
            container.innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

document.addEventListener('click', function(event) {
    const searchInput = document.getElementById('main-search');
    const searchResultContainer = document.getElementById('searchResult');

    if (!searchInput.contains(event.target) && !searchResultContainer.contains(event.target)) {
        searchResultContainer.classList.add('d-none');
    }
});

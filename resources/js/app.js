import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'

const swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
        el: '.swiper-scrollbar',
    },
});


document.addEventListener('DOMContentLoaded', function () {
    const alert = document.getElementById('success-alert');
    if (alert) {
        setTimeout(() => {
            alert.style.right = '20px';
        }, 100);

        setTimeout(() => {
            alert.style.right = '-300px';
        }, 3000);

        setTimeout(() => {
            alert.remove();
        }, 3500);
    }
});
document.addEventListener('DOMContentLoaded', () => {
    const quantityInput = document.getElementById('quantity');
    const hiddenQuantityInput = document.getElementById('hidden-quantity');
    const increaseBtn = document.getElementById('increase-quantity');
    const decreaseBtn = document.getElementById('decrease-quantity');
    const cartForm = document.getElementById('cart-form');

    // Increase quantity
    increaseBtn.addEventListener('click', () => {
        const currentValue = parseInt(quantityInput.value) || 1;
        quantityInput.value = currentValue + 1;
        updateHiddenQuantity();
    });

    // Decrease quantity
    decreaseBtn.addEventListener('click', () => {
        const currentValue = parseInt(quantityInput.value) || 1;
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
        updateHiddenQuantity();
    });

    // Update the hidden quantity input before submitting the form
    function updateHiddenQuantity() {
        hiddenQuantityInput.value = quantityInput.value;
    }

    // Ensure hidden quantity is updated when the form is submitted
    cartForm.addEventListener('submit', (event) => {
        updateHiddenQuantity();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.wishlist-toggle').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.productId;

            fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ product_id: productId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'added' || data.status === 'removed') {
                        // Check the reload flag and reload the page if true
                        if (data.reload) {
                            location.reload(); // Reload the page after update
                        }
                    } else {
                        console.error('Error:', 'Unexpected response from the server.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
});



// function updateWishlistCount() {
//     fetch('/wishlist/count')
//         .then(response => response.json())
//         .then(data => {
//             const wishlistBadge = document.querySelector('.wishlist .badge');
//             if (wishlistBadge) {
//                 wishlistBadge.textContent = data.count;
//             }
//         });
// }
//
// // Call the function to update the wishlist count on page load
// updateWishlistCount();

document.addEventListener('DOMContentLoaded', function() {
    // Get all the decrease and increase buttons
    const decreaseButtons = document.querySelectorAll('.decrease-btn');
    const increaseButtons = document.querySelectorAll('.increase-btn');
    const quantityInput = document.getElementById('quantity');
    // Add event listeners to decrease buttons
    decreaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = button.getAttribute('data-product-id');
            updateQuantity(productId, -1);
            submitCartForm(productId);
        });
    });

    // Add event listeners to increase buttons
    increaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = button.getAttribute('data-product-id');
            updateQuantity(productId, 1);
            submitCartForm(productId);
        });
    });
});

function updateQuantity(productId, delta) {
    const quantityInput = document.getElementById('quantity-' + productId);
    let currentQuantity = parseInt(quantityInput.value);
    if (currentQuantity + delta >= 1) {
        currentQuantity += delta;
        quantityInput.value = currentQuantity;
    }
}

function submitCartForm(productId) {
    const form = document.getElementById('cart-form-' + productId);
    form.submit();
}


// document.addEventListener('DOMContentLoaded', () => {
//     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
//
//     document.querySelectorAll('.wishlist-toggle').forEach((btn) => {
//         btn.addEventListener('click', (event) => {
//             const target = event.target.closest('.wishlist-toggle'); // Ensure we get the correct element
//             const productId = target.dataset.productId;
//
//             fetch('/wishlist/toggle', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': csrfToken, // Include CSRF token
//                 },
//                 body: JSON.stringify({ product_id: productId }),
//             })
//                 .then((response) => {
//                     if (!response.ok) {
//                         throw new Error(`HTTP error! status: ${response.status}`);
//                     }
//                     return response.json();
//                 })
//                 .then((data) => {
//                     if (data.status === 'added') {
//                         target.querySelector('i').classList.add('fas');
//                         target.querySelector('i').classList.remove('far');
//                     } else if (data.status === 'removed') {
//                         target.querySelector('i').classList.add('far');
//                         target.querySelector('i').classList.remove('fas');
//                     }
//                 })
//                 .catch((error) => {
//                     console.error('Error:', error);
//                 });
//         });
//     });
// });
//
//


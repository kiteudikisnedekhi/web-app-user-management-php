<div class="bg-gray-50 min-h-screen pb-12">
    <!-- Product Details Section -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <!-- Product Image Gallery -->
                <div class="md:w-1/2">
                    <div class="swiper-container product-gallery">
                        <div class="swiper-wrapper">
                            <?php 
                            $images = json_decode($product['images'], true) ?? [];
                            if (empty($images)) {
                                $images = [$product['image_url']];
                            }
                            foreach ($images as $image): 
                            ?>
                            <div class="swiper-slide">
                                <div class="relative pb-[100%]">
                                    <img src="<?= htmlspecialchars($image) ?>" 
                                         alt="<?= htmlspecialchars($product['name']) ?>"
                                         class="absolute inset-0 w-full h-full object-cover">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="md:w-1/2 p-6">
                    <div class="mb-4">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($product['name']) ?></h1>
                        <p class="text-gray-600"><?= htmlspecialchars($product['category_name']) ?></p>
                    </div>

                    <!-- Rating -->
                    <?php if ($product['review_count'] > 0): ?>
                    <div class="flex items-center mb-4">
                        <div class="flex items-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?= $i <= round($product['avg_rating']) ? 'text-yellow-400' : 'text-gray-300' ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="ml-2 text-sm text-gray-600">
                            <?= number_format($product['avg_rating'], 1) ?> 
                            (<?= $product['review_count'] ?> reviews)
                        </span>
                    </div>
                    <?php endif; ?>

                    <!-- Price -->
                    <div class="mb-6">
                        <div class="flex items-center">
                            <span class="text-3xl font-bold text-primary">₹<?= number_format($product['price'], 2) ?></span>
                            <?php if ($product['original_price'] > $product['price']): ?>
                            <span class="ml-3 text-lg text-gray-500 line-through">
                                ₹<?= number_format($product['original_price'], 2) ?>
                            </span>
                            <span class="ml-2 text-sm text-green-600">
                                <?= number_format((($product['original_price'] - $product['price']) / $product['original_price']) * 100) ?>% off
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- HG Coins Info -->
                        <?php if ($product['HGCOINS_VALUE_CLAIMABLE'] > 0): ?>
                        <div class="mt-2 flex items-center text-sm text-gray-600">
                            <i class="fas fa-coins text-secondary mr-2"></i>
                            Earn <?= $product['HGCOINS_percentage_or_flat'] === 'FLAT' ? 
                                '₹' . $product['HGCOINS_VALUE_CLAIMABLE'] : 
                                $product['HGCOINS_VALUE_CLAIMABLE'] . '%' ?> 
                            in HG Coins
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Variants Selection -->
                    <?php if (!empty($variants)): ?>
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Select Variant</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <?php foreach ($variants as $variant): ?>
                            <label class="relative">
                                <input type="radio" name="variant" value="<?= $variant['id'] ?>" class="peer hidden">
                                <div class="border-2 rounded-lg p-4 cursor-pointer peer-checked:border-primary peer-checked:bg-primary/5">
                                    <div class="font-medium"><?= htmlspecialchars($variant['name']) ?></div>
                                    <div class="text-sm text-gray-500"><?= htmlspecialchars($variant['description']) ?></div>
                                    <div class="mt-1 font-semibold text-primary">₹<?= number_format($variant['price'], 2) ?></div>
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Delivery Info -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Delivery Information</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Base Delivery Fee</span>
                                <span class="font-medium">₹<?= number_format($product['base_delivery_fee'], 2) ?></span>
                            </div>
                            <?php if ($deliveryFee > $product['base_delivery_fee']): ?>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Additional Floor Charges</span>
                                <span class="font-medium">₹<?= number_format($deliveryFee - $product['base_delivery_fee'], 2) ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="flex justify-between text-primary font-medium pt-2 border-t">
                                <span>Total Delivery Fee</span>
                                <span>₹<?= number_format($deliveryFee, 2) ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Add to Cart / Subscribe Buttons -->
                    <div class="space-y-3">
                        <?php if ($product['is_subscribable']): ?>
                        <button onclick="showSubscriptionModal()" 
                                class="w-full bg-secondary hover:bg-secondary-dark text-white py-3 px-6 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Subscribe & Save
                        </button>
                        <?php endif; ?>

                        <button onclick="addToCart(<?= $product['id'] ?>)" 
                                class="w-full bg-primary hover:bg-primary-dark text-white py-3 px-6 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            <?= $inCart ? 'Update Cart' : 'Add to Cart' ?>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Description -->
            <div class="p-6 border-t">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Product Description</h2>
                <div class="prose max-w-none">
                    <?= nl2br(htmlspecialchars($product['description'])) ?>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <?php if (!empty($reviews)): ?>
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Customer Reviews</h2>
            <div class="space-y-6">
                <?php foreach ($reviews as $review): ?>
                <div class="border-b last:border-0 pb-6 last:pb-0">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="font-medium text-gray-900"><?= htmlspecialchars($review['user_name']) ?></div>
                            <span class="mx-2 text-gray-300">•</span>
                            <div class="text-sm text-gray-500">
                                <?= date('M d, Y', strtotime($review['created_at'])) ?>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?= $i <= $review['rating'] ? 'text-yellow-400' : 'text-gray-300' ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <p class="text-gray-600"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Related Products -->
        <?php if (!empty($relatedProducts)): ?>
        <div class="mt-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Related Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php foreach ($relatedProducts as $relatedProduct): ?>
                <a href="/product/<?= $relatedProduct['id'] ?>" 
                   class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    <div class="relative pb-[100%]">
                        <img src="<?= htmlspecialchars($relatedProduct['image_url']) ?>" 
                             alt="<?= htmlspecialchars($relatedProduct['name']) ?>"
                             class="absolute inset-0 w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="font-medium text-gray-900 mb-1 truncate"><?= htmlspecialchars($relatedProduct['name']) ?></h3>
                        <div class="flex items-center justify-between">
                            <span class="text-primary font-bold">₹<?= number_format($relatedProduct['price'], 2) ?></span>
                            <?php if ($relatedProduct['avg_rating'] > 0): ?>
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="ml-1 text-sm text-gray-600"><?= number_format($relatedProduct['avg_rating'], 1) ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Subscription Modal -->
<?php if ($product['is_subscribable']): ?>
<div id="subscriptionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Subscribe to <?= htmlspecialchars($product['name']) ?>
                        </h3>
                        
                        <form id="subscriptionForm" class="space-y-4">
                            <!-- Frequency Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Frequency</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="relative">
                                        <input type="radio" name="frequency" value="daily" class="peer hidden" checked>
                                        <div class="border-2 rounded-lg p-4 cursor-pointer peer-checked:border-primary peer-checked:bg-primary/5">
                                            <div class="font-medium">Daily</div>
                                            <div class="text-sm text-gray-500">Delivery every day</div>
                                        </div>
                                    </label>
                                    <label class="relative">
                                        <input type="radio" name="frequency" value="alternate" class="peer hidden">
                                        <div class="border-2 rounded-lg p-4 cursor-pointer peer-checked:border-primary peer-checked:bg-primary/5">
                                            <div class="font-medium">Alternate Days</div>
                                            <div class="text-sm text-gray-500">Delivery every other day</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Quantity Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantity per Delivery</label>
                                <div class="flex items-center">
                                    <button type="button" onclick="updateQuantity(-1)" 
                                            class="rounded-l-lg border border-gray-300 px-4 py-2 hover:bg-gray-50">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" 
                                           class="w-20 border-t border-b border-gray-300 px-3 py-2 text-center">
                                    <button type="button" onclick="updateQuantity(1)"
                                            class="rounded-r-lg border border-gray-300 px-4 py-2 hover:bg-gray-50">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Subscription Duration -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Subscription Duration</label>
                                <select name="duration" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                                    <option value="1">1 Month</option>
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">12 Months</option>
                                </select>
                            </div>

                            <!-- Price Summary -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Product Price</span>
                                        <span>₹<?= number_format($product['price'], 2) ?> × <span id="totalQuantity">30</span></span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Delivery Fee</span>
                                        <span>₹<?= number_format($deliveryFee, 2) ?> × <span id="totalDeliveries">30</span></span>
                                    </div>
                                    <div class="flex justify-between font-medium pt-2 border-t">
                                        <span>Total Monthly Amount</span>
                                        <span id="totalAmount" class="text-primary">₹0</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="submitSubscription()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                    Subscribe Now
                </button>
                <button type="button" onclick="hideSubscriptionModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Initialize Swiper -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize product gallery slider
    new Swiper('.product-gallery', {
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    // Initialize subscription form calculations
    if (document.getElementById('subscriptionForm')) {
        calculateSubscriptionTotal();
        document.getElementById('subscriptionForm').addEventListener('change', calculateSubscriptionTotal);
    }
});

function showSubscriptionModal() {
    document.getElementById('subscriptionModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideSubscriptionModal() {
    document.getElementById('subscriptionModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function updateQuantity(change) {
    const input = document.getElementById('quantity');
    const newValue = Math.max(1, parseInt(input.value) + change);
    input.value = newValue;
    calculateSubscriptionTotal();
}

function calculateSubscriptionTotal() {
    const form = document.getElementById('subscriptionForm');
    const frequency = form.querySelector('input[name="frequency"]:checked').value;
    const quantity = parseInt(document.getElementById('quantity').value);
    const duration = parseInt(form.querySelector('select[name="duration"]').value);

    const daysInMonth = 30;
    const deliveriesPerMonth = frequency === 'daily' ? daysInMonth : Math.floor(daysInMonth / 2);

    const productTotal = <?= $product['price'] ?> * quantity * deliveriesPerMonth;
    const deliveryTotal = <?= $deliveryFee ?> * deliveriesPerMonth;
    const monthlyTotal = productTotal + deliveryTotal;

    document.getElementById('totalQuantity').textContent = quantity * deliveriesPerMonth;
    document.getElementById('totalDeliveries').textContent = deliveriesPerMonth;
    document.getElementById('totalAmount').textContent = '₹' + monthlyTotal.toFixed(2);
}

async function submitSubscription() {
    const form = document.getElementById('subscriptionForm');
    const formData = new FormData(form);
    formData.append('product_id', <?= $product['id'] ?>);

    try {
        showLoading();
        const response = await fetch('/subscription/create', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        
        if (response.ok) {
            window.location.href = '/subscriptions';
        } else {
            alert(data.error || 'Failed to create subscription');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        hideLoading();
    }
}

async function addToCart(productId) {
    const quantity = 1; // You might want to add quantity selector in the UI
    const variantId = document.querySelector('input[name="variant"]:checked')?.value;

    try {
        showLoading();
        const response = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity,
                variant_id: variantId
            })
        });

        const data = await response.json();
        
        if (response.ok) {
            // Update cart UI
            const cartCountElement = document.querySelector('.cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = data.cart_count;
            }
            alert('Product added to cart successfully');
        } else {
            alert(data.error || 'Failed to add product to cart');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        hideLoading();
    }
}
</script>

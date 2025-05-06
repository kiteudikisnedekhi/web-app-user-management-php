<div class="bg-gray-50 min-h-screen pb-24">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Cart Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Shopping Cart</h1>
            <div class="text-sm">
                <a href="/products" class="text-primary hover:text-primary-dark">
                    <i class="fas fa-arrow-left mr-1"></i> Continue Shopping
                </a>
            </div>
        </div>

        <?php if (empty($immediateItems) && empty($subscriptionItems)): ?>
        <!-- Empty Cart -->
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-shopping-cart text-3xl text-gray-400"></i>
            </div>
            <h2 class="text-xl font-medium text-gray-900 mb-2">Your cart is empty</h2>
            <p class="text-gray-600 mb-6">Looks like you haven't added any items to your cart yet.</p>
            <a href="/products" 
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-dark">
                Start Shopping
            </a>
        </div>
        <?php else: ?>

        <!-- Cart Tabs -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex" aria-label="Tabs">
                    <button onclick="switchTab('immediate')"
                            class="tab-button w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm focus:outline-none"
                            data-tab="immediate">
                        Immediate Order
                        <?php if (!empty($immediateItems)): ?>
                        <span class="ml-2 bg-primary text-white px-2 py-1 rounded-full text-xs">
                            <?= count($immediateItems) ?>
                        </span>
                        <?php endif; ?>
                    </button>
                    <button onclick="switchTab('subscription')"
                            class="tab-button w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm focus:outline-none"
                            data-tab="subscription">
                        Subscriptions
                        <?php if (!empty($subscriptionItems)): ?>
                        <span class="ml-2 bg-secondary text-white px-2 py-1 rounded-full text-xs">
                            <?= count($subscriptionItems) ?>
                        </span>
                        <?php endif; ?>
                    </button>
                </nav>
            </div>
        </div>

        <!-- Cart Content -->
        <div class="lg:flex lg:gap-6">
            <!-- Cart Items -->
            <div class="flex-1">
                <!-- Immediate Order Items -->
                <div id="immediate-tab" class="tab-content">
                    <?php if (empty($immediateItems)): ?>
                    <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                        <p class="text-gray-600">No items in immediate order cart</p>
                    </div>
                    <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($immediateItems as $item): ?>
                        <div class="bg-white rounded-lg shadow-sm p-4">
                            <div class="flex items-center">
                                <!-- Product Image -->
                                <div class="w-24 h-24 flex-shrink-0">
                                    <img src="<?= htmlspecialchars($item['image_url']) ?>" 
                                         alt="<?= htmlspecialchars($item['name']) ?>"
                                         class="w-full h-full object-cover rounded-lg">
                                </div>
                                
                                <!-- Product Details -->
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">
                                                <?= htmlspecialchars($item['name']) ?>
                                            </h3>
                                            <?php if ($item['variant_name']): ?>
                                            <p class="text-sm text-gray-600">
                                                Variant: <?= htmlspecialchars($item['variant_name']) ?>
                                            </p>
                                            <?php endif; ?>
                                        </div>
                                        <button onclick="removeFromCart(<?= $item['id'] ?>)" 
                                                class="text-gray-400 hover:text-red-500">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Price and Quantity -->
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="flex items-center">
                                            <button onclick="updateQuantity(<?= $item['id'] ?>, -1)"
                                                    class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                                <i class="fas fa-minus text-sm"></i>
                                            </button>
                                            <span class="mx-4 w-8 text-center"><?= $item['quantity'] ?></span>
                                            <button onclick="updateQuantity(<?= $item['id'] ?>, 1)"
                                                    class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                                <i class="fas fa-plus text-sm"></i>
                                            </button>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-primary">
                                                ₹<?= number_format(($item['variant_price'] ?? $item['price']) * $item['quantity'], 2) ?>
                                            </div>
                                            <?php if ($item['HGCOINS_VALUE_CLAIMABLE'] > 0): ?>
                                            <div class="text-sm text-secondary">
                                                Earn <?= $item['HGCOINS_percentage_or_flat'] === 'FLAT' ? 
                                                    '₹' . $item['HGCOINS_VALUE_CLAIMABLE'] * $item['quantity'] : 
                                                    $item['HGCOINS_VALUE_CLAIMABLE'] . '%' ?> HG Coins
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Subscription Items -->
                <div id="subscription-tab" class="tab-content hidden">
                    <?php if (empty($subscriptionItems)): ?>
                    <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                        <p class="text-gray-600">No subscription items in cart</p>
                    </div>
                    <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($subscriptionItems as $item): ?>
                        <div class="bg-white rounded-lg shadow-sm p-4">
                            <div class="flex items-center">
                                <!-- Product Image -->
                                <div class="w-24 h-24 flex-shrink-0">
                                    <img src="<?= htmlspecialchars($item['image_url']) ?>" 
                                         alt="<?= htmlspecialchars($item['name']) ?>"
                                         class="w-full h-full object-cover rounded-lg">
                                </div>
                                
                                <!-- Product Details -->
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">
                                                <?= htmlspecialchars($item['name']) ?>
                                            </h3>
                                            <?php if ($item['variant_name']): ?>
                                            <p class="text-sm text-gray-600">
                                                Variant: <?= htmlspecialchars($item['variant_name']) ?>
                                            </p>
                                            <?php endif; ?>
                                            <p class="text-sm text-secondary mt-1">
                                                <i class="fas fa-sync-alt mr-1"></i> Monthly Subscription
                                            </p>
                                        </div>
                                        <button onclick="removeFromCart(<?= $item['id'] ?>)" 
                                                class="text-gray-400 hover:text-red-500">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Price and Quantity -->
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="flex items-center">
                                            <button onclick="updateQuantity(<?= $item['id'] ?>, -1)"
                                                    class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                                <i class="fas fa-minus text-sm"></i>
                                            </button>
                                            <span class="mx-4 w-8 text-center"><?= $item['quantity'] ?></span>
                                            <button onclick="updateQuantity(<?= $item['id'] ?>, 1)"
                                                    class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                                <i class="fas fa-plus text-sm"></i>
                                            </button>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-primary">
                                                ₹<?= number_format(($item['variant_price'] ?? $item['price']) * $item['quantity'] * 30, 2) ?>/month
                                            </div>
                                            <?php if ($item['HGCOINS_VALUE_CLAIMABLE'] > 0): ?>
                                            <div class="text-sm text-secondary">
                                                Earn <?= $item['HGCOINS_percentage_or_flat'] === 'FLAT' ? 
                                                    '₹' . $item['HGCOINS_VALUE_CLAIMABLE'] * $item['quantity'] * 30 : 
                                                    $item['HGCOINS_VALUE_CLAIMABLE'] . '%' ?> HG Coins/month
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:w-96 mt-6 lg:mt-0">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                    
                    <!-- Immediate Order Summary -->
                    <div id="immediate-summary" class="summary-content">
                        <div class="space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span>₹<?= number_format($immediateTotal, 2) ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Delivery Fee</span>
                                <span>₹<?= number_format($immediateDeliveryFee, 2) ?></span>
                            </div>
                            <?php if ($immediateHGCoins > 0): ?>
                            <div class="flex justify-between text-sm text-secondary">
                                <span>HG Coins to Earn</span>
                                <span>₹<?= number_format($immediateHGCoins, 2) ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="pt-4 border-t">
                                <div class="flex justify-between">
                                    <span class="text-base font-medium">Total</span>
                                    <span class="text-xl font-bold text-primary">
                                        ₹<?= number_format($immediateTotal + $immediateDeliveryFee, 2) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subscription Summary -->
                    <div id="subscription-summary" class="summary-content hidden">
                        <div class="space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Monthly Subtotal</span>
                                <span>₹<?= number_format($subscriptionTotal * 30, 2) ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Monthly Delivery Fee</span>
                                <span>₹<?= number_format($subscriptionDeliveryFee * 30, 2) ?></span>
                            </div>
                            <?php if ($subscriptionHGCoins > 0): ?>
                            <div class="flex justify-between text-sm text-secondary">
                                <span>Monthly HG Coins</span>
                                <span>₹<?= number_format($subscriptionHGCoins * 30, 2) ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="pt-4 border-t">
                                <div class="flex justify-between">
                                    <span class="text-base font-medium">Monthly Total</span>
                                    <span class="text-xl font-bold text-primary">
                                        ₹<?= number_format(($subscriptionTotal + $subscriptionDeliveryFee) * 30, 2) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Wallet Balance -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">Wallet Balance</span>
                            <span class="font-medium">₹<?= number_format($wallet['balance'], 2) ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">HG Coins Balance</span>
                            <span class="font-medium text-secondary">₹<?= number_format($wallet['hg_coins'], 2) ?></span>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <?php if (!empty($immediateItems) || !empty($subscriptionItems)): ?>
                    <div class="mt-6">
                        <button onclick="proceedToCheckout()"
                                class="w-full bg-primary text-white py-3 px-4 rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Proceed to Checkout
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function switchTab(tab) {
    // Update tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        if (button.dataset.tab === tab) {
            button.classList.add('border-primary', 'text-primary');
            button.classList.remove('border-transparent', 'text-gray-500');
        } else {
            button.classList.remove('border-primary', 'text-primary');
            button.classList.add('border-transparent', 'text-gray-500');
        }
    });

    // Update tab content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    document.getElementById(`${tab}-tab`).classList.remove('hidden');

    // Update summary content
    document.querySelectorAll('.summary-content').forEach(content => {
        content.classList.add('hidden');
    });
    document.getElementById(`${tab}-summary`).classList.remove('hidden');
}

async function updateQuantity(cartItemId, change) {
    try {
        showLoading();
        const response = await fetch('/cart/update-quantity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                cart_item_id: cartItemId,
                quantity: parseInt(document.querySelector(`[data-cart-item="${cartItemId}"]`).textContent) + change
            })
        });

        const data = await response.json();
        
        if (response.ok) {
            location.reload(); // Refresh to update all totals
        } else {
            alert(data.error || 'Failed to update quantity');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        hideLoading();
    }
}

async function removeFromCart(cartItemId) {
    if (!confirm('Are you sure you want to remove this item?')) {
        return;
    }

    try {
        showLoading();
        const response = await fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                cart_item_id: cartItemId
            })
        });

        const data = await response.json();
        
        if (response.ok) {
            location.reload(); // Refresh to update cart
        } else {
            alert(data.error || 'Failed to remove item');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        hideLoading();
    }
}

function proceedToCheckout() {
    const activeTab = document.querySelector('.tab-button.border-primary').dataset.tab;
    window.location.href = `/checkout/${activeTab}`;
}

// Initialize with immediate tab
document.addEventListener('DOMContentLoaded', function() {
    switchTab('immediate');
});
</script>

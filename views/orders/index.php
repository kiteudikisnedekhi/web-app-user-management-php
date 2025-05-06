<div class="bg-gray-50 min-h-screen pb-12">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">My Orders</h1>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="p-4">
                <div class="flex flex-wrap gap-4">
                    <!-- Order Type Filter -->
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Order Type</label>
                        <select id="typeFilter" onchange="applyFilters()"
                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                            <option value="all" <?= $currentType === 'all' ? 'selected' : '' ?>>All Types</option>
                            <option value="immediate" <?= $currentType === 'immediate' ? 'selected' : '' ?>>Immediate Orders</option>
                            <option value="subscription" <?= $currentType === 'subscription' ? 'selected' : '' ?>>Subscriptions</option>
                        </select>
                    </div>

                    <!-- Order Status Filter -->
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="statusFilter" onchange="applyFilters()"
                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                            <option value="all" <?= $currentStatus === 'all' ? 'selected' : '' ?>>All Status</option>
                            <option value="pending" <?= $currentStatus === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="processing" <?= $currentStatus === 'processing' ? 'selected' : '' ?>>Processing</option>
                            <option value="out_for_delivery" <?= $currentStatus === 'out_for_delivery' ? 'selected' : '' ?>>Out for Delivery</option>
                            <option value="delivered" <?= $currentStatus === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                            <option value="cancelled" <?= $currentStatus === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <?php if (empty($orders)): ?>
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-shopping-bag text-3xl text-gray-400"></i>
            </div>
            <h2 class="text-xl font-medium text-gray-900 mb-2">No orders found</h2>
            <p class="text-gray-600 mb-6">Start shopping to see your orders here</p>
            <a href="/products" 
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-dark">
                Browse Products
            </a>
        </div>
        <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($orders as $order): ?>
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <!-- Order Header -->
                <div class="p-4 border-b bg-gray-50">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Order #<?= htmlspecialchars($order['order_number']) ?>
                            </h3>
                            <p class="text-sm text-gray-600">
                                Placed on <?= date('M d, Y', strtotime($order['created_at'])) ?>
                            </p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Order Status Badge -->
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                <?php
                                switch ($order['status']) {
                                    case 'pending':
                                        echo 'bg-yellow-100 text-yellow-800';
                                        break;
                                    case 'processing':
                                        echo 'bg-blue-100 text-blue-800';
                                        break;
                                    case 'out_for_delivery':
                                        echo 'bg-indigo-100 text-indigo-800';
                                        break;
                                    case 'delivered':
                                        echo 'bg-green-100 text-green-800';
                                        break;
                                    case 'cancelled':
                                        echo 'bg-red-100 text-red-800';
                                        break;
                                    default:
                                        echo 'bg-gray-100 text-gray-800';
                                }
                                ?>">
                                <?= ucfirst(str_replace('_', ' ', $order['status'])) ?>
                            </span>

                            <!-- Order Type Badge -->
                            <?php if ($order['type'] === 'subscription'): ?>
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-secondary/10 text-secondary">
                                Subscription
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="p-4">
                    <div class="flex flex-wrap justify-between gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <h4 class="text-sm font-medium text-gray-700 mb-1">Items</h4>
                            <p class="text-gray-900">
                                <?= htmlspecialchars($order['product_names']) ?>
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                <?= $order['item_count'] ?> item<?= $order['item_count'] > 1 ? 's' : '' ?>
                            </p>
                        </div>

                        <div class="text-right">
                            <h4 class="text-sm font-medium text-gray-700 mb-1">Total Amount</h4>
                            <p class="text-lg font-bold text-primary">
                                ₹<?= number_format($order['total_amount'], 2) ?>
                            </p>
                            <?php if ($order['payment_status'] === 'pending'): ?>
                            <p class="text-sm text-yellow-600 mt-1">Payment Pending</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <a href="/order/<?= $order['id'] ?>" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            View Details
                        </a>
                        <?php if ($order['status'] === 'delivered'): ?>
                        <button onclick="reorder(<?= $order['id'] ?>)"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-primary bg-primary/10 hover:bg-primary/20">
                            <i class="fas fa-redo mr-2"></i>
                            Reorder
                        </button>
                        <?php endif; ?>
                        <?php if ($order['status'] === 'pending' && $order['payment_status'] === 'pending'): ?>
                        <button onclick="makePayment(<?= $order['id'] ?>)"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-primary hover:bg-primary-dark">
                            <i class="fas fa-credit-card mr-2"></i>
                            Make Payment
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="mt-6 flex justify-center">
            <div class="flex space-x-2">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?><?= $currentStatus !== 'all' ? '&status=' . $currentStatus : '' ?><?= $currentType !== 'all' ? '&type=' . $currentType : '' ?>" 
                   class="px-4 py-2 rounded-lg <?= $i === $currentPage ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                    <?= $i ?>
                </a>
                <?php endfor; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<script>
function applyFilters() {
    const type = document.getElementById('typeFilter').value;
    const status = document.getElementById('statusFilter').value;
    
    let url = '/orders?';
    if (type !== 'all') url += `type=${type}&`;
    if (status !== 'all') url += `status=${status}&`;
    
    window.location.href = url.slice(0, -1); // Remove trailing & or ?
}

async function reorder(orderId) {
    try {
        showLoading();
        const response = await fetch(`/order/${orderId}/reorder`, {
            method: 'POST'
        });

        const data = await response.json();
        
        if (response.ok) {
            window.location.href = '/cart';
        } else {
            alert(data.error || 'Failed to reorder');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        hideLoading();
    }
}

async function makePayment(orderId) {
    try {
        showLoading();
        const response = await fetch(`/payment/process`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                order_id: orderId,
                payment_type: 'order'
            })
        });

        const data = await response.json();
        
        if (response.ok) {
            if (data.requires_payment) {
                // Initialize Razorpay
                const options = {
                    key: data.key,
                    amount: data.amount,
                    currency: data.currency,
                    name: 'HAVMORICE',
                    description: 'Order Payment',
                    order_id: data.order_id,
                    handler: async function(response) {
                        await verifyPayment(response);
                    },
                    prefill: {
                        name: '<?= htmlspecialchars($user['name'] ?? '') ?>',
                        contact: '<?= htmlspecialchars($user['mobile']) ?>'
                    },
                    theme: {
                        color: '#FF6B6B'
                    }
                };

                const rzp = new Razorpay(options);
                rzp.open();
            } else {
                // Payment processed using wallet/HG Coins
                location.reload();
            }
        } else {
            alert(data.error || 'Failed to process payment');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        hideLoading();
    }
}

async function verifyPayment(response) {
    try {
        showLoading();
        const verifyResponse = await fetch('/payment/verify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_order_id: response.razorpay_order_id,
                razorpay_signature: response.razorpay_signature
            })
        });

        const data = await verifyResponse.json();
        
        if (verifyResponse.ok) {
            location.reload();
        } else {
            alert(data.error || 'Failed to verify payment');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        hideLoading();
    }
}
</script>

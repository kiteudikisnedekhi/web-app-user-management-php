<div class="bg-gray-50 min-h-screen pb-12">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Order #<?= htmlspecialchars($order['order_number']) ?>
                </h1>
                <p class="text-sm text-gray-600">
                    Placed on <?= date('M d, Y H:i', strtotime($order['created_at'])) ?>
                </p>
            </div>
            <a href="/orders" class="text-primary hover:text-primary-dark">
                <i class="fas fa-arrow-left mr-1"></i>
                Back to Orders
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Order Details and Items -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Status Cards -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 border-b bg-gray-50">
                        <h2 class="text-lg font-medium text-gray-900">Order Status</h2>
                    </div>
                    <div class="p-4">
                        <div class="flex flex-wrap gap-4">
                            <!-- Order Status -->
                            <div class="flex-1 min-w-[200px]">
                                <div class="text-sm text-gray-600 mb-1">Status</div>
                                <div class="flex items-center">
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
                                </div>
                            </div>

                            <!-- Payment Status -->
                            <div class="flex-1 min-w-[200px]">
                                <div class="text-sm text-gray-600 mb-1">Payment Status</div>
                                <div class="flex items-center">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        <?= $order['payment_status'] === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                        <?= ucfirst($order['payment_status']) ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Order Type -->
                            <div class="flex-1 min-w-[200px]">
                                <div class="text-sm text-gray-600 mb-1">Order Type</div>
                                <div class="flex items-center">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        <?= $order['type'] === 'subscription' ? 'bg-secondary/10 text-secondary' : 'bg-primary/10 text-primary' ?>">
                                        <?= ucfirst($order['type']) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 border-b bg-gray-50">
                        <h2 class="text-lg font-medium text-gray-900">Order Items</h2>
                    </div>
                    <div class="divide-y">
                        <?php foreach ($items as $item): ?>
                        <div class="p-4">
                            <div class="flex items-start">
                                <!-- Product Image -->
                                <div class="w-20 h-20 flex-shrink-0">
                                    <img src="<?= htmlspecialchars($item['image_url']) ?>" 
                                         alt="<?= htmlspecialchars($item['name']) ?>"
                                         class="w-full h-full object-cover rounded-lg">
                                </div>
                                
                                <!-- Product Details -->
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </h3>
                                    <?php if ($item['variant_name']): ?>
                                    <p class="text-sm text-gray-600">
                                        Variant: <?= htmlspecialchars($item['variant_name']) ?>
                                    </p>
                                    <?php endif; ?>
                                    <div class="mt-1 flex items-center justify-between">
                                        <div class="text-sm text-gray-600">
                                            Quantity: <?= $item['quantity'] ?>
                                        </div>
                                        <div class="text-lg font-bold text-primary">
                                            ₹<?= number_format($item['price'] * $item['quantity'], 2) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Delivery Timeline -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 border-b bg-gray-50">
                        <h2 class="text-lg font-medium text-gray-900">Order Timeline</h2>
                    </div>
                    <div class="p-4">
                        <div class="flow-root">
                            <ul class="-mb-8">
                                <?php foreach ($timeline as $index => $event): ?>
                                <li>
                                    <div class="relative pb-8">
                                        <?php if ($index !== count($timeline) - 1): ?>
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        <?php endif; ?>
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white
                                                    <?php
                                                    switch ($event['status']) {
                                                        case 'delivered':
                                                            echo 'bg-green-500';
                                                            break;
                                                        case 'cancelled':
                                                            echo 'bg-red-500';
                                                            break;
                                                        case 'out_for_delivery':
                                                            echo 'bg-indigo-500';
                                                            break;
                                                        case 'processing':
                                                            echo 'bg-blue-500';
                                                            break;
                                                        default:
                                                            echo 'bg-gray-500';
                                                    }
                                                    ?>">
                                                    <i class="fas fa-circle-notch text-white"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?= ucfirst(str_replace('_', ' ', $event['status'])) ?>
                                                </div>
                                                <div class="mt-1 text-sm text-gray-500">
                                                    <?= htmlspecialchars($event['description']) ?>
                                                </div>
                                                <div class="mt-1 text-xs text-gray-400">
                                                    <?= date('M d, Y H:i', strtotime($event['created_at'])) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary and Delivery Info -->
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 border-b bg-gray-50">
                        <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
                    </div>
                    <div class="p-4">
                        <div class="space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span>₹<?= number_format($order['subtotal'], 2) ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Delivery Fee</span>
                                <span>₹<?= number_format($order['delivery_fee'], 2) ?></span>
                            </div>
                            <?php if ($order['hg_coins_used'] > 0): ?>
                            <div class="flex justify-between text-sm text-secondary">
                                <span>HG Coins Used</span>
                                <span>-₹<?= number_format($order['hg_coins_used'], 2) ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="pt-4 border-t">
                                <div class="flex justify-between">
                                    <span class="text-base font-medium">Total</span>
                                    <span class="text-xl font-bold text-primary">
                                        ₹<?= number_format($order['total_amount'], 2) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 border-b bg-gray-50">
                        <h2 class="text-lg font-medium text-gray-900">Delivery Information</h2>
                    </div>
                    <div class="p-4">
                        <div class="space-y-4">
                            <!-- Delivery Address -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Delivery Address</h3>
                                <div class="text-gray-900">
                                    <?= htmlspecialchars($order['address_line1']) ?><br>
                                    <?php if ($order['address_line2']): ?>
                                    <?= htmlspecialchars($order['address_line2']) ?><br>
                                    <?php endif; ?>
                                    <?= htmlspecialchars($order['city']) ?>, 
                                    <?= htmlspecialchars($order['state']) ?> - 
                                    <?= htmlspecialchars($order['pincode']) ?>
                                </div>
                                <div class="mt-2 text-sm text-gray-600">
                                    Floor: <?= htmlspecialchars($order['floor_number']) ?>
                                </div>
                            </div>

                            <?php if ($order['delivery_partner_name']): ?>
                            <!-- Delivery Partner -->
                            <div class="pt-4 border-t">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Delivery Partner</h3>
                                <div class="flex items-center">
                                    <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-gray-900">
                                            <?= htmlspecialchars($order['delivery_partner_name']) ?>
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            <?= htmlspecialchars($order['delivery_partner_mobile']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <?php if ($order['status'] === 'delivered'): ?>
                    <button onclick="reorder(<?= $order['id'] ?>)"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-primary bg-primary/10 hover:bg-primary/20">
                        <i class="fas fa-redo mr-2"></i>
                        Reorder
                    </button>
                    <?php endif; ?>
                    
                    <?php if ($order['status'] === 'pending' && $order['payment_status'] === 'pending'): ?>
                    <button onclick="makePayment(<?= $order['id'] ?>)"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-primary hover:bg-primary-dark">
                        <i class="fas fa-credit-card mr-2"></i>
                        Make Payment
                    </button>
                    <?php endif; ?>

                    <?php if ($order['status'] === 'pending'): ?>
                    <button onclick="cancelOrder(<?= $order['id'] ?>)"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-red-600 bg-white hover:bg-gray-50">
                        <i class="fas fa-times mr-2"></i>
                        Cancel Order
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function reorder(orderId) {
    if (!confirm('Are you sure you want to reorder these items?')) {
        return;
    }

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

async function cancelOrder(orderId) {
    if (!confirm('Are you sure you want to cancel this order?')) {
        return;
    }

    try {
        showLoading();
        const response = await fetch(`/order/${orderId}/cancel`, {
            method: 'POST'
        });

        const data = await response.json();
        
        if (response.ok) {
            location.reload();
        } else {
            alert(data.error || 'Failed to cancel order');
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

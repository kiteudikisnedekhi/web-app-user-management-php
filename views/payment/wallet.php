<div class="bg-gray-50 min-h-screen pb-12">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">My Wallet</h1>
        </div>

        <!-- Balance Cards -->
        <div class="grid gap-6 md:grid-cols-2 mb-8">
            <!-- Main Wallet Balance -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-wallet text-2xl text-primary mr-3"></i>
                            <h2 class="text-lg font-medium text-gray-900">Wallet Balance</h2>
                        </div>
                        <button onclick="showRechargeModal()" 
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-full text-white bg-primary hover:bg-primary-dark">
                            <i class="fas fa-plus mr-1"></i>
                            Add Money
                        </button>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">
                        ₹<?= number_format($wallet['balance'], 2) ?>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        Available balance for purchases
                    </p>
                </div>
                <div class="bg-gray-50 px-6 py-3">
                    <div class="text-sm">
                        <span class="text-gray-600">Last updated:</span>
                        <span class="text-gray-900">
                            <?= date('M d, Y H:i', strtotime($wallet['updated_at'])) ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- HG Coins Balance -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-coins text-2xl text-secondary mr-3"></i>
                        <h2 class="text-lg font-medium text-gray-900">HG Coins</h2>
                    </div>
                    <div class="text-3xl font-bold text-secondary">
                        ₹<?= number_format($wallet['hg_coins'], 2) ?>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        Earned through referrals and purchases
                    </p>
                </div>
                <div class="bg-gray-50 px-6 py-3">
                    <a href="/referral" class="text-sm text-secondary hover:text-secondary-dark">
                        <i class="fas fa-user-plus mr-1"></i>
                        Refer friends to earn more
                    </a>
                </div>
            </div>
        </div>

        <!-- Transactions History -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-medium text-gray-900">Transaction History</h2>
            </div>

            <!-- Transaction Tabs -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex" aria-label="Tabs">
                    <button onclick="switchTab('wallet')"
                            class="tab-button w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm"
                            data-tab="wallet">
                        Wallet Transactions
                    </button>
                    <button onclick="switchTab('hgcoins')"
                            class="tab-button w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm"
                            data-tab="hgcoins">
                        HG Coins History
                    </button>
                </nav>
            </div>

            <!-- Wallet Transactions -->
            <div id="wallet-tab" class="tab-content">
                <?php if (empty($transactions)): ?>
                <div class="p-6 text-center">
                    <p class="text-gray-600">No transactions yet</p>
                </div>
                <?php else: ?>
                <div class="divide-y">
                    <?php foreach ($transactions as $transaction): ?>
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-medium text-gray-900">
                                    <?php
                                    switch ($transaction['reference_type']) {
                                        case 'recharge':
                                            echo 'Wallet Recharge';
                                            break;
                                        case 'order':
                                            echo 'Order Payment';
                                            break;
                                        case 'refund':
                                            echo 'Order Refund';
                                            break;
                                        default:
                                            echo 'Transaction';
                                    }
                                    ?>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <?= date('M d, Y H:i', strtotime($transaction['created_at'])) ?>
                                </div>
                                <?php if ($transaction['reference_id']): ?>
                                <div class="text-xs text-gray-500 mt-1">
                                    Ref: <?= htmlspecialchars($transaction['reference_id']) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-medium <?= $transaction['type'] === 'credit' ? 'text-green-600' : 'text-red-600' ?>">
                                    <?= $transaction['type'] === 'credit' ? '+' : '-' ?>₹<?= number_format($transaction['amount'], 2) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- HG Coins History -->
            <div id="hgcoins-tab" class="tab-content hidden">
                <?php if (empty($hgCoinsHistory)): ?>
                <div class="p-6 text-center">
                    <p class="text-gray-600">No HG Coins transactions yet</p>
                </div>
                <?php else: ?>
                <div class="divide-y">
                    <?php foreach ($hgCoinsHistory as $transaction): ?>
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-medium text-gray-900">
                                    <?php
                                    switch ($transaction['reference_type']) {
                                        case 'referral':
                                            echo 'Referral Bonus';
                                            break;
                                        case 'order':
                                            echo $transaction['type'] === 'credit' ? 'Order Cashback' : 'Used for Order';
                                            break;
                                        default:
                                            echo 'HG Coins Transaction';
                                    }
                                    ?>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <?= date('M d, Y H:i', strtotime($transaction['created_at'])) ?>
                                </div>
                                <?php if ($transaction['reference_id']): ?>
                                <div class="text-xs text-gray-500 mt-1">
                                    Ref: <?= htmlspecialchars($transaction['reference_id']) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-medium <?= $transaction['type'] === 'credit' ? 'text-green-600' : 'text-red-600' ?>">
                                    <?= $transaction['type'] === 'credit' ? '+' : '-' ?>₹<?= number_format($transaction['amount'], 2) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recharge Modal -->
<div id="rechargeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="min-h-screen px-4 text-center">
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Add Money to Wallet
                        </h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Enter Amount (₹)
                            </label>
                            <input type="number" id="rechargeAmount" min="1" step="1"
                                   class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary"
                                   placeholder="Enter amount">
                        </div>

                        <div class="grid grid-cols-3 gap-2">
                            <?php foreach ([100, 500, 1000] as $amount): ?>
                            <button onclick="setAmount(<?= $amount ?>)"
                                    class="border border-gray-300 rounded-lg py-2 hover:bg-gray-50">
                                ₹<?= number_format($amount) ?>
                            </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="initiateRecharge()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                    Proceed to Pay
                </button>
                <button type="button" onclick="hideRechargeModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
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
}

function showRechargeModal() {
    document.getElementById('rechargeModal').classList.remove('hidden');
}

function hideRechargeModal() {
    document.getElementById('rechargeModal').classList.add('hidden');
}

function setAmount(amount) {
    document.getElementById('rechargeAmount').value = amount;
}

async function initiateRecharge() {
    const amount = document.getElementById('rechargeAmount').value;
    
    if (!amount || amount < 1) {
        alert('Please enter a valid amount');
        return;
    }

    try {
        showLoading();
        const response = await fetch('/payment/initiate-recharge', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ amount })
        });

        const data = await response.json();
        
        if (response.ok) {
            const options = {
                key: data.key,
                amount: data.amount,
                currency: data.currency,
                name: 'HAVMORICE',
                description: 'Wallet Recharge',
                order_id: data.order_id,
                handler: async function(response) {
                    await verifyRecharge(response);
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
            hideRechargeModal();
        } else {
            alert(data.error || 'Failed to initiate recharge');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        hideLoading();
    }
}

async function verifyRecharge(response) {
    try {
        showLoading();
        const verifyResponse = await fetch('/payment/verify-recharge', {
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
            alert('Recharge successful!');
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

// Initialize with wallet tab
document.addEventListener('DOMContentLoaded', function() {
    switchTab('wallet');
});
</script>

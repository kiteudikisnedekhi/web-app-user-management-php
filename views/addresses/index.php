<div class="bg-gray-50 min-h-screen pb-12">
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">My Addresses</h1>
            <button onclick="showAddAddressModal()" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                <i class="fas fa-plus mr-2"></i>
                Add New Address
            </button>
        </div>

        <!-- Address List -->
        <?php if (empty($addresses)): ?>
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-map-marker-alt text-3xl text-gray-400"></i>
            </div>
            <h2 class="text-xl font-medium text-gray-900 mb-2">No addresses found</h2>
            <p class="text-gray-600 mb-6">Add your first delivery address to start shopping</p>
            <button onclick="showAddAddressModal()" 
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-dark">
                Add New Address
            </button>
        </div>
        <?php else: ?>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($addresses as $address): ?>
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <!-- Address Header -->
                <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="font-medium text-gray-900">
                            <?= htmlspecialchars($address['address_line1']) ?>
                        </span>
                        <?php if ($address['is_default']): ?>
                        <span class="ml-2 px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                            Default
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center space-x-2">
                        <?php if (!$address['is_default']): ?>
                        <button onclick="setDefaultAddress(<?= $address['id'] ?>)"
                                class="text-sm text-primary hover:text-primary-dark">
                            Set Default
                        </button>
                        <?php endif; ?>
                        <div class="relative">
                            <button onclick="toggleAddressMenu(<?= $address['id'] ?>)"
                                    class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <!-- Dropdown Menu -->
                            <div id="addressMenu<?= $address['id'] ?>" 
                                 class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                <div class="py-1">
                                    <button onclick="editAddress(<?= $address['id'] ?>)"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Edit Address
                                    </button>
                                    <?php if (!$address['is_scrutinized']): ?>
                                    <button onclick="uploadDoorPhoto(<?= $address['id'] ?>)"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Upload Door Photo
                                    </button>
                                    <?php endif; ?>
                                    <?php if (!$address['is_default']): ?>
                                    <button onclick="deleteAddress(<?= $address['id'] ?>)"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        Delete Address
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Details -->
                <div class="p-4">
                    <div class="space-y-3">
                        <p class="text-gray-600">
                            <?= htmlspecialchars($address['address_line2'] ?? '') ?>
                        </p>
                        <p class="text-gray-600">
                            <?= htmlspecialchars($address['city']) ?>, 
                            <?= htmlspecialchars($address['state']) ?> - 
                            <?= htmlspecialchars($address['pincode']) ?>
                        </p>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-building mr-2"></i>
                            Floor: <?= htmlspecialchars($address['floor_number']) ?>
                        </div>
                        <?php if ($address['landmark']): ?>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-map-signs mr-2"></i>
                            Landmark: <?= htmlspecialchars($address['landmark']) ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Door Photo -->
                    <?php if ($address['door_photo']): ?>
                    <div class="mt-4">
                        <div class="relative pb-[56.25%]">
                            <img src="<?= htmlspecialchars($address['door_photo']) ?>" 
                                 alt="Door Photo" 
                                 class="absolute inset-0 w-full h-full object-cover rounded-lg">
                        </div>
                        <?php if ($address['is_scrutinized']): ?>
                        <div class="mt-2 flex items-center text-sm text-green-600">
                            <i class="fas fa-lock mr-1"></i>
                            Address verified and locked
                        </div>
                        <?php else: ?>
                        <button onclick="lockAddress(<?= $address['id'] ?>)"
                                class="mt-2 inline-flex items-center text-sm text-primary hover:text-primary-dark">
                            <i class="fas fa-lock mr-1"></i>
                            Lock Address
                        </button>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                        <div class="flex items-center text-yellow-800">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Door photo required for delivery verification
                        </div>
                        <button onclick="uploadDoorPhoto(<?= $address['id'] ?>)"
                                class="mt-2 text-sm text-primary hover:text-primary-dark">
                            Upload Door Photo
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Address Form Modal -->
<div id="addressModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="min-h-screen px-4 text-center">
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="addressForm" class="p-6">
                <input type="hidden" id="addressId" name="address_id">
                
                <h3 class="text-lg font-medium text-gray-900 mb-4" id="modalTitle">
                    Add New Address
                </h3>

                <div class="space-y-4">
                    <!-- Address Line 1 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Address Line 1 *
                        </label>
                        <input type="text" id="addressLine1" name="address_line1" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                    </div>

                    <!-- Address Line 2 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Address Line 2
                        </label>
                        <input type="text" id="addressLine2" name="address_line2"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                    </div>

                    <!-- City, State, Pincode -->
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                City *
                            </label>
                            <input type="text" id="city" name="city" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                State *
                            </label>
                            <input type="text" id="state" name="state" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Pincode *
                            </label>
                            <input type="text" id="pincode" name="pincode" required pattern="[0-9]{6}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                        </div>
                    </div>

                    <!-- Floor Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Floor Number *
                        </label>
                        <input type="number" id="floorNumber" name="floor_number" required min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                    </div>

                    <!-- Landmark -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Landmark
                        </label>
                        <input type="text" id="landmark" name="landmark"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                    </div>

                    <!-- Door Photo Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Door Photo
                        </label>
                        <div class="mt-1 flex items-center">
                            <input type="file" id="doorPhoto" name="door_photo" accept="image/*"
                                   class="sr-only" onchange="previewDoorPhoto(event)">
                            <label for="doorPhoto"
                                   class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-camera mr-2"></i>
                                Choose Photo
                            </label>
                        </div>
                        <div id="photoPreview" class="mt-2 hidden">
                            <img src="" alt="Door Photo Preview" class="w-full h-48 object-cover rounded-lg">
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="hideAddressModal()"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Cancel
                    </button>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Save Address
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentAddressId = null;

function showAddAddressModal() {
    document.getElementById('modalTitle').textContent = 'Add New Address';
    document.getElementById('addressForm').reset();
    document.getElementById('addressId').value = '';
    document.getElementById('photoPreview').classList.add('hidden');
    document.getElementById('addressModal').classList.remove('hidden');
    currentAddressId = null;
}

function hideAddressModal() {
    document.getElementById('addressModal').classList.add('hidden');
}

function toggleAddressMenu(addressId) {
    const menu = document.getElementById(`addressMenu${addressId}`);
    document.querySelectorAll('[id^="addressMenu"]').forEach(m => {
        if (m.id !== `addressMenu${addressId}`) {
            m.classList.add('hidden');
        }
    });
    menu.classList.toggle('hidden');
}

function previewDoorPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

async function editAddress(addressId) {
    try {
        showLoading();
        const response = await fetch(`/address/${addressId}`);
        const data = await response.json();
        
        if (response.ok) {
            document.getElementById('modalTitle').textContent = 'Edit Address';
            document.getElementById('addressId').value = addressId;
            document.getElementById('addressLine1').value = data.address_line1;
            document.getElementById('addressLine2').value = data.address_line2 || '';
            document.getElementById('city').value = data.city;
            document.getElementById('state').value = data.state;
            document.getElementById('pincode').value = data.pincode;
            document.getElementById('floorNumber').value = data.floor_number;
            document.getElementById('landmark').value = data.landmark || '';
            
            if (data.door_photo) {
                const preview = document.getElementById('photoPreview');
                preview.querySelector('img').src = data.door_photo;
                preview.classList.remove('hidden');
            }
            
            document.getElementById('addressModal').classList.remove('hidden');
            currentAddressId = addressId;
        } else {
            alert(data.error || 'Failed to load address');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        hideLoading();
    }
}

async function deleteAddress(addressId) {
    if (!confirm('Are you sure you want to delete this address?')) {
        return;
    }

    try {
        showLoading();
        const response = await fetch('/address/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ address_id: addressId })
        });

        const data = await response.json();
        
        if (response.ok) {
            location.reload();
        } else {
            alert(data.error || 'Failed to delete address');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        hideLoading();
    }
}

async function setDefaultAddress(addressId) {
    try {
        showLoading();
        const response = await fetch('/address/set-default', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ address_id: addressId })
        });

        const data = await response.json();
        
        if (response.ok) {
            location.reload();
        } else {
            alert(data.error || 'Failed to set default address');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        hideLoading();
    }
}

async function lockAddress(addressId) {
    if (!confirm('Are you sure you want to lock this address? This action cannot be undone.')) {
        return;
    }

    try {
        showLoading();
        const response = await fetch('/address/lock', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ address_id: addressId })
        });

        const data = await response.json();
        
        if (response.ok) {
            location.reload();
        } else {
            alert(data.error || 'Failed to lock address');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        hideLoading();
    }
}

document.getElementById('addressForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const url = currentAddressId ? '/address/update' : '/address/add';

    try {
        showLoading();
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        
        if (response.ok) {
            location.reload();
        } else {
            alert(data.error || 'Failed to save address');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    } finally {
        hideLoading();
    }
});

// Close dropdown menus when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('[id^="addressMenu"]')) {
        document.querySelectorAll('[id^="addressMenu"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});
</script>

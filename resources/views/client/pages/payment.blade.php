{{-- @extends('client.layout.app') --}}

@section('content')
@php
$user = (object)[
'name' => 'John Doe',
'email' => 'john@example.com',
'phone' => '123-456-7890',
'address' => '123 Example Street, HCMC',
'created_at' => now()->subYears(2),
];

$pendingTotal = 250000; // in cents = 2,500.00 VNĐ

$paymentMethods = [
(object)[
'id' => 'cash',
'label' => 'Cash',
'description' => 'Pay at the counter',
'icon' => '💵',
],
(object)[
'id' => 'bank',
'label' => 'Bank Transfer',
'description' => 'Transfer to our bank account',
'icon' => '🏦',
],
(object)[
'id' => 'momo',
'label' => 'MoMo',
'description' => 'Pay via MoMo e-wallet',
'icon' => '📱',
],
(object)[
'id' => 'vnpay',
'label' => 'VNPay',
'description' => 'Pay using VNPay QR',
'icon' => '🧾',
],
];

$pendingPayments = [
(object)[
'id' => 1,
'payment_id' => 'PMT-001',
'amount' => 100000, // 1,000.00 VNĐ
'due_date' => now()->addDays(3),
'status' => 'pending',
'order' => (object)[
'order_number' => 'ORD-001',
'device_type' => 'iPhone 14',
'services' => collect([
(object)['name' => 'Screen Replacement'],
(object)['name' => 'Battery Replacement'],
]),
],
],
(object)[
'id' => 2,
'payment_id' => 'PMT-002',
'amount' => 150000,
'due_date' => now()->addDays(5),
'status' => 'overdue',
'order' => (object)[
'order_number' => 'ORD-002',
'device_type' => 'Samsung S22',
'services' => collect([
(object)['name' => 'Water Damage Repair'],
]),
],
],
];

$paymentHistory = [
(object)[
'id' => 3,
'payment_id' => 'PMT-003',
'amount' => 200000,
'paid_at' => now()->subDays(2),
'payment_method' => 'bank',
'order' => (object)[
'order_number' => 'ORD-003',
'device_type' => 'iPhone 12',
'services' => collect([
(object)['name' => 'Camera Repair'],
]),
],
],
(object)[
'id' => 4,
'payment_id' => 'PMT-004',
'amount' => 120000,
'paid_at' => now()->subDays(10),
'payment_method' => 'momo',
'order' => (object)[
'order_number' => 'ORD-004',
'device_type' => 'Xiaomi Redmi Note 11',
'services' => collect([
(object)['name' => 'Speaker Replacement'],
(object)['name' => 'Battery Replacement'],
]),
],
],
];
@endphp

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Payments</h1>
        <div class="text-sm text-gray-500">
            Total pending: ${{ number_format($pendingTotal / 100, 2) }}
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Methods</h2>
        <form id="payment-method-form">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($paymentMethods as $method)
                
                <label class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition-all payment-method-option"
                    data-method="{{ $method->id}}">

                   
                    <input type="radio" name="paymentMethod" value="{{ $method->id }}"
                        class="sr-only" {{ $method->id === 'cash' ? 'checked' : '' }}>
                    <div class="text-3xl mb-2">{{ $method->icon }}</div>

                  
                    <h3 class="font-medium text-gray-900">{{ $method->label }}</h3>
                    <p class="text-sm text-gray-500 text-center mt-1">{{ $method->description }}</p>
                </label>
                @endforeach
            </div>
        </form>
    </div>

    <!-- Pending Payments -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Pending Payments</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Payment ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Order
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Service
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Due Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pendingPayments as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $payment->payment_id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $payment->order->order_number }}</div>
                            <div class="text-sm text-gray-500">{{ $payment->order->device_type }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $payment->order->services->pluck('name')->join(', ') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${{ number_format($payment->amount / 100, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $payment->due_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($payment->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="processPayment('{{ $payment->id }}')"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Pay Now
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No pending payments
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payment History -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Payment History</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Payment ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Order
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Service
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Payment Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Method
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Invoice
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($paymentHistory as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $payment->payment_id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $payment->order->order_number }}</div>
                            <div class="text-sm text-gray-500">{{ $payment->order->device_type }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $payment->order->services->pluck('name')->join(', ') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${{ number_format($payment->amount / 100, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $payment->paid_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ ucfirst($payment->payment_method) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button onclick="viewInvoice('{{ $payment->id }}')"
                                    class="text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <a href=""
                                    class="text-green-600 hover:text-green-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No payment history
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bank Transfer Info -->
    <div id="bank-info" class="bg-blue-50 rounded-lg p-6 hidden">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bank Transfer Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">Bank Name</p>
                <p class="font-medium">{{ config('payment.bank.name', 'TechBank') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Account Number</p>
                <p class="font-medium">{{ config('payment.bank.account', '12345678901234') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Account Holder</p>
                <p class="font-medium">{{ config('payment.bank.holder', 'DEVICE REPAIR COMPANY') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Transfer Note</p>
                <p class="font-medium">Payment [Order Number]</p>
            </div>
        </div>
    </div>

    <!-- QR Code for Digital Payments -->
    <div id="qr-code" class="bg-gray-50 rounded-lg p-6 text-center hidden">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            Scan QR Code to Pay
        </h3>
        <div class="w-48 h-48 bg-white border-2 border-gray-300 rounded-lg mx-auto flex items-center justify-center">
            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
            </svg>
        </div>
        <p class="text-sm text-gray-600 mt-4" id="qr-instruction">
            Use the app to scan the QR code
        </p>
    </div>
</div>

<!-- Invoice Modal -->
<div id="invoice-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Electronic Invoice</h2>
            <button onclick="closeInvoiceModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                ×
            </button>
        </div>

        <div id="invoice-content" class="space-y-4">
            <!-- Invoice content will be loaded here -->
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment method selection
        const paymentOptions = document.querySelectorAll('.payment-method-option');
        const bankInfo = document.getElementById('bank-info');
        const qrCode = document.getElementById('qr-code');
        const qrInstruction = document.getElementById('qr-instruction');

        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove active class from all options
                paymentOptions.forEach(opt => {
                    opt.classList.remove('border-blue-500', 'bg-blue-50');
                    opt.classList.add('border-gray-200');
                });

                // Add active class to selected option
                this.classList.remove('border-gray-200');
                this.classList.add('border-blue-500', 'bg-blue-50');

                // Check the radio button
                this.querySelector('input[type="radio"]').checked = true;

                const method = this.dataset.method;

                // Hide all payment info sections
                bankInfo.classList.add('hidden');
                qrCode.classList.add('hidden');

                // Show relevant payment info
                if (method === 'bank') {
                    bankInfo.classList.remove('hidden');
                } else if (method === 'momo' || method === 'vnpay') {
                    qrCode.classList.remove('hidden');
                    qrInstruction.textContent = `Use ${method === 'momo' ? 'MoMo' : 'VNPay'} app to scan the QR code`;
                }
            });
        });

        // Set initial state
        document.querySelector('.payment-method-option[data-method="cash"]').click();
    });

    function processPayment(paymentId) {
        const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
        const methodLabel = document.querySelector(`[data-method="${selectedMethod}"] h3`).textContent;

        if (confirm(`Process payment using ${methodLabel}?`)) {
            // Show loading state
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Processing...';
            button.disabled = true;

            // Make AJAX request to process payment
            fetch(``, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        payment_id: paymentId,
                        payment_method: selectedMethod
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Payment processed successfully!');
                        location.reload();
                    } else {
                        alert('Payment failed: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Payment processing failed. Please try again.');
                })
                .finally(() => {
                    button.textContent = originalText;
                    button.disabled = false;
                });
        }
    }

    function viewInvoice(paymentId) {
        fetch(`/${paymentId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('invoice-content').innerHTML = data.html;
                    document.getElementById('invoice-modal').classList.remove('hidden');
                } else {
                    alert('Failed to load invoice');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load invoice');
            });
    }

    function closeInvoiceModal() {
        document.getElementById('invoice-modal').classList.add('hidden');
    }
</script>
@endsection
@extends('website.layout.app')
@section('content')
    <style>
        /* Hide spinner arrows from number input */
        .cart-qty-input::-webkit-outer-spin-button,
        .cart-qty-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .cart-qty-input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <div class="container mx-auto px-4 py-8 mt-20">
        <h1 class="text-3xl font-bold mb-8 text-center text-blue-700">Your Shopping Cart</h1>
        @if (empty($cart) || count($cart) === 0)
            <div class="flex flex-col items-center justify-center py-20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300 mb-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 008.48 19h7.04a2 2 0 001.83-1.3L17 13M7 13V6h13" />
                </svg>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">Your cart is empty</h2>
                <p class="text-gray-500 mb-6">You haven't added any services yet. Start exploring our services now!</p>
                <a href="{{ route('service.index') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition">Back to
                    Service</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-xl shadow-lg">
                    <thead>
                        <tr class="bg-blue-50">
                            <th class="px-6 py-4 text-left text-gray-700 font-semibold">Device</th>
                            <th class="px-6 py-4 text-left text-gray-700 font-semibold">Issue</th>
                            <th class="px-6 py-4 text-right text-gray-700 font-semibold">Price</th>
                            <th class="px-6 py-4 text-center text-gray-700 font-semibold">Quantity</th>
                            <th class="px-6 py-4 text-right text-gray-700 font-semibold">Subtotal</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($cart as $id => $item)
                            @php $total += $item['price'] * $item['qty']; @endphp
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4 flex items-center space-x-4">
                                    {{-- <img src="{{ $item['image'] ?? '/default.png' }}" alt="Image" class="w-14 h-14 rounded-lg object-cover border"> --}}
                                    <span class="font-medium text-gray-800">{{ $item['device_type_name'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $item['issue_category_name'] }}</td>
                                <td class="px-6 py-4 text-right text-blue-600 font-semibold">
                                    ${{ number_format($item['price'], 2) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex items-center border rounded-lg">
                                        <button
                                            class="decrease-qty px-2 py-1 text-lg text-gray-500 hover:text-blue-600 focus:outline-none"
                                            data-service-id="{{ $id }}">-</button>
                                        <input type="number" min="1"
                                            class="cart-qty-input w-12 text-center font-semibold"
                                            data-service-id="{{ $id }}" value="{{ $item['qty'] }}">
                                        <button
                                            class="increase-qty px-2 py-1 text-lg text-gray-500 hover:text-blue-600 focus:outline-none"
                                            data-service-id="{{ $id }}">+</button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-green-600 cart-item-subtotal">
                                    ${{ number_format($item['price'] * $item['qty'], 2) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <button class="remove-from-cart text-red-500 hover:text-red-700"
                                        data-service-id="{{ $id }}" title="Remove">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right font-bold text-lg">Subtotal</td>
                            <td class="px-6 py-4 text-right text-blue-600 text-xl font-bold cart-subtotal-value">
                                ${{ number_format($total, 2) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right font-bold text-lg">Total</td>
                            <td class="px-6 py-4 text-right text-blue-700 text-2xl font-bold cart-total-value">
                                ${{ number_format($total, 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center mt-8 gap-4">
                <a href="{{ route('service.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold transition">Continue
                    Shopping</a>
                <a href="{{ route('payment.index') }}"
                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-10 py-4 rounded-lg font-bold text-lg shadow-lg hover:shadow-xl transition">Proceed
                    to Checkout</a>
            </div>
        @endif
    </div>
@endsection

@section('my-js')
    <script>
        $(document).ready(function() {
            function updateQty(serviceId, qty, $row) {
                $.ajax({
                    url: '/cart/update/' + serviceId,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        qty: qty
                    },
                    success: function(response) {
                        $row.find('.cart-qty-input').val(response.service_qty);
                        $row.find('.cart-item-subtotal').text('$' + Number(response.subtotal).toFixed(
                            2));
                        $('.cart-qty-badge').text(response.total_qty);
                        $('.cart-total-value').text('$' + Number(response.total).toFixed(2));
                        $('.cart-subtotal-value').text('$' + Number(response.total).toFixed(2));
                        $('.add-service-to-cart[data-service-id="' + serviceId +
                            '"] .service-qty-badge').text(response.service_qty);
                    }
                });
            }
            $('.increase-qty').on('click', function() {
                var $row = $(this).closest('tr');
                var $input = $row.find('.cart-qty-input');
                var serviceId = $(this).data('service-id');
                var qty = parseInt($input.val()) + 1;
                updateQty(serviceId, qty, $row);
            });
            $('.decrease-qty').on('click', function() {
                var $row = $(this).closest('tr');
                var $input = $row.find('.cart-qty-input');
                var serviceId = $(this).data('service-id');
                var qty = Math.max(1, parseInt($input.val()) - 1);
                updateQty(serviceId, qty, $row);
            });
            $('.cart-qty-input').on('change', function() {
                var $row = $(this).closest('tr');
                var serviceId = $(this).data('service-id');
                var qty = Math.max(1, parseInt($(this).val()));
                updateQty(serviceId, qty, $row);
            });
            // Remove from cart (keep as before)
            $('.remove-from-cart').on('click', function(e) {
                e.preventDefault();
                var $btn = $(this);
                var serviceId = $btn.data('service-id');
                $.ajax({
                    url: '/cart/remove/' + serviceId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $btn.closest('tr').remove();
                        $('.cart-qty-badge').text(response.total_qty);
                        $('.add-service-to-cart[data-service-id="' + response.service_id +
                            '"] .service-qty-badge').text(response.service_qty);
                        if ($('tbody tr').length === 0) {
                            location.reload();
                        }
                    }
                });
            });
        });
    </script>
@endsection

<html style="font-family: Arial, sans-serif; background: #f6f8fa;">
<body style="margin:0;padding:0;background:#f6f8fa;">
    <div style="max-width:600px;margin:40px auto;background:#fff;border-radius:12px;box-shadow:0 2px 8px #e0e7ef;padding:32px;">
        <h2 style="color:#dc2626;text-align:center;margin-bottom:24px;">New Order Notification</h2>
        <div style="margin-bottom:24px;">
            <h3 style="margin:0 0 8px 0;color:#111827;font-size:18px;">Customer Information</h3>
            <div style="padding:12px 20px;background:#f1f5f9;border-radius:8px;">
                <strong>Name:</strong> {{ $order->user->name ?? '' }}<br>
                <strong>Address:</strong> {{ $order->user->address ?? '' }}<br>
                <strong>Phone:</strong> {{ $order->user->phone_number ?? '' }}
            </div>
        </div>
        <div style="margin-bottom:24px;">
            <h3 style="margin:0 0 8px 0;color:#111827;font-size:18px;">Order Details</h3>
            <table style="width:100%;border-collapse:collapse;background:#fff;">
                <thead>
                    <tr style="background:#f1f5f9;">
                        <th style="padding:10px 8px;text-align:left;font-size:14px;">#</th>
                        <th style="padding:10px 8px;text-align:left;font-size:14px;">Product</th>
                        <th style="padding:10px 8px;text-align:center;font-size:14px;">Qty</th>
                        <th style="padding:10px 8px;text-align:right;font-size:14px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($order->orderItems as $orderItem)
                    <tr style="border-bottom:1px solid #e5e7eb;">
                        <td style="padding:8px 8px;">{{ $loop->iteration }}</td>
                        <td style="padding:8px 8px;">{{ $orderItem->name }}</td>
                        <td style="padding:8px 8px;text-align:center;">{{ $orderItem->qty }}</td>
                        <td style="padding:8px 8px;text-align:right;">{{ number_format($orderItem->price * $orderItem->qty, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="padding:12px 8px;text-align:right;font-weight:bold;">Total</td>
                        <td style="padding:12px 8px;text-align:right;font-weight:bold;color:#dc2626;">{{ number_format($order->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div style="text-align:center;color:#64748b;font-size:14px;">Please process this order promptly.</div>
    </div>
</body>
</html>


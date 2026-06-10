<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $transaction->transaction_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 20px;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
        }
        
        .receipt-container {
            background: #fff;
            width: 100%;
            max-width: 350px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .receipt-container {
                box-shadow: none;
                max-width: 100%;
            }
        }

        .text-center { text-align: center; }
        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 10px; }
        .mt-2 { margin-top: 10px; }
        .mt-4 { margin-top: 20px; }
        
        .store-name {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 0 5px 0;
        }
        
        .store-address {
            font-size: 0.85rem;
            color: #555;
            margin-bottom: 15px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 15px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            margin-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            margin: 10px 0;
        }

        th {
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
            text-align: right;
            font-weight: normal;
        }
        
        th.text-left { text-align: left; }
        
        td {
            padding: 5px 0;
            text-align: right;
            vertical-align: top;
        }

        td.item-name {
            text-align: left;
            padding-right: 10px;
        }

        .totals {
            width: 100%;
            font-size: 0.9rem;
        }

        .totals .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .totals .grand-total {
            font-size: 1.2rem;
            font-weight: bold;
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-top: 5px;
        }

        .footer {
            font-size: 0.85rem;
            color: #333;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        <div class="text-center">
            <h1 class="store-name">PureVibe</h1>
            <div class="store-address">
                PureVibe Wellness Market<br>
                Tel: (555) 123-4567
            </div>
        </div>

        <div class="divider"></div>

        <div class="info-row">
            <span>Txn #:</span>
            <span>{{ $transaction->transaction_number }}</span>
        </div>
        <div class="info-row">
            <span>Date:</span>
            <span>{{ $transaction->created_at->format('M d, Y h:i A') }}</span>
        </div>

        <div class="divider"></div>

        <table>
            <thead>
                <tr>
                    <th class="text-left">Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $item)
                <tr>
                    <td class="item-name">
                        {{ $item->product ? $item->product->name : 'Unknown Item' }}
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <div class="totals">
            <div class="row">
                <span>Subtotal:</span>
                <span>₱{{ number_format($transaction->subtotal, 2) }}</span>
            </div>
            <div class="row">
                <span>{{ $settings['tax_name'] ?? 'VAT' }} ({{ $settings['default_tax_rate'] ?? 12 }}%):</span>
                <span>₱{{ number_format($transaction->tax_amount, 2) }}</span>
            </div>
            <div class="row grand-total">
                <span>TOTAL:</span>
                <span>₱{{ number_format($transaction->total_amount, 2) }}</span>
            </div>
        </div>

        <div class="divider"></div>

        <div class="text-center footer">
            <p class="mb-1">Thank you for shopping with us!</p>
            <p>Please keep this receipt for your records.</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>

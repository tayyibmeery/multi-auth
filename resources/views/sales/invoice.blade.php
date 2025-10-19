<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $sale->sale_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-header {
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="invoice-header">
                    <div class="row">
                        <div class="col-6">
                            <h2>INVOICE</h2>
                            <h4>Your Company Name</h4>
                            <p>
                                123 Business Street<br>
                                City, State 12345<br>
                                Phone: (123) 456-7890<br>
                                Email: info@company.com
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <h3>{{ $sale->sale_number }}</h3>
                            <p>
                                <strong>Date:</strong> {{ $sale->sale_date->format('M d, Y') }}<br>
                                <strong>Due Date:</strong> {{ $sale->sale_date->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bill To -->
                <div class="row mb-4">
                    <div class="col-6">
                        <h5>Bill To:</h5>
                        <p>
                            <strong>{{ $sale->customer->name ?? 'Walk-in Customer' }}</strong><br>
                            @if($sale->customer)
                            {{ $sale->customer->address ?? '' }}<br>
                            {{ $sale->customer->phone ?? '' }}<br>
                            {{ $sale->customer->email ?? '' }}
                            @endif
                        </p>
                    </div>
                    <div class="col-6 text-end">
                        <h5>Payment Status:</h5>
                        <span class="badge bg-{{ $sale->payment_status === 'paid' ? 'success' : ($sale->payment_status === 'partial' ? 'warning' : 'danger') }}">
                            {{ ucfirst($sale->payment_status) }}
                        </span>
                    </div>
                </div>

                <!-- Items -->
                <table class="invoice-table mb-4">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->saleItems as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ number_format($item->quantity, 2) }}</td>
                            <td>Rs {{ number_format($item->unit_price, 2) }}</td>
                            <td>Rs {{ number_format($item->total_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Totals -->
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <table class="table table-bordered">
                            <tr>
                                <td><strong>Subtotal:</strong></td>
                                <td class="text-right">Rs {{ number_format($sale->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tax:</strong></td>
                                <td class="text-right">Rs {{ number_format($sale->tax_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Discount:</strong></td>
                                <td class="text-right">-Rs {{ number_format($sale->discount_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td class="text-right"><strong>Rs {{ number_format($sale->total_amount, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Paid:</strong></td>
                                <td class="text-right">Rs {{ number_format($sale->paid_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Due:</strong></td>
                                <td class="text-right">Rs {{ number_format($sale->due_amount, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Notes -->
                @if($sale->notes)
                <div class="mt-4">
                    <h5>Notes:</h5>
                    <p>{{ $sale->notes }}</p>
                </div>
                @endif

                <!-- Footer -->
                <div class="mt-5 pt-5 border-top">
                    <div class="row">
                        <div class="col-6">
                            <p>Thank you for your business!</p>
                        </div>
                        <div class="col-6 text-end">
                            <p>Authorized Signature</p>
                        </div>
                    </div>
                </div>

                <!-- Print Button -->
                <div class="no-print mt-4 text-center">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print me-1"></i> Print Invoice
                    </button>
                    <button onclick="window.close()" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }

    </script>
</body>
</html>

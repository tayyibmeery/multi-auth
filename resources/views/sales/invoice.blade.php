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
            font-size: 14px;
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
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .total-section {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
                font-size: 12px;
            }

            .container {
                max-width: 100%;
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
                            <h2 class="text-primary">INVOICE</h2>
                            <h4>{{ $company->company_name ?? 'Your Company Name' }}</h4>
                            <p class="mb-1">
                                @if($company && $company->address)
                                {{ $company->address }}<br>
                                @else
                                123 Business Street<br>
                                City, State 12345<br>
                                @endif

                                @if($company && $company->phone)
                                Phone: {{ $company->phone }}<br>
                                @else
                                Phone: (123) 456-7890<br>
                                @endif

                                @if($company && $company->email)
                                Email: {{ $company->email }}<br>
                                @else
                                Email: info@company.com<br>
                                @endif

                                @if($company && $company->website)
                                Website: {{ $company->website }}
                                @endif
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <h3 class="text-success">{{ $sale->sale_number }}</h3>
                            <p class="mb-1">
                                <strong>Date:</strong> {{ \Carbon\Carbon::parse($sale->sale_date)->format('M d, Y') }}<br>
                                <strong>Due Date:</strong> {{ \Carbon\Carbon::parse($sale->sale_date)->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bill To & Status -->
                <div class="row mb-4">
                    <div class="col-6">
                        <h5>Bill To:</h5>
                        <p class="mb-1">
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
                        <span class="badge bg-{{ $sale->payment_status === 'paid' ? 'success' : ($sale->payment_status === 'partial' ? 'warning' : 'danger') }} fs-6">
                            {{ ucfirst($sale->payment_status) }}
                        </span>
                    </div>
                </div>

                <!-- Items Table -->
                <table class="invoice-table mb-4">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="45%">Product</th>
                            <th width="15%">Quantity</th>
                            <th width="15%">Unit Price</th>
                            <th width="20%">Total</th>
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
                            <tr class="total-section">
                                <td><strong>Total Amount:</strong></td>
                                <td class="text-right">Rs {{ number_format($sale->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Paid Amount:</strong></td>
                                <td class="text-right">Rs {{ number_format($sale->paid_amount, 2) }}</td>
                            </tr>
                            <tr class="{{ $sale->due_amount > 0 ? 'table-danger' : 'table-success' }}">
                                <td><strong>Due Amount:</strong></td>
                                <td class="text-right">Rs {{ number_format($sale->due_amount, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Notes -->
                @if($sale->notes)
                <div class="mt-4">
                    <h5>Notes:</h5>
                    <p class="text-muted">{{ $sale->notes }}</p>
                </div>
                @endif

                <!-- Footer -->
                <div class="mt-5 pt-5 border-top">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-0">Thank you for your business!</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-0">Authorized Signature</p>
                            <div class="mt-4" style="border-top: 1px solid #000; width: 200px; margin-left: auto;"></div>
                        </div>
                    </div>
                </div>

                <!-- Print Controls -->
                <div class="no-print mt-4 text-center">
                    <button onclick="window.print()" class="btn btn-primary">
                        Print Invoice
                    </button>
                    <button onclick="window.close()" class="btn btn-secondary">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            // Auto-print when page loads
            window.print();
        }

    </script>
</body>
</html>

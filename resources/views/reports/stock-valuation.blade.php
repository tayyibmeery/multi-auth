@extends('layouts.app')

@section('title', 'Stock Valuation Report')

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Stock Valuation Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                    <li class="breadcrumb-item active">Stock Valuation</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Total Valuation Cards -->
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Rs {{ number_format($totalItemValue, 2) }}</h3>
                        <p>Spare Parts Stock Value</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <a href="#spare-parts" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rs {{ number_format($totalProductValue, 2) }}</h3>
                        <p>Products Stock Value</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cube"></i>
                    </div>
                    <a href="#products" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>Rs {{ number_format($totalItemValue + $totalProductValue, 2) }}</h3>
                        <p>Total Inventory Value</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <a href="{{ route('reports.stock-valuation') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Items Valuation -->
                <div class="card" id="spare-parts">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">
                            <i class="fas fa-boxes mr-2"></i>
                            Spare Parts Valuation (Raw Materials)
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="itemsValuationTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Spare Part</th>
                                        <th>Category</th>
                                        <th>Current Stock</th>
                                        <th>Unit Price</th>
                                        <th>Stock Value</th>
                                        <th>% of Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold text-primary">{{ $item->name }}</div>
                                            <small class="text-muted">{{ $item->code }}</small>
                                        </td>
                                        <td>{{ $item->category->name }}</td>
                                        <td class="font-weight-bold">{{ $item->current_stock }} {{ $item->unit }}</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($item->current_price, 2) }}</td>
                                        <td class="font-weight-bold text-info">Rs {{ number_format($item->total_value, 2) }}</td>
                                        <td class="font-weight-bold">{{ $totalItemValue > 0 ? number_format(($item->total_value / $totalItemValue) * 100, 1) : 0 }}%</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="4" class="text-right font-weight-bold">Total Spare Parts Value:</td>
                                        <td class="font-weight-bold text-primary">Rs {{ number_format($totalItemValue, 2) }}</td>
                                        <td class="font-weight-bold text-primary">100%</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Products Valuation -->
                <div class="card" id="products">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">
                            <i class="fas fa-cube mr-2"></i>
                            Products Valuation (Finished Goods)
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="productsValuationTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Current Stock</th>
                                        <th>Selling Price</th>
                                        <th>Stock Value</th>
                                        <th>% of Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold text-primary">{{ $product->name }}</div>
                                            <small class="text-muted">{{ $product->code }}</small>
                                        </td>
                                        <td class="font-weight-bold">{{ $product->current_stock }} units</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($product->selling_price, 2) }}</td>
                                        <td class="font-weight-bold text-info">Rs {{ number_format($product->total_value, 2) }}</td>
                                        <td class="font-weight-bold">{{ $totalProductValue > 0 ? number_format(($product->total_value / $totalProductValue) * 100, 1) : 0 }}%</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Total Products Value:</td>
                                        <td class="font-weight-bold text-primary">Rs {{ number_format($totalProductValue, 2) }}</td>
                                        <td class="font-weight-bold text-primary">100%</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Valuation Summary -->
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-2"></i>
                            Valuation Summary
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="font-weight-bold text-dark mb-3">Inventory Distribution</h5>
                                <div class="space-y-3">
                                    <div>
                                        <div class="mb-1 d-flex justify-between">
                                            <span class="text-muted">Raw Materials (Spare Parts)</span>
                                            <span class="font-weight-bold">Rs {{ number_format($totalItemValue, 2) }}</span>
                                        </div>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $totalItemValue + $totalProductValue > 0 ? ($totalItemValue / ($totalItemValue + $totalProductValue)) * 100 : 0 }}%" aria-valuenow="{{ $totalItemValue + $totalProductValue > 0 ? ($totalItemValue / ($totalItemValue + $totalProductValue)) * 100 : 0 }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ $totalItemValue + $totalProductValue > 0 ? number_format(($totalItemValue / ($totalItemValue + $totalProductValue)) * 100, 1) : 0 }}%
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="mb-1 d-flex justify-between">
                                            <span class="text-muted">Finished Goods (Products)</span>
                                            <span class="font-weight-bold">Rs {{ number_format($totalProductValue, 2) }}</span>
                                        </div>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalItemValue + $totalProductValue > 0 ? ($totalProductValue / ($totalItemValue + $totalProductValue)) * 100 : 0 }}%" aria-valuenow="{{ $totalItemValue + $totalProductValue > 0 ? ($totalProductValue / ($totalItemValue + $totalProductValue)) * 100 : 0 }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ $totalItemValue + $totalProductValue > 0 ? number_format(($totalProductValue / ($totalItemValue + $totalProductValue)) * 100, 1) : 0 }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold text-dark mb-3">Top 5 Most Valuable Spare Parts</h5>
                                <div class="list-group">
                                    @foreach($items->sortByDesc('total_value')->take(5) as $item)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold">{{ $item->name }}</span>
                                        <span class="badge badge-info badge-pill">Rs {{ number_format($item->total_value, 2) }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection

@push('scripts')
<!-- DataTables & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script>
    $(function() {
        $("#itemsValuationTable").DataTable({
            "responsive": true
            , "lengthChange": true
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "pageLength": 10
        });

        $("#productsValuationTable").DataTable({
            "responsive": true
            , "lengthChange": true
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "pageLength": 10
        });
    });

</script>
@endpush

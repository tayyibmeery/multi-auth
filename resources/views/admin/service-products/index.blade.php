@extends('layouts.app')

@section('title', 'Service Products - Admin')

@push('css')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Service Products Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.website.dashboard') }}">Website Settings</a></li>
                    <li class="breadcrumb-item active">Service Products</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Service Products List</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.service-products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add Service Product
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="serviceProductsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Monthly Price</th>
                                        <th>Yearly Price</th>
                                        <th>Featured</th>
                                        <th>Active</th>
                                        <th>Sort Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <i class="{{ $product->icon }} fa-lg text-{{ $product->color }}"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $product->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($product->monthly_price, 2) }}</td>
                                        <td>
                                            @if($product->yearly_price)
                                            ${{ number_format($product->yearly_price, 2) }}
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $product->is_featured ? 'success' : 'secondary' }}">
                                                {{ $product->is_featured ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $product->is_active ? 'success' : 'danger' }}">
                                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $product->sort_order }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.service-products.edit', $product->id) }}" class="btn btn-sm btn-info" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.service-products.destroy', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this service product?')" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#serviceProductsTable').DataTable({
            "paging": true
            , "lengthChange": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "autoWidth": false
            , "responsive": true
            , "order": [
                [6, 'asc']
            ] // Sort by sort order
        });
    });

</script>
@endpush

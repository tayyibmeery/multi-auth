@extends("layouts.app")

@section("title", "Customers Management")

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Customers Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Customers</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ \App\Models\Customer::count() }}</h3>
                        <p>Total Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('customers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rs {{ number_format(\App\Models\Customer::with('sales')->get()->sum(function($customer) {
                            return $customer->sales->sum('total_amount');
                        }), 2) }}</h3>
                        <p>Total Sales</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('sales.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>Rs {{ number_format(\App\Models\Customer::with('sales')->get()->sum(function($customer) {
                            return $customer->sales->sum('due_amount');
                        }), 2) }}</h3>
                        <p>Total Due</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="{{ route('customers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>{{ \App\Models\Customer::whereHas('sales', function($query) {
                            $query->where('due_amount', '>', 0);
                        })->count() }}</h3>
                        <p>Customers with Due</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <a href="{{ route('customers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Customers List</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCustomerModal">
                                <i class="fas fa-plus mr-1"></i> Add Customer
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="customersTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Customer Details</th>
                                    <th>Contact Information</th>
                                    <th>Total Sales</th>
                                    <th>Total Due</th>
                                    <th>Last Sale</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $customer)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-primary">{{ $customer->name }}</div>
                                        <small class="text-muted">
                                            @if($customer->company_name)
                                            {{ $customer->company_name }}
                                            @else
                                            Individual Customer
                                            @endif
                                        </small>
                                        @if($customer->tax_number)
                                        <br><small class="text-muted">Tax: {{ $customer->tax_number }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">
                                            @if($customer->phone)
                                            <i class="fas fa-phone mr-1 text-muted"></i>{{ $customer->phone }}
                                            @else
                                            <span class="text-muted">No Phone</span>
                                            @endif
                                        </div>
                                        <small class="text-muted">
                                            @if($customer->email)
                                            <i class="fas fa-envelope mr-1"></i>{{ $customer->email }}
                                            @else
                                            No Email
                                            @endif
                                        </small>
                                        @if($customer->address)
                                        <br><small class="text-muted">{{ Str::limit($customer->address, 40) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-success">Rs {{ number_format($customer->total_sales, 2) }}</div>
                                        <small class="text-muted">{{ $customer->sales_count }} sales</small>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold {{ $customer->total_due > 0 ? 'text-danger' : 'text-success' }}">
                                            Rs {{ number_format($customer->total_due, 2) }}
                                        </div>
                                        @if($customer->total_due > 0)
                                        <small class="text-danger">
                                            <i class="fas fa-exclamation-circle mr-1"></i>Has due amount
                                        </small>
                                        @else
                                        <small class="text-success">All paid</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($customer->last_sale_date)
                                        <div class="font-weight-bold">{{ \Carbon\Carbon::parse($customer->last_sale_date)->format('M j, Y') }}</div>
                                        <small class="text-muted">Last purchase</small>
                                        @else
                                        <span class="text-muted">No sales yet</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('customers.show', $customer) }}" class="btn btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-warning edit-customer" data-toggle="modal" data-target="#editCustomerModal" data-customer="{{ json_encode($customer) }}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this customer?')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-users fa-3x mb-3"></i>
                                            <h5>No customers found</h5>
                                            <p>Get started by adding your first customer</p>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCustomerModal">
                                                <i class="fas fa-plus mr-2"></i>Add First Customer
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Customer Details</th>
                                    <th>Contact Information</th>
                                    <th>Total Sales</th>
                                    <th>Total Due</th>
                                    <th>Last Sale</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Add New Customer
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}">
                        @error('company_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tax_number" class="form-label">Tax Number</label>
                        <input type="text" name="tax_number" id="tax_number" class="form-control @error('tax_number') is-invalid @enderror" value="{{ old('tax_number') }}">
                        @error('tax_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Save Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCustomerModalLabel">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Customer
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCustomerForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit_phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="edit_phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit_address" class="form-label">Address</label>
                        <textarea name="address" id="edit_address" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_company_name" class="form-label">Company Name</label>
                        <input type="text" name="company_name" id="edit_company_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit_tax_number" class="form-label">Tax Number</label>
                        <input type="text" name="tax_number" id="edit_tax_number" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
    $(function() {
        $("#customersTable").DataTable({
            "responsive": true
            , "lengthChange": true
            , "autoWidth": false
            , "paging": true
            , "searching": true
            , "ordering": true
            , "info": true
            , "buttons": [{
                    extend: 'copy'
                    , text: '<i class="fas fa-copy mr-1"></i>Copy'
                    , className: 'btn btn-default btn-sm'
                }
                , {
                    extend: 'csv'
                    , text: '<i class="fas fa-file-csv mr-1"></i>CSV'
                    , className: 'btn btn-default btn-sm'
                }
                , {
                    extend: 'excel'
                    , text: '<i class="fas fa-file-excel mr-1"></i>Excel'
                    , className: 'btn btn-default btn-sm'
                }
                , {
                    extend: 'pdf'
                    , text: '<i class="fas fa-file-pdf mr-1"></i>PDF'
                    , className: 'btn btn-default btn-sm'
                }
                , {
                    extend: 'print'
                    , text: '<i class="fas fa-print mr-1"></i>Print'
                    , className: 'btn btn-default btn-sm'
                }
                , {
                    extend: 'colvis'
                    , text: '<i class="fas fa-eye mr-1"></i>Columns'
                    , className: 'btn btn-default btn-sm'
                }
            ]
            , "language": {
                "search": "_INPUT_"
                , "searchPlaceholder": "Search customers..."
                , "lengthMenu": "Show _MENU_ entries"
                , "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>"
                    , "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
            , "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                "<'row'<'col-sm-12 col-md-6'B>>"
            , "drawCallback": function() {
                $('.dataTables_filter input').addClass('form-control form-control-sm');
                $('.dataTables_length select').addClass('form-control form-control-sm');
            }
        }).buttons().container().appendTo('#customersTable_wrapper .col-md-6:eq(0)');

        // Edit Customer Modal
        $('#editCustomerModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var customer = button.data('customer');
            var modal = $(this);

            modal.find('#edit_name').val(customer.name);
            modal.find('#edit_email').val(customer.email || '');
            modal.find('#edit_phone').val(customer.phone || '');
            modal.find('#edit_address').val(customer.address || '');
            modal.find('#edit_company_name').val(customer.company_name || '');
            modal.find('#edit_tax_number').val(customer.tax_number || '');

            modal.find('#editCustomerForm').attr('action', '/customers/' + customer.id);
        });

        // Form validation for add customer
        $('form').on('submit', function() {
            $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');
        });
    });

</script>
@endpush

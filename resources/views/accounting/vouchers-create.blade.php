@extends("layouts.app")

@section("title", "Create Accounting Voucher")

@section("content")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Accounting Voucher</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounting.dashboard') }}">Accounting</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounting.vouchers') }}">Vouchers</a></li>
                        <li class="breadcrumb-item active">Create Voucher</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">New Voucher Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ route('accounting.vouchers.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="voucher_date">Voucher Date *</label>
                                            <input type="date" class="form-control @error('voucher_date') is-invalid @enderror" id="voucher_date" name="voucher_date" value="{{ old('voucher_date', date('Y-m-d')) }}" required>
                                            @error('voucher_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="account_id">Account *</label>
                                            <select class="form-control select2 @error('account_id') is-invalid @enderror" id="account_id" name="account_id" required>
                                                <option value="">Select Account</option>
                                                @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                                    {{ $account->code }} - {{ $account->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('account_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="debit">Debit Amount</label>
                                            <input type="number" step="0.01" class="form-control @error('debit') is-invalid @enderror" id="debit" name="debit" value="{{ old('debit', 0) }}" placeholder="0.00">
                                            @error('debit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="credit">Credit Amount</label>
                                            <input type="number" step="0.01" class="form-control @error('credit') is-invalid @enderror" id="credit" name="credit" value="{{ old('credit', 0) }}" placeholder="0.00">
                                            @error('credit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description *</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Enter voucher description..." required>{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="reference">Reference</label>
                                    <input type="text" class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ old('reference') }}" placeholder="Optional reference number">
                                    @error('reference')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Create Voucher
                                    </button>
                                    <a href="{{ route('accounting.vouchers') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2();

        // Ensure only one of debit or credit is filled
        $('#debit, #credit').on('input', function() {
            if ($(this).val() > 0) {
                if ($(this).attr('id') === 'debit') {
                    $('#credit').val(0);
                } else {
                    $('#debit').val(0);
                }
            }
        });
    });

</script>
@endsection

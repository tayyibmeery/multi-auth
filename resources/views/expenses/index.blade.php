@extends('layouts.app')

@section('title', 'Expenses')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Expenses</h5>
                    <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Expense
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="expensesTable">
                            <thead>
                                <tr>
                                    <th>Expense #</th>
                                    <th>Date</th>
                                    <th>Account</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->expense_number }}</td>
                                    <td>{{ $expense->expense_date->format('M d, Y') }}</td>
                                    <td>{{ $expense->account->name }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $expense->category }}</span>
                                    </td>
                                    <td>Rs {{ number_format($expense->amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($expense->payment_method) }}</span>
                                    </td>
                                    <td>{{ Str::limit($expense->description, 30) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this expense?')">
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

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $expenses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#expensesTable').DataTable({
            order: [
                [1, 'desc']
            ]
            , pageLength: 20
        });
    });

</script>
@endpush

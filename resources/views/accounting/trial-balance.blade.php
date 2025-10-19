@extends('layouts.app')

@section('title', 'Trial Balance')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Trial Balance</h5>
                    <button onclick="window.print()" class="btn btn-secondary">
                        <i class="fas fa-print me-1"></i> Print
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Account</th>
                                    <th>Code</th>
                                    <th>Debit (Rs )</th>
                                    <th>Credit (Rs )</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trialBalance as $item)
                                <tr>
                                    <td>{{ $item['account'] }}</td>
                                    <td>{{ $item['code'] }}</td>
                                    <td class="text-end">{{ number_format($item['debit'], 2) }}</td>
                                    <td class="text-end">{{ number_format($item['credit'], 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="2" class="text-end"><strong>Total:</strong></td>
                                    <td class="text-end"><strong>{{ number_format($totalDebit, 2) }}</strong></td>
                                    <td class="text-end"><strong>{{ number_format($totalCredit, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end"><strong>Difference:</strong></td>
                                    <td colspan="2" class="text-end {{ $totalDebit == $totalCredit ? 'text-success' : 'text-danger' }}">
                                        <strong>{{ number_format($totalDebit - $totalCredit, 2) }}</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($totalDebit != $totalCredit)
                    <div class="alert alert-danger mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Trial Balance is not balanced! Debit and Credit totals do not match.
                    </div>
                    @else
                    <div class="alert alert-success mt-3">
                        <i class="fas fa-check-circle me-2"></i>
                        Trial Balance is balanced.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

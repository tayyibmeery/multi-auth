@extends('layouts.app')

@section('title', 'View Message')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Message Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Messages
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Name:</th>
                                    <td>{{ $message->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>
                                        <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $message->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if($message->status == 'unread')
                                        <span class="badge badge-warning">Unread</span>
                                        @else
                                        <span class="badge badge-success">Read</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Submitted:</th>
                                    <td>{{ $message->created_at->format('M j, Y g:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Message:</h5>
                            <div class="border p-3 bg-light">
                                {{ $message->message }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        @if($message->status == 'unread')
                        <form action="{{ route('admin.messages.update', $message->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="read">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i> Mark as Read
                            </button>
                        </form>
                        @endif

                        <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this message?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

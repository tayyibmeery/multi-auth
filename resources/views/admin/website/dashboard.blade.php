@extends('layouts.app')

@section('title', 'Website Settings Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Website Settings</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Company Information</h5>
                                    <p class="card-text">Manage company details, contact information, and about us content.</p>
                                    {{-- FIXED: Changed to correct route name --}}
                                    <a href="{{ route('admin.company.index') }}" class="btn btn-light">Manage</a>
                                </div>
                            </div>
                        </div>
                        <!-- Add more setting cards as needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

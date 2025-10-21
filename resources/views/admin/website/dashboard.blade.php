@extends('layouts.app')

@section('title', 'Website Settings Dashboard')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Website Settings</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item active">Website Settings</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Company Information</h5>
                        <p class="card-text">Manage company details, contact information, and about us content.</p>
                        <a href="{{ route('admin.company.index') }}" class="btn btn-light">Manage</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Service Products</h5>
                        <p class="card-text">Manage service products, pricing, and features for your website.</p>
                        <a href="{{ route('admin.service-products.index') }}" class="btn btn-light">Manage</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Contact Messages</h5>
                        <p class="card-text">View and manage contact messages from your website visitors.</p>
                        <a href="{{ route('admin.messages.index') }}" class="btn btn-light">Manage</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Company Information Summary -->
        @if($company)
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Current Company Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Basic Information</h5>
                                <p><strong>Company Name:</strong> {{ $company->company_name }}</p>
                                <p><strong>Tagline:</strong> {{ $company->tagline }}</p>
                                <p><strong>Email:</strong> {{ $company->email }}</p>
                                <p><strong>Phone:</strong> {{ $company->phone }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Social Media</h5>
                                @if($company->facebook)
                                <p><strong>Facebook:</strong> {{ $company->facebook }}</p>
                                @endif
                                @if($company->twitter)
                                <p><strong>Twitter:</strong> {{ $company->twitter }}</p>
                                @endif
                                @if($company->linkedin)
                                <p><strong>LinkedIn:</strong> {{ $company->linkedin }}</p>
                                @endif
                                @if($company->instagram)
                                <p><strong>Instagram:</strong> {{ $company->instagram }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

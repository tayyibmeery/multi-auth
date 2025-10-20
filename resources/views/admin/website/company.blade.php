@extends('layouts.app')

@section('title', 'Company Information')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Company Information</h3>
                </div>
                <div class="card-body">
                    {{-- FIXED: Changed to POST method and correct route name --}}
                    <form action="{{ route('admin.company.update') }}" method="POST">
                        @csrf
                        {{-- REMOVED: @method('PUT') since route uses POST --}}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">Company Name *</label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name', $company->company_name ?? '') }}" required>
                                    @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tagline">Tagline *</label>
                                    <input type="text" class="form-control @error('tagline') is-invalid @enderror" id="tagline" name="tagline" value="{{ old('tagline', $company->tagline ?? '') }}" required>
                                    @error('tagline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="about">About Company *</label>
                            <textarea class="form-control @error('about') is-invalid @enderror" id="about" name="about" rows="4" required>{{ old('about', $company->about ?? '') }}</textarea>
                            @error('about')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mission">Mission *</label>
                            <textarea class="form-control @error('mission') is-invalid @enderror" id="mission" name="mission" rows="3" required>{{ old('mission', $company->mission ?? '') }}</textarea>
                            @error('mission')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="vision">Vision *</label>
                            <textarea class="form-control @error('vision') is-invalid @enderror" id="vision" name="vision" rows="3" required>{{ old('vision', $company->vision ?? '') }}</textarea>
                            @error('vision')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address *</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $company->address ?? '') }}</textarea>
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone *</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $company->phone ?? '') }}" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $company->email ?? '') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website', $company->website ?? '') }}">
                                    @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Add the new social media fields --}}
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="url" class="form-control @error('facebook') is-invalid @enderror" id="facebook" name="facebook" value="{{ old('facebook', $company->facebook ?? '') }}">
                                    @error('facebook')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="twitter">Twitter</label>
                                    <input type="url" class="form-control @error('twitter') is-invalid @enderror" id="twitter" name="twitter" value="{{ old('twitter', $company->twitter ?? '') }}">
                                    @error('twitter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linkedin">LinkedIn</label>
                                    <input type="url" class="form-control @error('linkedin') is-invalid @enderror" id="linkedin" name="linkedin" value="{{ old('linkedin', $company->linkedin ?? '') }}">
                                    @error('linkedin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="url" class="form-control @error('instagram') is-invalid @enderror" id="instagram" name="instagram" value="{{ old('instagram', $company->instagram ?? '') }}">
                                    @error('instagram')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="working_hours">Working Hours</label>
                            <input type="text" class="form-control @error('working_hours') is-invalid @enderror" id="working_hours" name="working_hours" value="{{ old('working_hours', $company->working_hours ?? '') }}" placeholder="e.g., Mon-Fri 9:00 AM - 5:00 PM">
                            @error('working_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Information</button>
                            {{-- FIXED: Changed to correct dashboard route --}}
                            <a href="{{ route('admin.website.dashboard') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Company form loaded');
    });

</script>
@endsection

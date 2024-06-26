@extends('layouts.app')

@section('title', 'User Profile')

@section('third_party_stylesheets')
    @include('includes.filepond-css')
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('utils.alerts')
                <h3>Hello, <span class="text-primary">{{ auth()->user()->first_name }}</span></h3>
                <p class="font-italic">Change your profile information & password from here...</p>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="form-group">
                                <label for="image">Profile Image <span class="text-danger">*</span></label>
                                <div style="width: 100px; height: 100px; overflow: hidden;"
                                    class="d-block mx-auto img-thumbnail mb-2 rounded-circle">
                                    @if (auth()->user()->hasRole('Super Admin'))
                                        <img style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;"
                                            src="{{ auth()->user()->getFirstMediaUrl('avatars') }}" alt="Profile Image">
                                    @else
                                        <img style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;"
                                            src="{{ auth()->user()->store->image == 'avatar.png'
                                                ? auth()->user()->getFirstMediaUrl('avatars')
                                                : asset('storage/' . auth()->user()->store->image) }}"
                                            alt="Profile Image">
                                    @endif
                                </div>
                                <input id="image" type="file" name="image" data-max-file-size="500KB">
                            </div>


                            <div class="form-group">
                                <label for="name">First Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="first_name" required
                                    value="{{ auth()->user()->first_name }}">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Middle Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="middle_name" 
                                    value="{{ auth()->user()->middle_name }}">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Last Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="last_name" required
                                    value="{{ auth()->user()->last_name }}">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                           
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input class="form-control" type="email" name="email" required
                                    value="{{ auth()->user()->email }}">
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Profile <i
                                        class="bi bi-check"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('profile.update.password') }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="current_password">Current Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="current_password" required>
                                @error('current_password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">New Password <span class="text-danger">*</span></label>
                                <input class="form-control" type="password" name="password" required>
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="password" name="password_confirmation" required>
                                @error('password_confirmation')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Password <i
                                        class="bi bi-check"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    @include('includes.filepond-js')
@endpush

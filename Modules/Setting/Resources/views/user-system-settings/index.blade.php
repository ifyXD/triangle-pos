@extends('layouts.app')

@section('title', 'Edit Settings')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">System Settings</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('utils.alerts')
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">General Settings</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('system-settings.update') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="user_id" value="{{ auth()->user()->id}}" required>
                                        <label for="company_name">Company Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_name" value="{{ $settings->company_name?? NULL }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company_email">Company Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_email" value="{{ $settings->company_email?? NULL }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company_phone">Company Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_phone" value="{{ $settings->company_phone?? NULL }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="default_currency_id">Default Currency <span class="text-danger">*</span></label>
                                        <select name="default_currency_id" id="default_currency_id" class="form-control" required>
                                            @foreach(\Modules\Currency\Entities\Currency::all() as $currency)
                                                <option {{ optional($settings)->default_currency_id == $currency->id ? 'selected' : '' }} value="{{ $currency->id ?? NULL }}">{{ $currency->currency_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                                 
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="default_currency_position">Default Currency Position <span class="text-danger">*</span></label>
                                        <select name="default_currency_position" id="default_currency_position" class="form-control" required>
                                            <option {{ optional($settings)->default_currency_position == 'prefix' ? 'selected' : '' }} value="prefix">Prefix</option>
                                            <option {{ optional($settings)->default_currency_position == 'suffix' ? 'selected' : '' }} value="suffix">Suffix</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="notification_email">Notification Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="notification_email" value="{{ optional($settings)->notification_email }}" required>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="form-row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="company_address">Company Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_address" value="{{ optional($settings)->company_address }}">
                                    </div>
                                </div>
                            </div>
                            

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </div>
@endsection


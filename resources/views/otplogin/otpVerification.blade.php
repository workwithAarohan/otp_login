@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Please Enter Login Code') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('otp.verify') }}">
                        @csrf

                        @if (Session::get('Fail'))
                            <div class="alert alert-danger">
                                {{ Session::get('Fail') }}
                            </div>

                        @endif

                        <div class="form-group row">
                            <label for="otp" class="col-md-4 col-form-label text-md-right">{{ __('Login Code') }}</label>

                            <div class="col-md-6">
                                <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" autocomplete="otp" autofocus>

                                @error('otp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

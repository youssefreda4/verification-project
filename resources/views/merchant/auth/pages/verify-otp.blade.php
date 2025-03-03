@extends('merchant.auth.layouts.master')

@section('title', 'Verfiy')

@section('content')


    <!-- Register -->
    <div class="card">
        <div class="card-body">

            <!-- Logo -->
            @include('merchant.auth.layouts.logo')
            <!-- /Logo -->

            <p class="mb-4">Please verify your otp</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form id="formAuthentication" class="mb-3" action="{{ route('merchants.verify.otp') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ Str::fromBase64(request()->email) }}">

                <div class="mb-3">
                    <label for="otp" class="form-label">OTP</label>
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter your OTP"
                        value="{{ old('otp') }}" autofocus />
                    <x-input-error :messages="$errors->get('otp')" class="mt-2" />

                </div>

                <div class="mb-3">
                    <button class="btn btn-primary d-grid w-100" type="submit">Verify</button>
                </div>
            </form>

            <form method="POST" action="{{ route('merchants.resend.otp') }}" class="text-center">
                @csrf
                <input type="hidden" name="email" value="{{ Str::fromBase64(request()->email) }}">

                <span>OTP not arrived?</span>
                <button type="submit" class="btn btn-link p-0 border-0 align-baseline">
                    <span>Resend</span>
                </button>
            </form>

        </div>
    </div>
    <!-- /Register -->
@endsection

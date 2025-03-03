@extends('merchant.auth.layouts.master')

@push('header')
    {{-- V2 --}}
    {{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}

    {{-- V3 --}}
    <script src="https://www.google.com/recaptcha/api.js"></script>
@endpush

@section('title', 'Register')

@section('content')
    <!-- Register Card -->
    <div class="card">
        <div class="card-body">

            <!-- Logo -->
            @include('merchant.auth.layouts.logo')
            <!-- /Logo -->

            <h4 class="mb-2">Adventure starts here 🚀</h4>
            <p class="mb-4">Make your app management easy and fun!</p>

            <form id="formAuthentication" class="mb-3" action="{{ route('merchants.register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="name" placeholder="Enter your name"
                        value="{{ old('name') }}" autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />

                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email"
                        value="{{ old('email') }}" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                </div>
                <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control" name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" />
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                </div>

                {{-- <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
                <br> --}}

                {{-- <button class="btn btn-primary d-grid w-100">Sign up</button> --}}

                {{-- V3 --}}
                <button class="g-recaptcha  btn btn-primary d-grid w-100" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"
                    data-callback='onSubmit' data-action='submit'>Submit</button>
            </form>

            <p class="text-center">
                <span>Already have an account?</span>
                <a href="{{ route('merchants.login') }}">
                    <span>Sign in instead</span>
                </a>
            </p>
        </div>
    </div>
    <!-- Register Card -->
@endsection

@push('js')
    <script>
        function onSubmit(token) {
            document.getElementById("formAuthentication").submit();
        }
    </script>
@endpush

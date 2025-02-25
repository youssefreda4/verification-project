@extends('merchant.auth.layouts.master')

@section('title', 'Verify Email')

@section('content')
    <!-- Session Status -->
    {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}

    <!-- Register -->
    <div class="card">
        <div class="card-body">

            <!-- Logo -->
            @include('merchant.auth.layouts.logo')
            <!-- /Logo -->

            <x-guest-layout>
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <div class="mt-4 flex items-center">
                    <form method="POST" action="{{ route('merchants.verification.send') }}">
                        @csrf

                        <div>
                            <button type="submit"
                                class=" btn btn-primary  hover:text-gray rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Resend Verification Email') }}
                            </button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('merchants.logout') }}">
                        @csrf

                        <button type="submit"
                            class="ml-3 btn btn-danger  hover:text-gray rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </x-guest-layout>


        </div>
    </div>
    <!-- /Register -->
@endsection

<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('merchant-assets') }}/" data-template="vertical-menu-template-free">

@include('merchant.auth.layouts.header')

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- / Content -->

    @include('merchant.auth.layouts.script')
</body>

</html>

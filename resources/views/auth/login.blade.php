@extends('adminlte::master')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

<body class="hold-transition login-page">
    <div class="login-box">
      
        <div class="card">
            <div class="card-header text-center">
                <div class="{{ $auth_type ?? 'login' }}-logo">
                    <a href="{{ 'home' }}">
        
                        {{-- Logo Image --}}
                        @if (config('adminlte.auth_logo.enabled', false))
                            <img src="{{ asset(config('adminlte.auth_logo.img.path')) }}"
                                 alt="{{ config('adminlte.auth_logo.img.alt') }}"
                                 @if (config('adminlte.auth_logo.img.class', null))
                                    class="{{ config('adminlte.auth_logo.img.class') }}"
                                 @endif
                                 @if (config('adminlte.auth_logo.img.width', null))
                                    width="{{ config('adminlte.auth_logo.img.width') }}"
                                 @endif
                                 @if (config('adminlte.auth_logo.img.height', null))
                                    height="{{ config('adminlte.auth_logo.img.height') }}"
                                 @endif>
                        @else
                            <img src="{{ asset(config('adminlte.logo_img')) }}"
                                 alt="{{ config('adminlte.logo_img_alt') }}" height="50">
                        @endif
        
                        {{-- Logo Label --}}
                        {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
        
                    </a>
                </div>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <div class="social-auth-links text-center mb-3">
                    {{-- <p>- OR -</p> --}}

                    <a href="{{ route('auth.google') }}" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div>
            </div>
            <!-- /.login-card-body -->
        </div>

    </div>
    <!-- /.login-box -->

    {{-- @vite(['resources/js/app.js']) --}}

</body>



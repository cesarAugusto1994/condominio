@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">

                    <div class="wrapper-page">

                        <div class="m-t-40 card-box">
                            <div class="text-center">
                                <h2 class="text-uppercase m-t-0 m-b-30">
                                    <a href="index.html" class="text-success">
                                        <span><img src="#" alt="" height="30"></span>
                                    </a>
                                </h2>
                                <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                            </div>
                            <div class="account-content">

                              @foreach ($errors->all() as $error)
                                  <div class="alert alert-danger">{{ $error }}</div>
                              @endforeach

                                <form action="{{ url(config('adminlte.login_url', 'login')) }}" class="form-horizontal" method="post">
                                    {!! csrf_field() !!}
                                    <div class="form-group m-b-20 {{ $errors->has('login') ? ' has-error' : '' }}">
                                        <div class="col-xs-12">
                                            <label for="emailaddress">{{ trans('adminlte::adminlte.email') }}</label>
                                            <input class="form-control" name="email" type="email" id="emailaddress" required="" placeholder="" autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group m-b-20 {{ $errors->has('password') ? ' has-error' : '' }}">
                                        <div class="col-xs-12">
                                            <a href="pages-forget-password.html" class="text-muted pull-right font-14">{{ trans('adminlte::adminlte.i_forgot_my_password') }}</a>
                                            <label for="password">{{ trans('adminlte::adminlte.password') }}</label>
                                            <input class="form-control" name="password" type="password" required="" id="password" placeholder="">
                                        </div>
                                    </div>

                                    <div class="form-group m-b-30">
                                        <div class="col-xs-12">
                                            <div class="checkbox checkbox-primary">
                                                <input id="checkbox5" type="checkbox">
                                                <label for="checkbox5">
                                                    {{ trans('adminlte::adminlte.remember_me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group account-btn text-center m-t-10">
                                        <div class="col-xs-12">
                                            <button class="btn btn-lg btn-primary btn-block" type="submit">{{ trans('adminlte::adminlte.sign_in') }}</button>
                                        </div>
                                    </div>

                                </form>

                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <!-- end card-box-->


                        <div class="row m-t-50">
                            <div class="col-sm-12 text-center">
                                <p class="text-muted"><a href="{{ url(config('adminlte.register_url', 'register')) }}" class="text-dark m-l-5">{{ trans('adminlte::adminlte.register_a_new_membership') }} </a></p>
                            </div>
                        </div>

                    </div>
                    <!-- end wrapper -->

                </div>
            </div>
        </div>
    </section>

@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    @yield('js')
@stop

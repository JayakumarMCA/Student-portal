@extends('auth.layouts.master')

@php
    $page_title = 'LOGIN';
    $page_name = 'LOGIN';
@endphp
@section('content')
<body class="auth-body-bg">
    <div class="accountbg"></div>
    <div class="wrapper-page">
        <div class="card">
            
            <div class="card-body">
                <h3 class="text-center mt-0 mb-3">
                    <a href="/" class="logo"><img src="{{ asset('assets/images/tech-data.png')}}" height="40" alt="logo-img"></a>
                </h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br />
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <h4 class="text-center mt-0 text-color"><b>Sign In</b></h4>
                <form class="form-horizontal mt-3 mx-3" action="{{ route('login') }}" method="POST" id="loginForm">
                    @csrf
                    <div class="form-group mb-3">
                        <div class="col-12">
                            <input class="form-control" type="text" required="" name="email" id="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="col-12">
                            <input class="form-control" type="password" required="" name="password" id="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" type="checkbox" checked="">
                                <label for="checkbox-signup" class="text-color">
                                    Remember me
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center mt-3 mb-3">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block btn-lg waves-effect waves-light w-100" type="submit">
                                Log In</button>
                        </div>
                    </div>
                    <!-- <div class="form-group row mt-4 mb-0">
                        <div class="col-sm-7">
                            <a href="auth-recoverpw.html" class="red-text-color">
                                <i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                        </div>
                        <div class="col-sm-5 text-right">
                            <a href="/register" class="blue-text-color">Create an account</a>
                        </div>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
    <script>
        $(document).ready(function(){
            $("#loginForm").validate({
                rules: {
                    name    : "required",
                    password: "required",
                },
                messages: {
                    name    : "Please enter the name.",
                    password: "Please enter the password.",
                }
            });
        });
    </script>
@endsection
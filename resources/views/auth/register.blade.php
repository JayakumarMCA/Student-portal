@extends('auth.layouts.master')

@php
    $page_title = 'Register';
    $page_name = 'Register';
@endphp
@section('content')
<body class="auth-body-bg loginbg">
    <div class="accountbg"></div>
    <div class="wrapper-page login-wrapper">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mt-0 mb-2">
                    <a href="index.html" class="logo"><img src="assets/images/tech-data.png" height="40" alt="logo-img" /></a>
                </h3>
                <!-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br />
                            @endforeach
                        </ul>
                    </div>
                @endif -->
                <h4 class="text-center mt-0 text-color"><b>Sign Up</b></h4>

                <form class="form-horizontal mt-3" action="{{route('register')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <div class="col-12">
                                    <input class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Username" required />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="col-12">
                                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required />
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="col-12">
                                    <input class="form-control" type="text" name="mobile" value="{{ old('mobile') }}" placeholder="Mobile" required />
                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="col-12">
                                    <input class="form-control" type="password" name="password" placeholder="Password" required />
                                    <small class="text-danger">
                                        Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).
                                    </small>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="col-12">
                                    <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password" required />
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <div class="col-12">
                                    <input class="form-control" type="text" name="organization" value="{{ old('organization') }}" placeholder="Organization" required />
                                    @error('organization')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="col-12">
                                    <input class="form-control" type="text" name="job_title" value="{{ old('job_title') }}" placeholder="Job Title" required />
                                    @error('job_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="col-12">
                                    <input class="form-control" type="text" name="city" value="{{ old('city') }}" placeholder="City" required />
                                    @error('city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="col-12">
                                    <select class="form-select" name="country" required style="border: #000 solid 1px;">
                                        <option selected disabled>Choose Country</option>
                                        <option value="India">India</option>
                                        <option value="Vietnam">Vietnam</option>
                                        <option value="Cantonese">Cantonese</option>
                                        <option value="Bahasa">Bahasa</option>
                                    </select>
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center mt-4">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block btn-lg waves-effect waves-light w-50" type="submit">Register</button>
                        </div>
                    </div>

                    <div class="form-group mt-3 mb-0">
                        <div class="col-sm-12 text-center">
                            <a href="/" class="">Already have account?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
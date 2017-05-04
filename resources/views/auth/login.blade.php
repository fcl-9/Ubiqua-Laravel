@extends('layouts.login')

@section('content')
    <div class="container-fluid">
        <div class="col-md-6 col-sm-3 hidden-xs" style="background-color: #00b3ee; height:100%; border-left-color: #8c8c8c">
            <div style="position:relative; height:100%">
                <img class="img-responsive" style="position: absolute; left: 0;right: 0;top:80px;margin-left: auto;margin-right: auto;width: 200px;" src="/img/Logo1.png">
            </div>
        </div>

        <div class="col-md-6 col-sm-9 col-xs-12">
            <div style="position:relative; height:100%; margin-top: calc(100% - 85%); width:90%; margin-left:auto; margin-right: auto;">
                <h1 style="text-align: center;     margin-bottom: 10%;"></span>Sing-In to Control Your Shelf</h1>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>

                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
@endsection

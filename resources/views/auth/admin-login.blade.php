@extends('layouts.app')
@section('content')

<div class="login-box">
  <div class="login-logo">
    <a href="../../"><b>CNCS</b>app</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
  <p class="login-box-msg">This is for Admin Login | Try Member <a href="{{ URL::route('home') }}">Login</a></p>

    <form class="form-horizontal" method="POST" action="{{ route('admin.login.submit') }}">
        <div class="box-body">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">E-Mail</label>

                <div class="col-md-8">
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

                <div class="col-md-8">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <!--<div class="form-group">
                <div class="col-md-6 col-md-offset-1">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                    </div>
                </div>
            </div>-->

            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>

                    <!--<a class="btn btn-link" href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>-->
                </div>
            </div>
        </div>    
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@endsection

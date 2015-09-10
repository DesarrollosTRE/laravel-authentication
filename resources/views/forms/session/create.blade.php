<form action="{{ $route or route('authentication::session.store') }}" method="post">

    {!! csrf_field() !!}

    {!! $errors->first('authentication::login_error', '<div class="alert alert-danger">:message</div>') !!}
    {!! $errors->first('authentication::login_warning', '<div class="alert alert-warning">:message</div>') !!}
    {!! $errors->first('authentication::password-reset.updated', '<div class="alert alert-success">:message</div>') !!}

    <div class="form-group">
        <label for="email">{{ trans('authentication::user.email') }}</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="password">{{ trans('authentication::user.password') }}</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    @if(config('authentication.login.rememberMe') != 'off')
        <div class="checkbox">
            <label>
                @if(config('authentication.login.rememberMe') == 'default')
                    <input type="checkbox" name="remember" checked>
                @else
                    <input type="checkbox" name="remember">
                @endif
                {{ trans('authentication::session.remember_me') }}
            </label>
        </div>
    @endif

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            {{ trans('authentication::session.create') }}
        </button>
        <a href="{{ route('authentication::password-reset.create') }}" class="btn btn-link">
            {{ trans('authentication::password-reset.forgot_your_password') }}
        </a>
    </div>

</form>
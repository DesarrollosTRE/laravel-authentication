<form action="{{ $route or route('authentication::password.update') }}" method="post">

    {!! method_field('patch') !!}

    {!! csrf_field() !!}

    <div class="form-group {{ $errors->has('current_password') ? 'has-error' : '' }}">
        <label for="current_password">{{ trans('authentication::password.current_password') }}</label>
        <input type="password" name="current_password" id="current_password" class="form-control" required>
        {!! $errors->first('current_password', '<div class="help-block">:message</div>') !!}
    </div>

    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
        <label for="new_password">{{ trans('authentication::password.new_password') }}</label>
        <input type="password" name="new_password" id="new_password" class="form-control" required>
        {!! $errors->first('new_password', '<div class="help-block">:message</div>') !!}
    </div>

    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
        <label for="new_password_confirmation">{{ trans('authentication::password.confirm_new_password') }}</label>
        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
        {!! $errors->first('new_password_confirmation', '<div class="help-block">:message</div>') !!}
    </div>

    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary">
            {{ trans('authentication::password.update') }}
        </button>
        <a href="{{ route('authentication::profile.show') }}" class="btn btn-link">
            {{ trans('authentication::core.cancel') }}
        </a>
    </div>

</form>
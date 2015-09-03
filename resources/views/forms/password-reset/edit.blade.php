<form action="{{ route('authentication::password-reset.update') }}" method="post">

    {!! method_field('patch') !!}

    {!! csrf_field() !!}

    <input type="hidden" name="token" value="{{ $token }}">

    {!! $errors->first('authentication::password-reset.expired', '<div class="alert alert-danger">:message</div>') !!}
    {!! $errors->first('authentication::password-reset.updated', '<div class="alert alert-success">:message</div>') !!}

    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="email">{{ trans('authentication::user.email') }}</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" >
        {!! $errors->first('email', '<div class="help-block">:message</div>') !!}
    </div>

    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
        <label for="password">{{ trans('authentication::user.password') }}</label>
        <input type="password" name="password" id="password" class="form-control" >
        {!! $errors->first('password', '<div class="help-block">:message</div>') !!}
    </div>

    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
        <label for="password_confirmation">{{ trans('authentication::user.password_confirmation') }}</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" >
        {!! $errors->first('password_confirmation', '<div class="help-block">:message</div>') !!}
    </div>

    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary">
            {{ trans('authentication::password-reset.edit') }}
        </button>
    </div>

</form>
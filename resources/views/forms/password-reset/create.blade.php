<form action="{{ $route or route('authentication::password-reset.store') }}" method="post">

    {{ csrf_field() }}

    {!! $errors->first('authentication::password-reset.created', '<div class="alert alert-success">:message</div>') !!}
    {!! $errors->first('authentication::password-reset.expired', '<div class="alert alert-warning">:message</div>') !!}

    <div class="form-group  {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="email">{{ trans('authentication::user.email') }}</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
        {!! $errors->first('email', '<div class="help-block">:message</div>') !!}
    </div>

    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary">
            {{ trans('authentication::password-reset.create') }}
        </button>
        <a href="{{ route('authentication::session.create') }}" class="btn btn-link">
            {{ trans('authentication::session.create') }}
        </a>
    </div>

</form>
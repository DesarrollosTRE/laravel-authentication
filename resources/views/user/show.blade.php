@extends(config('authentication.views.app'))

@section('title', trans('authentication::user.show'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-push-3">
                <h1 class="page-header">{{ trans('authentication::user.show') }}</h1>
                <div class="form-group">
                    <label>{{ trans('authentication::user.email') }}</label>
                    <p class="form-control-static">{{ $user->email }}</p>
                </div>
                <div class="form-group">
                    <label>{{ trans('authentication::user.name') }}</label>
                    <p class="form-control-static">{{ $user->name }}</p>
                </div>
                <div class="form-group">
                    <label>{{ trans('authentication::user.created_at') }}</label>
                    <p class="form-control-static">{{ $user->created_at }}</p>
                </div>
                <div class="form-group">
                    <label>{{ trans('authentication::user.banned_at') }}</label>
                    <p class="form-control-static">{{ $user->banned_at }}</p>
                </div>
                <div class="form-group">
                    <label>{{ trans('authentication::user.administrator') }}</label>
                    <p class="form-control-static">
                        <i class="glyphicon glyphicon-{{ $user->managesUsers() ? 'ok' : 'remove' }}"></i>
                    </p>
                </div>

                <hr>

                <ul class="list-inline">
                    <li>@include($user->isBanned() ? 'authentication::forms.user.unban' : 'authentication::forms.user.ban')</li>
                    <li><a href="{{ route('authentication::user.index') }}" class="btn btn-link">{{ trans('authentication::user.index') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
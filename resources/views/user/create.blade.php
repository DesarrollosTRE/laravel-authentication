@extends(config('authentication.views.app'))

@section('title', trans('authentication::user.create'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-push-3">
                <h1 class="page-header">@lang('authentication::user.create')</h1>
                @include('authentication::forms.user.create')
            </div>
        </div>
    </div>
@endsection
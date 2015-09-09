@extends(config('authentication.views.app'))

@section('title', trans('authentication::profile.edit'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-push-3">
                <h1 class="page-header">{{ trans('authentication::profile.edit') }}</h1>
                @include('authentication::forms.profile.edit')
            </div>
        </div>
    </div>
@endsection
@extends(config('authentication.parentView'))

@section('title', trans('authentication::password-reset.create'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-push-3">
                <h1 class="page-header">@lang('authentication::password-reset.create')</h1>
                @include('authentication::forms.password-reset.create')
            </div>
        </div>
    </div>
@endsection
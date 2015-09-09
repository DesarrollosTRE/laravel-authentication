@extends(config('authentication.views.app'))

@section('title', trans('authentication::user.index'))

@section('content')
    <div class="container">
        <h1 class="page-header">{{ trans('authentication::user.index') }}</h1>
        <table class="table">
            <thead>
            <tr>
                <td>{{ trans('authentication::user.email') }}</td>
                <td>{{ trans('authentication::user.name') }}</td>
                <td>{{ trans('authentication::user.created_at') }}</td>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $users->render() !!}
    </div>
@endsection
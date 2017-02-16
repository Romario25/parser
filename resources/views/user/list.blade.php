@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <a class="btn btn-success" href="/">Список прокси</a>
                <a class="btn btn-danger" href="/user/add">Добавить пользователя</a>
                <br><br><br>

                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Role</td>
                                <td>Action</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('edit-user', ['id' => $user->id]) }}">Обновить</a>
                                        <form action="{{ route('edit-user', ['id' => $user->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button class="btn btn-danger">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {!! $users->render() !!}
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection

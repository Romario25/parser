@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @can('user')
                <a class="btn btn-success" href="/user">Список юзеров</a>
                <a class="btn btn-primary" href="{{ route('proxy-add') }}">Добавить прокси</a>
            @endcan

            <br><br><br>

            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                @if(session('status'))
                    <div class="alert alert-success">
                        {{session('status')}}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>IP</td>
                                <td>Location</td>
                                <td>Port</td>
                                <td>Speed</td>
                                <td>Sites</td>
                                @can('user')
                                    <td>Action</td>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proxies as $proxy)
                                <tr>
                                    <td>{{ $proxy->ip }}</td>
                                    <td>{{ $proxy->location }}</td>
                                    <td>{{ $proxy->port }}</td>
                                    <td>{{ $proxy->speed }}</td>
                                    <td>@if(!empty($proxy->sites)) {{ implode(', ', unserialize($proxy->sites)) }} @endif</td>
                                    @can('user')
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('proxy-update', ['id' => $proxy->id]) }}">Обновить</a>
                                        <form action="{{ route('proxy-update', ['id' => $proxy->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button class="btn btn-danger">Удалить</button>
                                        </form>
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {!! $proxies->render() !!}
                </div>


            </div>
        </div>
    </div>
</div>
@endsection

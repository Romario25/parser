@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Proxy IP : {{ $proxy->ip }}</div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('proxy-update', ['id' => $proxy->id]) }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('ip') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">IP</label>

                                <div class="col-md-6">
                                    <input id="ip" type="text" class="form-control" name="ip" value="@if(empty(old('ip'))) {{$proxy->ip}} @else {{ old('ip') }} @endif" required autofocus>

                                    @if ($errors->has('ip'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('ip') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Location</label>

                                <div class="col-md-6">
                                    <input id="location" type="text" class="form-control" name="location" value="@if(empty(old('location'))) {{$proxy->location}} @else {{ old('location') }} @endif" required autofocus>

                                    @if ($errors->has('location'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('speed') ? ' has-error' : '' }}">
                                <label for="speed" class="col-md-4 control-label">SPEED</label>

                                <div class="col-md-6">
                                    <input id="speed" type="text" class="form-control" name="speed" value="@if(empty(old('speed'))) {{$proxy->speed}} @else {{ old('speed') }} @endif" required autofocus>

                                    @if ($errors->has('speed'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('speed') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('port') ? ' has-error' : '' }}">
                                <label for="speed" class="col-md-4 control-label">PORT</label>

                                <div class="col-md-6">
                                    <input id="port" type="text" class="form-control" name="port" value="@if(empty(old('port'))) {{$proxy->port}} @else {{ old('port') }} @endif" required autofocus>

                                    @if ($errors->has('port'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('port') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Type</label>

                                <div class="col-md-6">
                                    <input id="type" type="text" class="form-control" name="type" value="@if(empty(old('type'))) {{$proxy->type}} @else {{ old('type') }} @endif" required autofocus>

                                    @if ($errors->has('type'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">STATUS</label>

                                <div class="col-md-6">
                                    <select name="status" class="form-control" id="role">
                                        <option @if($proxy->status == 0) selected="selected" @endif value="0">Не работает</option>
                                        <option @if($proxy->status == 1) selected="selected" @endif value="1">Работает</option>
                                    </select>

                                    @if ($errors->has('status'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('on') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Включить</label>

                                <div class="col-md-6">
                                    <input class="form-control" name="on" value="1" type="checkbox" @if($proxy->on == 1) checked="checked" @endif />
                                    @if ($errors->has('on'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('on') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        UPDATE
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

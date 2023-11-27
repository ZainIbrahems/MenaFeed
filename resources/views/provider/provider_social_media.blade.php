@extends('voyager::master')
@php
    $provider = \App\Models\Provider::where('user_id',auth('web')->user()->id)->first();
@endphp
@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <!-- CSRF TOKEN -->
                    {{ csrf_field() }}

                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="control-label" style="margin: 10px 20px;">Social Media Accounts Details </h4>
                                <form method="POST" action="{{route('contact-save')}}">
                                    <div class="modal-body">
                                        @csrf
                                        <input name="provider_id" type="hidden"
                                               value="{{$provider->id}}">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Instagram Account</label>
                                                <input type="text" value="{{$provider->instagram}}" class="form-control"
                                                       name="instagram">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Facebook Account</label>
                                                <input type="text" value="{{$provider->facebook }}" class="form-control"
                                                       name="facebook">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Pinterest Account</label>
                                                <input type="text" value="{{$provider->pinterest }}" class="form-control"
                                                       name="pinterest">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Youtube Account</label>
                                                <input type="text" value="{{$provider->youtube}}" class="form-control"
                                                       name="youtube">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Tiktok Account</label>
                                                <input type="text" value="{{$provider->tiktok}}" class="form-control"
                                                       name="tiktok">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        {{--                                <button type="button" class="btn btn-default"--}}
                                        {{--                                        data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>--}}
                                        <button type="submit" class="btn btn-success">Confirm
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop

@section('javascript')


@stop

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
                                <h4 class="control-label" style="margin: 10px 20px;">Contact Details</h4>
                                <form method="POST" action="{{route('contact-save')}}">
                                    <div class="modal-body">
                                        @csrf
                                        <input name="provider_id" type="hidden"
                                               value="{{$provider->id}}">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Website</label>
                                                <input type="text" value="{{$provider->website}}" class="form-control"
                                                       name="website">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Public Email</label>
                                                <input type="text" value="{{$provider->public_email}}" class="form-control"
                                                       name="public_email">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Telephone Or Mobile No. </label>
                                                <input type="text" value="{{$provider->telephone}}" class="form-control"
                                                       name="telephone">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">WhatsApp No. with County Code</label>
                                                <input type="text" value="{{$provider->whatsapp}}" class="form-control"
                                                       name="whatsapp">
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

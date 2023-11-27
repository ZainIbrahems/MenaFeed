@extends('voyager::master')
@php
    $provider = \App\Models\Provider::where('user_id',auth('web')->user()->id)->first();
@endphp
@php
    $dataType = Voyager::model('DataType')->where('slug', '=', 'providers')->first();
    $dataTypeRows = $dataType->{('editRows')};
    $display_options = $row->details->display ?? NULL;
    $dataTypeContent = $provider;
@endphp
@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                @include('voyager::multilingual.language-selector',['isModelTranslatable'=>true])
            </div>
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
                                <h4 class="control-label" style="margin: 10px 20px;">Edit your Account Details</h4>
                                <form method="POST" action="{{route('save-account-details')}}" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        @csrf
                                        <input name="provider_id" type="hidden"
                                               value="{{$provider->id}}">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Abbreviation</label>
                                                <select class="form-control select2" name="abbreviation_id">
                                                    @foreach(\App\Models\Abbreviation::get() as $abb)
                                                        <option
                                                            value="{{$abb->id}}" {{$abb->id==$provider->abbreviation_id?'selected':''}}>{{$abb->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <label class="control-label">Enter your full legal name OR
                                                    Enter Your Legal Facility Name
                                                </label>
                                                @php($field = 'full_name')
                                                <span class="language-label js-language-label"></span>
                                                <input type="hidden"
                                                       data-i18n="true"
                                                       name="{{ $field }}_i18n"
                                                       id="{{ $field }}_i18n"
                                                       value="{{ get_field_translations($dataTypeContent, $field) }}">

                                                <input type="full_name" value="{{$provider->full_name }}"
                                                       class="form-control"
                                                       name="full_name">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label class="control-label">
                                                    Upload Your Image / If company Upload LOGO
                                                    <img src="{{Voyager::image($provider->personal_picture)}}" style="width: 40px;">
                                                </label>
                                                <input type="file"
                                                       class="form-control"
                                                       name="personal_picture">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="control-label">Your formal Email</label>
                                                <input type="email" value="{{$provider->email}}" class="form-control"
                                                       name="email">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="control-label">Recovery Email</label>
                                                <input type="email" value="{{$provider->recovery_email}}" class="form-control"
                                                       name="recovery_email">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label class="control-label">Your Mobile No. ( Country Code ) Mobile No.</label>
                                                <input type="text" value="{{$provider->phone}}" class="form-control"
                                                       name="phone">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label class="control-label">Profile summary</label>
                                                @php($field = 'summary')
                                                <span class="language-label js-language-label"></span>
                                                <input type="hidden"
                                                       data-i18n="true"
                                                       name="{{ $field }}_i18n"
                                                       id="{{ $field }}_i18n"
                                                       value="{{ get_field_translations($dataTypeContent, $field) }}">
                                                <textarea class="form-control"
                                                       name="summary">{{$provider->summary}}</textarea>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Enter User Name</label>
                                                <input type="text" value="{{$provider->user_name}}" class="form-control"
                                                       name="user_name">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Password</label>
                                                <input type="password" class="form-control"
                                                       name="password">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Re-Type Password</label>
                                                <input type="password"  class="form-control"
                                                       name="confirm_password">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        {{--                                <button type="button" class="btn btn-default"--}}
                                        {{--                                        data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>--}}
                                        <button onclick="updateLang()" type="submit" class="btn btn-success">Confirm
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

    <script>
        function updateLang(){
            var btn = $('.btn-lang.active');
            $('.btn-lang').trigger('click');
            btn.trigger('click');
        }
        $('.side-body').multilingual({"editing": true});
    </script>

@stop

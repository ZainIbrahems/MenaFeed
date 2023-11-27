@extends('voyager::master')
@php
    $provider = \App\Models\Provider::where('user_id',auth('web')->user()->id)->first();
@endphp

@push('css')
    <style>
        .hidden {
            display: none;
        }
    </style>
@endpush

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
                                <h4 class="control-label" style="margin: 10px 20px;">Account verification
                                    information</h4>
                                <form method="POST" action="{{route('save-account-verification')}}"
                                      enctype="multipart/form-data">
                                    <div class="modal-body">
                                        @csrf
                                        <input name="provider_id" type="hidden"
                                               value="{{$provider->id}}">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Provider Type</label>
                                                <select class="form-control select2" name="provider_type_id"
                                                        id="provider_type_id">
                                                    @foreach(\App\Models\ProviderType::get() as $abb)
                                                        <option
                                                            value="{{$abb->id}}" {{$abb->id==$provider->provider_type_id?'selected':''}}>{{$abb->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <label class="control-label">Registration No. (Professional license
                                                    number Or License No.
                                                </label>
                                                <input type="text" value="{{$provider->registration_number }}"
                                                       class="form-control"
                                                       name="registration_number">
                                            </div>
                                            <div
                                                id="qualification_certificate"
                                                class="col-md-12 form-group {{$provider->provider_type_id==2?'hidden':''}}">
                                                <label class="control-label">
                                                    Upload Your Qualification Certificate
                                                    @if($provider->qualification_certificate)<a
                                                        href="{{getFileURL($provider->qualification_certificate)}}"><b
                                                            style="color:red">Download</b></a>
                                                    @endif
                                                </label>
                                                <input type="file"
                                                       class="form-control"
                                                       name="qualification_certificate">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label class="control-label">Upload Your Professional License Or License
                                                    @if($provider->professional_license)
                                                        <a href="{{getFileURL($provider->professional_license)}}"><b
                                                                style="color:red">Download</b></a>
                                                    @endif
                                                </label>
                                                <input type="file" class="form-control"
                                                       name="professional_license">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="control-label">Select Platform</label>
                                                <select class="form-control select2" name="platform_id">
                                                    @foreach(\App\Models\Platform::get() as $abb)
                                                        <option
                                                            value="{{$abb->id}}" {{$abb->id==$provider->platform_id?'selected':''}}>{{$abb->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="control-label">
                                                    Select Platform Category
                                                </label>
                                                <select class="form-control select2" name="platform_category">
                                                    @php
                                                        $pc = \App\Models\PlatformCategory::where('platform_id',$provider->platform_id)->get();
                                                    @endphp
                                                    @foreach($pc as $p)
                                                        <option
                                                            value="{{$p->id}}" {{$p->id==$provider->platform_category?'selected':''}}>{{$p->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label class="control-label">
                                                    Select Speciality group
                                                </label>
                                                <select class="form-control select2" name="speciality_group[]" multiple>
                                                    @php
                                                        $pc = \App\Models\ProviderSpecialityGroup::where('provider_id',$provider->id)->pluck('platform_sub_category_id');
                                                        $pc = \App\Models\PlatformSubCategory::whereIn('id',$pc)->get();
                                                    @endphp
                                                    @foreach($pc as $p)
                                                        <option value="{{$p->id}}" selected>{{$p->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label class="control-label">
                                                    Select Specialities
                                                </label>
                                                <select class="form-control select2" name="specialities[]" multiple>
                                                    @php
                                                        $pc = \App\Models\ProviderSpeciality::where('provider_id',$provider->id)->pluck('platform_sub_sub_category_id');
                                                        $pc = \App\Models\PlatformSubSubCategory::whereIn('id',$pc)->get();
                                                    @endphp
                                                    @foreach($pc as $p)
                                                        <option value="{{$p->id}}" selected>{{$p->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label class="control-label">
                                                    Location
                                                </label>
                                                <input type="text"
                                                       value="{{$provider->address}}"
                                                       class="form-control"
                                                       name="address2">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                @php
                                                    $dataType = Voyager::model('DataType')->where('slug', '=', 'providers')->first();
                                                    $dataTypeRows = $dataType->{('editRows')};
                                                    $display_options = $row->details->display ?? NULL;
                                                    $dataTypeContent = $provider;
                                                @endphp
                                                @foreach($dataTypeRows as $row)
                                                    @if($row->field=='location')
                                                        @include('voyager::formfields.coordinates')
                                                    @endif
                                                @endforeach
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
    <script>
        $('#provider_type_id').change(() => {
            if (parseInt($('#provider_type_id').val()) == 1) {
                $('#qualification_certificate').removeClass('hidden');
            } else {
                $('#qualification_certificate').addClass('hidden');
            }
        });
    </script>

    <script>

        function updateSpecialityGroup() {
            var platform_category = $('select[name="platform_category"]').val();
            $.getJSON("{{route('update-speciality-group')}}/" + platform_category, function (data) {
                $('select[name="speciality_group[]"]').empty();
                var $element = $('select[name="speciality_group[]"]').select2();
                for (var d = 0; d < data.length; d++) {
                    var item = data[d];

                    // Create the DOM option that is pre-selected by default

                    var option = new Option(item.text, item.id, false, (parseInt(platform_category) == item.id) ? true : false);


                    // Append it to the select
                    $element.append(option);
                }

                // Update the selected options that are displayed
                $element.trigger('change');
            });
        }

        $('select[name="platform_category"]').change(() => {
            updateSpecialityGroup();
        });

        function updateSpecialities() {
            var speciality_group = $('select[name="speciality_group[]"]').val();
            $.getJSON("{{route('update-specialities')}}/" + speciality_group, function (data) {
                $('select[name="specialities[]"]').empty();
                var $element = $('select[name="specialities[]"]').select2();
                for (var d = 0; d < data.length; d++) {
                    var item = data[d];

                    // Create the DOM option that is pre-selected by default

                    var option = new Option(item.text, item.id, false, (parseInt(speciality_group) == item.id) ? true : false);


                    // Append it to the select
                    $element.append(option);

                }

                // Update the selected options that are displayed
                $element.trigger('change');
            });
        }

        $('select[name="speciality_group[]"]').change(() => {
            updateSpecialities();
        });

        function updatePlatform() {
            var platform_id = $('select[name="platform_id"]').val();
            $.getJSON("{{route('update-platform')}}/" + platform_id, function (data) {
                $('select[name="platform_category"]').empty();
                console.log(data);
                var $element = $('select[name="platform_category"]').select2();
                for (var d = 0; d < data.length; d++) {
                    var item = data[d];

                    // Create the DOM option that is pre-selected by default

                    var option = new Option(item.text, item.id, false, (parseInt(platform_id) == item.id) ? true : false);


                    // Append it to the select
                    $element.append(option);
                }

                // Update the selected options that are displayed
                $element.trigger('change');
            });
        }

        $('select[name="platform_id"]').change(() => {
            updatePlatform();
        });
        // updatePlatform();
    </script>
@stop

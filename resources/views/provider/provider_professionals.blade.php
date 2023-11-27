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
                                <h4 class="control-label" style="margin: 10px 20px;">Add Your Professionals</h4>
                                <h5 style="margin: 10px 20px;color:orange;">If Professional subscribe with Mena
                                    Platform Choice from below list : </h5>
                                <form method="POST" action="{{route('add-professional')}}"
                                      enctype="multipart/form-data">
                                    <div class="modal-body">
                                        @csrf
                                        <input type="hidden" name="type" value="old">
                                        <input name="provider_id" type="hidden"
                                               value="{{$provider->id}}">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Select Platform</label>
                                                <select class="form-control select2" name="platform_id">
                                                    @foreach(\App\Models\Platform::get() as $abb)
                                                        <option
                                                            value="{{$abb->id}}" {{$abb->id==$provider->platform_id?'selected':''}}>{{$abb->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">
                                                    Select Platform Category
                                                </label>
                                                <select class="form-control select2" name="platform_category">

                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">
                                                    Select Speciality group
                                                </label>
                                                <select class="form-control select2" name="speciality_group">

                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label class="control-label">
                                                    Select Specialities
                                                </label>
                                                <select class="form-control select2" name="specialities[]" multiple>

                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label class="control-label">
                                                    Select Professionals
                                                </label>
                                                <select class="form-control select2" name="professionals[]" multiple>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Confirm
                                        </button>
                                    </div>
                                </form>
                                <hr/>
                                <h5 style="margin: 10px 20px;color:orange;">If Professional Not subscribe with
                                    Mena Platform Add Manually : </h5>
                                <form method="POST" action="{{route('add-professional')}}"
                                      enctype="multipart/form-data">
                                    <div class="modal-body">
                                        @csrf
                                        <input type="hidden" name="type" value="new">
                                        <input name="provider_id" type="hidden"
                                               value="{{$provider->id}}">
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label class="control-label">Professional Full Legal Name</label>
                                                <input type="text" class="form-control" name="full_name"
                                                       required>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Select Platform</label>
                                                <select class="form-control select2" name="platform_id">
                                                    @foreach(\App\Models\Platform::get() as $abb)
                                                        <option
                                                            value="{{$abb->id}}" {{$abb->id==$provider->platform_id?'selected':''}}>{{$abb->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">
                                                    Select Platform Category
                                                </label>
                                                <select class="form-control select2" name="platform_category">

                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">
                                                    Select Speciality group
                                                </label>
                                                <select class="form-control select2" name="speciality_group">

                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label class="control-label">
                                                    Select Specialities
                                                </label>
                                                <select class="form-control select2" name="specialities[]"
                                                        required multiple>

                                                </select>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label class="control-label">Professional Registration license number </label>
                                                <input type="file" class="form-control"
                                                       required
                                                       name="qualification_certificate">
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label class="control-label">Upload Professional License</label>
                                                <input type="file" class="form-control"
                                                       required
                                                       name="professional_license">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="control-label">Professional Formal Email</label>
                                                <input type="email" class="form-control" name="email"
                                                       required>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="control-label">Professional Mobile No.</label>
                                                <input type="text" class="form-control" name="phone"
                                                       required>
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
                $('select[name="speciality_group"]').empty();
                var $element = $('select[name="speciality_group"]').select2();
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


        function updateProfessionals() {
            var specialities = $('select[name="specialities[]"]').val();
            $.getJSON("{{route('update-professionals')}}/" + JSON.stringify(specialities), function (data) {
                $('select[name="professionals[]"]').empty();
                var $element = $('select[name="professionals[]"]').select2();
                for (var d = 0; d < data.length; d++) {
                    var item = data[d];

                    // Create the DOM option that is pre-selected by default

                    var option = new Option(item.text, item.id, false, false);


                    // Append it to the select
                    $element.append(option);

                }

                // Update the selected options that are displayed
                // $element.trigger('change');
            });
        }

        $('select[name="specialities[]"]').change(() => {
            updateProfessionals();
        });

        function updateSpecialities() {
            var speciality_group = $('select[name="speciality_group"]').val();
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

        $('select[name="speciality_group"]').change(() => {
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
    </script>
@stop

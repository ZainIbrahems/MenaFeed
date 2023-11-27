@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp
@php
    $provider = \App\Models\Provider::where('user_id',auth('web')->user()->id)->first();
@endphp
@extends('voyager::master')
@php
    $dataType = Voyager::model('DataType')->where('slug', '=', 'providers')->first();
    $dataTypeRows = $dataType->{('editRows')};
    $display_options = $row->details->display ?? NULL;
@endphp
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@php
    $times = \App\Models\AppointmentSlotTimes::where('slot_id',$dataTypeContent->getKey())->get();
    $days = \App\Models\AppointmentSlotDays::where('slot_id',$dataTypeContent->getKey())->pluck('day');
    $days = json_decode($days);
@endphp
@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

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

                                @php($field = 'about')

                                <h4 class="control-label" style="margin: 10px 20px;"> Create My Availability Date and
                                    Time <span
                                        style="color:gray;"
                                        class="language-label js-language-label"></span></h4>


                                <form method="POST" style="margin-top: 30px;"
                                      action="{{route('update-appointment-data-time')}}">
                                    @csrf
                                    <input name="provider_id" type="hidden" value="{{$provider->id}}">
                                    <input name="slot_id" type="hidden" value="{{$dataTypeContent->getKey()}}">
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Select appointement Type</label>
                                        <select class="form-control select2" name="appointment_type">
                                            @foreach(\App\Models\AppointmentType::get() as $at)
                                                <option
                                                    value="{{$at->id}}" {{$dataTypeContent->{'appointment_type'}==$at->id?'selected':''}}>{{$at->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label class="control-label">Select Days</label><br/>

                                        <div class="row">
                                            <div class="col-sm-1"><input name="days[]" {{in_array(0,$days)?'checked':''}} type="checkbox" value="0"> <b>Sat</b></div>
                                            <div class="col-sm-1"><input name="days[]" {{in_array(1,$days)?'checked':''}} type="checkbox" value="1"> <b>Sun</b></div>
                                            <div class="col-sm-1"><input name="days[]" {{in_array(2,$days)?'checked':''}} type="checkbox" value="2"> <b>Mon</b></div>
                                            <div class="col-sm-1"><input name="days[]" {{in_array(3,$days)?'checked':''}} type="checkbox" value="3"> <b>Tue</b></div>
                                            <div class="col-sm-1"><input name="days[]" {{in_array(4,$days)?'checked':''}} type="checkbox" value="4"> <b>Wed</b></div>
                                            <div class="col-sm-1"><input name="days[]" {{in_array(5,$days)?'checked':''}} type="checkbox" value="5"> <b>Thu</b></div>
                                            <div class="col-sm-1"><input name="days[]" {{in_array(6,$days)?'checked':''}} type="checkbox" value="6"> <b>Fri</b></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group">

                                        <label class="control-label">Select Time
                                            <button type="button" onclick="addTime()" class="btn btn-success">Add
                                            </button>
                                        </label>
                                        <div id="times">
                                            @foreach($times as $key=>$t)
                                                <div class="row" id="time-{{$key}}">
                                                    <div class="col-md-5">
                                                        <label>From</label>
                                                        <input class="form-control" type="time"
                                                               value="{{$t->from_time}}"
                                                               name="time_from[]">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label>To</label>
                                                        <input class="form-control" type="time"
                                                               value="{{$t->to_time}}"
                                                               name="time_to[]">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <br/>
                                                        <button type="button" onclick="removeTime(1)"
                                                                class="btn btn-danger">Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">
                                            Select facility
                                        </label>
                                        <select class="form-control select2" name="facility_id">
                                            <?php
                                            $facilities = \App\Models\ProvidersProfessional::where('professional_id',
                                                $provider->id)->pluck('provider_id');
                                            $facilities = \App\Models\Provider::whereIn('id', $facilities)->get();
                                            ?>
                                            <option value="-1">Select Facility</option>
                                            @foreach($facilities as $d)
                                                <option
                                                    value="{{$d->id}}" {{$dataTypeContent->{'facility_id'}==$d->id?'selected':'' }}>{{$d->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">
                                            Select Professional
                                        </label>
                                        <select class="form-control select2" name="professional_id">
                                            <?php
                                            $professionals = \App\Models\ProvidersProfessional::where('provider_id',
                                                $provider->id)->pluck('professional_id');
                                            $professionals = \App\Models\Provider::whereIn('id', $professionals)->get();
                                            ?>
                                            <option value="-1">Select Professional</option>
                                            @foreach($professionals as $d)
                                                <option
                                                    value="{{$d->id}}" {{$dataTypeContent->{'professional_id'}==$d->id?'selected':'' }}>{{$d->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Fees
                                        </label>
                                        <input class="form-control select2" type="number" name="fees"
                                               value="{{ $dataTypeContent->{'fees'} }}" min="0">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">Currancies
                                        </label>

                                        <select class="form-control select2" name="currency">
                                            @foreach(\App\Models\Currency::get() as $c)
                                                <option
                                                    value="{{$c->id}}" {{$dataTypeContent->{'currency'}==$d->id?'selected':'' }}>{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <div class="form-group" style="margin: 0 20px;">
                                            <button type="submit"
                                                    onclick="updateLang()"
                                                    class="btn btn-primary save">Update
                                            </button>
                                        </div>
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
        function CountCharacters() {
            var body = tinymce.get('richtextabout').getBody();
            var content = tinymce.trim(body.innerText || body.textContent);
            return content.length;
        };

        $(document).ready(function () {
            var additionalConfig = {
                selector: '#richtextabout',
            }

            $.extend(additionalConfig, {
                'min_height': 200,
                setup: function (ed) {
                    ed.on('KeyDown', function (e) {
                        var max = 165;
                        var count = CountCharacters();
                        if (count >= max) {
                            if (e.keyCode != 8 && e.keyCode != 46)
                                tinymce.dom.Event.cancel(e);
                            document.getElementById("character_count").innerHTML = "Maximun allowed character is: 165";

                        } else {
                            document.getElementById("character_count").innerHTML = count + ' Charcters';
                        }
                    });

                }
            });
            tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfig));
        });
    </script>
    <script>
        function updateLang() {
            var btn = $('.btn-lang.active');
            $('.btn-lang').trigger('click');
            btn.trigger('click');
        }

        $('.side-body').multilingual({"editing": true});
    </script>
    <script>
        var i = {{sizeof($times)}};

        function addTime() {
            i++;
            $('#times').append('<div class="row" id="time-' + i + '">' +
                '    <div class="col-md-5">' +
                '    <label>From</label>' +
                ' <input class="form-control" type="time"' +
                '      name="time_from[]">' +
                ' </div>' +
                ' <div class="col-md-5">' +
                '    <label>To</label>' +
                '    <input class="form-control" type="time"' +
                '           name="time_to[]">' +
                ' </div>' +
                '<div class="col-md-2">' +
                '   <br/>' +
                '   <button onclick="removeTime(' + i + ')" class="btn btn-danger">Delete</button>' +
                '  </div>' +
                '</div>');
        }

        function removeTime(id) {
            $('#time-' + id).remove();
        }
    </script>
@stop

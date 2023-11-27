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
@push('css')
    <style>
        .col-xs-6{
            text-align: center;
            margin: 0 !important;
            padding: 0 5px !important;
        }
    </style>
@endpush
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


                                <h4 class="control-label" style="margin: 10px 20px;">Clients Appointment lists
                                    <span
                                        style="color:gray;"
                                        class="language-label js-language-label"></span></h4>

                                <table class="table table-hover">
                                    <tr>
                                        <th>Client full Name</th>
                                        <th>Mobile Number</th>
                                        <th>Facility</th>
                                        <th>Professional</th>
                                        <th>Date and Time</th>
                                        <th>Appointment Type</th>
                                        <th>Payment Status</th>
                                        <th>States</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td style="width: 250px;">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-primary">Occurred</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-danger">Rescheduled</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-warning">Cancelled</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-success">Deleted</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td style="width: 250px;">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-primary">Occurred</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-danger">Rescheduled</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-warning">Cancelled</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-success">Deleted</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td style="width: 250px;">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-primary">Occurred</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-danger">Rescheduled</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-warning">Cancelled</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-success">Deleted</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td style="width: 250px;">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-primary">Occurred</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-danger">Rescheduled</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-warning">Cancelled</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-success">Deleted</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td>----</td>
                                        <td style="width: 250px;">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-primary">Occurred</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-danger">Rescheduled</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-warning">Cancelled</button>
                                                </div>
                                                <div class="col-xs-6">
                                                    <button class="btn btn-sm btn-block btn-success">Deleted</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>

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
@stop

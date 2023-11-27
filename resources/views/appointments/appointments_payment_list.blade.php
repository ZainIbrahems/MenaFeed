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


                                <h4 class="control-label" style="margin: 10px 20px;">Manage Appointement payment list
                                    <span
                                        style="color:gray;"
                                        class="language-label js-language-label"></span></h4>

                                <table class="table table-hover">
                                    <tr>
                                        <th>Provider name</th>
                                        <th>Professional Name</th>
                                        <th>Client name</th>
                                        <th>Date and Time</th>
                                        <th>Payment Method</th>
                                        <th>Amount (currency)</th>
                                        <th>Payment Status</th>
                                        <th>Payment portal</th>
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
                                        <td>
                                            <button class="btn btn-sm btn-primary btn-block">Transfer to provide
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-block">Not Yet Deposit</button>
                                            <button class="btn btn-sm btn-warning btn-block">Canceled from origin
                                            </button>
                                            <button class="btn btn-sm btn-success btn-block">Transfer to Client</button>
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
                                        <td>
                                            <button class="btn btn-sm btn-primary btn-block">Transfer to provide
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-block">Not Yet Deposit</button>
                                            <button class="btn btn-sm btn-warning btn-block">Canceled from origin
                                            </button>
                                            <button class="btn btn-sm btn-success btn-block">Transfer to Client</button>
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
                                        <td>
                                            <button class="btn btn-sm btn-primary btn-block">Transfer to provide
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-block">Not Yet Deposit</button>
                                            <button class="btn btn-sm btn-warning btn-block">Canceled from origin
                                            </button>
                                            <button class="btn btn-sm btn-success btn-block">Transfer to Client</button>
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
                                        <td>
                                            <button class="btn btn-sm btn-primary btn-block">Transfer to provide
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-block">Not Yet Deposit</button>
                                            <button class="btn btn-sm btn-warning btn-block">Canceled from origin
                                            </button>
                                            <button class="btn btn-sm btn-success btn-block">Transfer to Client</button>
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
                                        <td>
                                            <button class="btn btn-sm btn-primary btn-block">Transfer to provide
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-block">Not Yet Deposit</button>
                                            <button class="btn btn-sm btn-warning btn-block">Canceled from origin
                                            </button>
                                            <button class="btn btn-sm btn-success btn-block">Transfer to Client</button>
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

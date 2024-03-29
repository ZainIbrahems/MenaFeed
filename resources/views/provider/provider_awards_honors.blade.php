@extends('voyager::master')
@php
    $provider = \App\Models\Provider::where('user_id',auth('web')->user()->id)->first();
@endphp
@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12" style="margin-top: 20px;">
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

                                <h4 class="control-label" style="margin: 10px 20px;">Awards and Honors <a
                                        class="btn btn-primary btn-sm"
                                        data-toggle="modal" data-target="#add_award">Add</a></h4>

                                <div class="modal fade modal-primary" id="add_award">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{route('award-save')}}">
                                                <div class="modal-body">
                                                    @csrf
                                                    <input name="provider_id" type="hidden"
                                                           value="{{$provider->id}}">
                                                    <div class="form-group">
                                                        <label class="control-label">Award or Honor Title </label>
                                                        <input type="text" value=""
                                                               class="form-control" name="title">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Congress or Authority Name</label>
                                                        <input type="text" value=""
                                                               class="form-control" name="authority_name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Order</label>
                                                        <input type="number" value="0" class="form-control" name="sort">
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                                                    <button type="submit" class="btn btn-success">Confirm
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $awards = \App\Models\ProviderAward::where('provider_id',$provider->id)->
                                    orderBy('sort')->get();
                                @endphp
                                @if(sizeof($awards)>0)
                                    <table class="table table-hover">
                                        <tr>
                                            <th>#ID</th>
                                            <th>Award or Honor Title</th>
                                            <th>Congress or Authority Name</th>
                                            <th>Order</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach($awards as $pe)
                                            <tr>
                                                <td>{{$pe->id}}</td>
                                                <td>{{$pe->title}}</td>
                                                <td>{{$pe->authority_name}}</td>
                                                <td>{{$pe->sort}}</td>
                                                <td>
                                                    <form method="POST" action="{{route('award-delete')}}"
                                                          style="display: inline;">
                                                        @csrf
                                                        <input name="id" type="hidden"
                                                               value="{{$pe->id}}">
                                                        <button type="submit" class="btn btn-danger">Delete
                                                        </button>
                                                    </form>
                                                    <a
                                                        class="btn btn-warning btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#edit_award{{$pe->id}}">Edit</a>

                                                    <div class="modal fade modal-primary" id="edit_award{{$pe->id}}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form method="POST" action="{{route('award-update')}}">
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        <input name="id" type="hidden"
                                                                               value="{{$pe->id}}">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Award or Honor
                                                                                Title </label>
                                                                            @php($field = 'title')
                                                                            <span
                                                                                class="language-label js-language-label"></span>
                                                                            <input type="hidden"
                                                                                   data-i18n="true"
                                                                                   name="{{ $field }}_i18n"
                                                                                   id="{{ $field }}_i18n"
                                                                                   value="{{ get_field_translations($pe, $field) }}">
                                                                            <input type="text" value="{{$pe->title}}"
                                                                                   class="form-control" name="title">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Congress or Authority
                                                                                Name</label>
                                                                            @php($field = 'authority_name')
                                                                            <span
                                                                                class="language-label js-language-label"></span>
                                                                            <input type="hidden"
                                                                                   data-i18n="true"
                                                                                   name="{{ $field }}_i18n"
                                                                                   id="{{ $field }}_i18n"
                                                                                   value="{{ get_field_translations($pe, $field) }}">
                                                                            <input type="text" value="{{$pe->authority_name}}"
                                                                                   class="form-control" name="authority_name">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Order</label>
                                                                            <input type="number" value="{{$pe->sort}}"
                                                                                   class="form-control" name="sort">
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default"
                                                                                data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                                                                        <button
                                                                            onclick="updateLang()"
                                                                            type="submit" class="btn btn-success">Confirm
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
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
        function updateLang() {
            var btn = $('.btn-lang.active');
            $('.btn-lang').trigger('click');
            btn.trigger('click');
        }

        $('.side-body').multilingual({"editing": true});
    </script>
@stop


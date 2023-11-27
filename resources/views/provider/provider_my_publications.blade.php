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
                                <h4 class="control-label" style="margin: 10px 20px;">My Publication <a
                                        class="btn btn-primary btn-sm"
                                        data-toggle="modal" data-target="#add_publication">Add</a></h4>

                                <div class="modal fade modal-primary" id="add_publication">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{route('publication-save')}}">
                                                <div class="modal-body">
                                                    @csrf
                                                    <input name="provider_id" type="hidden"
                                                           value="{{$provider->id}}">
                                                    <div class="form-group">
                                                        <label class="control-label">Paper Title </label>
                                                        <input type="text" class="form-control" name="paper_title">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Summary </label>
                                                        <textarea class="form-control" name="summary"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Publisher</label>
                                                        <input type="text" class="form-control" name="publisher">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Link to the publication ( Published URL
                                                            ) </label>
                                                        <input type="url" class="form-control" name="published_url">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Published on ( Date ) </label>
                                                        <input type="date" class="form-control" name="published_date">
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
                                    $publications = \App\Models\ProviderPublication::where('provider_id',$provider->id)->
                                    orderBy('sort')->get();
                                @endphp
                                @if(sizeof($publications)>0)
                                    <table class="table table-hover">
                                        <tr>
                                            <th>#ID</th>
                                            <th>Paper Titke</th>
                                            <th>Summary</th>
                                            <th>Publisher</th>
                                            <th>URL</th>
                                            <th>Published Date</th>
                                            <th>Order</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach($publications as $pe)
                                            <tr>
                                                <td>{{$pe->id}}</td>
                                                <td>{{$pe->paper_title}}</td>
                                                <td>{{$pe->summary}}</td>
                                                <td>{{$pe->publisher}}</td>
                                                <td><a href="{{$pe->published_url}}">Link</a></td>
                                                <td>{{$pe->published_date}}</td>
                                                <td>{{$pe->sort}}</td>
                                                <td>
                                                    <form method="POST" action="{{route('publication-delete')}}"
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
                                                        data-target="#edit_publication{{$pe->id}}">Edit</a>

                                                    <div class="modal fade modal-primary"
                                                         id="edit_publication{{$pe->id}}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form method="POST" action="{{route('publication-update')}}">
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        <input name="id" type="hidden"
                                                                               value="{{$pe->id}}">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Paper Title </label>
                                                                            @php($field = 'paper_title')
                                                                            <span
                                                                                class="language-label js-language-label"></span>
                                                                            <input type="hidden"
                                                                                   data-i18n="true"
                                                                                   name="{{ $field }}_i18n"
                                                                                   id="{{ $field }}_i18n"
                                                                                   value="{{ get_field_translations($pe, $field) }}">
                                                                            <input type="text" value="{{$pe->paper_title}}"
                                                                                   class="form-control" name="paper_title">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Summary </label>
                                                                            @php($field = 'summary')
                                                                            <span
                                                                                class="language-label js-language-label"></span>
                                                                            <input type="hidden"
                                                                                   data-i18n="true"
                                                                                   name="{{ $field }}_i18n"
                                                                                   id="{{ $field }}_i18n"
                                                                                   value="{{ get_field_translations($pe, $field) }}">
                                                                            <textarea class="form-control"
                                                                                      name="summary">{{$pe->summary}}</textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Publisher</label>
                                                                            @php($field = 'publisher')
                                                                            <span
                                                                                class="language-label js-language-label"></span>
                                                                            <input type="hidden"
                                                                                   data-i18n="true"
                                                                                   name="{{ $field }}_i18n"
                                                                                   id="{{ $field }}_i18n"
                                                                                   value="{{ get_field_translations($pe, $field) }}">
                                                                            <input type="text" value="{{$pe->publisher}}"
                                                                                   class="form-control" name="publisher">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Link to the publication
                                                                                ( Published URL ) </label>
                                                                            <input type="url" value="{{$pe->published_url}}"
                                                                                   class="form-control" name="published_url">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Published on ( Date
                                                                                ) </label>
                                                                            <input type="date" value="{{$pe->published_date}}"
                                                                                   class="form-control" name="published_date">
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
                                                                        <button type="submit" class="btn btn-success"
                                                                        onclick="updateLang()">Confirm
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

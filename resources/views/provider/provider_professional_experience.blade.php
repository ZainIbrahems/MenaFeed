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
                                <h4 class="control-label" style="margin: 10px 20px;">Professional Experiences <a
                                        class="btn btn-primary btn-sm"
                                        data-toggle="modal" data-target="#add_experience">Add</a></h4>

                                <div class="modal fade modal-primary" id="add_experience">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{route('experiences-save')}}">
                                                <div class="modal-body">
                                                    @csrf
                                                    <input name="provider_id" type="hidden"
                                                           value="{{$provider->id}}">
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label class="control-label">Place Of Work</label>
                                                            <input type="text" class="form-control" name="place_of_work">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label class="control-label">Designation</label>
                                                            <input type="text" value="0" class="form-control"
                                                                   name="designation">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label class="control-label">Period ( Starting Year )</label>
                                                            <input type="date" value="0" class="form-control"
                                                                   name="starting_year">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label class="control-label">Period ( Ending Year )</label>
                                                            <input type="date" value="0" class="form-control"
                                                                   name="ending_year">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label class="control-label">Currently working </label>
                                                            <br/>
                                                            <input type="checkbox" name="currently_working">
                                                        </div>

                                                        <div class="form-group col-md-4">
                                                            <label class="control-label">Order</label>
                                                            <input type="number" value="0" class="form-control" name="sort">
                                                        </div>
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
                                    $data = \App\Models\ProviderExperience::where('provider_id',$provider->id)->
                                    orderBy('sort')->get();
                                @endphp
                                @if(sizeof($data)>0)
                                    <table class="table table-hover">
                                        <tr>
                                            <th>#ID</th>
                                            <th>Place of Work</th>
                                            <th>Designation</th>
                                            <th>Starting Year</th>
                                            <th>Ending Year</th>
                                            <th>Currently Working</th>
                                            <th>Order</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach($data as $pe)
                                            <tr>
                                                <td>{{$pe->id}}</td>
                                                <td>{{$pe->place_of_work}}</td>
                                                <td>{{$pe->designation}}</td>
                                                <td>{{$pe->starting_year}}</td>
                                                <td>{{$pe->ending_year}}</td>
                                                <td>{{$pe->currently_working?'Yes':'No'}}</td>
                                                <td>{{$pe->sort}}</td>
                                                <td>
                                                    <form method="POST" action="{{route('experiences-delete')}}"
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
                                                        data-target="#edit_experiences{{$pe->id}}">Edit</a>

                                                    <div class="modal fade modal-primary"
                                                         id="edit_experiences{{$pe->id}}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form method="POST" action="{{route('experiences-update')}}">
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        <input name="id" type="hidden"
                                                                               value="{{$pe->id}}">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-4">
                                                                                <label class="control-label">Place Of
                                                                                    Work</label>
                                                                                @php($field = 'place_of_work')
                                                                                <span
                                                                                    class="language-label js-language-label"></span>
                                                                                <input type="hidden"
                                                                                       data-i18n="true"
                                                                                       name="{{ $field }}_i18n"
                                                                                       id="{{ $field }}_i18n"
                                                                                       value="{{ get_field_translations($pe, $field) }}">
                                                                                <input type="text"
                                                                                       value="{{$pe->place_of_work}}"
                                                                                       class="form-control"
                                                                                       name="place_of_work">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label class="control-label">Designation</label>
                                                                                @php($field = 'designation')
                                                                                <span
                                                                                    class="language-label js-language-label"></span>
                                                                                <input type="hidden"
                                                                                       data-i18n="true"
                                                                                       name="{{ $field }}_i18n"
                                                                                       id="{{ $field }}_i18n"
                                                                                       value="{{ get_field_translations($pe, $field) }}">
                                                                                <input type="text" value="{{$pe->designation}}"
                                                                                       class="form-control" name="designation">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label class="control-label">Period ( Starting
                                                                                    Year )</label>
                                                                                <input type="date"
                                                                                       value="{{$pe->starting_year}}"
                                                                                       class="form-control"
                                                                                       name="starting_year">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label class="control-label">Period ( Ending
                                                                                    Year )</label>
                                                                                <input type="date" value="{{$pe->ending_year}}"
                                                                                       class="form-control" name="ending_year">
                                                                            </div>
                                                                            <div class="form-group col-md-4">
                                                                                <label class="control-label">Currently
                                                                                    working </label>
                                                                                <br/>
                                                                                <input type="checkbox"
                                                                                       name="currently_working" {{$pe->currently_working?'selected':''}}>
                                                                            </div>

                                                                            <div class="form-group col-md-4">
                                                                                <label class="control-label">Order</label>
                                                                                <input type="number" value="{{$pe->sort}}"
                                                                                       class="form-control" name="sort">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default"
                                                                                data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                                                                        <button type="submit"
                                                                                onclick="updateLang()"
                                                                                class="btn btn-success">Confirm
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

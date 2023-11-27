@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
    $provider = \App\Models\Provider::where('id',$dataTypeContent->getKey())->first();
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

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
            <div class="{{($edit && isAdmin())?'col-md-8':'col-md-12'}}">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                          class="form-edit-add"
                          action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                          method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                    @if($edit)
                        {{ method_field("PUT") }}
                    @endif

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

                        <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                            @endphp

                            @foreach($dataTypeRows as $row)
                            <!-- GET THE DISPLAY OPTIONS -->
                                @php
                                    $display_options = $row->details->display ?? NULL;
                                    if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                        $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                    }
                                @endphp
                                @if (isset($row->details->legend) && isset($row->details->legend->text))
                                    <legend class="text-{{ $row->details->legend->align ?? 'center' }}"
                                            style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                @endif

                                <div
                                    class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                    {{ $row->slugify }}
                                    <label class="control-label"
                                           for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                    @include('voyager::multilingual.input-hidden-bread-edit-add')
                                    @if ($add && isset($row->details->view_add))
                                        @include($row->details->view_add, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'view' => 'add', 'options' => $row->details])
                                    @elseif ($edit && isset($row->details->view_edit))
                                        @include($row->details->view_edit, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'view' => 'edit', 'options' => $row->details])
                                    @elseif (isset($row->details->view))
                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                    @elseif ($row->type == 'relationship')
                                        @include('voyager::formfields.relationship', ['options' => $row->details])
                                    @else
                                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                    @endif

                                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                    @endforeach
                                    @if ($errors->has($row->field))
                                        @foreach ($errors->get($row->field) as $error)
                                            <span class="help-block">{{ $error }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            @section('submit-buttons')
                                <button type="submit"
                                        class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            @stop
                            @yield('submit-buttons')
                        </div>
                    </form>

                    <div style="display:none">
                        <input type="hidden" id="upload_url" value="{{ route('voyager.upload') }}">
                        <input type="hidden" id="upload_type_slug" value="{{ $dataType->slug }}">
                    </div>
                </div>
            </div>
            @if($edit)
                @if(isAdmin())
                    <div class="col-md-4">
                        <div class="panel panel-bordered">

                            <h4 class="control-label" style="margin: 10px 20px;">Provider Features</h4>
                            <form method="POST" action="{{route('update-provider-features')}}">
                                @csrf
                                <input name="provider_id" type="hidden" value="{{$dataTypeContent->getKey()}}">
                                @php
                                    $features = \App\Models\ProviderFeature::where('provider_id',$dataTypeContent->getKey())->pluck('feature_id');
                                   $features = json_decode($features);
                                @endphp
                                <div class="form-group" style="margin: 0 20px;">
                                    @foreach(\App\Models\Feature::get() as $f)
                                        <div>
                                            <input name="features[]"
                                                   {{in_array($f->id,$features)?'checked':''}}
                                                   type="checkbox" value="{{$f->id}}"> {{$f->title}}
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group" style="margin: 0 20px;">
                                    <button type="submit"
                                            class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">

                    <div class="panel panel-bordered">

                        <h4 class="control-label" style="margin: 10px 20px;">About </h4>

                        <form method="POST" action="{{route('update-provider-about')}}">
                            @csrf
                            <input name="provider_id" type="hidden" value="{{$dataTypeContent->getKey()}}">
                            <div class="form-group" style="margin: 0 20px;">
                                <textarea class="form-control richTextBox" name="about"
                                          id="richtext_about">
                                    {!! $provider->about !!}
                                </textarea>
                            </div>

                            <span style="margin: 5px 20px;color:red" id="character_count"></span>
                            <div class="form-group" style="margin: 0 20px;">
                                <button type="submit"
                                        class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-bordered">

                        <h4 class="control-label" style="margin: 10px 20px;">Education <a
                                class="btn btn-primary btn-sm"
                                data-toggle="modal" data-target="#add_education">Add</a></h4>

                        <div class="modal fade modal-primary" id="add_education">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{route('education-save')}}">
                                        <div class="modal-body">
                                            @csrf
                                            <input name="provider_id" type="hidden"
                                                   value="{{$dataTypeContent->getKey()}}">
                                            <div class="form-group">
                                                <label class="control-label">University Name</label>
                                                <input type="text" class="form-control" name="university_name">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Degree</label>
                                                <input type="number" value="0" class="form-control" name="degree">
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
                            $educations = \App\Models\ProviderEducation::where('provider_id',$provider->id)->
                            orderBy('sort')->get();
                        @endphp
                        @if(sizeof($educations)>0)
                            <table class="table table-hover">
                                <tr>
                                    <th>#ID</th>
                                    <th>University Name</th>
                                    <th>Degree</th>
                                    <th>Order</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($educations as $pe)
                                    <tr>
                                        <td>{{$pe->id}}</td>
                                        <td>{{$pe->university_name}}</td>
                                        <td>{{$pe->degree}}</td>
                                        <td>{{$pe->sort}}</td>
                                        <td>
                                            <form method="POST" action="{{route('education-delete')}}"
                                                  style="display: inline;">
                                                @csrf
                                                <input name="id" type="hidden"
                                                       value="{{$pe->id}}">
                                                <button type="submit" class="btn btn-danger">Delete
                                                </button>
                                            </form>
                                            <a
                                                style="display: inline;"
                                                class="btn btn-warning btn-sm"
                                                data-toggle="modal"
                                                data-target="#edit_education{{$pe->id}}">Edit</a>

                                            <div class="modal fade modal-primary" id="edit_education{{$pe->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{route('education-update')}}">
                                                            <div class="modal-body">
                                                                @csrf
                                                                <input name="id" type="hidden"
                                                                       value="{{$pe->id}}">
                                                                <div class="form-group">
                                                                    <label class="control-label">University Name</label>
                                                                    <input type="text" value="{{$pe->university_name}}"
                                                                           class="form-control" name="university_name">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Degree</label>
                                                                    <input type="number" value="{{$pe->degree}}"
                                                                           class="form-control" name="degree">
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
                                                                <button type="submit" class="btn btn-success">Confirm
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
                <div class="col-md-12">
                    <div class="panel panel-bordered">

                        <h4 class="control-label" style="margin: 10px 20px;">Professional Experiences
                            <a
                                class="btn btn-primary btn-sm"
                                data-toggle="modal" data-target="#add_experience">Add</a>
                        </h4>

                        <div class="modal fade modal-primary" id="add_experience">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{route('experiences-save')}}">
                                        <div class="modal-body">
                                            @csrf
                                            <input name="provider_id" type="hidden"
                                                   value="{{$dataTypeContent->getKey()}}">
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
                                                style="display: inline;"
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
                                                                        <input type="text"
                                                                               value="{{$pe->place_of_work}}"
                                                                               class="form-control"
                                                                               name="place_of_work">
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label class="control-label">Designation</label>
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
                                                                <button type="submit" class="btn btn-success">Confirm
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
                <div class="col-md-12">
                    <div class="panel panel-bordered">

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
                                                   value="{{$dataTypeContent->getKey()}}">
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
                                                style="display: inline;"
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
                                                                    <input type="text" value="{{$pe->paper_title}}"
                                                                           class="form-control" name="paper_title">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Summary </label>
                                                                    <textarea class="form-control"
                                                                              name="summary">{{$pe->summary}}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Publisher</label>
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
                                                                <button type="submit" class="btn btn-success">Confirm
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
                <div class="col-md-12">
                    <div class="panel panel-bordered">

                        <h4 class="control-label" style="margin: 10px 20px;">Vacations and Certificates <a
                                class="btn btn-primary btn-sm"
                                data-toggle="modal" data-target="#add_vacations">Add</a></h4>

                        <div class="modal fade modal-primary" id="add_vacations">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{route('vacations-save')}}">
                                        <div class="modal-body">
                                            @csrf
                                            <input name="provider_id" type="hidden"
                                                   value="{{$dataTypeContent->getKey()}}">
                                            <div class="form-group">
                                                <label class="control-label">Name of Certificate – Vacations </label>
                                                <input type="text" class="form-control" name="certificate_name">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Issue Date ( Year ) </label>
                                                <input type="date" class="form-control" name="issue_date">
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
                            $vacations = \App\Models\ProviderVacation::where('provider_id',$provider->id)->
                            orderBy('sort')->get();
                        @endphp
                        @if(sizeof($vacations)>0)
                            <table class="table table-hover">
                                <tr>
                                    <th>#ID</th>
                                    <th>Certificate Name</th>
                                    <th>Issu Date</th>
                                    <th>Order</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($vacations as $pe)
                                    <tr>
                                        <td>{{$pe->id}}</td>
                                        <td>{{$pe->certificate_name}}</td>
                                        <td>{{$pe->issue_date}}</td>
                                        <td>{{$pe->sort}}</td>
                                        <td>
                                            <form method="POST" action="{{route('vacations-delete')}}"
                                                  style="display: inline;">
                                                @csrf
                                                <input name="id" type="hidden"
                                                       value="{{$pe->id}}">
                                                <button type="submit" class="btn btn-danger">Delete
                                                </button>
                                            </form>
                                            <a
                                                style="display: inline;"
                                                class="btn btn-warning btn-sm"
                                                data-toggle="modal"
                                                data-target="#edit_vacations{{$pe->id}}">Edit</a>

                                            <div class="modal fade modal-primary" id="edit_vacations{{$pe->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{route('vacations-update')}}">
                                                            <div class="modal-body">
                                                                @csrf
                                                                <input name="id" type="hidden"
                                                                       value="{{$pe->id}}">
                                                                <div class="form-group">
                                                                    <label class="control-label">Name of Certificate –
                                                                        Vacations </label>
                                                                    <input type="text" value="{{$pe->certificate_name}}"
                                                                           class="form-control" name="certificate_name">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Issue Date ( Year
                                                                        ) </label>
                                                                    <input type="date" value="{{$pe->issue_date}}"
                                                                           class="form-control" name="issue_date">
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
                                                                <button type="submit" class="btn btn-success">Confirm
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
                <div class="col-md-12">
                    <div class="panel panel-bordered">

                        <h4 class="control-label" style="margin: 10px 20px;">Memberships <a
                                class="btn btn-primary btn-sm"
                                data-toggle="modal" data-target="#add_membership">Add</a></h4>

                        <div class="modal fade modal-primary" id="add_membership">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{route('membership-save')}}">
                                        <div class="modal-body">
                                            @csrf
                                            <input name="provider_id" type="hidden"
                                                   value="{{$dataTypeContent->getKey()}}">
                                            <div class="form-group">
                                                <label class="control-label">Association Name or Society Name </label>
                                                <input type="text" class="form-control" name="name">
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
                            $memberships = \App\Models\ProviderMembership::where('provider_id',$provider->id)->
                            orderBy('sort')->get();
                        @endphp
                        @if(sizeof($memberships)>0)
                            <table class="table table-hover">
                                <tr>
                                    <th>#ID</th>
                                    <th>Association Name or Society Name</th>
                                    <th>Order</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($memberships as $pe)
                                    <tr>
                                        <td>{{$pe->id}}</td>
                                        <td>{{$pe->name}}</td>
                                        <td>{{$pe->sort}}</td>
                                        <td>
                                            <form method="POST" action="{{route('membership-delete')}}"
                                                  style="display: inline;">
                                                @csrf
                                                <input name="id" type="hidden"
                                                       value="{{$pe->id}}">
                                                <button type="submit" class="btn btn-danger">Delete
                                                </button>
                                            </form>
                                            <a
                                                style="display: inline;"
                                                class="btn btn-warning btn-sm"
                                                data-toggle="modal"
                                                data-target="#edit_membership{{$pe->id}}">Edit</a>

                                            <div class="modal fade modal-primary" id="edit_membership{{$pe->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{route('membership-update')}}">
                                                            <div class="modal-body">
                                                                @csrf
                                                                <input name="id" type="hidden"
                                                                       value="{{$pe->id}}">
                                                                <div class="form-group">
                                                                    <label class="control-label">Association Name or
                                                                        Society Name </label>
                                                                    <input type="text" value="{{$pe->name}}"
                                                                           class="form-control" name="name">
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
                                                                <button type="submit" class="btn btn-success">Confirm
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
                <div class="col-md-12">
                    <div class="panel panel-bordered">

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
                                                   value="{{$dataTypeContent->getKey()}}">
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
                                                style="display: inline;"
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
                                                                    <input type="text" value="{{$pe->title}}"
                                                                           class="form-control" name="title">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Congress or Authority
                                                                        Name</label>
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
                                                                <button type="submit" class="btn btn-success">Confirm
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

                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <h4 class="control-label" style="margin: 10px 20px;">Contact Details</h4>
                        <form method="POST" action="{{route('contact-save')}}">
                            <div class="modal-body">
                                @csrf
                                <input name="provider_id" type="hidden"
                                       value="{{$dataTypeContent->getKey()}}">
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

                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <h4 class="control-label" style="margin: 10px 20px;">Social Media Accounts Details </h4>
                        <form method="POST" action="{{route('contact-save')}}">
                            <div class="modal-body">
                                @csrf
                                <input name="provider_id" type="hidden"
                                       value="{{$dataTypeContent->getKey()}}">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Instagram Account</label>
                                        <input type="text" value="{{$provider->instagram}}" class="form-control"
                                               name="instagram">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Facebook Account</label>
                                        <input type="text" value="{{$provider->facebook }}" class="form-control"
                                               name="facebook">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Pinterest Account</label>
                                        <input type="text" value="{{$provider->pinterest }}" class="form-control"
                                               name="pinterest">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Youtube Account</label>
                                        <input type="text" value="{{$provider->youtube}}" class="form-control"
                                               name="youtube">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="control-label">Tiktok Account</label>
                                        <input type="text" value="{{$provider->tiktok}}" class="form-control"
                                               name="tiktok">
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
            @endif
        </div>
    </div>

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}
                    </h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'
                    </h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger"
                            id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')
    <script>

        function updateSpecialityGroup() {
            var platform_category = $('select[name="platform_category"]').val();
            $.getJSON("{{route('update-speciality-group')}}/" + platform_category, function (data) {
                $('select[name="provider_belongsto_platform_sub_category_relationship[]"]').empty();
                var $element = $('select[name="provider_belongsto_platform_sub_category_relationship[]"]').select2();
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

        @if($add)
        updateSpecialityGroup();
        @endif

        function updateSpecialities() {
            var speciality_group = $('select[name="provider_belongsto_platform_sub_category_relationship[]"]').val();
            $.getJSON("{{route('update-specialities')}}/" + speciality_group, function (data) {
                $('select[name="provider_belongstomany_platform_sub_sub_category_relationship[]"]').empty();
                var $element = $('select[name="provider_belongstomany_platform_sub_sub_category_relationship[]"]').select2();
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

        $('select[name="provider_belongsto_platform_sub_category_relationship[]"]').change(() => {
            updateSpecialities();
        });
    </script>
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
            return function () {
                $file = $(this).siblings(tag);

                params = {
                    slug: '{{ $dataType->slug }}',
                    filename: $file.data('file-name'),
                    id: $file.data('id'),
                    field: $file.parent().data('field-name'),
                    multi: isMulti,
                    _token: '{{ csrf_token() }}'
                }

                $('.confirm_delete_name').text(params.filename);
                $('#confirm_delete_modal').modal('show');
            };
        }

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: ['YYYY-MM-DD']
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function (i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function () {
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if (response
                        && response.data
                        && response.data.status
                        && response.data.status == 200) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function () {
                            $(this).remove();
                        })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        function CountCharacters() {
            var body = tinymce.get('richtext_about').getBody();
            var content = tinymce.trim(body.innerText || body.textContent);
            return content.length;
        };

        $(document).ready(function () {
            var additionalConfig = {
                selector: '#richtext_about',
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
@stop

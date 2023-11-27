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
                                <h4 class="control-label" style="margin: 10px 20px;">Spoken Languages <a
                                        class="btn btn-primary btn-sm"
                                        data-toggle="modal" data-target="#add_spoken_language">Add</a></h4>

                                <div class="modal fade modal-primary" id="add_spoken_language">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{route('provider-spoken-language-save')}}">
                                                <div class="modal-body">
                                                    @csrf
                                                    <input name="provider_id" type="hidden"
                                                           value="{{$provider->id}}">
                                                    <div class="form-group">
                                                        <label class="control-label">Language</label>
                                                        @php
                                                            $spoken_languages = \App\Models\SpokenLanguage::all();
                                                        @endphp
                                                        <select class="form-control" name="spoken_language_id">
                                                            @forelse ($spoken_languages as $sl)
                                                                <option value="{{ $sl->id }}">{{ $sl->name }}</option>
                                                            @empty
                                                                <option value="--">No Languages Found</option>
                                                            @endforelse
                                                        </select>
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
                                @if(sizeof($provider->spoken_languages)>0)
                                    <table class="table table-hover">
                                        <tr>
                                            <th>#ID</th>
                                            <th>Language</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach($provider->spoken_languages as $sl)
                                            <tr>
                                                <td>{{$sl->id}}</td>
                                                <td>{{$sl->name}}</td>
                                                <td>
                                                    <form method="POST" action="{{route('provider-spoken-language-delete')}}"
                                                          style="display: inline;">
                                                        @csrf
                                                        <input name="id" type="hidden"
                                                               value="{{$sl->id}}">
                                                        <button type="submit" class="btn btn-danger">Delete
                                                        </button>
                                                    </form>
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

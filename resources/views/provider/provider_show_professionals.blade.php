@extends('voyager::master')
@php
    $provider = \App\Models\Provider::where('user_id',auth('web')->user()->id)->first();
@endphp
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

                                <h4 class="control-label" style="margin: 10px 20px;">My Professionals</h4>
                                @php
                                    $data = \App\Models\ProvidersProfessional::
                                    where('provider_id',$provider->id)->pluck('professional_id');
                                    $data = \App\Models\Provider::whereIn('id',$data)->get();
                                @endphp
                                @if(sizeof($data)>0)
                                    <table class="table table-hover">
                                        <tr>
                                            <th>#ID</th>
                                            <th>Full Legal Name</th>
                                            <th>Professional Formal Email</th>
                                            <th>Professional Mobile No.</th>
                                            <th>Verified</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach($data as $pe)
                                            <tr>
                                                <td>{{$pe->id}}</td>
                                                <td>{{$pe->full_name}}</td>
                                                <td>{{$pe->email}}</td>
                                                <td>{{$pe->phone}}</td>
                                                <td>
                                                    @if($pe->verified)
                                                        <span class="badge badge-success">Yes</span>
                                                    @else
                                                        <span class="badge badge-danger">No</span>
                                                    @endif</td>
                                                <td>
                                                    <form method="POST" action="{{route('delete-professional')}}"
                                                          style="display: inline;">
                                                        @csrf
                                                        <input name="provider_id" type="hidden"
                                                               value="{{$provider->id}}">
                                                        <input name="id" type="hidden"
                                                               value="{{$pe->id}}">
                                                        <button type="submit" class="btn btn-danger">
                                                            Delete
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


@stop

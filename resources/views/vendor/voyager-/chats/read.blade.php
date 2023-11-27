@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->getTranslatedAttribute('display_name_singular'))

@push('css')

    <link href="{{asset('lightbox/css/lightbox.css')}}" rel="stylesheet"/>
    <style>
        .stretch-card > .card {
            width: 100%;
            min-width: 100%
        }

        .file {
            width: 100%;
            max-width: 100%;
            font-weight: bold;
            border-radius: 20px;
            height: 150px;
            border: 1px solid #24629c;
            line-height: 10;
        }

        .text-center {
            text-align: center;
        }

        body {
            background-color: #f9f9fa
        }

        .flex {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }

        @media (max-width: 991.98px) {
            .padding {
                padding: 1.5rem
            }
        }

        @media (max-width: 767.98px) {
            .padding {
                padding: 1rem
            }
        }

        .padding {
            padding: 3rem
        }

        .box.box-warning {
            border-top-color: #f39c12;
        }

        .box {
            position: relative;
            border-radius: 3px;
            background: #ffffff;
            border-top: 3px solid #d2d6de;
            margin-bottom: 20px;
            width: 100%;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        .box-header.with-border {
            border-bottom: 1px solid #f4f4f4
        }

        .box-header.with-border {
            border-bottom: 1px solid #f4f4f4;
        }

        .box-header {
            color: #444;
            display: block;
            padding: 10px;
            position: relative;
        }

        .box-header:before, .box-body:before, .box-footer:before, .box-header:after, .box-body:after, .box-footer:after {
            content: " ";
            display: table;
        }

        .box-header {
            color: #444;
            display: block;
            padding: 10px;
            position: relative
        }

        .box-header > .fa, .box-header > .glyphicon, .box-header > .ion, .box-header .box-title {
            display: inline-block;
            font-size: 18px;
            margin: 0;
            line-height: 1;
        }

        .box-header > .box-tools {
            position: absolute;
            right: 10px;
            top: 5px;
        }

        .box-header > .box-tools [data-toggle="tooltip"] {
            position: relative;
        }

        .bg-yellow, .callout.callout-warning, .alert-warning, .label-warning, .modal-warning .modal-body {
            background-color: #f39c12 !important;
        }

        .bg-yellow {
            color: #fff !important;
        }

        .btn {
            border-radius: 3px;
            -webkit-box-shadow: none;
            box-shadow: none;
            border: 1px solid transparent;
        }

        .btn-box-tool {
            padding: 5px;
            font-size: 12px;
            background: transparent;
            color: #97a0b3;
        }

        .direct-chat .box-body {
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            position: relative;
            overflow-x: hidden;
            padding: 0;
        }

        .box-body {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
            padding: 10px;
        }

        .box-header:before, .box-body:before, .box-footer:before, .box-header:after, .box-body:after, .box-footer:after {
            content: " ";
            display: table;
        }

        .direct-chat-messages {
            -webkit-transform: translate(0, 0);
            -ms-transform: translate(0, 0);
            -o-transform: translate(0, 0);
            transform: translate(0, 0);
            padding: 10px;
            height: 60vh;
            overflow: auto;
        }

        .direct-chat-messages, .direct-chat-contacts {
            -webkit-transition: -webkit-transform .5s ease-in-out;
            -moz-transition: -moz-transform .5s ease-in-out;
            -o-transition: -o-transform .5s ease-in-out;
            transition: transform .5s ease-in-out;
        }


        .direct-chat-msg {
            margin-bottom: 10px;
        }

        .direct-chat-msg, .direct-chat-text {
            display: block;
        }

        .direct-chat-info {
            display: block;
            margin-bottom: 2px;
            font-size: 12px;
        }

        .direct-chat-timestamp {
            color: #999;
        }

        .btn-group-vertical > .btn-group:after, .btn-group-vertical > .btn-group:before, .btn-toolbar:after, .btn-toolbar:before, .clearfix:after, .clearfix:before, .container-fluid:after, .container-fluid:before, .container:after, .container:before, .dl-horizontal dd:after, .dl-horizontal dd:before, .form-horizontal .form-group:after, .form-horizontal .form-group:before, .modal-footer:after, .modal-footer:before, .modal-header:after, .modal-header:before, .nav:after, .nav:before, .navbar-collapse:after, .navbar-collapse:before, .navbar-header:after, .navbar-header:before, .navbar:after, .navbar:before, .pager:after, .pager:before, .panel-body:after, .panel-body:before, .row:after, .row:before {
            display: table;
            content: " ";
        }

        .direct-chat-img {
            border-radius: 50%;
            float: left;
            width: 40px;
            height: 40px;
        }

        .direct-chat-text {
            border-radius: 5px;
            position: relative;
            padding: 5px 10px;
            background: #d2d6de;
            border: 1px solid #d2d6de;
            margin: 5px 0 0 50px;
            color: #444;
            width: 50%;
        }

        .direct-chat-msg, .direct-chat-text {
            display: block;
        }


        :after, :before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .direct-chat-msg:after {
            clear: both;
        }

        .direct-chat-msg:after {
            content: " ";
            display: table;
        }

        .direct-chat-info {
            display: block;
            margin-bottom: 2px;
            font-size: 12px;
        }

        .right .direct-chat-img {
            float: right;
        }

        .direct-chat-warning .right > .direct-chat-text {
            background: #f39c12;
            border-color: #f39c12;
            color: #fff;
        }

        .right .direct-chat-text {
            margin-right: 10px;
            margin-left: 0;
        }

        .box-footer {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
            border-top: 1px solid #f4f4f4;
            padding: 10px;
            background-color: #fff;
        }

        .box-header:before, .box-body:before, .box-footer:before, .box-header:after, .box-body:after, .box-footer:after {
            content: " ";
            display: table;
        }


        .input-group-btn {
            position: relative;
            font-size: 0;
            white-space: nowrap;
        }

        .input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
            z-index: 2;
            margin-left: -1px;
        }

        .btn-warning {
            color: #fff;
            background-color: #f0ad4e;
            border-color: #eea236;
        }

        .text-right {
            text-align: right;
            float: right;
        }

        .text-left {
            text-align: left;
        }

    </style>
@endpush

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }}
        &nbsp;

        @can('edit', $dataTypeContent)
            <a href="{{ route('voyager.'.$dataType->slug.'.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
                <i class="glyphicon glyphicon-pencil"></i> <span
                    class="hidden-xs hidden-sm">{{ __('voyager::generic.edit') }}</span>
            </a>
        @endcan
        @can('delete', $dataTypeContent)
            @if($isSoftDeleted)
                <a href="{{ route('voyager.'.$dataType->slug.'.restore', $dataTypeContent->getKey()) }}"
                   title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore"
                   data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span
                        class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
                </a>
            @else
                <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete"
                   data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span
                        class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
                </a>
            @endif
        @endcan
        @can('browse', $dataTypeContent)
            <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
                <i class="glyphicon glyphicon-list"></i> <span
                    class="hidden-xs hidden-sm">{{ __('voyager::generic.return_to_list') }}</span>
            </a>
        @endcan
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">Messages</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">
                        @php
                            $chat = \App\Models\Chat::where('id',$dataTypeContent->getKey())->first();
                            if (auth('web')->user()->role_id == getRoleID('provider')) {
                                        return $q->where(function ($qi) {
                                            return $qi->where([
                                                'from_id' => auth('web')->user()->id,
                                                'from_type' => 'provider'
                                            ]);
                                        })->orWhere(function ($qi) {
                                            return $qi->where([
                                                'to_id' => auth('web')->user()->id,
                                                'from_type' => 'provider'
                                            ]);
                                        });
                                    }
                            $chat = $chat->first();
                            $messags = \App\Resources\Message::collection(\App\Models\Message::withTrashed()->where('chat_id',$dataTypeContent->getKey())->
                            orderBy('id','desc')->whereDate('created_at','>=',\Carbon\Carbon::now()->subMonths(6)->toDateTimeString())->get());
                        @endphp
                        <div class="direct-chat-messages">
                            @if(sizeof($messags)==0)
                                <div class="alert alert-warning">
                                    No Messages yes!
                                </div>
                            @endif
                            <?php
                            $messags = json_decode(json_encode($messags));
                            ?>
                            @foreach($messags as $m)

                                <div class="direct-chat-msg {{$chat->from_id==$m->from_id?'':'right'}}">
                                    <div class="direct-chat-info clearfix">
                                        <span
                                            style="color:red;"
                                            class="direct-chat-name {{$chat->from_id==$m->from_id?'pull-left':'pull-right'}}">{{$m->from_name}}</span>
                                    </div>

                                    <img class="direct-chat-img"
                                         src="https://img.icons8.com/color/36/000000/administrator-male.png"
                                         alt="message user image">

                                    <div
                                        class="direct-chat-text {{$chat->from_id==$m->from_id?'direct-chat-text-from':'direct-chat-text-to'}} {{$chat->from_id==$m->from_id?'text-left':'text-right'}}">
                                        {{$m->message}}
                                        <br/>
                                        <div class="row">
                                            @if(is_array($m->files) && sizeof($m->files)>0)
                                                @foreach($m->files as $f)
                                                    @if($f->type=='image')
                                                        <div class="col-xs-4 text-center">
                                                            <a href="{{$f->path}}" data-lightbox="roadtrip">
                                                                <img src="{{$f->path}}"
                                                                     class="file">
                                                            </a>
                                                        </div>
                                                    @elseif($f->type=='video')
                                                        <div class="col-xs-6 text-center">

                                                            {{--                                                            <a href="{{$f->path}}" data-lightbox="roadtrip">--}}
                                                            <video class="file" controls>
                                                                <source src="{{$f->path}}"
                                                                        type="video/mp4">
                                                            </video>
                                                            {{--                                                            </a>--}}
                                                        </div>
                                                    @elseif($f->type=='audio')
                                                        <div class="col-xs-6 text-center">
                                                            <div class="file" style="line-height: 2">
                                                                <audio style="max-width: 100%;" controls>
                                                                    <source src="{{$f->path}}" type="audio/mpeg">
                                                                </audio>
                                                                <a href="{{$f->path}}"
                                                                   target="_blank">Download</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-xs-3 text-center">
                                                            {{--                                                            <a href="{{$f->path}}" data-lightbox="roadtrip">--}}
                                                            <div class="file">
                                                                <a href="{{$f->path}}"
                                                                   target="_blank">Download</a>
                                                            </div>
                                                            {{--                                                            </a>--}}
                                                        </div>
                                                    @endif
                                                @endforeach
                                                {{--                                            <br/>--}}
                                                {{--                                            @if($m->type=='image')--}}
                                                {{--                                                <img src="{{asset('storage'.'/'.json_encode())}}" style="max-width: 150px">--}}
                                                {{--                                            @else--}}
                                                {{--                                                <a href="{{json_encode($m->files)}}" target="_blank">Download</a>--}}
                                                {{--                                            @endif--}}
                                            @endif
                                        </div>
                                        <span
                                            dir="ltr"
                                            style="font-size: 12px;"
                                            class="direct-chat-timestamp {{$chat->from_id==$m->from_id?'pull-right':'pull-left'}}">{{\Carbon\Carbon::parse($m->created_at)->toDateTimeString()}}</span>

                                    </div>

                                </div>

                            @endforeach

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('javascript')
    @if ($isModelTranslatable)
        <script>
            $(document).ready(function () {
                $('.side-body').multilingual();
            });
        </script>
    @endif
    <script>
        var deleteFormAction;
        $('.delete').on('click', function (e) {
            var form = $('#delete_form')[0];

            if (!deleteFormAction) {
                // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/)
                ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                : deleteFormAction + '/' + $(this).data('id');

            $('#delete_modal').modal('show');
        });

    </script>

    <script src="{{asset('lightbox/js/lightbox.js')}}"></script>
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })
    </script>
@stop

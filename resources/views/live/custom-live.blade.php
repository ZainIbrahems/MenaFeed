@extends('live.custom-app')

@section('page', $page)
@section('title', getSetting('APPLICATION_NAME')->normal_text . ' | ' . $meeting->title)

<?php
$invited = false;
$loggedin = auth('web')->check();
$can_watch = true;
$isModerator = isModerator($meeting);
$username = $user ? $user['full_name'] : $meeting->username;
?>


@section('style')
    <style>

        html, body {
            position: fixed;
            height: 100vh;
            width: 100%;
            background-color: #f4f4f4;
        }

        .meeting-section {
            background-color: #f4f4f4 !important;
        }

        .card-body {
            padding: 0 1.25rem;
        }

        .form-group {
            margin-bottom: 0;
        }

        .card {
            border-radius: 20px;
        }

        .trim-events-content {
            max-width: 100%;
            max-height: 200px;
            overflow: auto !important;
        }

        .hidden {
            display: none !important;
        }

        .fa, .far, .fas {
            color: #2688eb;
        }

        .meeting-options > button {
            color: #2688eb;
            background-color: #f4f4f4;
            border: none !important;
        }

        .member .fa {
            color: #2989eb !important;
        }

        .meeting-options .btn-danger,
        .meeting-options .btn-danger .fas {
            color: white !important;
            background-color: #c7242a !important;
        }

        label {
            text-align: left;
        }

        .videoContainer button .fa {
            color: white !important;
        }

        #recording.red {
            background: #c7242a !important;
        }

        .settings {
            display: flex;
        }

        .settings label {
            margin: 0 5px;
        }

        .settings img {
            width: 30px;
            height: 30px;
            padding: 6px;
            background-color: #a3a3a3;
            border-radius: 20px;
            cursor: pointer;
        }


        #setting-button {
            background-color: white !important;
            border: 1px solid #a3a3a3;
        }

        .main-container-image, #container-with-image {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 80px;
            background-color: #f4f4f4;
            margin: 10px 0;
        }

        .main-container-image > div {
            width: fit-content;
            padding: 30px;
            border-radius: 80px;
            background-color: #2688eb;
            color: rgba(255, 255, 255, 0.98);
            font-weight: 600px;
            font-size: 48px;
            line-height: 52px;
        }

        .main-container-image > p {
            font-weight: 400;
            font-size: 14px;
            line-height: 20px;
            color: #1b1b1b;
            border-radius: 16px;
        }

        .card-header {
            border-bottom: 0;
        }

        .main-container-image > img, #container-with-image > img:nth-of-type(2) {
            position: absolute;
            right: 3px;
            top: 3px;
            margin: 10px;
            width: 35px;
            height: 35px;
            padding: 8px;
            background-color: #e64646;
            border-radius: 36px;
            cursor: pointer;
            user-select: none;
        }

        .main-list {
            overflow-x: hidden;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .main-list > h3 {
            font-family: "Inter";
            font-style: normal;
            font-weight: 500;
            font-size: 30px;
            line-height: 36px;
            color: #1b1b1b;
        }

        .main-list > div {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .options-list {
            white-space: nowrap;
            overflow-x: auto;
        }

        #recording {
            cursor: pointer;
            color: white;
            background-color: #475366;
            /*border: 4px solid #475366;*/
        }

        .options-list > * {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 8px;
            padding: 0 10px;
            border-radius: 50px;
            color: white;
            cursor: pointer;
            line-height: 20px;
        }

        .options-list > * p {
            margin-top: 0.3rem;
            margin-bottom: 0.3rem;
            font-size: 11px;
        }

        .stream-details {
            justify-content: space-between;
            align-items: center;
            width: 300px;
            min-width: fit-content;
        }

        .stream-details > div {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
        }

        .stream-details > div > p {
            padding: 5px;
            background-color: white;
            color: #2688eb;
            border-radius: 15px;
            font-family: "Inter";
            font-style: normal;
            font-weight: 700;
            font-size: 10px;
            line-height: 12px;
        }

        .stream-details > p {
            padding: 3px 20px;
            background-color: white;
            color: #2688eb;
            border-radius: 55px;
        }


        @media only screen and (max-width: 767px) {
            .main-list {
                flex-wrap: wrap;
            }

            .main-list > div {
                gap: 8px;
                flex-wrap: wrap;
                justify-content: flex-start;
            }
        }

        .stream {
            /* min-height: 700px; */
            max-height: 100%;
            overflow-y: hidden;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            gap: 10px;
            padding: 1rem;
        }
        @media only screen and (min-width: 769px) and (max-width: 1024px){
            .chat {
                padding: 0;
                z-index: 30;
            }
        }
        .chat {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
            padding: 10px 5px !important;
            background-color: white;
            box-shadow: 0px 2px 4px -1px rgba(33, 33, 33, 0.25);
            border-radius: 40px;
            overflow: hidden;
            max-height: 95vh;
        }
        @media only screen and (min-width: 769px) and (max-width: 1024px){

            .chat > div:nth-of-type(1) {
                padding: 0.7rem 0.2rem 0 0.2rem;
            }
        }

        .chat > div:nth-child(1) {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }



    </style>
    <link href="{{ asset('assets/css/meeting.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container meeting-details">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <h3>{{$meeting->title}}</h3>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center">Get Started</h5>
                        <h6 class="text-center">Setup your audio and video before joining</h6>
                    </div>

                    <div class="card-body pb-0">
                        @if($can_watch)
                            <form id="passwordCheck"
                                  style="display: {{($invited || $isModerator || !$loggedin)?'block':'none'}};">
                                <input type="hidden" value="{{ $meeting->code }}" name="meeting_id">
                                <div class="row">
                                    <div class="main-container-image">
                                        <img src="{{asset('assets/new-live/icons/mic-muted-white.svg')}}" alt="mic"
                                             id="video-mic">
                                        <div>{{strlen($username)>2?substr($username,0,2):"NA"}}</div>
                                        <p>{{isset($user['full_name'])?$user['full_name']:''}}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="settings">
                                        <input type="checkbox" style="display: none;" checked class="form-check-input"
                                               id="muteAudio"/>
                                        <label for="muteAudio"><img
                                                src="{{asset('assets/new-live/icons/mic-muted-white.svg')}}" alt="mic"
                                                id="list-mic"></label>
                                        <input type="checkbox" style="display: none;" checked class="form-check-input"
                                               id="muteCamera"/>
                                        <label for="muteCamera"><img
                                                src="{{asset('assets/new-live/icons/video-disabled-white.svg')}}"
                                                alt="video" id="list-video"></label>
                                        <label class="updateDevices"
                                               data-toggle="tooltip"
                                               data-placement="top" title="Settings">
                                            <img src="{{asset('assets/new-live/icons/settings.svg')}}" alt="settings"
                                                 id="setting-button">
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-8 mt-3">
                                        <input type="text" id="username" name="username" class="form-control"
                                               value="{{ $username }}"
                                               placeholder="Enter your name"
                                               required/>
                                    </div>
                                    <div class="col-md-4 mt-3">

                                        @if($loggedin)
                                            <button class="btn btn-primary btn-block" id="joinMeeting"
                                                    data-toggle="tooltip"
                                                    data-placement="top" title="Join Meeting" type="submit" disabled>
                                                {{$isModerator?'start':'Join'}}
                                            </button>
                                        @endif
                                        @if(!$isModerator)
                                            <button class="btn btn-primary btn-block" id="watchMeeting"
                                                    data-toggle="tooltip"
                                                    data-placement="top" title="Watch Meeting" type="button"
                                                    disabled>
                                                Watch
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid meeting-section">
        <div class="main-list">
            <h3>{{$meeting->topic?$meeting->topic->title:""}}</h3>
            <div class="options-list">
                @if($meeting->isModerator || isset($_GET['admin']) )
                    <div id="recording">
                        <img src="{{asset('assets/new-live/icons/start-record.svg')}}" alt="end">
                        <p>Start Recording</p>
                    </div>
                @endif
                {{--                <div style="background-color: #2688eb" id="go-live-button">--}}
                {{--                    <img src="{{asset('assets/new-live/icons/stream.svg')}}" alt="stream">--}}
                {{--                    <input type="checkbox" name="" checked>--}}
                {{--                    <p>Pause Live</p>--}}
                {{--                </div>--}}
                <div id="leave" style="background-color: #e64646" id="leave-studio-button">
                    <img src="{{asset('assets/new-live/icons/exit.svg')}}" alt="exit">
                    <p>Leave Studio</p>
                </div>
                <div style="background-color: #2688eb" class="stream-details">
                    <div>
                        <img src="{{asset('assets/new-live/icons/participants.svg')}}" alt="participants">
                        <p id="participants">1</p>
                    </div>
                    <p id="timer">00:00:00</p>
                </div>
            </div>
        </div>
        <div class="row">
{{--            <div class="stream">--}}
                <div id="videos" dir="ltr">
                    <div class="videoContainer localVideoContainer">
                        <video id="localVideo" autoplay playsinline muted></video>
                        <span class="local-user-name"></span>
                    </div>
                </div>
{{--                <div class="chat">--}}
{{--                    <div>--}}
{{--                        <p class="chat-button">Chat</p>--}}
{{--                        <div class="participants-button">--}}
{{--                            <p>participants</p>--}}
{{--                            <p class="participants-button-number">1</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="chat-list">--}}
{{--                        <!-- participant -->--}}
{{--                        <div class="participant">--}}
{{--                            <img src="./images/profile-picture.png" alt="profile-picture"/>--}}
{{--                            <p>me</p>--}}
{{--                            <div class="participant-list">--}}
{{--                                <img src="./icons/mic-blue.svg" alt="mic-allowed-blue"/>--}}
{{--                                <img src="./icons/video-blue.svg" alt="video-allowed-outline"/>--}}
{{--                                <img src="./icons/options-blue.svg" alt="options"/>--}}
{{--                            </div>--}}

{{--                            <!-- full options menu -->--}}
{{--                            <div class="participant-options">--}}
{{--                                <div>--}}
{{--                                    <img src="./icons/mic-muted-black.svg" alt="mic"/>--}}
{{--                                    <p>Mute</p>--}}
{{--                                </div>--}}
{{--                                <div>--}}
{{--                                    <img src="./icons/exit-black.svg" alt="exit"/>--}}
{{--                                    <p>Dismiss</p>--}}
{{--                                </div>--}}
{{--                                <div>--}}
{{--                                    <img src="./icons/question-mark.svg" alt="?"/>--}}
{{--                                    <p>Block</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <!-- chat element -->--}}
{{--                        <div class="chat-element">--}}
{{--                            <div class="chat-element-image">--}}
{{--                                <img src="./images/profile-picture2.png" alt="image"/>--}}
{{--                            </div>--}}
{{--                            <div class="chat-element-details">--}}
{{--                                <p>Amine</p>--}}
{{--                                <p>--}}
{{--                                    nsienfg vpisnfd jbnsadf nbafafdbma k’dbojs nobmso fdmbo[sm--}}
{{--                                    boisjfdoibmsp igdbisn bdwpe kmrgokm lergmo ajme roejrg oiqjero--}}
{{--                                    [igj aoler jg--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <p id="add-participant-button">+ Add Participants</p>--}}

{{--                    <!-- type message segment -->--}}
{{--                    <div class="type-message-segment">--}}
{{--                        <img style="background-color: #01bc62" src="./icons/smiley-face.svg" alt="smile"/>--}}
{{--                        <input type="text" placeholder="Type message"/>--}}
{{--                        <button style="background-color: #2688eb">c--}}
{{--                            <img src="./icons/send.svg" alt="send"/>--}}
{{--                        </button>--}}
{{--                    </div>--}}

{{--                    <p id="cancel-chat-button">cancel</p>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>

        {{--        <div class="meeting-info text-center">--}}
        {{--            <span id="meetingIdInfo" class="text-center"></span>--}}
        {{--            <span id="timer" class="text-center"></span>--}}
        {{--        </div>--}}
        <div class="chat-panel">
            <div class="chat-box">
                <div class="chat-header">
                    Chat
                    <i class="fas fa-times close-panel"></i>
                </div>
                <div class="chat-body">
                    <div class="empty-chat-body">
                        <i class="fa fa-envelope chat-icon"></i>
                    </div>
                </div>
                <div class="chat-footer">
                    <form id="chatForm">
                        <div class="input-group">
                            <label for="messageInput" class="hidden">Write your message</label>
                            <input type="text" id="messageInput" class="form-control note-input"
                                   placeholder="Write your message here ..." autocomplete="off" maxlength="250"/>
                            <div class="input-group-append">
                                <button id="sendMessage" class="btn btn-outline-secondary" type="submit" title="Send">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                                <button id="selectFile" class="btn btn-outline-secondary" title="Attach File"
                                        type="button">
                                    <i class="fas fa-file"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <input type="file" name="file" id="file" data-max="50" hidden/>
                </div>
            </div>
        </div>
        <div class="members-panel">
            <div class="chat-box">
                <div class="chat-header">
                    Users
                    <i class="fas fa-times close-members-panel"></i>
                </div>
                <div class="members-body">
                    {{--<div class="member">--}}
                    {{--<span></span>--}}
                    {{--<a class="member-btn"><i class="fa fa-ban"></i></a>--}}
                    {{--<a class="member-btn"><i class="fa fa-volume-off"></i></a>--}}
                    {{--<a class="member-btn"><i class="fa fa-plus"></i></a>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
        <div class="meeting-options">
            {{--@if($meeting->isModerator)--}}



            {{--            @if($meeting->isModerator || isset($_GET['admin']) )--}}
            {{--                <button class="btn meeting-option" title="Recording" id="recording">--}}
            {{--                    <i class="fa fa-record-vinyl"></i>--}}
            {{--                </button>--}}
            {{--            @endif--}}
            <button class="btn meeting-option updateDevices" id="updateDevices" title="Update Devices">
                <i class="fa fa-cog"></i>
            </button>
            <button class="btn meeting-option" title="Start/Stop ScreenShare" id="screenShare">
                <i class="fa fa-desktop"></i>
            </button>
            <button class="btn meeting-option" title="Rotate Camera" id="toggleCam">
                <i class="fas fa-camera"></i>
            </button>
            <button class="btn meeting-option" title="On/Off Camera" id="toggleVideo">
                <i class="fa fa-video"></i>
            </button>
            {{--            <button class="btn btn-danger" title="Leave Meeting" id="leave">--}}
            {{--                <i class="fas fa-phone"></i>--}}
            {{--            </button>--}}

            <button class="btn meeting-option" title="Mute/Unmute Mic" id="toggleMic">
                <i class="fa fa-microphone"></i>
            </button>

            <button class="btn meeting-option" title="Members" id="openMembers">
                <i class="far fa-user"></i>
            </button>
            {{--@endif--}}
            <button class="btn meeting-option" title="Chat" id="openChat">
                <i class="far fa-comment-alt"></i>
            </button>
            <button class="btn meeting-option" title="Invite" id="add">
                <i class="fas fa-user-plus"></i>
            </button>
            <button class="btn meeting-option" title="Full Screen" id="fullscreen_btn">
                <i class="fa fa-expand"></i>
            </button>
            <button class="btn meeting-option updateLayout" id="updateLayouts" title="Update Layout">
                <i class="fa fa-bars"></i>
            </button>

        </div>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img alt="preview" id="previewImage" src=""/>
                    {{--<p id="previewFilename"></p>--}}
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>--}}
                    <button type="button" id="sendFile" class="btn btn-primary">إرسال</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateLayout" tabindex="-1" role="dialog" aria-labelledby="updateLayoutLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deviceSettingsLabel">Change Layout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <button id="showAllBtn" class="btn btn-primary  btn-block" data-dismiss="modal">View All
                        </button>
                    </div>
                    <div class="form-group">
                        <button id="showSpeakerBtn" class="btn btn-primary  btn-block" data-dismiss="modal">
                            Only who talk
                        </button>
                    </div>
                    <div class="form-group">
                        <button id="showShareScreenBtn" class="btn btn-primary  btn-block" data-dismiss="modal">
                            Screen Share
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="displayModal" tabindex="-1" role="dialog" aria-labelledby="displayModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="displayModalLabel">Show FIle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img alt="display" id="displayImage" src=""/>
                </div>
                <div class="modal-footer">
                    <button type="button" id="downloadFile" class="btn btn-primary">Download</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deviceSettings" tabindex="-1" role="dialog" aria-labelledby="deviceSettingsLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deviceSettingsLabel">Device Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-3 col-md-4 text-left">
                            <label for="videoQualitySelect">Video Quality</label>
                        </div>
                        <div class="col-lg-9 col-md-8">
                            <select id="videoQualitySelect" class="form-control">
                                <option id="QVGA" data-width="320" data-height="240">QVGA</option>
                                <option id="VGA" data-width="640" data-height="480">VGA</option>
                                <option id="HD" data-width="1280" data-height="720">HD</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row hidden">
                        <div class="col-lg-3 col-md-4 text-left">
                            <label for="audioSource">Audio input source </label>
                        </div>
                        <div class="col-lg-9 col-md-8">
                            <select id="audioSource" class="form-control"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-3 col-md-4 text-left">
                            <label for="videoSource">Video source </label>
                        </div>
                        <div class="col-lg-9 col-md-8">
                            <select id="videoSource" class="form-control"></select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="shortcutInfo" tabindex="-1" role="dialog" aria-labelledby="shortcutInfoLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shortcutInfoLabel">Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Shortcut Key</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">C</th>
                            <td>Chat</td>
                        </tr>
                        <tr>
                            <th scope="row">F</th>
                            <td>Attach File</td>
                        </tr>
                        <tr>
                            <th scope="row">A</th>
                            <td>Mute/Unmute Audio</td>
                        </tr>
                        <tr>
                            <th scope="row">L</th>
                            <td>Leave Meeting</td>
                        </tr>
                        <tr>
                            <th scope="row">V</th>
                            <td>On/Off Video</td>
                        </tr>
                        <tr>
                            <th scope="row">S</th>
                            <td>Screen Share</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('assets/js/recordrtc/RecordRTC.js')}}"></script>
    @if($can_watch)
        <script type="text/javascript">
            const userInfo = {
                username: "{{ $username }}",
                meetingId: "{{ $meeting->code }}",
                meetingTitle: "{{ $meeting->title }}"
            };

            const passwordRequired = "{{ $meeting->password }}";
            const isModerator = "{{ $isModerator }}";
            const limitedTimeMeeting = false;

        </script>
    @endif
    <script src="{{ asset('assets/js/socket.io.js') }}"></script>
    <script src="{{ asset('assets/js/easytimer.min.js') }}"></script>
    <script src="{{ asset('assets/js/adapter.min.js')}}"></script>
    <script src="{{ asset('assets/js/siofu.min.js')}}"></script>
    <script src="{{ asset('assets/js/hark.js')}}?date={{\Carbon\Carbon::now()->toDateTimeString()}}"></script>
    <script src="{{ asset('assets/js/opentok-layout.min.js')}}"></script>
    @if($can_watch)
        <script>toastr.options.rtl = true;</script>
        <script src="{{ asset('assets/js/meeting.js')}}?date={{\Carbon\Carbon::now()->toDateTimeString()}}"></script>
    @endif
@endsection

@extends('live.new-app')

@section('page', $page)
@section('title', getSetting('APPLICATION_NAME')->normal_text . ' | ' . $meeting->title)

<?php
$invited = false;
$loggedin = auth('web')->check();
$can_watch = true;
$isModerator = isModerator($meeting);
?>


@section('style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('assets/new-live/styles/main.css')}}"/>

@endsection

@section('content')

    <!-- <div class="top"></div> -->
    <h3 class="main-header">{{$meeting->title}}</h3>

    <div class="main-container">
        <h3>Get Started</h3>
        <p>Setup your audio and video before joining</p>
        <div class="main-container-image">
            <img src="{{asset('assets/new-live/icons/mic-muted-white.svg')}}" alt="mic" id="video-mic"/>
            <div>KA</div>
            <p>Karen a</p>
        </div>

        <!-- container with image -->
        <div id="container-with-image">
            <img src="{{asset('assets/new-live/images/small-main-image.png')}}" alt="image"/>
            <img src="{{asset('assets/new-live/icons/mic-muted-white.svg')}}" alt="mic" id="video-with-image-mic"/>
        </div>
        <div class="share-feed">
            <p>Share My live on my feed page</p>
            <label class="switch">
                <input type="checkbox" checked/>
                <span class="slider round"></span>
            </label>
        </div>
        <div class="settings">
            <input type="hidden" class="form-check-input" id="togglemic"/>
            <img src="{{asset('assets/new-live/icons/mic-muted-white.svg')}}" alt="mic" id="list-mic"/>
            <input type="hidden" class="form-check-input" id="muteCamera"/>
            <img src="{{asset('assets/new-live/icons/video-disabled-white.svg')}}" alt="video" id="list-video"/>
            <img src="{{asset('assets/new-live/icons/settings.svg')}}"
                 class="updateDevices"
                 alt="settings" id="setting-button"/>
        </div>
        <div class="join-form">
            @if($can_watch)
                <form id="passwordCheck">
                    <input type="hidden" value="{{ $meeting->code }}" name="meeting_id">
                    <input type="text" id="username" name="username"
                           value="{{ $user?$user['name']:$meeting->username }}"/>
                    @if($loggedin)
                        <button id="joinMeeting"
                                data-toggle="tooltip"
                                data-placement="top" title="Join Meeting" type="submit"
                                disabled>{{$isModerator?'start':'Join'}}</button>
                    @endif
                    @if(!$isModerator)
                        <button id="watchMeeting"
                                data-toggle="tooltip"
                                data-placement="top" title="Watch Meeting" type="button"
                                disabled>Watch
                        </button>
                    @endif
                </form>
            @endif
        </div>
    </div>

    <div class="container-fluid meeting-section">
        <!-- fullscreen -->
        <div id="fullscreen"></div>

        <!-- you left the stream frame -->
        <div class="left-stream-alert" style="display: none;">
            <div style="background-color: #2688eb">
                <div>
                    <img src="./icons/participants.svg" alt="participants" />
                    <p>217K</p>
                </div>
                <p>00:24:03</p>
            </div>
            <div>
                <img src="./icons/hand.svg" alt="wave" />
                <div class="left-stream-alert-header">
                    <h2>You left the stream</h2>
                    <p>Have a nice day!</p>
                </div>
                <div class="left-stream-alert-list">
                    <p>Left by mistake?</p>
                    <div style="background-color: #2688eb" id="rejoin-button">
                        <img src="./icons/exit.svg" alt="exit" />
                        <p>Rejoin</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Recording Frame -->
        <div class="end-record-alert" style="display: none;">
            <div>
                <div class="alert-header">
                    <img src="./icons/alert.svg" alt="alert" />
                    <p>End Recording</p>
                </div>
                <p>Are you sure you want to end recording?</p>
                <div class="alert-list">
                    <p id="cancel-end-record">Don't End</p>
                    <p id="end-record-button">End Recording</p>
                </div>
            </div>
        </div>

        <!-- <div class="top"></div> -->

        <div class="main-list">
            <h3>Live Description</h3>
            <div class="options-list">
                <div id="start-record-button">
                    <img src="./icons/start-record.svg" alt="end" />
                    <p>Start Recording</p>
                </div>
                <div style="background-color: #2688eb" id="go-live-button">
                    <img src="./icons/stream.svg" alt="stream" />
                    <p>Go Live</p>
                </div>
                <div style="background-color: #e64646" id="leave-studio-button">
                    <img src="./icons/exit.svg" alt="exit" />
                    <p>Leave Studio</p>
                </div>
                <div style="background-color: #2688eb" class="stream-details">
                    <div>
                        <img src="./icons/participants.svg" alt="participants" />
                        <p>217K</p>
                    </div>
                    <p>00:24:03</p>
                </div>
            </div>
        </div>

        <div class="stream">
            <!-- videos list -->
            <div class="video">
                <div class="row">
                    <div id="videos" dir="ltr">
                        <div class="videoContainer localVideoContainer">
                            <video id="localVideo" autoplay playsinline muted></video>
                            <span class="local-user-name"></span>
                        </div>
                    </div>
                </div>

                <div id="stream-video">
                    <div class="video-segment">
                        <img src="./icons/mic-muted-white.svg" alt="mic" class="single-video-mic" />
                        <img src="./images/main-image.png" alt="main-image" class="main-video single-video-image" />
                        <!-- no main image -->
                        <div class="no-image-video" style="display: none;">
                            <p>KA</p>
                            <p>Karen A</p>
                        </div>
                    </div>
                </div>

                <div class="video-options-list">
                    <img src="./icons/mic-muted-white.svg" alt="mic" id="list-mic" />
                    <img src="./icons/video-white.svg" alt="video" id="list-video" />
                    <img src="./icons/attach.svg" alt="attach" id="list-attach" />
                    <img src="./icons/fullscreen.svg" alt="fullscreen" id="list-fullscreen" fullscreen="false" />
                    <img src="./icons/options.svg" alt="options" id="list-options" />
                </div>
            </div>
            <div class="chat">
                <div>
                    <p class="chat-button">Chat</p>
                    <div class="participants-button">
                        <p>participants</p>
                        <p class="participants-button-number">1</p>
                    </div>
                </div>
                <div class="chat-list">
                    <!-- participant -->
                    <div class="participant">
                        <img src="./images/profile-picture.png" alt="profile-picture" />
                        <p>me</p>
                        <div class="participant-list">
                            <img src="./icons/mic-blue.svg" alt="mic-allowed-blue" />
                            <img src="./icons/video-blue.svg" alt="video-allowed-outline" />
                            <img src="./icons/options-blue.svg" alt="options" />
                        </div>

                        <!-- full options menu -->
                        <div class="participant-options">
                            <div>
                                <img src="./icons/mic-muted-black.svg" alt="mic" />
                                <p>Mute</p>
                            </div>
                            <div>
                                <img src="./icons/exit-black.svg" alt="exit" />
                                <p>Dismiss</p>
                            </div>
                            <div>
                                <img src="./icons/question-mark.svg" alt="?" />
                                <p>Block</p>
                            </div>
                        </div>
                    </div>

                    <!-- chat element -->
                    <div class="chat-element">
                        <div class="chat-element-image">
                            <img src="./images/profile-picture2.png" alt="image" />
                        </div>
                        <div class="chat-element-details">
                            <p>Amine</p>
                            <p>
                                nsienfg vpisnfd jbnsadf nbafafdbma k’dbojs nobmso fdmbo[sm
                                boisjfdoibmsp igdbisn bdwpe kmrgokm lergmo ajme roejrg oiqjero
                                [igj aoler jg
                            </p>
                        </div>
                    </div>
                </div>
                <p id="add-participant-button">+ Add Participants</p>

                <!-- type message segment -->
                <div class="type-message-segment">
                    <img style="background-color: #01bc62" src="./icons/smiley-face.svg" alt="smile" />
                    <input type="text" placeholder="Type message" />
                    <button style="background-color: #2688eb">
                        <img src="./icons/send.svg" alt="send" />
                    </button>
                </div>

                <p id="cancel-chat-button">cancel</p>
            </div>
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
                username: "{{ $user?$user['name']:$meeting->username }}",
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
    <script src="{{asset("assets/new-live/scripts/main.js")}}" type="text/javascript"></script>

    @if($can_watch)
        <script>toastr.options.rtl = true;</script>
        <script src="{{ asset('assets/js/meeting-new.js')}}?date={{\Carbon\Carbon::now()->toDateTimeString()}}"></script>
    @endif
@endsection

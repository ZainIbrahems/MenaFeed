<html>

<head>

    <title>{{ $lv->title}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
        }

        #root {
            width: 100%;
            height: 100%;
        }

        .info {
            position: absolute !important;
            z-index: 12312 !important;
            width: 100% !important;
        }

        .span {
            background: #313443;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .col-sm-4 {
            margin: 20px 0 0 0;
            text-align: center;
            /*font-weight: bold;*/
            /*color: #0074c7;*/
            /*text-shadow: 0px 0px 13px white;*/
        }
    </style>
</head>


<body>
<div class="row info">
    <div class="col-sm-4"><span class="span">{{ $lv->title}}</span></div>
    <div class="col-sm-4"><span class="span">{{ $lv->goal}}</span></div>
    <div class="col-sm-4"><span class="span">{{ $lv->topic}}</span></div>
</div>


<div id="root"></div>

</body>
<script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>
<script>

    function getUrlParams(url) {
        let urlStr = url.split('?')[1];
        const urlSearchParams = new URLSearchParams(urlStr);
        const result = Object.fromEntries(urlSearchParams.entries());
        return result;
    }


    // Generate a Kit Token by calling a method.
    // @param 1: appID
    // @param 2: serverSecret
    // @param 3: Room ID
    // @param 4: User ID
    // @param 5: Username
    const roomID = '{{$lv->room_id}}';
    const userID = Math.floor(Math.random() * 10000) + "";
    const userName = "{{auth('web')->check()?auth('web')->user()->full_name:'UserName'}}";
    const appID = 1810631269;
    const serverSecret = "f92ef3d9855565fe15e7b81b708d52fc";
    const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(appID, serverSecret, roomID, userID, userName);


    // You can assign different roles based on url parameters.
    // let role = getUrlParams(window.location.href)['role'] || 'Host';
    @php
        $is_co_host = false;
            if (auth('sanctum')->check()) {
                $is_co_host = (bool)\App\Models\ProviderLivestream::where([
                    'provider_id' => auth('sanctum')->user()->id,
                    'livestream_id' => $lv->id,
                ])->first();

                if(auth('sanctum')->user()->role_id==getRoleID('nm-admin')){
                     $is_co_host = true;
                }
            }

    @endphp

    let role = '{{($is_co_host)?'Host':'Audience'}}';
    role = role === 'Host' ? ZegoUIKitPrebuilt.Host : ZegoUIKitPrebuilt.Audience;


    const zp = ZegoUIKitPrebuilt.create(kitToken);
    zp.joinRoom({
        container: document.querySelector("#root"),
        scenario: {
            mode: ZegoUIKitPrebuilt.LiveStreaming,
            config: {
                role,
            },
        },
        sharedLinks: [{
            name: 'Join as audience',
            url:
                "{{route('show-live')}}" +
                '?roomID=' +
                roomID +
                '&role=Audience',
        }]
    });
</script>

</html>

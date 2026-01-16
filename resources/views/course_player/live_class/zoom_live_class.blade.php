<!DOCTYPE html>

<head>
    <title>{{$live_class->class_topic ?? 'Live Class'}} | {{get_phrase('Live Class')}}</title>
    <meta charset="utf-8" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <style type="text/css">
        .ax-outline-blue-important:first-child {
            display: none !important;
        }
    </style>
</head>

<body>
    <script src="https://source.zoom.us/3.1.6/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/3.1.6/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/3.1.6/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/3.1.6/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/3.1.6/lib/vendor/lodash.min.js"></script>
    <script src="https://source.zoom.us/zoom-meeting-3.1.6.min.js"></script>

    @php
        $meeting_info = json_decode($live_class->additional_info ?? '{}', true);
        if (!is_array($meeting_info)) {
            $meeting_info = [];
        }
        $course = App\Models\Course::where('id', $live_class->course_id ?? 0)->first();
        $is_host = $course && $course->instructors()->where('id', auth()->user()->id)->count() > 0 ? 1:0;
        
        // Validate meeting info
        $meeting_id = $meeting_info['id'] ?? '';
        $meeting_password = $meeting_info['password'] ?? '';
        $sdk_key = get_settings('zoom_sdk_client_id') ?? '';
        $sdk_secret = get_settings('zoom_sdk_client_secret') ?? '';
        
        $has_valid_meeting = !empty($meeting_id) && !empty($sdk_key) && !empty($sdk_secret);
    @endphp

    @if(!$has_valid_meeting)
        <div style="padding: 50px; text-align: center; font-family: Arial, sans-serif;">
            <h2 style="color: #d32f2f;">{{ get_phrase('Meeting Information Missing') }}</h2>
            <p style="color: #666; margin-top: 20px;">
                @if(empty($meeting_id))
                    {{ get_phrase('Meeting ID is not available. Please check if the Zoom meeting was created successfully.') }}
                @elseif(empty($sdk_key) || empty($sdk_secret))
                    {{ get_phrase('Zoom SDK credentials are not configured. Please configure them in the settings.') }}
                @else
                    {{ get_phrase('Unable to join the meeting. Please contact the administrator.') }}
                @endif
            </p>
            <a href="{{ $_SERVER['HTTP_REFERER'] ?? url('/') }}" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #1976d2; color: white; text-decoration: none; border-radius: 4px;">
                {{ get_phrase('Go Back') }}
            </a>
        </div>
    @else
    <script>
        "use strict";
        var mn = "{{$meeting_id}}";
        var user_name = "{{auth()->user()->name ?? ''}}";
        var pwd = "{{$meeting_password}}";
        var role = {{$is_host}}; //1 is host and 0 is general user
        var email = "{{auth()->user()->email ?? ''}}";
        var lang = "en-US";
        var china = 0;
        var sdkKey = "{{$sdk_key}}"; //SDK Key or Client ID
        var sdkSecret = "{{$sdk_secret}}"; //SDK Secret or Client Secret
        var leaveUrl = "{{$_SERVER['HTTP_REFERER'] ?? url('/')}}";

        console.log('Meeting Info:', {
            meetingNumber: mn,
            userName: user_name,
            password: pwd,
            role: role,
            email: email,
            sdkKey: sdkKey ? 'Set' : 'Missing',
            sdkSecret: sdkSecret ? 'Set' : 'Missing'
        });

        // Validate required fields before proceeding
        if (!mn || !sdkKey || !sdkSecret) {
            alert('{{ get_phrase("Missing required meeting information. Please contact the administrator.") }}');
            window.location.href = leaveUrl;
        }

        //Generate signature here
        ZoomMtg.generateSDKSignature({
            meetingNumber: mn,
            sdkKey: sdkKey,
            sdkSecret: sdkSecret,
            role: role,
            success: function(signature) {
                console.log(ZoomMtg.checkSystemRequirements())
                console.log(signature)

                //After generating the signature, initializing the meeting
                ZoomMtg.preLoadWasm();
                ZoomMtg.prepareWebSDK();
                ZoomMtg.i18n.load(lang);
                ZoomMtg.init({
                    leaveUrl: leaveUrl,
                    disableCORP: !window.crossOriginIsolated, // default true
                    success: function() {

                        //Join to the meeting
                        ZoomMtg.join({
                            meetingNumber: mn,
                            userName: user_name,
                            signature: signature,
                            sdkKey: sdkKey,
                            userEmail: email,
                            passWord: pwd,
                            success: function(res) {
                                console.log("join meeting success");
                                console.log("get attendeelist");
                                ZoomMtg.getAttendeeslist({});
                                ZoomMtg.getCurrentUser({
                                    success: function(res) {
                                        console.log("success getCurrentUser", res.result.currentUser);
                                    },
                                });
                            },
                            error: function(res) {
                                console.log(res);
                            },
                        });
                    },
                    error: function(res) {
                        console.log(res);
                    },
                });

                ZoomMtg.inMeetingServiceListener("onUserJoin", function(data) {
                    console.log("inMeetingServiceListener onUserJoin", data);
                });

                ZoomMtg.inMeetingServiceListener("onUserLeave", function(data) {
                    console.log("inMeetingServiceListener onUserLeave", data);
                });

                ZoomMtg.inMeetingServiceListener("onUserIsInWaitingRoom", function(data) {
                    console.log("inMeetingServiceListener onUserIsInWaitingRoom", data);
                });

                ZoomMtg.inMeetingServiceListener("onMeetingStatus", function(data) {
                    console.log("inMeetingServiceListener onMeetingStatus", data);
                });
            },
            error: function(error) {
                console.error('Error generating signature:', error);
                alert('{{ get_phrase("Error generating meeting signature. Please try again or contact support.") }}');
                window.location.href = leaveUrl;
            }
        });
    </script>
    @endif
</body>

</html>
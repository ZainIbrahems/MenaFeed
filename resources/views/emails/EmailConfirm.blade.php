<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Password Reset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        /**
         * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
         */
         body{
           
         }
         .card { 
            padding:40px;
            background:white;
            width:50%;
            position:relative;
            left:50%;
            transform:translateX(-50%);
         }
        @media (max-width:1100px){
            body{
                padding:30px;
            }
            .card{
                width:90%;
            }
        }
        @media screen {
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 700;
                src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
            }
        }

        /**
         * Avoid browser level font resizing.
         * 1. Windows Mobile
         * 2. iOS / OSX
         */
        body,
        table,
        td,
        a {
            -ms-text-size-adjust: 100%; /* 1 */
            -webkit-text-size-adjust: 100%; /* 2 */
        }

        /**
         * Remove extra space added to tables and cells in Outlook.
         */
        table,
        td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
        }

        /**
         * Better fluid images in Internet Explorer.
         */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /**
         * Remove blue links for iOS devices.
         */
        a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
        }

        /**
         * Fix centering issues in Android 4.4.
         */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }

        body {
            width: 100% !important;
            height: 100% !important;
            /* padding: 0 !important; */
            margin: 0 !important;
        }

        /**
         * Collapse table borders to avoid space between cells.
         */
        table {
            border-collapse: collapse !important;
        }

        a {
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
            color: white !important;
            border-radius: 20px;
            background: #32cb9d !important;
        }

        img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
        }
    </style>
</head>
<body style="background-color: #e9ecef; display:flex;
            justify-content:center;
            align-items:center;">

<table width="100%" bgcolor="#F6FAFB" align="center" border="0" cellspacing="0" cellpadding="0">
    <tbody align="center">
        <tr>
            <td>
                <table width="600" align="center" border="0" cellspacing="0" cellpadding="0">
                        <tr><td><img src="{{$message->embed(asset('MenaEmailLogo.svg'))}}"></td></tr>
                        <tr><td><p style="font-weight:bold;">Dear {{$user->user_name}}</p></td></tr>
                        <tr><td><p>We are delighted to welcome you to the world's most exceptional application (Mena).</p></td></tr>
                        <tr><td><p>You've just taken the first step to experience something truly extraodinary.</p></td></tr>
                        <tr><td><p style="font-weight:bold;">What awaits You:</p></td></tr>
                        <tr><td><p>Get ready to explore a world of endless possibilities and unmatched innovation.</p></td></tr>
                        <tr><td><p>Mena is where dreams turn into reality and where you'll discover a universe of opportunities.</p></td></tr>
                        <tr><td><p style="font-weight:bold;">Begin Your Journey:</p></td></tr>
                        <tr><td><p>Simply log in with your registered email and password to unlock the wonders of our application.</p></td></tr>
                        <tr><td><p>Customize your profile to reflect your unique style and interests.</p></td></tr>
                        <tr><td><p>Dive into a sea of features, content, and conversations that will leave you awe-inspired.</p></td></tr>
                        <tr><td><p style="font-weight:bold;text-align:center;">Stay Connected to Greatness:</p></td></tr>
                        <tr><td><p>Connect with like-minded individuals and experts from diverse backgrounds.</p></td></tr>
                        <tr><td><p>Keep pace with the latest updates, trending topics, and thought-provoking discussion.</p></td></tr>
                        <tr><td><p style="font-weight:bold;text-align:center;">Exclusive Perks:</p></td></tr>
                        <tr><td><p>As a Mena User, you'll enjoy exclucive benifits and access to content that's truly one of the kind. </p></td></tr>
                        <tr><td><p>Be the first to know about upcoming events, promotions and insider information.</p></td></tr>
                        <tr><td><p>Privacy and Security:</p></td></tr>
                        <tr><td><p>Your privacy is paramount to us. Rest assured that your data is protected with the highest levels of security.</p></td></tr>
                        <tr><td><p>Thank you for choosing Mena.You're now a part of a global community that thrives on</p></td></tr>

                        <tr><td><p>excellence, and we're excited to have you on board.</p></td></tr>
                        <tr><td><p>Welcome to the world's premier application.</p></td></tr>
                        <tr><td><p>Warm regards</p></td></tr>
                        <tr><td><p style="font-weight:bold;text-align:center;">Nimer AlKhatib</p></td></tr>
                        <tr><td><p style="font-weight:bold;text-align:center;">Founder</p></td></tr>
                        <tr><td><p>Best regards,</p></td></tr>
                        
                        <tr align="center"><td><p style="text-align:center;margin-bottom:0px !imporatnt;">From</p>
                            <img  style=" width: 90px;
    max-width: 90px;vertical-align: middle;
    border: 0;
    line-height: 100%;
    height: auto;
    outline: none;
    text-decoration: none;" src="{{$message->embed(asset('blue.png'))}}">
                    </td></tr>
                        <tr><td><p style="text-align:center;"></p></td></tr>
                        <tr><td><p style="text-align:center;">©  MenaAi Information Technology, United Arab Emirates, Dubai</p></td></tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>


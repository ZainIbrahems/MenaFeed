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
         p{
            margin-bottom:0px !important;
         }
         div img{
            margin-top:-30px;
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
                        <tr><td><img src="{{$message->embed(asset('MenaLogo.png'))}}"></td></tr>
                        <tr><td><p style="font-weight:bold;">Dear {{$user->full_name}}</p></td></tr>
                        <tr><td><p>You need to verify your email address to continue using your Mena account. Enter the following code to verify your email address :</p></td></tr>
                        <tr><td><p style="font-weight:bold;text-align:center;">OPT Code: {{$token}}</p></td></tr>
                        <tr><td><p>Please note that this OTP is valid for only 10 minutes</p></td></tr>
                        <tr><td><p>Thank you for using Mena!</p></td></tr>
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


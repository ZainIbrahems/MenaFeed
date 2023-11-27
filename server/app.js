"use strict";

require('dotenv').config();
var cors = require('cors');
const express = require('express');
const app = express();
app.use(cors());
// const fs = require('fs');
const options = {
    key: '-----BEGIN RSA PRIVATE KEY-----\n' +
        'MIIEpQIBAAKCAQEAyzgWKUKU2Dk1hu0e6MlUEPYiLKCqMHDgkFiJYS/38fTRCRmA\n' +
        'H5ewuqkpwa2v2XELzU3Pif2yk72OoGyc0r1xE1yB6ez8S17qYRTmWOZq4BkQYVLZ\n' +
        '3hr5Yox0oYCciOnYI0NDXNae/mZ7ixgQicwVABSSEcaHaIo99OTX8i8oTPHODGWP\n' +
        'ZqfIXBh+kvwSKYKxh8Y/M3pPtpwqWedOcjH+48PeEB9Bs92dNNj8vZ0wkIKE4M6h\n' +
        'NlGgyD7EQqyjleHN+YyR05wxcH8cZPes0tC5cjChF7V3SyYJ5hbZAUkn/HON/N50\n' +
        'I0pOvKHGZxXFzD7XTYNsaZk346jrU21YTdAZtQIDAQABAoIBAQCP7/rqYIlymRrL\n' +
        'pZoWAbu0g9Fy0J2az+iO9Nbhaotw6hlBG7m/Jr77hyPXVcFO/x3/3ZQZRgM9V670\n' +
        '+9kb/yhfMU+nM78DV4glGRuKbjHW5onOlVNRWMO4xIk7dw/ofdEkMNk+oZld0ZLB\n' +
        '01qrb0yUkP1g78ArEHePxKMbm8EstXk6OzwrLpFHOTsT+nIdMiZQwK/6ADqnMnLy\n' +
        'CByu2Mzc3bJwheyI4pdfxCE9ZuyR5tV2O7JhxFjq9fFt0id7YLUtmlpKRNVpVpU2\n' +
        'YF54e9p5xts2peEruilj7a5NZ0xHCS6z0R1LzCWcLeQWfeHT5Pqx2zg/gPXiWto3\n' +
        'CPhKZWlhAoGBAOeBWI65Ci+kpnxHeP/LCRJNaStKvsP84H+69j5B6tI0tW/9/Xdg\n' +
        'LzwqBbnspneQqH4nYS8oR8ZSoaXfdV7FV9+1kAROidah3Ad1NM9ecUvfF9jmDIYF\n' +
        '2bkxagVYi8fVe3WSpam4iiyQ71gxhmTGf4WI8fIs2J2Mr4prq2h5W855AoGBAOC4\n' +
        'kaQsTqh2h/wIyIhPFjpnUluuzVViUIPdSzI4xiGNCAZ/jBjKIwUAMfEz3lojHLvG\n' +
        'fHLKkdaJXRk/t977p2TrMT/CuRdJSlCp/7wZzGSuU/U0Wcly/OeEmyqirlUdaiWL\n' +
        'zbd3zrwi3V/L5KZf5XUxBVjB427yNLBktDmL8eYdAoGBAJuVJfrlCJ90PB8RuZPO\n' +
        '083lEGTz2rjEXev5rjuw+StEGRumyo1LqvL4GtkU3dtE8Le3p2yV2YbDSbe8MZj7\n' +
        'b079Kkh6r8/6/3BTqKYkhmfDCrfOA2Se0e/P8byeAXLPWiVt5L/nMZU54mCXCAb6\n' +
        'EAGiQ1fKI9neDqssKQoRZU2hAoGAZAPBTkAqAfA/NXzzQzdvvS6fCQ8TdBz9mLK0\n' +
        '9PUvuV77Y2kBAUd1rpQXpjJfk95su2XrnWtq3QDl3obtXuDB77h9gtM3bZXA7YW7\n' +
        'vAv/XA/6bfeOvone5WuvY5pj3J3q0CsYs78u06zwueIVMbcceLwIlSg2APrrWFZ5\n' +
        'n+MZFkECgYEAktubuJUDZ5FQyYLSn2AHNgks+2i/kcyvkv+haMRwUNM9aQSy3jk1\n' +
        '3WpWNpTnQklBI8G03tSvMVeYPDHYkdq0iG5K1+ZrH8ih6QH75VTOFSKmYc065L46\n' +
        'NLY65v6X8v/4y+/ZEXPrUlHMMyY2zOKtPfgJyVxR6DKTintFhdQk9+4=\n' +
        '-----END RSA PRIVATE KEY-----',
    cert: '-----BEGIN CERTIFICATE-----\n' +
        'MIIGQTCCBSmgAwIBAgIQIMDlb4DUpHe0StDu6V/UijANBgkqhkiG9w0BAQsFADCB\n' +
        'jzELMAkGA1UEBhMCR0IxGzAZBgNVBAgTEkdyZWF0ZXIgTWFuY2hlc3RlcjEQMA4G\n' +
        'A1UEBxMHU2FsZm9yZDEYMBYGA1UEChMPU2VjdGlnbyBMaW1pdGVkMTcwNQYDVQQD\n' +
        'Ey5TZWN0aWdvIFJTQSBEb21haW4gVmFsaWRhdGlvbiBTZWN1cmUgU2VydmVyIENB\n' +
        'MB4XDTIyMDYxNDAwMDAwMFoXDTIzMDYxNDIzNTk1OVowHDEaMBgGA1UEAxMRbWVu\n' +
        'YXBsYXRmb3Jtcy5jb20wggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDL\n' +
        'OBYpQpTYOTWG7R7oyVQQ9iIsoKowcOCQWIlhL/fx9NEJGYAfl7C6qSnBra/ZcQvN\n' +
        'Tc+J/bKTvY6gbJzSvXETXIHp7PxLXuphFOZY5mrgGRBhUtneGvlijHShgJyI6dgj\n' +
        'Q0Nc1p7+ZnuLGBCJzBUAFJIRxodoij305NfyLyhM8c4MZY9mp8hcGH6S/BIpgrGH\n' +
        'xj8zek+2nCpZ505yMf7jw94QH0Gz3Z002Py9nTCQgoTgzqE2UaDIPsRCrKOV4c35\n' +
        'jJHTnDFwfxxk96zS0LlyMKEXtXdLJgnmFtkBSSf8c4383nQjSk68ocZnFcXMPtdN\n' +
        'g2xpmTfjqOtTbVhN0Bm1AgMBAAGjggMJMIIDBTAfBgNVHSMEGDAWgBSNjF7EVK2K\n' +
        '4Xfpm/mbBeG4AY1h4TAdBgNVHQ4EFgQUPmip8D3C9JwsoZb97HygCkPlR4gwDgYD\n' +
        'VR0PAQH/BAQDAgWgMAwGA1UdEwEB/wQCMAAwHQYDVR0lBBYwFAYIKwYBBQUHAwEG\n' +
        'CCsGAQUFBwMCMEkGA1UdIARCMEAwNAYLKwYBBAGyMQECAgcwJTAjBggrBgEFBQcC\n' +
        'ARYXaHR0cHM6Ly9zZWN0aWdvLmNvbS9DUFMwCAYGZ4EMAQIBMIGEBggrBgEFBQcB\n' +
        'AQR4MHYwTwYIKwYBBQUHMAKGQ2h0dHA6Ly9jcnQuc2VjdGlnby5jb20vU2VjdGln\n' +
        'b1JTQURvbWFpblZhbGlkYXRpb25TZWN1cmVTZXJ2ZXJDQS5jcnQwIwYIKwYBBQUH\n' +
        'MAGGF2h0dHA6Ly9vY3NwLnNlY3RpZ28uY29tMDMGA1UdEQQsMCqCEW1lbmFwbGF0\n' +
        'Zm9ybXMuY29tghV3d3cubWVuYXBsYXRmb3Jtcy5jb20wggF9BgorBgEEAdZ5AgQC\n' +
        'BIIBbQSCAWkBZwB2AK33vvp8/xDIi509nB4+GGq0Zyldz7EMJMqFhjTr3IKKAAAB\n' +
        'gWJVANgAAAQDAEcwRQIhAICL9935qFutWMMV+vmIXex5gXUWjDChrV+DJZImhwQ+\n' +
        'AiB7IN+18vzHXOffVt1Sqp/HfvHn4T6TesFqy6vAdcbLnAB1AHoyjFTYty22IOo4\n' +
        '4FIe6YQWcDIThU070ivBOlejUutSAAABgWJVAKsAAAQDAEYwRAIgG26EUOeM+kqa\n' +
        '8I7MdYGatXVXQ7GXqM5e/uCxp618il4CIDmcW/WRbdFT3NrOUS6Mkxe1Q7BEXTVS\n' +
        'dK3OUz94P9apAHYA6D7Q2j71BjUy51covIlryQPTy9ERa+zraeF3fW0GvW4AAAGB\n' +
        'YlUAcgAABAMARzBFAiAk3k+BuUSHNeIZ/MNxo7yYpJBoYcf8lVVElZtn0XHV/QIh\n' +
        'ALyZshu+bOedrlF8lp0V0CadlgotmNx/Fi8BnwrCVb8uMA0GCSqGSIb3DQEBCwUA\n' +
        'A4IBAQABb7VKUxDd4cp3FdTmSJ0x0uuncfbmNCqaDAhdi8+PFOmBNtm35o1k1YUd\n' +
        'Gh2REmjAkGyt3YLs8s93x1iVNveHzNh+R/rB7MwKSN/8N5rThBJIRx0/g3bv3tO7\n' +
        '7jGibXIL3BmCMEtY7W/oolT/CoY/FNXGHXcUXfwd83qIg1I/pPBmZgdKAP07vuXd\n' +
        '7ygUzoFoC75FmE2fkh9+/BB7WstLh0pw62ccgniXsALaDbUPpYK8W9ZWfLNRFH8y\n' +
        'CaZKcNmzA14dmK+GshlOUQnyIe9SuqmKY9dm8MEtLiP6tkxcDP9MDsIttfi5lsEz\n' +
        'O6DoNB/tLTa1lljizxAk25dFozcs\n' +
        '-----END CERTIFICATE-----'
};
const https = require('https').Server(options, app);
const io = require('socket.io')(https);
const listner = https.listen(2053, function () {
    console.log('Listening on ', listner.address().port);
});

//allow only the specified domain to connect
// io.set('origins', 'https://menaplatforms.com:*');

require('./socket')(io);

app.get('/', function (req, res) {
    res.send('Ok2');
});

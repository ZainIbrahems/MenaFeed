<?php

use App\Models\BlogView;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;
use TCG\Voyager\Models\Translation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

function uploadToGoogleStorage(UploadedFile $file, $folder = null, $filename = null)
{
    try {
        $name = !is_null($filename) ? $filename : Str::random(25);

        return $file->storeAs(
            $folder,
            $name . "." . $file->getClientOriginalExtension(),
            'gcs'
        );
    } catch (\Exception $e) {
        return '';
    }
}
function getImageUrlFromBucket($bucket, $path)
{
    return "https://storage.googleapis.com/" . $bucket . "/" . $path;

}
function getFileURL($file)
{
    if ($file != null) {
        $file = json_decode($file);
        $v = new \TCG\Voyager\Voyager();
        if (sizeof($file) > 0) {
            return $v->image($file[0]->download_link);
        } else {
            return '';
        }
    }
    return '';
}

function getFilePath($file)
{
    if ($file != null) {
        $file = json_decode($file);
        $v = new \TCG\Voyager\Voyager();
        if (sizeof($file) > 0) {
            return public_path('storage\\' . $file[0]->download_link);
        } else {
            return '';
        }
    }
    return '';
}

function getFilePathSvg($file)
{
    if ($file != null) {
        $file = json_decode($file);
        $v = new \TCG\Voyager\Voyager();
        if (sizeof($file) > 0) {
            return $file[0]->download_link;
        } else {
            return '';
        }
    }
    return '';
}

function getFileName($file)
{
    if ($file != null) {
        $file = json_decode($file);
        if (sizeof($file) > 0) {
            return $file[0]->original_name;
        } else {
            return '';
        }
    }
    return '';
}

function getImageURL($image)
{
    $v = new \TCG\Voyager\Voyager();
    if ($image != null && Storage::disk('public')->exists($image)) {
        return $v->image($image);
    } else {
        return asset('logo.png');
    }

}

function SateColor($id)
{
    switch ($id) {
        case 1:
            return "#4CAF50";
        case 2:
            return "#FF9800";
        case 3:
            return "#E91E63";
        case 4:
            return "#ff002d";
        default:
            return "";
    }

}

function PaymentColor($id)
{
    switch ($id) {
        case 1:
            return "#4CAF50";
        case 2:
            return "#FF9800";
        case 3:
            return "#ff002d";
        case 4:
            return "#3F51B5";
        default:
            return "";
    }

}

function isAdmin()
{
    if (auth('web')->check() && (auth('web')->user()->role_id == 1 || auth('web')->user()->role_id == 2)) {
        return true;
    }
    return false;
}

function isSuperAdmin()
{
    if (auth('web')->check() && auth('web')->user()->role_id == 1) {
        return true;
    }
    return false;
}

function getRoleID($name)
{
    $role = \App\Models\Role::where('name', $name)->first();
    return $role ? $role->id : NULL;
}

function getRoleName($id)
{
    $role = \App\Models\Role::where('id', $id)->first();
    return $role ? $role->name : '';
}

function getThumbnail($model, $image, $size = 'm')
{
    if ($model) {
        switch ($size) {
            case 's':
                $size = 'small';
                break;
            case 'm':
                $size = 'medium';
                break;
            case 'l':
                $size = 'large';
                break;
            case 'c':
                $size = 'cropped';
                break;
        }
        return $model->thumbnail($size, $image);
    }
    return $model->{$image};
}

/*
 * Image
 */

function is_image($image)
{
    if (str_contains($image, 'png') || str_contains($image, 'jpg') || str_contains($image, 'jpeg') || str_contains($image, 'webp')) {
        return true;
    }
    return false;
}

function upload($dir, $format, $image = null)
{
    if ($image != null) {
        $imageName = Carbon::now()->toDateString() . "/" . uniqid() . "." . $format;
        if (!Storage::disk('public')->exists($dir)) {
            Storage::disk('public')->makeDirectory($dir);
        }
        Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
    } else {
        $imageName = 'def.png';
    }

    return $dir . $imageName;
}

function update($dir, $old_image, $format, $image = null)
{
    if (Storage::disk('public')->exists($dir . $old_image)) {
        Storage::disk('public')->delete($dir . $old_image);
    }
    $imageName = upload($dir, $format, $image);
    return $imageName;
}

#[ArrayShape(['success' => "int", 'message' => "string"])] function delete($full_path)
{
    if (Storage::disk('public')->exists($full_path)) {
        Storage::disk('public')->delete($full_path);
    }

    return [
        'success' => 1,
        'message' => 'Removed successfully !'
    ];
}

function slugify($text, $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function generateRandomCode($length = 6)
{
    $code = rand(100000, 999999);
    return $code;
}

function send_push_notif_to_topic($title, $body, $data)
{
    $key = config('app.push_notification_key');

    $url = "https://fcm.googleapis.com/fcm/send";
    $header = [
        "authorization: key=" . $key . "",
        "content-type: application/json",
    ];

    $image = asset('logo.png');
    $str = '';
    if (is_array($data) && sizeof($data) > 0) {
        foreach ($data as $key => $value) {
            $str .= '"' . $key . '" : "' . $value . '",';
        }
    }
    $postdata = '{
            "to" : "/topics/blood_request",
            "data" : {
                "title":"' . $title . '",
                "body" : "' . $body . '",
                "image" : "' . $image . '",
                "icon" : "' . $image . '",
                ' . $str . '
                "is_read": 0
              },
              "notification" : {
                "title":"' . $title . '",
                "body" : "' . $body . '",
                ' . $str . '
                "is_read": 0,
                "icon" : "new",
                "sound" : "default"
              }
        }';

    return $postdata;


    $ch = curl_init();
    $timeout = 120;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    // Get URL content
    $result = curl_exec($ch);
    // close handle to release resources
    curl_close($ch);

    return $result;
}

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

function getTimeZones()
{
    $times = array(
        'Asia/Kabul' => 'Afghanistan',
        'Europe/Tirane' => 'Albania',
        'Africa/Algiers' => 'Algeria',
        'Pacific/Pago_Pago' => 'American Samoa',
        'Europe/Andorra' => 'Andorra',
        'Africa/Luanda' => 'Angola',
        'America/Anguilla' => 'Anguilla',
        'Antarctica/Casey' => 'Antarctica',
        'Antarctica/Davis' => 'Antarctica',
        'Antarctica/DumontDUrville' => 'Antarctica',
        'Antarctica/Mawson' => 'Antarctica',
        'Antarctica/McMurdo' => 'Antarctica',
        'Antarctica/Palmer' => 'Antarctica',
        'Antarctica/Rothera' => 'Antarctica',
        'Antarctica/Syowa' => 'Antarctica',
        'Antarctica/Troll' => 'Antarctica',
        'Antarctica/Vostok' => 'Antarctica',
        'America/Antigua' => 'Antigua and Barbuda',
        'America/Argentina/Buenos_Aires' => 'Argentina',
        'America/Argentina/Catamarca' => 'Argentina',
        'America/Argentina/Cordoba' => 'Argentina',
        'America/Argentina/Jujuy' => 'Argentina',
        'America/Argentina/La_Rioja' => 'Argentina',
        'America/Argentina/Mendoza' => 'Argentina',
        'America/Argentina/Rio_Gallegos' => 'Argentina',
        'America/Argentina/Salta' => 'Argentina',
        'America/Argentina/San_Juan' => 'Argentina',
        'America/Argentina/San_Luis' => 'Argentina',
        'America/Argentina/Tucuman' => 'Argentina',
        'America/Argentina/Ushuaia' => 'Argentina',
        'Asia/Yerevan' => 'Armenia',
        'America/Aruba' => 'Aruba',
        'Antarctica/Macquarie' => 'Australia',
        'Australia/Adelaide' => 'Australia',
        'Australia/Brisbane' => 'Australia',
        'Australia/Broken_Hill' => 'Australia',
        'Australia/Darwin' => 'Australia',
        'Australia/Eucla' => 'Australia',
        'Australia/Hobart' => 'Australia',
        'Australia/Lindeman' => 'Australia',
        'Australia/Lord_Howe' => 'Australia',
        'Australia/Melbourne' => 'Australia',
        'Australia/Perth' => 'Australia',
        'Australia/Sydney' => 'Australia',
        'Europe/Vienna' => 'Austria',
        'Asia/Baku' => 'Azerbaijan',
        'America/Nassau' => 'Bahamas',
        'Asia/Bahrain' => 'Bahrain',
        'Asia/Dhaka' => 'Bangladesh',
        'America/Barbados' => 'Barbados',
        'Europe/Minsk' => 'Belarus',
        'Europe/Brussels' => 'Belgium',
        'America/Belize' => 'Belize',
        'Africa/Porto-Novo' => 'Benin',
        'Atlantic/Bermuda' => 'Bermuda',
        'Asia/Thimphu' => 'Bhutan',
        'Plurinational State of' => 'Bolivia',
        'Sint Eustatius and Saba' => 'Bonaire',
        'Europe/Sarajevo' => 'Bosnia and Herzegovina',
        'Africa/Gaborone' => 'Botswana',
        'America/Araguaina' => 'Brazil',
        'America/Bahia' => 'Brazil',
        'America/Belem' => 'Brazil',
        'America/Boa_Vista' => 'Brazil',
        'America/Campo_Grande' => 'Brazil',
        'America/Cuiaba' => 'Brazil',
        'America/Eirunepe' => 'Brazil',
        'America/Fortaleza' => 'Brazil',
        'America/Maceio' => 'Brazil',
        'America/Manaus' => 'Brazil',
        'America/Noronha' => 'Brazil',
        'America/Porto_Velho' => 'Brazil',
        'America/Recife' => 'Brazil',
        'America/Rio_Branco' => 'Brazil',
        'America/Santarem' => 'Brazil',
        'America/Sao_Paulo' => 'Brazil',
        'Indian/Chagos' => 'British Indian Ocean Territory',
        'Asia/Brunei' => 'Brunei Darussalam',
        'Europe/Sofia' => 'Bulgaria',
        'Africa/Ouagadougou' => 'Burkina Faso',
        'Africa/Bujumbura' => 'Burundi',
        'Asia/Phnom_Penh' => 'Cambodia',
        'Africa/Douala' => 'Cameroon',
        'America/Atikokan' => 'Canada',
        'America/Blanc-Sablon' => 'Canada',
        'America/Cambridge_Bay' => 'Canada',
        'America/Creston' => 'Canada',
        'America/Dawson' => 'Canada',
        'America/Dawson_Creek' => 'Canada',
        'America/Edmonton' => 'Canada',
        'America/Fort_Nelson' => 'Canada',
        'America/Glace_Bay' => 'Canada',
        'America/Goose_Bay' => 'Canada',
        'America/Halifax' => 'Canada',
        'America/Inuvik' => 'Canada',
        'America/Iqaluit' => 'Canada',
        'America/Moncton' => 'Canada',
        'America/Nipigon' => 'Canada',
        'America/Pangnirtung' => 'Canada',
        'America/Rainy_River' => 'Canada',
        'America/Rankin_Inlet' => 'Canada',
        'America/Regina' => 'Canada',
        'America/Resolute' => 'Canada',
        'America/St_Johns' => 'Canada',
        'America/Swift_Current' => 'Canada',
        'America/Thunder_Bay' => 'Canada',
        'America/Toronto' => 'Canada',
        'America/Vancouver' => 'Canada',
        'America/Whitehorse' => 'Canada',
        'America/Winnipeg' => 'Canada',
        'America/Yellowknife' => 'Canada',
        'Atlantic/Cape_Verde' => 'Cape Verde',
        'America/Cayman' => 'Cayman Islands',
        'Africa/Bangui' => 'Central African Republic',
        'Africa/Ndjamena' => 'Chad',
        'America/Punta_Arenas' => 'Chile',
        'America/Santiago' => 'Chile',
        'Pacific/Easter' => 'Chile',
        'Asia/Shanghai' => 'China',
        'Asia/Urumqi' => 'China',
        'Indian/Christmas' => 'Christmas Island',
        'Indian/Cocos' => 'Cocos (Keeling) Islands',
        'America/Bogota' => 'Colombia',
        'Indian/Comoro' => 'Comoros',
        'Pacific/Rarotonga' => 'Cook Islands',
        'America/Costa_Rica' => 'Costa Rica',
        'Europe/Zagreb' => 'Croatia',
        'America/Havana' => 'Cuba',
        'America/Curacao' => 'Curaçao',
        'Asia/Famagusta' => 'Cyprus',
        'Asia/Nicosia' => 'Cyprus',
        'Europe/Prague' => 'Czech Republic',
        'Africa/Abidjan' => 'Côte d Ivoire',
        'Europe/Copenhagen' => 'Denmark',
        'Africa/Djibouti' => 'Djibouti',
        'America/Dominica' => 'Dominica',
        'America/Santo_Domingo' => 'Dominican Republic',
        'America/Guayaquil' => 'Ecuador',
        'Pacific/Galapagos' => 'Ecuador',
        'Africa/Cairo' => 'Egypt',
        'America/El_Salvador' => 'El Salvador',
        'Africa/Malabo' => 'Equatorial Guinea',
        'Africa/Asmara' => 'Eritrea',
        'Europe/Tallinn' => 'Estonia',
        'Africa/Addis_Ababa' => 'Ethiopia',
        'Atlantic/Stanley' => 'Falkland Islands (Malvinas)',
        'Atlantic/Faroe' => 'Faroe Islands',
        'Pacific/Fiji' => 'Fiji',
        'Europe/Helsinki' => 'Finland',
        'Europe/Paris' => 'France',
        'America/Cayenne' => 'French Guiana',
        'Pacific/Gambier' => 'French Polynesia',
        'Pacific/Marquesas' => 'French Polynesia',
        'Pacific/Tahiti' => 'French Polynesia',
        'Indian/Kerguelen' => 'French Southern Territories',
        'Africa/Libreville' => 'Gabon',
        'Africa/Banjul' => 'Gambia',
        'Asia/Tbilisi' => 'Georgia',
        'Europe/Berlin' => 'Germany',
        'Europe/Busingen' => 'Germany',
        'Africa/Accra' => 'Ghana',
        'Europe/Gibraltar' => 'Gibraltar',
        'Europe/Athens' => 'Greece',
        'America/Danmarkshavn' => 'Greenland',
        'America/Nuuk' => 'Greenland',
        'America/Scoresbysund' => 'Greenland',
        'America/Thule' => 'Greenland',
        'America/Grenada' => 'Grenada',
        'America/Guadeloupe' => 'Guadeloupe',
        'Pacific/Guam' => 'Guam',
        'America/Guatemala' => 'Guatemala',
        'Europe/Guernsey' => 'Guernsey',
        'Africa/Conakry' => 'Guinea',
        'Africa/Bissau' => 'Guinea-Bissau',
        'America/Guyana' => 'Guyana',
        'America/Port-au-Prince' => 'Haiti',
        'Europe/Vatican' => 'Holy See (Vatican City State)',
        'America/Tegucigalpa' => 'Honduras',
        'Asia/Hong_Kong' => 'Hong Kong',
        'Europe/Budapest' => 'Hungary',
        'Atlantic/Reykjavik' => 'Iceland',
        'Asia/Kolkata' => 'India',
        'Asia/Jakarta' => 'Indonesia',
        'Asia/Jayapura' => 'Indonesia',
        'Asia/Makassar' => 'Indonesia',
        'Asia/Pontianak' => 'Indonesia',
        'Islamic Republic of' => 'Iran',
        'Asia/Baghdad' => 'Iraq',
        'Europe/Dublin' => 'Ireland',
        'Europe/Isle_of_Man' => 'Isle of Man',
        'Asia/Jerusalem' => 'Israel',
        'Europe/Rome' => 'Italy',
        'America/Jamaica' => 'Jamaica',
        'Asia/Tokyo' => 'Japan',
        'Europe/Jersey' => 'Jersey',
        'Asia/Amman' => 'Jordan',
        'Asia/Almaty' => 'Kazakhstan',
        'Asia/Aqtau' => 'Kazakhstan',
        'Asia/Aqtobe' => 'Kazakhstan',
        'Asia/Atyrau' => 'Kazakhstan',
        'Asia/Oral' => 'Kazakhstan',
        'Asia/Qostanay' => 'Kazakhstan',
        'Asia/Qyzylorda' => 'Kazakhstan',
        'Africa/Nairobi' => 'Kenya',
        'Pacific/Kanton' => 'Kiribati',
        'Pacific/Kiritimati' => 'Kiribati',
        'Pacific/Tarawa' => 'Kiribati',
        'Democratic Peoples Republic of' => 'Korea',
        'Asia/Kuwait' => 'Kuwait',
        'Asia/Bishkek' => 'Kyrgyzstan',
        'Asia/Vientiane' => 'Lao Peoples Democratic Republic',
        'Europe/Riga' => 'Latvia',
        'Asia/Beirut' => 'Lebanon',
        'Africa/Maseru' => 'Lesotho',
        'Africa/Monrovia' => 'Liberia',
        'Africa/Tripoli' => 'Libya',
        'Europe/Vaduz' => 'Liechtenstein',
        'Europe/Vilnius' => 'Lithuania',
        'Europe/Luxembourg' => 'Luxembourg',
        'Asia/Macau' => 'Macao',
        'the Former Yugoslav Republic of' => 'Macedonia',
        'Indian/Antananarivo' => 'Madagascar',
        'Africa/Blantyre' => 'Malawi',
        'Asia/Kuala_Lumpur' => 'Malaysia',
        'Asia/Kuching' => 'Malaysia',
        'Indian/Maldives' => 'Maldives',
        'Africa/Bamako' => 'Mali',
        'Europe/Malta' => 'Malta',
        'Pacific/Kwajalein' => 'Marshall Islands',
        'Pacific/Majuro' => 'Marshall Islands',
        'America/Martinique' => 'Martinique',
        'Africa/Nouakchott' => 'Mauritania',
        'Indian/Mauritius' => 'Mauritius',
        'Indian/Mayotte' => 'Mayotte',
        'America/Bahia_Banderas' => 'Mexico',
        'America/Cancun' => 'Mexico',
        'America/Chihuahua' => 'Mexico',
        'America/Hermosillo' => 'Mexico',
        'America/Matamoros' => 'Mexico',
        'America/Mazatlan' => 'Mexico',
        'America/Merida' => 'Mexico',
        'America/Mexico_City' => 'Mexico',
        'America/Monterrey' => 'Mexico',
        'America/Ojinaga' => 'Mexico',
        'America/Tijuana' => 'Mexico',
        'Europe/Monaco' => 'Monaco',
        'Asia/Choibalsan' => 'Mongolia',
        'Asia/Hovd' => 'Mongolia',
        'Asia/Ulaanbaatar' => 'Mongolia',
        'Europe/Podgorica' => 'Montenegro',
        'America/Montserrat' => 'Montserrat',
        'Africa/Casablanca' => 'Morocco',
        'Africa/Maputo' => 'Mozambique',
        'Asia/Yangon' => 'Myanmar',
        'Africa/Windhoek' => 'Namibia',
        'Pacific/Nauru' => 'Nauru',
        'Asia/Kathmandu' => 'Nepal',
        'Europe/Amsterdam' => 'Netherlands',
        'Pacific/Noumea' => 'New Caledonia',
        'Pacific/Auckland' => 'New Zealand',
        'Pacific/Chatham' => 'New Zealand',
        'America/Managua' => 'Nicaragua',
        'Africa/Niamey' => 'Niger',
        'Africa/Lagos' => 'Nigeria',
        'Pacific/Niue' => 'Niue',
        'Pacific/Norfolk' => 'Norfolk Island',
        'Pacific/Saipan' => 'Northern Mariana Islands',
        'Europe/Oslo' => 'Norway',
        'Asia/Muscat' => 'Oman',
        'Asia/Karachi' => 'Pakistan',
        'Pacific/Palau' => 'Palau',
        'America/Panama' => 'Panama',
        'Pacific/Bougainville' => 'Papua New Guinea',
        'Pacific/Port_Moresby' => 'Papua New Guinea',
        'America/Asuncion' => 'Paraguay',
        'America/Lima' => 'Peru',
        'Asia/Manila' => 'Philippines',
        'Pacific/Pitcairn' => 'Pitcairn',
        'Europe/Warsaw' => 'Poland',
        'Atlantic/Azores' => 'Portugal',
        'Atlantic/Madeira' => 'Portugal',
        'Europe/Lisbon' => 'Portugal',
        'America/Puerto_Rico' => 'Puerto Rico',
        'Asia/Qatar' => 'Qatar',
        'Europe/Bucharest' => 'Romania',
        'Asia/Anadyr' => 'Russian Federation',
        'Asia/Barnaul' => 'Russian Federation',
        'Asia/Chita' => 'Russian Federation',
        'Asia/Irkutsk' => 'Russian Federation',
        'Asia/Kamchatka' => 'Russian Federation',
        'Asia/Khandyga' => 'Russian Federation',
        'Asia/Krasnoyarsk' => 'Russian Federation',
        'Asia/Magadan' => 'Russian Federation',
        'Asia/Novokuznetsk' => 'Russian Federation',
        'Asia/Novosibirsk' => 'Russian Federation',
        'Asia/Omsk' => 'Russian Federation',
        'Asia/Sakhalin' => 'Russian Federation',
        'Asia/Srednekolymsk' => 'Russian Federation',
        'Asia/Tomsk' => 'Russian Federation',
        'Asia/Ust-Nera' => 'Russian Federation',
        'Asia/Vladivostok' => 'Russian Federation',
        'Asia/Yakutsk' => 'Russian Federation',
        'Asia/Yekaterinburg' => 'Russian Federation',
        'Europe/Astrakhan' => 'Russian Federation',
        'Europe/Kaliningrad' => 'Russian Federation',
        'Europe/Kirov' => 'Russian Federation',
        'Europe/Moscow' => 'Russian Federation',
        'Europe/Samara' => 'Russian Federation',
        'Europe/Saratov' => 'Russian Federation',
        'Europe/Ulyanovsk' => 'Russian Federation',
        'Europe/Volgograd' => 'Russian Federation',
        'Africa/Kigali' => 'Rwanda',
        'Indian/Reunion' => 'Réunion',
        'America/St_Barthelemy' => 'Saint Barthélemy',
        'Ascension and Tristan da Cunha' => 'Saint Helena',
        'America/St_Kitts' => 'Saint Kitts and Nevis',
        'America/St_Lucia' => 'Saint Lucia',
        'America/Marigot' => 'Saint Martin (French part)',
        'America/Miquelon' => 'Saint Pierre and Miquelon',
        'America/St_Vincent' => 'Saint Vincent and the Grenadines',
        'Pacific/Apia' => 'Samoa',
        'Europe/San_Marino' => 'San Marino',
        'Africa/Sao_Tome' => 'Sao Tome and Principe',
        'Asia/Riyadh' => 'Saudi Arabia',
        'Africa/Dakar' => 'Senegal',
        'Europe/Belgrade' => 'Serbia',
        'Indian/Mahe' => 'Seychelles',
        'Africa/Freetown' => 'Sierra Leone',
        'Asia/Singapore' => 'Singapore',
        'America/Lower_Princes' => 'Sint Maarten (Dutch part)',
        'Europe/Bratislava' => 'Slovakia',
        'Europe/Ljubljana' => 'Slovenia',
        'Pacific/Guadalcanal' => 'Solomon Islands',
        'Africa/Mogadishu' => 'Somalia',
        'Africa/Johannesburg' => 'South Africa',
        'Atlantic/South_Georgia' => 'South Georgia and the South Sandwich Islands',
        'Africa/Juba' => 'South Sudan',
        'Africa/Ceuta' => 'Spain',
        'Atlantic/Canary' => 'Spain',
        'Europe/Madrid' => 'Spain',
        'Asia/Colombo' => 'Sri Lanka',
        'Africa/Khartoum' => 'Sudan',
        'America/Paramaribo' => 'Suriname',
        'Arctic/Longyearbyen' => 'Svalbard and Jan Mayen',
        'Africa/Mbabane' => 'Swaziland',
        'Europe/Stockholm' => 'Sweden',
        'Europe/Zurich' => 'Switzerland',
        'Asia/Damascus' => 'Syrian Arab Republic',
        'Province of China' => 'Taiwan',
        'Asia/Dushanbe' => 'Tajikistan',
        'United Republic of' => 'Tanzania',
        'Asia/Bangkok' => 'Thailand',
        'Asia/Dili' => 'Timor-Leste',
        'Africa/Lome' => 'Togo',
        'Pacific/Fakaofo' => 'Tokelau',
        'Pacific/Tongatapu' => 'Tonga',
        'America/Port_of_Spain' => 'Trinidad and Tobago',
        'Africa/Tunis' => 'Tunisia',
        'Europe/Istanbul' => 'Turkey',
        'Asia/Ashgabat' => 'Turkmenistan',
        'America/Grand_Turk' => 'Turks and Caicos Islands',
        'Pacific/Funafuti' => 'Tuvalu',
        'Africa/Kampala' => 'Uganda',
        'Europe/Kiev' => 'Ukraine',
        'Europe/Simferopol' => 'Ukraine',
        'Europe/Uzhgorod' => 'Ukraine',
        'Europe/Zaporozhye' => 'Ukraine',
        'Asia/Dubai' => 'United Arab Emirates',
        'Europe/London' => 'United Kingdom',
        'America/Adak' => 'United States',
        'America/Anchorage' => 'United States',
        'America/Boise' => 'United States',
        'America/Chicago' => 'United States',
        'America/Denver' => 'United States',
        'America/Detroit' => 'United States',
        'America/Indiana/Indianapolis' => 'United States',
        'America/Indiana/Knox' => 'United States',
        'America/Indiana/Marengo' => 'United States',
        'America/Indiana/Petersburg' => 'United States',
        'America/Indiana/Tell_City' => 'United States',
        'America/Indiana/Vevay' => 'United States',
        'America/Indiana/Vincennes' => 'United States',
        'America/Indiana/Winamac' => 'United States',
        'America/Juneau' => 'United States',
        'America/Kentucky/Louisville' => 'United States',
        'America/Kentucky/Monticello' => 'United States',
        'America/Los_Angeles' => 'United States',
        'America/Menominee' => 'United States',
        'America/Metlakatla' => 'United States',
        'America/New_York' => 'United States',
        'America/Nome' => 'United States',
        'America/North_Dakota/Beulah' => 'United States',
        'America/North_Dakota/Center' => 'United States',
        'America/North_Dakota/New_Salem' => 'United States',
        'America/Phoenix' => 'United States',
        'America/Sitka' => 'United States',
        'America/Yakutat' => 'United States',
        'Pacific/Honolulu' => 'United States',
        'Pacific/Midway' => 'United States Minor Outlying Islands',
        'Pacific/Wake' => 'United States Minor Outlying Islands',
        'America/Montevideo' => 'Uruguay',
        'Asia/Samarkand' => 'Uzbekistan',
        'Asia/Tashkent' => 'Uzbekistan',
        'Pacific/Efate' => 'Vanuatu',
        'Bolivarian Republic of' => 'Venezuela',
        'Asia/Ho_Chi_Minh' => 'Viet Nam',
        'British' => 'Virgin Islands',
        'U.S.' => 'Virgin Islands',
        'Pacific/Wallis' => 'Wallis and Futuna',
        'Africa/El_Aaiun' => 'Western Sahara',
        'Asia/Aden' => 'Yemen',
        'Africa/Lusaka' => 'Zambia',
        'Africa/Harare' => 'Zimbabwe',
        'Europe/Mariehamn' => 'Åland Islands'
    );
    $times2 = [];
    foreach ($times as $t => $v) {
        $times2[] = [
            'id' => $t,
            'title' => $v
        ];
    }
    return $times2;
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function checkUserDataCompletedPercent($fields, $user)
{
    $total = sizeof($fields);
    $completed = 0;

    foreach ($fields as $field) {
        $field = json_decode(json_encode($field));
        $completed_at = $field->updated_at;
        if ($field->value != NULL) {
            $completed++;
        }
    }

    return $total > 0 ? round(($completed * 100 / $total), 2) : 0;
}

function checkUserDataCompleted($fields, $user)
{

    $completed = true;
    $completed_at = NULL;

    foreach ($fields as $field) {
        $field = json_decode(json_encode($field));
        $completed_at = $field->updated_at;
        if ($field->value == NULL) {
            $completed = false;
            $completed_at = NULL;
            break;
        }
    }

    return [
        'completed' => $completed,
        'completed_at' => $completed_at
    ];
}

function getUserName($id, $type)
{
    $chat = \App\Models\Chat::where('id', $id)->first();
    if ($type == 'From') {
        if ($chat->from_type == 'client') {
            $user = \App\Models\Client::where('id', $chat->from_id)->first();
        } else {
            $user = \App\Models\Provider::where('id', $chat->from_id)->first();
        }
    } else {
        if ($chat->from_type == 'client') {
            $user = \App\Models\Client::where('id', $chat->to_id)->first();
        } else {
            $user = \App\Models\Provider::where('id', $chat->to_id)->first();
        }
    }

    if ($user) {
        return $user->full_name;
    } else {
        return '';
    }
}

function getChatReportUserName($id, $type)
{
    $chat = \App\Models\ChatsReport::where('id', $id)->first();
    if ($chat->report_type == 'client') {
        $user = \App\Models\Client::where('id', $chat->report_from)->first();
    } else {
        $user = \App\Models\Provider::where('id', $chat->report_from)->first();
    }

    if ($user) {
        return $user->full_name;
    } else {
        return '';
    }
}

function getFeedReportUserName($id)
{
    $report = \App\Models\ProviderFeedReport::where('id', $id)->first();
    $user = '';
    if ($report->user_type == 'client') {
        $user = \App\Models\Client::where('id', $report->user_id)->first();
    } else {
        $report = \App\Models\Provider::where('id', $report->user_id)->first();
    }

    if ($user) {
        return $user->full_name;
    } else {
        return '';
    }
}

//
//function getVideoThumb($movie)
//{
//
//    $name = 'thumbnail'.time().'.png';
//
//    $ffmpeg = FFMpeg\FFMpeg::create();
//    $video = $ffmpeg->open($movie);
//    $video
//        ->filters()
//        ->synchronize();
//    return public_path('storage\\thumbnail\\'.$name);
//    $video
//        ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))
//        ->save(public_path('storage\\thumbnail\\'.$name));
//    return $video;
//}

function twopoints_on_earth(
    $latitudeFrom,
    $longitudeFrom,
    $latitudeTo,
    $longitudeTo
) {
    $long1 = deg2rad($longitudeFrom);
    $long2 = deg2rad($longitudeTo);
    $lat1 = deg2rad($latitudeFrom);
    $lat2 = deg2rad($latitudeTo);

    //Haversine Formula
    $dlong = $long2 - $long1;
    $dlati = $lat2 - $lat1;

    $val = pow(sin($dlati / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($dlong / 2), 2);

    $res = 2 * asin(sqrt($val));

    $radius = 3958.756;

    return round(($res * $radius) * 1.60934, 2);
}


function getProviderNearBy($request)
{

    $latitude = $request->header('lat') ? $request->header('lat') : '25.2048';
    $longitude = $request->header('lat') ? $request->header('lng') : '55.2708';
    $distance = 100000000;
    $providers = \App\Models\Provider::select('providers.*')->distinct()->
        join('providers_specialities', 'providers_specialities.provider_id', '=', 'providers.id')->
        where('providers.status', 1);

    //    $providers = $providers->whereRaw(DB::raw("(6371 * acos( cos( radians($latitude) )
//                     * cos( radians( ST_Y(location) ) )
//                     * cos( radians( ST_X(location) ) - radians($longitude) )
//                     + sin( radians($latitude) )
//                     * sin( radians( ST_Y(location) ) ) ) ) < $distance "));


    if (
        $request->has('sub_sub_category') &&
        is_numeric($request->get('sub_sub_category')) &&
        $request->get('sub_sub_category') > 0
    ) {
        $providers = $providers->whereIn('providers_specialities.platform_sub_sub_category_id', [$request->get('sub_sub_category')]);
    } elseif (
        $request->has('sub_category') &&
        is_numeric($request->get('sub_category')) &&
        $request->get('sub_category') > 0
    ) {
        $providers_id = \App\Models\ProviderSpecialityGroup::where('platform_sub_category_id', $request->get('sub_category'))->pluck('provider_id');
        $providers = $providers->whereIn('providers.id', $providers_id);
    } elseif (
        $request->has('category') &&
        is_numeric($request->get('category')) &&
        $request->get('category') > 0
    ) {
        $providers = $providers->whereIn('platform_category', [$request->get('category')]);
    }

    $providers = $providers->take(10)->get();
    $providers = \App\Resources\ProviderNearby::collection($providers);
    return $providers;
}

function getProviderNearByHomeSection($request, $home_section)
{

    $latitude = $request->header('lat') ? $request->header('lat') : '25.2048';
    $longitude = $request->header('lat') ? $request->header('lng') : '55.2708';
    $distance = 100;
    $providers = \App\Models\Provider::select('providers.*')->distinct()->
        join('providers_specialities', 'providers_specialities.provider_id', '=', 'providers.id')->
        where('providers.status', 1);

    $category = \App\Models\PlatformCategoryHomeSection::where('home_section_id', $home_section->id)->pluck('platform_category_id');

    $providers = $providers->whereRaw(DB::raw("(6371 * acos( cos( radians($latitude) )
                     * cos( radians( ST_Y(location) ) )
                     * cos( radians( ST_X(location) ) - radians($longitude) )
                     + sin( radians($latitude) )
                     * sin( radians( ST_Y(location) ) ) ) ) < $distance "));

    $providers = $providers->whereIn('platform_category', $category);

    $providers = $providers->take(10)->get();
    $providers = \App\Resources\ProviderNearby::collection($providers);
    return $providers;
}

function getProviderNearByLiveStream($request)
{

    $latitude = $request->header('lat') ? $request->header('lat') : '25.2048';
    $longitude = $request->header('lat') ? $request->header('lng') : '55.2708';
    $distance = 100;
    $providers = \App\Models\Provider::select('providers.*', 'lives.id', 'lives.code')->distinct()->
        join('lives', 'lives.added_by', '=', 'providers.id')->
        where('lives.status', 1)->
        where('providers.status', 1);

    //    $lives = \App\Models\Livestream::orderBy('created_at','desc')->pluck('added_by');

    $providers = $providers->
        whereRaw(DB::raw("(6371 * acos( cos( radians($latitude) )
                     * cos( radians( ST_Y(location) ) )
                     * cos( radians( ST_X(location) ) - radians($longitude) )
                     + sin( radians($latitude) )
                     * sin( radians( ST_Y(location) ) ) ) ) < $distance "));

    //    $providers = $providers->where('lives.status', 'on_live');
//    $providers = $providers->whereIn('providers.id', $lives);

    $providers = $providers->take(10)->orderBy('lives.id', 'desc')->get();
    $providers = \App\Resources\ProviderLive::collection($providers);
    return $providers;
}

function getProviderDistance($request, $location)
{
    $lat = $location && !is_null($location->y) ? $location->y : '25.2048';
    $lng = $location && !is_null($location->x) ? $location->x : '55.2708';
    $distance = ' -- km';
    if ($request->has('lat') && $request->has('lng')) {
        $distance = twopoints_on_earth($lat, $lng, $request->get('lat'), $request->get('lng')) . ' km';
    } elseif ($request->header('lat') && $request->header('lng')) {
        $distance = twopoints_on_earth($lat, $lng, $request->header('lat'), $request->header('lng')) . ' km';
    }
    return $distance;
}

function getUserType()
{

    return auth('sanctum')->user()->type_str;
    //    $from_type = 'client';
//    if (auth('sanctum')->user()->registration_number) {
//        $from_type = 'provider';
//    }
//    return $from_type;
}


function updateTranslation($table_name, $array, $field_name, $id)
{
    foreach ($array as $key => $value) {
        if ($key != 'en') {
            Translation::updateOrCreate([
                'table_name' => $table_name,
                'column_name' => $field_name,
                'foreign_key' => $id,
                'locale' => $key,
            ], [
                'value' => $value
            ]);
        } else {
            DB::table($table_name)->where('id', $id)->update([
                $field_name => $value
            ]);
        }
    }
}


function checkSlots($days, $time_from, $time_to, $provider_id)
{
    foreach ($days as $d) {
        foreach ($time_from as $key => $tf) {
            $slot = \App\Models\AppointmentSlot::
                join('appointment_slots_days', 'appointment_slots_days.slot_id', '=', 'appointment_slots.id')->
                join('appointment_slots_times', 'appointment_slots_times.slot_id', '=', 'appointment_slots.id')->
                where('appointment_slots_days.day', '=', $d)->
                whereTime('appointment_slots_times.from_time', '>=', $tf)->
                whereTime('appointment_slots_times.to_time', '<=', $time_to[$key])->
                where('appointment_slots.provider_id', '=', $provider_id)->first();
            if ($slot) {
                return [
                    'status' => false,
                    'd' => $d,
                    'tf' => $tf,
                    'tt' => $time_to[$key]
                ];
            }
        }
    }

    return [
        'status' => true
    ];
}


function getSlots($data)
{
    $times_response = [];
    foreach ($data as $d) {
        $slot = \App\Resources\AppointmentSlot::make($d);
        $times = \App\Models\AppointmentSlotTimes::where('slot_id', $d->id)->get();
        $days = json_decode(\App\Models\AppointmentSlotDays::where('slot_id', $d->id)->pluck('day'));
        for ($i = 0; $i < 30; $i++) {
            $day_index = Carbon::now()->endOfWeek(Carbon::FRIDAY)->addDays($i)->format('w');
            if (in_array($day_index, $days)) {
                $times_response[Carbon::now()->endOfWeek(Carbon::FRIDAY)->addDays($i)->toDateTimeLocalString()] = [];
            }
        }
        foreach ($times_response as $key => $ts) {
            $half_times = [];
            foreach ($times as $time) {
                $from_time = $time->from_time;
                $to_time = $time->to_time;
                $minutes = Carbon::parse($from_time)->diffInMinutes($to_time);
                for ($j = 0; $j < $minutes; $j = $j + 30) {
                    $half_times[] = Carbon::parse($from_time)->addMinutes($j + 30)->toDateTimeLocalString();
                }
            }
            foreach ($half_times as $ht) {
                $times_response[$key][] = [
                    'slot_id' => $slot->id,
                    'fees' => (double) $slot->fees,
                    'time' => $ht
                ];
            }
        }
    }


    //    $t = explode(' ', Carbon::parse($d->date_time)->toDateTimeString());
//    if (sizeof($t) >= 2) {
//        $times[Carbon::parse($t[0])->toDateTimeLocalString()][] = \App\Resources\AppointmentSlot::make($d);
//    }
    return sizeof($times_response) > 0 ? $times_response : null;
}


function getMessagesByToID($to_id, $to_type, $from_id, $from_type, $limit = 0, $offset = 0)
{
    $data = Message::query();
    $chat = Chat::where(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
        return $q->where([
            'from_id' => $from_id,
            'from_type' => $from_type,
            'from_deleted' => 0,
            'to_id' => $to_id,
            'to_type' => $to_type
        ]);
    })->orWhere(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
        return $q->where([
            'from_id' => $to_id,
            'from_type' => $to_type,
            'to_deleted' => 0,
            'to_id' => $from_id,
            'to_type' => $from_type
        ]);
    })->first();
    if (!$chat) {
        $chat = new Chat();
        $chat->from_id = $from_id;
        $chat->from_type = $from_type;
        $chat->to_id = $to_id;
        $chat->to_type = $to_type;
        $chat->last_message = '';
        $chat->last_message_from = -1;
        $chat->save();
    }
    $chat_id = $chat->id;

    $chat = Chat::where('id', $chat_id)->first();
    $data = $data->where('chat_id', $chat_id);

    if (auth('sanctum')->user()->id == $chat->from_id) {
        $data->where([
            'from_deleted' => 0
        ]);
    } else {
        $data->where([
            'to_deleted' => 0
        ]);
    }

    $data = $data->orderBy('updated_at', 'desc')->paginate($limit, ['*'], 'page', $offset);
    $data = [
        'total_size' => $data->total(),
        'limit' => (int) $limit,
        'offset' => (int) $offset,
        'chat_id' => (int) $chat_id,
        'data' => \App\Resources\Message::collection($data->all())
    ];
    return $data;
}

function getMessagesByChatID($chat_id, $limit = 0, $offset = 0)
{
    $data = Message::query();

    $chat = Chat::where('id', $chat_id)->first();
    $data = $data->where('chat_id', $chat_id);

    if ($chat && auth('sanctum')->user()->id == $chat->from_id) {
        $data->where([
            'from_deleted' => 0
        ]);
    } else {
        $data->where([
            'to_deleted' => 0
        ]);
    }

    $data = $data->orderBy('updated_at', 'desc')->paginate($limit, ['*'], 'page', $offset);
    $data = [
        'total_size' => $data->total(),
        'limit' => (int) $limit,
        'offset' => (int) $offset,
        'chat_id' => (int) $chat_id,
        'data' => \App\Resources\Message::collection($data->all())
    ];
    return $data;
}

/*
 * *****
 * Live
 * *****
 */

function getSetting($key)
{
    Cache::forget($key);
    Cache::forget($key);
    $time = 3600 * 24;

    $settings = Cache::remember($key, $time, function () use ($key) {
        return \App\Models\LiveSetting::where('key', $key)->first();
    });
    return $settings;
}

function isModerator($q)
{
    if (auth('web')->check()) {
        $role = auth('web')->user()->role_id;
        $provider = Provider::where('user_id', auth('web')->user()->id)->first();
        if (
            $role == getRoleID('admin') || $role == getRoleID('nm-admin') ||
            $role == getRoleID('super-admin') || ($provider && $q->added_by == $provider->id)
        ) {
            return true;
        }
    }
    return false;
}

/*
 * **********
 * Blogs
 * **********
 */
function addBlogView($blog)
{
    if ($blog) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $bv = BlogView::where([
            'blogs_id' => $blog->id,
            'ip' => $ip,
        ])->first();
        if (!$bv || ($bv && Carbon::now()->diffInHours(Carbon::parse($bv->created_at)) > 2)) {
            $bv = new BlogView();
            $bv->users_id = $blog->id;
            $bv->blogs_id = $blog->id;
            $bv->ip = $ip;
            $bv->save();
        }
    }
}


/**
 * Chats
 */

function clearPhone($phone)
{
    $phone = preg_replace('/[^0-9.]+/', '', $phone);
    $phone = (int) $phone;
    return $phone;
}




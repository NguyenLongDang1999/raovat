<?php

use CodeIgniter\I18n\Time;

function getMenuActive($patterns, $activeClass = "active")
{
    if (url_is('*administrator/' . $patterns)) {
        return $activeClass;
    }
}

function getMenuUserActive($patterns, $activeClass = "active")
{
    if (url_is('/' . $patterns)) {
        return $activeClass;
    }
}

function getDateHumanize($date)
{
    $time = Time::parse($date);
    return $time->humanize();
}

function video_youtube($link)
{
    $video_id = explode("?v=", $link);
    $video_id = $video_id[1];
    $thumbnail = "http://img.youtube.com/vi/" . $video_id . "/maxresdefault.jpg";

    return $thumbnail;
}

function getDateTime($date)
{
    $time = Time::parse($date);
    return $time->toLocalizedString('dd-MM-yyyy');
}

function imageManipulation($path, $fileName, $fileNameNew, $folder, $data)
{
    $image = \Config\Services::image();
    if ($folder == '') {
        $savePath = $path . '/';
    } else {
        $savePath = $path . '/' . $folder;
    }

    if (!file_exists($savePath)) {
        mkdir($savePath, 755);
    }
    $image->withFile($path . $fileName);
    switch ($folder) {
        case 'small':
            $image->resize($data['resizeX'], $data['resizeY'], $data['ratio'], $data['masterDim']);
            break;

        case 'medium':
            $image->resize($data['resizeX'], $data['resizeY'], $data['ratio'], $data['masterDim']);
            break;

        default:
            $image->resize($data['resizeX'], $data['resizeY'], $data['ratio'], $data['masterDim']);
            break;
    }
    $image->convert(IMAGETYPE_WEBP);

    if ($folder == '') {
        return $image->save($savePath . $fileNameNew);
    } else {
        return $image->save($savePath . '/' . $fileNameNew);
    }
}

function deleteImage($path, $fileName)
{
    if (file_exists($path . $fileName)) {
        unlink($path . $fileName);
    }
}

function deleteMultipleImage($path, $array)
{
    if (count($array) > 0) {
        foreach ($array as $item) {
            deleteImage($path, $item['image']);
        }
    }
}

function deleteMultiplePostImage($path, $array)
{
    if (!empty($array[0])) {
        foreach ($array as $item) {
            deleteImage($path, $item);
        }
    }
}

function getOptionOrders()
{
    $option = [
        '' => 'Vui L??ng Ch???n',
        '0' => 'Banner Tr??n',
        '1' => 'Banner Gi???a',
        '2' => 'Banner Cu???i'
    ];

    return $option;
}

function getOptionIsType()
{
    $option = [
        '' => '',
        '0' => 'C???n b??n',
        '1' => 'C???n mua',
        '2' => 'C???n thu??',
        '3' => 'Cho thu??',
        '4' => 'Kh??c'
    ];

    return $option;
}

function getOptionStatusPost()
{
    $option = [
        '' => 'Vui L??ng Ch???n',
        STATUS_POST_READY => 'Ch??a Duy???t',
        STATUS_POST_ACTIVE => '??ang ????ng',
        STATUS_POST_INACTIVE => 'Kh??ng ???????c Duy???t',
        STATUS_POST_HIDDEN => '??ang ???n'
    ];

    return $option;
}


function showIsTypePostDetail($is_type)
{
    $html = '';

    if ($is_type == 0) {
        $html .= 'C???n B??n';
    } elseif ($is_type == 1) {
        $html .= 'C???n Mua';
    } elseif ($is_type == 2) {
        $html .= 'C???n Thu??';
    } elseif ($is_type == 3) {
        $html .= 'Cho Thu??';
    } elseif ($is_type == 4) {
        $html .= 'Kh??c';
    }

    return $html;
}

function diffDate($expire_from, $expire_to)
{
    $from = Time::parse($expire_from);
    $to = Time::parse($expire_to);

    $diff = $from->difference($to);

    return $diff->getDays();
}

function number_to_amount($num, int $precision = 0, string $locale = null)
{
    try {
        $num = 0 + str_replace(',', '', $num);
    } catch (ErrorException $ee) {
        return false;
    }

    $suffix = '';

    $generalLocale = $locale;
    if (!empty($locale) && ($underscorePos = strpos($locale, '_'))) {
        $generalLocale = substr($locale, 0, $underscorePos);
    }

    if ($num >= 1000000000000000) {
        $suffix = lang('Number.quadrillion', [], $generalLocale);
        $num    = round(($num / 1000000000000000), $precision);
    } elseif ($num >= 1000000000000) {
        $suffix = lang('Number.trillion', [], $generalLocale);
        $num    = round(($num / 1000000000000), $precision);
    } elseif ($num > 1000000000) {
        $suffix = lang('Number.billion', [], $generalLocale);
        $num    = round(($num / 1000000000), $precision);
    } elseif ($num > 1000000) {
        $suffix = lang('Number.million', [], $generalLocale);
        $num    = round(($num / 1000000), $precision);
    } elseif ($num >= 1000) {
        $suffix = lang('Number.thousand', [], $generalLocale);
        $num    = round(($num / 1000), $precision);
    }

    return format_number($num, $precision, $locale, ['after' => $suffix]);
}

function userShowImage($user_avatar)
{
    if (is_null($user_avatar)) {
        $path = base_url(PATH_DEFAULT_AVATAR);
    } else {
        if (strpos($user_avatar, 'https') !== false) {
            $path = $user_avatar;
        } else {
            $path = base_url(PATH_USER_IMAGE . $user_avatar);
        }
    }

    return $path;
}

function categoryShowImage($image)
{
    if (is_null($image)) {
        $path = base_url(PATH_DEFAULT_AVATAR);
    } else {
        if (strpos($image, 'https') !== false) {
            $path = $image;
        } else {
            $path = PATH_CATEGORY_IMAGE . $image;
        }
    }

    return $path;
}

function postShowImage($thumb_list)
{
    if (!empty($thumb_list)) {
        if (strpos($thumb_list, 'https') !== false) {
            $path = $thumb_list;
        } else {
            $path = base_url(PATH_POST_SMALL_IMAGE . $thumb_list);
        }
    } else {
        $path = base_url(PATH_POST_IMAGE_DEFAULT);
    }

    return $path;
}

function showPostStatus($status)
{
    $html = '';
    if ($status == STATUS_POST_ACTIVE) {
        $html .= '<span class="badge badge-light-success badge-pill">??ang ????ng</span>';
    } elseif ($status == STATUS_POST_READY) {
        $html .= '<span class="badge badge-light-dark badge-pill">Ch??a Duy???t</span>';
    } elseif ($status == STATUS_POST_INACTIVE) {
        $html .= '<span class="badge badge-light-danger badge-pill">Kh??ng ???????c Duy???t</span>';
    } elseif ($status == STATUS_POST_HIDDEN) {
        $html .= '<span class="badge badge-light-warning badge-pill">???n Tin</span>';
    }

    return $html;
}

function checkFavorites()
{
    $favorites = true;

    if (logged_in()) {
        $favorites = FAVORITES_AUTH;
    } else {
        $favorites = FAVORITES_NO_AUTH;
    }

    return $favorites;
}

function showRoleUser($role)
{
    $show = '';

    if ($role == SUPER_ADMINISTRATOR) {
        $show .= 'Administrator';
    } else if ($role == MANAGER) {
        $show .= 'Manager';
    }

    return $show;
}
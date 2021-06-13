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

function getOptionOrders()
{
    $option = [
        '' => 'Vui Lòng Chọn',
        '0' => 'Banner Trên',
        '1' => 'Banner Giữa',
        '2' => 'Banner Cuối'
    ];

    return $option;
}

function getOptionIsType()
{
    $option = [
        '' => '',
        '0' => 'Cần bán',
        '1' => 'Cần mua',
        '2' => 'Cần thuê',
        '3' => 'Cho thuê',
        '4' => 'Khác'
    ];

    return $option;
}

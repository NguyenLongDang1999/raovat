<?php

function getMenuActive($patterns, $activeClass = "active")
{
    if (url_is('*administrator/' . $patterns)) {
        return $activeClass;
    }
}

function imageManipulation($path, $fileName, $fileNameNew, $folder, $data)
{
    $image = \Config\Services::image();
    $savePath = $path . '/';
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
    return $image->save($savePath . $fileNameNew);
}

function deleteImage($path, $fileName)
{
    if (file_exists($path . $fileName)) {
        unlink($path . $fileName);
    }
}

function deleteMultipleImage($array)
{
    if (count($array) > 0) {
        foreach ($array as $item) {
            deleteImage(PATH_CATEGORY_IMAGE, $item['image']);
        }
    }
}
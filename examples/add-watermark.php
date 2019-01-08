<?php

// this will be handled via your composer loader
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Watermark.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Position.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'ImageType.php';

// optional
use BertMaurau\Watermarker;

// the source/original image
$sourceImage = __DIR__ . DIRECTORY_SEPARATOR . 'source.jpg';
// the image used as the watermark
$watermarkImage = __DIR__ . DIRECTORY_SEPARATOR . 'watermark.png';

// available positions
/*
 * Position:: TOP_LEFT | TOP_CENTER | TOP_RIGHT | CENTER_CENTER | BOTTOM_LEFT | BOTTOM_CENTER | BOTTOM_RIGHT
 */

// available imageTypes
/*
 * ImageType:: JPEG | BMP | GIF | PNG
 */

// Static method
/**
 * Function arguments
 * @param string required $sourceImage       The image to put the watermark on
 * @param string required $watermarkImage    The image that you want to use as a watermark
 * @param string optional $outputPath        The path where the generated image should be placed (check your permissions)
 * @param string optional $outputFilename    The filename you want to give the exported file
 * @param string optional $outputExtension   The extension it should have (jpg, jpeg, png, bmp, gif)
 * @param string optional $position          The position to put the watermark at ('top-left', 'top-center', 'top-right', 'center-center', 'bottom-left', 'bottom-center', 'bottom-right')
 * @param int optional $outputQuality        The exported quality (Used for .jpg or for compression with .png [1-100])
 */
try {
    Watermarker\Watermark::AddImageAsWatermark($sourceImage, $watermarkImage, __DIR__, $filename = Watermarker\Position::CENTER_CENTER, Watermarker\ImageType::JPEG, Watermarker\Position::BOTTOM_CENTER, 100);
} catch (\Exception $ex) {
    echo $ex -> getMessage();
}

// Initialized mathod
try {
    $marker = (new Watermarker\Watermark)
            -> setSourceImage($sourceImage)
            -> setWatermarkImage($watermarkImage)
            -> setOutputPath(__DIR__)
            -> watermark();
} catch (Exception $ex) {
    echo $ex -> getMessage();
}


<?php

// this will be handled via your composer loader
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Watermark.php';

// optional
use BertMaurau\Watermarker\Watermark;

// the source/original image
$sourceImage = __DIR__ . DIRECTORY_SEPARATOR . 'source.jpg';
// the image used as the watermark
$watermarkImage = __DIR__ . DIRECTORY_SEPARATOR . 'watermark.png';

// available positions
$positions = ['top-left', 'top-center', 'top-right', 'center-center', 'bottom-left', 'bottom-center', 'bottom-right'];
foreach ($positions as $position) {

    /**
     * Function arguments
     * @param string $sourceImage       The image to put the watermark on
     * @param string $watermarkImage    The image that you want to use as a watermark
     * @param string $outputPath        The path where the generated image should be placed (check your permissions)
     * @param string $outputFilename    The filename you want to give the exported file
     * @param string $outputExtension   The extension it should have (jpg, jpeg, png, bmp, gif)
     * @param string $position          The position to put the watermark at ('top-left', 'top-center', 'top-right', 'center-center', 'bottom-left', 'bottom-center', 'bottom-right')
     * @param int $outputQuality        The exported quality (Used for .jpg or for compression with .png [1-100])
     */
    try {
        Watermark::AddImageAsWatermark($sourceImage, $watermarkImage, __DIR__, $filename = $position, 'jpg', $position, 100);
    } catch (\Exception $ex) {
        echo $ex -> getMessage();
    }
}

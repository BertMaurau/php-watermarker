# PHP Watermarker

[![License](http://img.shields.io/badge/license-MIT-lightgrey.svg)](https://github.com/bertmaurau/php-watermarker/blob/master/LICENSE)

A simple and basic library to watermark an image using a source-image and a watermark-image. Function can be used as a static caller as well as an initialized function (see example).

![Preview](https://raw.githubusercontent.com/bertmaurau/php-watermarker/branch/preview.jpg)



## Usage

### Installation

Via [Composer](https://getcomposer.org)

```bash
composer require bertmaurau/php-watermarker
```

### Example

``` php

// example (examples/add-watermark.php)
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
 * @param string optional $outputExtension   The extension it should have
 * @param string optional $position          The position to put the watermark at
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
            // other setters
            -> watermark();
} catch (Exception $ex) {
    echo $ex -> getMessage();
}


```

> [View all examples](/examples/add-watermark.php).

### Issues

> For bug reporting or code discussions.

## Credits

- [Bert Maurau](https://github.com/bertmaurau)

## License

The module is licensed under [MIT](./LICENSE.md).
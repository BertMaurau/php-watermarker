<?php

namespace BertMaurau\Watermarker;

/**
 *  Watermark
 *
 *  - AddImageAsWatermark: Add an image as a watermark to an existing image
 *
 *  @author Bert Maurau
 */
class Watermark
{

    // list of pre-defined positions where the watermark can be placed
    const WATERMARK_POSITIONS = ['top-left', 'top-center', 'top-right', 'center-center', 'bottom-left', 'bottom-center', 'bottom-right'];

    /**
     * Add an image as a watermark to an existing image
     *
     * @param string $sourceImage
     * @param string $watermarkImage
     * @param string $outputPath
     * @param string $outputFilename
     * @param string $outputExtension
     * @param string $position
     * @param int $outputQuality
     *
     * @throws Exception
     *
     * @return boolean
     */
    public static function AddImageAsWatermark(string $sourceImage, string $watermarkImage, string $outputPath = '/', string $outputFilename = null, string $outputExtension = null, string $position = 'bottom-right', int $outputQuality = 100)
    {

        // check if the watermark image is an actual image
        if (!self::checkFile($watermarkImage)) {
            throw new \Exception("File not found `$watermarkImage`.");
        }
        // check if the source image is an actual image
        if (!self::checkFile($sourceImage)) {
            throw new \Exception("File not found `$sourceImage`.");
        }

        // create the image resource from the given file
        $_watermarkImage = self::createImageFromFile($watermarkImage);

        // create the image resource from the source file
        $_sourceImage = self::createImageFromFile($sourceImage);

        // imagealphablending($watermark, false);
        // imagesavealpha($watermark, true);
        // get dimensions for the watermark image
        $_watermarkDimensions = self::getImageDimensions($_watermarkImage);

        // get dimenstions for the source image
        $_sourceDimensions = self::getImageDimensions($_sourceImage);

        // calculate position for placing watermark
        $_position = self::calculateTargetPosition($_sourceDimensions, $_watermarkDimensions, $position);

        // copy the watermark
        imagecopy($_sourceImage, $_watermarkImage, $_position -> x, $_position -> y, 0, 0, $_watermarkDimensions -> x, $_watermarkDimensions -> y);

        // build the output name
        $outputFile = rtrim($outputPath, '/') . DIRECTORY_SEPARATOR . ($outputFilename ?: (pathinfo($sourceImage)['filename'] . '-watermarked')) . '.' . ltrim(($outputExtension ?: pathinfo($sourceImage)['extension']), '.');

        // write to file
        $result = self::exportImage($_sourceImage, $outputFile, $outputQuality, $outputExtension ?: pathinfo($sourceImage)['extension']);

        // destroy temp resources
        imagedestroy($_sourceImage);
        imagedestroy($_watermarkImage);

        return $result;
    }

    /**
     * Checks whether the given file or directory exists
     *
     * @param string $file
     *
     * @return boolean
     */
    private static function checkFile(string $file)
    {
        return file_exists($file);
    }

    /**
     * Create a new image from the given file
     *
     * @param string $imageFile
     *
     * @throws Exception
     *
     * @return Resource an image resource
     */
    private static function createImageFromFile(string $imageFile)
    {
        // check for requested mime-type and create an image from it
        switch ($mimeType = self::getMimeContentType($imageFile)) {
            case 'image/png':
                $_caller = 'imagecreatefrompng';
                break;
            case 'image/gif':
                $_caller = 'imagecreatefromgif';
                break;
            case 'image/jpeg':
                $_caller = 'imagecreatefromjpeg';
                break;
            case 'image/bmp':
                $_caller = 'imagecreatefrombmp';
                break;
            default:
                throw new Exception("Unsupported MIME-Type `$mimeType`.");
        }

        try {
            $image = $_caller($imageFile);
        } catch (\Exception $ex) {
            // throw the original exception
            throw $ex;
        }

        return $image;
    }

    /**
     * Get the MIME-Type for given image path
     *
     * @param string $imageFile
     *
     * @return string
     */
    private static function getMimeContentType(string $imageFile)
    {
        return mime_content_type($imageFile);
    }

    /**
     * Get the dimensions for given image resource
     *
     * @param resource $image
     *
     * @return Object
     */
    private static function getImageDimensions($image)
    {
        return (object) ['x' => imagesx($image), 'y' => imagesy($image)];
    }

    /**
     * Calculate the coordinates for the position of the watermark
     *
     * @param object $dimensionsSource
     * @param object $dimensionsWatermark
     * @param string $position
     *
     * @return object
     */
    private static function calculateTargetPosition($dimensionsSource, $dimensionsWatermark, string $position)
    {

        switch ($position) {
            case 'top-left':
                $_x = 0;
                $_y = 0;
                break;
            case 'top-center':
                $_x = ($dimensionsSource -> x / 2) - ($dimensionsWatermark -> x / 2);
                $_y = 0;
                break;
            case 'top-right':
                $_x = ($dimensionsSource -> x) - ($dimensionsWatermark -> x);
                $_y = 0;
                break;
            case 'center-center':
                $_x = ($dimensionsSource -> x / 2) - ($dimensionsWatermark -> x / 2);
                $_y = ($dimensionsSource -> y / 2) - ($dimensionsWatermark -> y / 2);
                break;
            case 'bottom-left':
                $_x = 0;
                $_y = ($dimensionsSource -> y) - ($dimensionsWatermark -> y);
                break;
            case 'bottom-center':
                $_x = ($dimensionsSource -> x / 2) - ($dimensionsWatermark -> x / 2);
                $_y = ($dimensionsSource -> y) - ($dimensionsWatermark -> y);

                break;
            case 'bottom-right':
                $_x = ($dimensionsSource -> x) - ($dimensionsWatermark -> x);
                $_y = ($dimensionsSource -> y) - ($dimensionsWatermark -> y);

                break;
            default:
                break;
        }

        return (object) ['x' => $_x, 'y' => $_y];
    }

    /**
     * Export/Save the given resource to the given output file
     *
     * @param resource $input
     * @param string $outputFile
     * @param int $quality
     * @param string $extension
     *
     * @throws Exception
     *
     * @return boolean
     */
    private static function exportImage($input, string $outputFile, int $quality, string $extension)
    {
        switch ($extension) {
            case 'png':
                $res = imagepng($input, $outputFile, $quality);
                break;
            case 'gif':
                $res = imagegif($input, $outputFile);
                break;
            case 'jpeg':
            case 'jpg':
                $res = imagejpeg($input, $outputFile, $quality);
                break;
            case 'bmp':
                $res = imagebmp($input, $outputFile, ($quality < 100));
                break;
            default:
                throw new \Exception("Unsupported output extension `$extension`.");
        }

        return $res;
    }

}

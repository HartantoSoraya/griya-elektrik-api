<?php

namespace App\Helpers\ImageHelper;

use Illuminate\Http\UploadedFile;
use LogicException;

class ImageHelper
{
    public function createDummyImageWithTextSizeAndPosition($width, $height, $textPosition): UploadedFile
    {
        $img = imagecreatetruecolor($width, $height);

        $greyColor = imagecolorallocate($img, 192, 192, 192);
        imagefill($img, 0, 0, $greyColor);

        $textColor = imagecolorallocate($img, 255, 255, 255);

        $xSize = max($width, $height);
        $fontSize = round($xSize / 30);

        $text = $width.' x '.$height;
        $font = __DIR__.'/fonts/arial/ARIAL.TTF';
        $textBox = imagettfbbox($fontSize, 0, $font, $text);
        $textWidth = $textBox[2] - $textBox[0];
        $textHeight = $textBox[1] - $textBox[7];

        switch ($textPosition) {
            case 'top-left':
                $x = round($width * 0.025);
                $y = round($height * 0.1) + round($textHeight / 2);
                break;
            case 'top-center':
                $x = round($width / 2) - round($textWidth / 2);
                $y = round($height * 0.1) + round($textHeight / 2);
                break;
            case 'top-right':
                $x = round($width * 0.975) - round($textWidth);
                $y = round($height * 0.1) + round($textHeight / 2);
                break;
            case 'center-left':
                $x = round($width * 0.025);
                $y = round($height / 2) + round($textHeight / 2);
                break;
            case 'center':
                $x = round($width / 2) - round($textWidth / 2);
                $y = round($height / 2) + round($textHeight / 2);
                break;
            case 'center-right':
                $x = round($width * 0.975) - round($textWidth);
                $y = round($height / 2) + round($textHeight / 2);
                break;
            case 'bottom-left':
                $x = round($width * 0.025);
                $y = round($height * 0.9) + round($textHeight / 2);
                break;
            case 'bottom-center':
                $x = round($width / 2) - round($textWidth / 2);
                $y = round($height * 0.9) + round($textHeight / 2);
                break;
            case 'bottom-right':
                $x = round($width * 0.975) - round($textWidth);
                $y = round($height * 0.9) + round($textHeight / 2);
                break;
            default:
                throw new LogicException('Invalid text position');
                break;
        }

        imagettftext($img, $fontSize, 0, $x, $y, $textColor, $font, $text);

        $tempFilePath = tempnam(sys_get_temp_dir(), 'modified_image_');
        imagejpeg($img, $tempFilePath, 100);

        $uploadedFile = new UploadedFile($tempFilePath, 'modified_image.jpg', 'image/jpeg', null, true);

        imagedestroy($img);

        return $uploadedFile;
    }
}

<?php
// Em app/core/ImageHelper.php

class ImageHelper
{
    /**
     * Otimiza uma imagem (redimensiona e comprime).
     * Requer a extensão GD do PHP.
     */
    public static function optimize($sourcePath, $destinationPath, $quality = 80, $maxWidth = 1280)
    {
        $imageInfo = getimagesize($sourcePath);
        if ($imageInfo === false) return false;

        $mime = $imageInfo['mime'];
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($sourcePath);
                break;
            default:
                return false; // Formato não suportado
        }

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width > $maxWidth) {
            $newHeight = ($height / $width) * $maxWidth;
            $newImage = imagecreatetruecolor($maxWidth, $newHeight);
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $newImage;
        }

        $success = false;
        if ($mime == 'image/jpeg') {
            $success = imagejpeg($image, $destinationPath, $quality);
        } elseif ($mime == 'image/png') {
            $pngQuality = round(($quality / 100) * 9);
            imagesavealpha($image, true); // Preserva a transparência
            $success = imagepng($image, $destinationPath, $pngQuality);
        }

        imagedestroy($image);
        return $success;
    }
}
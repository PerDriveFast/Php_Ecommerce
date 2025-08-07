<?php
function image_resize($source, $destination, $target_width, $target_height)
{
    list($orig_width, $orig_height) = getimagesize($source);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $source);

    // Step 1: Calculate scale to cover the area (may overflow)
    $scale = max($target_width / $orig_width, $target_height / $orig_height);
    $new_width = ceil($orig_width * $scale);
    $new_height = ceil($orig_height * $scale);

    // Step 2: Resize the original image to new dimensions
    $resized_image = imagecreatetruecolor($new_width, $new_height);

    if ($mime == 'image/jpeg') {
        $src = imagecreatefromjpeg($source);
    } elseif ($mime == 'image/png') {
        $src = imagecreatefrompng($source);
        imagealphablending($resized_image, false);
        imagesavealpha($resized_image, true);
    } elseif ($mime == 'image/gif') {
        $src = imagecreatefromgif($source);
    } else {
        throw new Exception("Unsupported image type");
    }

    imagecopyresampled($resized_image, $src, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);

    // Step 3: Crop the center part to the exact target size
    $crop_x = round(($new_width - $target_width) / 2);
    $crop_y = round(($new_height - $target_height) / 2);

    $final_image = imagecreatetruecolor($target_width, $target_height);

    // Support transparency for PNG
    if ($mime == 'image/png') {
        imagealphablending($final_image, false);
        imagesavealpha($final_image, true);
        $transparent = imagecolorallocatealpha($final_image, 0, 0, 0, 127);
        imagefill($final_image, 0, 0, $transparent);
    }

    imagecopy($final_image, $resized_image, 0, 0, $crop_x, $crop_y, $target_width, $target_height);

    // Step 4: Save final image
    if ($mime == 'image/jpeg') {
        imagejpeg($final_image, $destination, 90);
    } elseif ($mime == 'image/png') {
        imagepng($final_image, $destination);
    } elseif ($mime == 'image/gif') {
        imagegif($final_image, $destination);
    }

    // Clean up
    imagedestroy($src);
    imagedestroy($resized_image);
    imagedestroy($final_image);
}

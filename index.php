<?php

include 'ImagePlaceholderAttributes.php';
include 'ImagePlaceholder.php';

$imageAttributes = new ImagePlaceholderAttributes();

if ($imageAttributes->haveSize()) {
    $image = new ImagePlaceholder(
        isset($imageAttributes->styles['font-size']) ? $imageAttributes->styles['font-size'] : null
    );

    if ($imageAttributes->width > 5000) {
        $image = $image->create(600, 300, '#e27573', '#561312', "Specified size is too large.\r\nMax allowed size is 4999px.");
    } else {
        $image = $image->create(
            $imageAttributes->imageSize()['width'],
            $imageAttributes->imageSize()['height'],
            isset($imageAttributes->styles['color']) ? $imageAttributes->styles['color'] : '#fafafa',
            isset($imageAttributes->styles['text-color']) ? $imageAttributes->styles['text-color'] : '#cdcdcd',
            isset($imageAttributes->styles['text']) ? $imageAttributes->styles['text'] : null,
        );
    }
    
    header("Content-Type: image/png");
    imagepng($image);
    ImageDestroy($image);
} else {
    $image = new ImagePlaceholder(15);
    $text  = "Seems like you forgot to set image size.\r\nYou can specify width and height after the slash in url.\r\nFor example: img.silencesys.dev/300x250";
    $image = $image->create(600, 300, '#8ffafc', '#0948a5', $text);
    
    header("Content-Type: image/png");
    imagepng($image);
    ImageDestroy($image);
}
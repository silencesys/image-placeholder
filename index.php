<?php

include 'ImageAttributes.php';
include 'Image.php';

$imageAttributes = new ImageAttributes($_SERVER['REQUEST_URI']);

$image = new Image(
    isset($imageAttributes->styles['font-size']) ? $imageAttributes->styles['font-size'] : null
);

$image = $image->create(
    $imageAttributes->imageSize()['width'],
    $imageAttributes->imageSize()['height'],
    isset($imageAttributes->styles['color']) ? $imageAttributes->styles['color'] : '#fafafa',
    isset($imageAttributes->styles['text-color']) ? $imageAttributes->styles['text-color'] : '#cdcdcd',
);

header("Content-Type: image/png");

imagepng($image);

ImageDestroy($image);
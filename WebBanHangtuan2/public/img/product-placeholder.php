<?php
// Set the content type to image/png
header('Content-Type: image/png');

// Create an image with dimensions 600x600 pixels
$width = 600;
$height = 600;
$image = imagecreatetruecolor($width, $height);

// Define colors
$bg_color = imagecolorallocate($image, 240, 240, 240); // Light gray background
$text_color = imagecolorallocate($image, 120, 120, 120); // Dark gray text
$border_color = imagecolorallocate($image, 200, 200, 200); // Border color

// Fill the background
imagefill($image, 0, 0, $bg_color);

// Draw border
imagerectangle($image, 0, 0, $width - 1, $height - 1, $border_color);

// Add text
$text = "No Image";
$font_size = 5; // Built-in font size (1-5)
$text_width = imagefontwidth($font_size) * strlen($text);
$text_height = imagefontheight($font_size);

// Center the text
$text_x = ($width - $text_width) / 2;
$text_y = ($height - $text_height) / 2;

// Draw text on the image
imagestring($image, $font_size, $text_x, $text_y, $text, $text_color);

// Output the image
imagepng($image);

// Free up memory
imagedestroy($image); 
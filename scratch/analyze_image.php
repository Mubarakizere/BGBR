<?php
if (extension_loaded('gd')) {
    $im = imagecreatefromjpeg(__DIR__ . '/../public/images/logo.jpg');
    if (!$im) {
        die("Failed to open image\n");
    }
    $w = imagesx($im);
    $h = imagesy($im);
    echo "Dimensions: {$w}x{$h}\n";
    $colors = [];
    // Sample colors
    for ($x = 0; $x < $w; $x += max(1, (int)($w / 20))) {
        for ($y = 0; $y < $h; $y += max(1, (int)($h / 20))) {
            $rgb = imagecolorat($im, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            $hex = sprintf('#%02X%02X%02X', $r, $g, $b);
            $colors[$hex] = ($colors[$hex] ?? 0) + 1;
        }
    }
    arsort($colors);
    echo "Sample colors:\n";
    foreach (array_slice($colors, 0, 15, true) as $color => $count) {
        echo "  $color: $count\n";
    }
} else {
    echo "GD not loaded\n";
}

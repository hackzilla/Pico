<?
// phpInfo();
// header("Content-type: image/png");

$width = 150;
$height = 40;
$noise = 100;

$im = ImageCreate($width, $height);

$white = imagecolorallocate($im, 255, 255, 255);
$grey[0] = imagecolorallocate($im, 50, 50, 50);
$grey[1] = imagecolorallocate($im, 100, 100, 100);
$grey[2] = imagecolorallocate($im, 150, 150, 150);
$grey[3] = imagecolorallocate($im, 200, 200, 200);
$black = imagecolorallocate($im, 0, 0, 0);

// add noise

$counter = 0;
$counttop = $noise;

while ($counter < $counttop) {
        srand((double)microtime()*1000000);
        $dotx = rand(1,($width - 2));
        $doty = rand(1,($height - 2));
        $greycol = rand(0,3);
        $dotsize = rand(0,2);
        imagerectangle($im, $dotx, $doty, ($dotx + $dotsize), ($doty + $dotsize), $grey[$greycol]);
        $counter++;
}

// render text

imagerectangle($im, 0, 0, ($width - 1), ($height - 1), $black);
imagestring($im,8,rand(10,26),rand(8,14),$randomstring,$black);

// add noise

$counter = 0;
$counttop = $noise;

while ($counter < $counttop) {
	srand((double)microtime()*1000000);
	$dotx = rand(1,($width - 2));
	$doty = rand(1,($height - 2));
	$greycol = rand(0,3);
	$dotsize = rand(0,2);
	imagerectangle($im, $dotx, $doty, ($dotx + $dotsize), ($doty + $dotsize), $grey[$greycol]);
	$counter++;
}

imagepng($im, $randomfile);
imagedestroy($im);

?>

<center><img src="data:image/png;base64,<?php echo logoqrcode(); ?>" alt="img"/></center>
<?php
function logoqrcode()
{
require 'phpqrcode/qrlib.php';
$qrcodecontent = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
$pfad = "QRcodes/";
$dateiname = "testqrcode";
$dateityp = ".png";
$datei = $pfad.$dateiname.uniqid().$dateityp;
QRcode::png($qrcodecontent,$datei,"H",10,0);

$logo = "logo/logokiz_start.png";
$QR = imagecreatefrompng($datei);

$logo = imagecreatefromstring(file_get_contents($logo));
$QR_width = imagesx($QR);
$QR_height = imagesy($QR);

$logo_width  = imagesx($logo);
$logo_height = imagesy($logo);
$logo_qr_width = $QR_width/4;
$scale = $logo_width/$logo_qr_width;
$logo_qr_height = $logo_height/$scale;

imagecopyresampled($QR,$logo, $QR_width/2.5, $QR_height/2.5,0,0,$logo_qr_width,$logo_qr_height,$logo_width,$logo_height);
ob_start();
imagepng($QR);
imagedestroy($QR);
$image_data = ob_get_contents();
ob_end_clean();

return base64_encode($image_data);
}
?>

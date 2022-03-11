<?PHP
$qr_img="";
if(isset($_POST))
{
    switch($_POST["logo"])
    {
        case "with":$qr_img = getqrcode($qr_img, true);
        break;
        case "without":$qr_img = getqrcode($qr_img, false);
        break;
    }
}
print_r($_POST);

$str_html = '<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <p>Please select the QR code type:</p>
  <form action="" id="form" method="POST">
  <input type="radio" id="with" name="logo" value="with" onclick="document.querySelector(\'#form\').submit();">
  <label for="with">with logo</label><br>
  <input type="radio" id="without" name="logo" value="without" onclick="document.querySelector(\'#form\').submit();">
  <label for="without">without logo</label>
<center><img src='.$qr_img.' alt="img"></img></center>
</form>
</body>
</html>';

echo $str_html;

function getqrcode($qr_img, $withlogo)
{   
    require 'phpqrcode/qrlib.php';
    $qrcodecontent = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
    $pfad = "QRcodes/";
    $pfadmitlogo = "QRcodes_logo/";
    $dateiname = "kizqrcode";
    $dateiname_mitlogo = "kizqrcode_logo";
    $dateityp = ".png";
    $filecount_ohnelogo = count(glob("$pfad"."*$dateityp"));
    $datei = $pfad.$dateiname.$filecount_ohnelogo.$dateityp;
    QRcode::png($qrcodecontent,$datei,"H",10,0);
    if($withlogo)
    {
        $logo = "logo/logokiz_start.png";
        $QR = imagecreatefrompng($datei);

        $logo = imagecreatefromstring(file_get_contents($logo));
        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);

        $logo_width  = imagesx($logo);
        $logo_height = imagesy($logo);
        $logo_qr_width = $QR_width/3;
        $scale = $logo_width/$logo_qr_width;
        $logo_qr_height = $logo_height/$scale;
        imagecopyresampled($QR,$logo, $QR_width/3, $QR_height/2.5,0,0,round($logo_qr_width),round($logo_qr_height),$logo_width,$logo_height);

        ob_start();
        imagepng($QR);
        imagedestroy($QR);
        $image_data = ob_get_contents();
        ob_end_clean();

        $filecount_mitlogo = count(glob("$pfadmitlogo"."*$dateityp"));
        $filewithlogo = $pfadmitlogo.$dateiname_mitlogo.$filecount_mitlogo.$dateityp;
        file_put_contents($filewithlogo, $image_data);

        $qr_img = $filewithlogo;
    }
    else{
        $qr_img = $datei;
    } 
    return $qr_img;
}
$_POST = array();
?>
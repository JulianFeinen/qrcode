<?php
$lines = file('Base64Encoded.txt', FILE_IGNORE_NEW_LINES);
$handle = fopen("newfile.txt","r+");
for($i=0;$i<count($lines);$i++)
{
    $fwrite = fwrite($handle, $lines[$i]);
}
?>
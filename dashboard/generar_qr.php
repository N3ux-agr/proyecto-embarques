<?php
include 'phpqrcode/qrlib.php';

$num_empleado = isset($_GET['num_empleado']) ? $_GET['num_empleado'] : 'default';
$url = "10.36.1.17/Proyecto%20empaque/dashboard/registrar_tarea_asistencia.php?num_empleado=$num_empleado";
//"10.36.1.17/Proyecto%20empaque/dashboard/registrar_tarea_asistencia.php?num_empleado=$num_empleado";
// http://localhost/Proyecto%20empaque/registrar_tarea_asistencia.php?num_empleado=$num_empleado

//10.36.1.17/Proyecto%20empaque/dashboard/registrar_tarea_lineaa.php?num_empleado=$num_empleado

$tamaño = 7;
$nivelCorreccion = 'H';
$margen = 2;
$filename = 'iconos/'.md5($url).'.png';
$logo = 'iconos/agros.png';
$logoSize = 90; // Reducir el tamaño del logo
$logoMargin = 20; // Ajustar el margen alrededor del logo

// Aquí se incluye la URL directamente en el código QR, en lugar de solo la cadena de consulta
QRcode::png($url, $filename, $nivelCorreccion, $tamaño, $margen);

$QR = imagecreatefrompng($filename);
list($anchoQR, $altoQR) = getimagesize($filename);
$logoImage = imagecreatefrompng($logo);
list($anchoLogo, $altoLogo) = getimagesize($logo);
$posX = ($anchoQR - $logoSize) / 2;
$posY = ($altoQR - $logoSize) / 2;

$logoImageRedimensionado = imagecreatetruecolor($logoSize, $logoSize);
imagecopyresampled($logoImageRedimensionado, $logoImage, 0, 0, 0, 0, $logoSize, $logoSize, $anchoLogo, $altoLogo);

imagecopy($QR, $logoImageRedimensionado, $posX, $posY, 0, 0, $logoSize, $logoSize);

header('Content-Type: image/png');
imagepng($QR);
imagedestroy($QR);
?>

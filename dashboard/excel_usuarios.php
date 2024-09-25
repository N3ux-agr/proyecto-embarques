<?php
// Incluir las clases necesarias de PhpSpreadsheet
require_once 'vendorr/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Crear un nuevo objeto Spreadsheet (PhpSpreadsheet)
$objPHPExcel = new Spreadsheet();

// Configurar las propiedades del documento
$objPHPExcel->getProperties()->setCreator("Nombre del Creador")
                             ->setLastModifiedBy("Nombre del Creador")
                             ->setTitle("Registro de Empleados")
                             ->setSubject("Registro de Empleados")
                             ->setDescription("Registro de Empleados en formato Excel")
                             ->setKeywords("registro empleados excel")
                             ->setCategory("Registro");

// Agregar una hoja al documento
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();

// Agregar encabezados a la primera fila y aplicar estilo
$headerStyle = [
    'font' => ['bold' => true],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'CCCCCC']],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
];
$sheet->setCellValue('A1', 'No. Empleado')->getStyle('A1')->applyFromArray($headerStyle);
$sheet->setCellValue('B1', 'Nombre Completo')->getStyle('B1')->applyFromArray($headerStyle);
$sheet->setCellValue('C1', 'Jefe Directo')->getStyle('C1')->applyFromArray($headerStyle);
$sheet->setCellValue('D1', 'Área')->getStyle('D1')->applyFromArray($headerStyle);

// Obtener los datos de la base de datos
include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT num_empleado, nombre_completo, jefe_directo, area FROM bd_empaque.empleados";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

// Procesar los datos y agregar al archivo Excel
$row = 2;
$dataStyle = [
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
];
foreach ($data as $empleado) {
    $sheet->setCellValue('A' . $row, $empleado['num_empleado'])->getStyle('A' . $row)->applyFromArray($dataStyle);
    $sheet->setCellValue('B' . $row, $empleado['nombre_completo'])->getStyle('B' . $row)->applyFromArray($dataStyle);
    $sheet->setCellValue('C' . $row, $empleado['jefe_directo'])->getStyle('C' . $row)->applyFromArray($dataStyle);
    $sheet->setCellValue('D' . $row, $empleado['area'])->getStyle('D' . $row)->applyFromArray($dataStyle);
    $row++;
}

// Establecer anchos de columna
$sheet->getColumnDimension('A')->setWidth(15);
$sheet->getColumnDimension('B')->setWidth(30);
$sheet->getColumnDimension('C')->setWidth(30);
$sheet->getColumnDimension('D')->setWidth(20);

// Establecer altura de fila para encabezados
$sheet->getRowDimension(1)->setRowHeight(20);

// Configurar cabecera de salida para descargar como un archivo Excel
$fechaDescarga = date('Ymd');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Registro_Empleados_' . $fechaDescarga . '.xlsx"');
header('Cache-Control: max-age=0');

// Crear el escritor de Excel y enviar la salida al navegador
$objWriter = new Xlsx($objPHPExcel);
$objWriter->save('php://output');
?>

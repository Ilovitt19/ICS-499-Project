<?php
require_once 'Classes/PHPExcel.php';
require_once 'Classes/PHPExcel/IOFactory.php';
require_once 'db_fns.php';

$conn = db_connect();
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "username");
			$objPHPExcel->getActiveSheet()->setCellValue('B1', "password");
			$objPHPExcel->getActiveSheet()->setCellValue('C1', "admin");
			$objPHPExcel->getActiveSheet()->setCellValue('D1', "user_type");
			$objPHPExcel->getActiveSheet()->setCellValue('E1', "user_id");


$sql = "SELECT * FROM user";

	$result = $conn->query($sql);

$i = 2;
	while ($row_array = $result->fetch_assoc()) {
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i , $row_array['username']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$i , $row_array['password']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i , $row_array['admin']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i , $row_array['user_type']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i , $row_array['user_id']);
			$i++;
	}


$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Something');

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('User');

// Create a new worksheet, after the default sheet
$objPHPExcel->createSheet();

// Add some data to the second sheet, resembling some different data types
$objPHPExcel->setActiveSheetIndex(1);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "user_id");
			$objPHPExcel->getActiveSheet()->setCellValue('B1', "first_name");
			$objPHPExcel->getActiveSheet()->setCellValue('C1', "last_name");
			$objPHPExcel->getActiveSheet()->setCellValue('D1', "nickname");
			$objPHPExcel->getActiveSheet()->setCellValue('E1', "grad_year");
			$objPHPExcel->getActiveSheet()->setCellValue('F1', "father_name");
			$objPHPExcel->getActiveSheet()->setCellValue('G1', "mother_name");
			$objPHPExcel->getActiveSheet()->setCellValue('H1', "email");
			$objPHPExcel->getActiveSheet()->setCellValue('I1', "phone");
			$objPHPExcel->getActiveSheet()->setCellValue('J1', "family_details");
			$objPHPExcel->getActiveSheet()->setCellValue('K1', "work_experience");
			$objPHPExcel->getActiveSheet()->setCellValue('L1', "awards");
			$objPHPExcel->getActiveSheet()->setCellValue('M1', "street");
			$objPHPExcel->getActiveSheet()->setCellValue('N1', "city");
			$objPHPExcel->getActiveSheet()->setCellValue('O1', "state");
			$objPHPExcel->getActiveSheet()->setCellValue('P1', "zip");
			$objPHPExcel->getActiveSheet()->setCellValue('Q1', "notes");
			$objPHPExcel->getActiveSheet()->setCellValue('R1', "photo");
			$objPHPExcel->getActiveSheet()->setCellValue('S1', "donation");
			$objPHPExcel->getActiveSheet()->setCellValue('T1', "attending");

$sql = "SELECT * FROM students";

$result = $conn->query($sql);

$i = 2;
	while ($row_array = $result->fetch_assoc()) {
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i , $row_array['user_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$i , $row_array['last_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i , $row_array['first_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i , $row_array['nickname']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i , $row_array['grad_year']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i , $row_array['father_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$i , $row_array['mother_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i , $row_array['email']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i , $row_array['phone']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$i , $row_array['family_details']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i , $row_array['work_experience']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i , $row_array['awards']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i , $row_array['street']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$i , $row_array['city']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$i , $row_array['state']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$i , $row_array['zip']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i , $row_array['notes']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$i , $row_array['photo']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$i , $row_array['donation']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$i , $row_array['attending']);
			$i++;
	}

// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('Students');

$objPHPExcel->createSheet();

// Add some data to the third sheet, resembling some different data types
$objPHPExcel->setActiveSheetIndex(2);

			$objPHPExcel->getActiveSheet()->setCellValue('A1', "first_name");
			$objPHPExcel->getActiveSheet()->setCellValue('B1', "last_name");
			$objPHPExcel->getActiveSheet()->setCellValue('C1', "nickname");
			$objPHPExcel->getActiveSheet()->setCellValue('D1', "start_year");
			$objPHPExcel->getActiveSheet()->setCellValue('E1', "end_year");
			$objPHPExcel->getActiveSheet()->setCellValue('F1', "end_year");
			$objPHPExcel->getActiveSheet()->setCellValue('G1', "father_name");
			$objPHPExcel->getActiveSheet()->setCellValue('H1', "mother_name");
			$objPHPExcel->getActiveSheet()->setCellValue('I1', "email");
			$objPHPExcel->getActiveSheet()->setCellValue('J1', "phone");
			$objPHPExcel->getActiveSheet()->setCellValue('K1', "family_details");
			$objPHPExcel->getActiveSheet()->setCellValue('L1', "work_experience");
			$objPHPExcel->getActiveSheet()->setCellValue('M1', "awards");
			$objPHPExcel->getActiveSheet()->setCellValue('N1', "street");
			$objPHPExcel->getActiveSheet()->setCellValue('O1', "city");
			$objPHPExcel->getActiveSheet()->setCellValue('P1', "state");
			$objPHPExcel->getActiveSheet()->setCellValue('Q1', "zip");
			$objPHPExcel->getActiveSheet()->setCellValue('R1', "notes");
			$objPHPExcel->getActiveSheet()->setCellValue('S1', "photo");
			$objPHPExcel->getActiveSheet()->setCellValue('T1', "donation");
			$objPHPExcel->getActiveSheet()->setCellValue('U1', "attending");

$sql = "SELECT * FROM teachers";

$result = $conn->query($sql);

$i = 2;
	while ($row_array = $result->fetch_assoc()) {
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i , $row_array['user_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$i , $row_array['last_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i , $row_array['first_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i , $row_array['nickname']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i , $row_array['start_year']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i , $row_array['end_year']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$i , $row_array['father_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i , $row_array['mother_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i , $row_array['email']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$i , $row_array['phone']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i , $row_array['family_details']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i , $row_array['work_experience']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i , $row_array['awards']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$i , $row_array['street']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$i , $row_array['city']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$i , $row_array['state']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i , $row_array['zip']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$i , $row_array['notes']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$i , $row_array['photo']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$i , $row_array['donation']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$i , $row_array['attending']);
			$i++;
	}


// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('Teachers');

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reunion.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>

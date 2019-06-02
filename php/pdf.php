<?php

require '../fpdf/fpdf.php';

$pdf = new FPDF;
$conn = '';
$last_id = '';

try {
    $conn = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $query = "SELECT id FROM user_data";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $last_elem = end($datas);
    foreach ($last_elem as $value) {
        $last_id = $value;
    }

} catch (PDOException $e) {
    echo $e->getMessage();
}

$pdf->AddPage();
$pdf->SetFont("Times", "B", 18);
$pdf->Image('../images/cv.png', 10, 10);
$pdf->Cell(0, 10, "CV", 0, 1, "C");
$pdf->SetFont("Times", "", 16);
$pdf->Cell(0, 20, "Pamatinformācija", 0, 1);
$pdf->SetFillColor(233, 229, 229);
$pdf->Rect(10, 34, 190, 2, 'F');

$query = "SELECT * FROM images WHERE id='{$last_id}'";
// $query = "SELECT * FROM images WHERE id='1'";

$stmtImg = $conn->prepare($query);
$stmtImg->execute();
$img = $stmtImg->fetchAll(PDO::FETCH_ASSOC);

if (!empty($img[0]['img_name'])) {
    $pdf->Cell(0, 35, "", 0, 1);
    $pdf->Image("../images/{$img[0]['img_name']}", 82, 40, 30);
}

$pdf->SetFont("Times", "", 12);
$pdf->Cell(70, 5, "Vārds, Uzvārds:", 0, 0, "R");
$pdf->SetFont("Times", "B", 14);

$query = "SELECT * FROM user_data WHERE id='{$last_id}'";
// $query = "SELECT * FROM user_data WHERE id='1'";

$stmtData = $conn->prepare($query);
$stmtData->execute();
$datas = $stmtData->fetchAll(PDO::FETCH_ASSOC);

foreach ($datas as $data) {
    $pdf->Cell(0, 5, $data['name'], 0, 1);
    $pdf->SetFont("Times", "", 12);
    $pdf->Cell(70, 5, "Dzimšanas datums:", 0, 0, "R");
    $pdf->Cell(0, 5, $data['birth_day'] . '. ' . $data['birth_month'] . ' ' . $data['birth_year'] . '.g.', 0, 1);
    $pdf->Cell(70, 5, "E-pasta adrese:", 0, 0, "R");
    $pdf->SetFont("Times", "U");
    $pdf->SetTextColor(28, 23, 172);
    $pdf->Cell(0, 5, $data['email'], 0, 1);
}

$pdf->SetFont("Times", "", 16);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 20, "Iemaņas un zināšanas", 0, 1);
$pdf->SetFillColor(233, 229, 229);

if (!empty($img[0]['img_name'])) {
    $pdf->Rect(10, 104, 190, 2, 'F');
} else {
    $pdf->Rect(10, 69, 190, 2, 'F');
}

$pdf->SetFont("Times", "B", 14);
$pdf->Cell(0, 10, "Valodu zināšanas", 0, 1);
$pdf->SetFont("Times", "", 14);
$pdf->SetFillColor(233, 229, 229);
$pdf->SetDrawColor(255, 255, 255);
$pdf->Cell(10, 5, "", 1, 0, "", TRUE);
$pdf->Cell(45, 5, "Valoda", 1, 0, "", TRUE);
$pdf->Cell(45, 5, "Runātprasme", 1, 0, "", TRUE);
$pdf->Cell(45, 5, "Lasītprasme", 1, 0, "", TRUE);
$pdf->Cell(45, 5, "Rakstītprasme", 1, 1, "", TRUE);
$pdf->SetDrawColor(233, 229, 229);
$pdf->SetFillColor(255, 255, 255);

$query = "SELECT * FROM lang WHERE id='{$last_id}'";
// $query = "SELECT * FROM lang WHERE id='1'";

$stmtLang = $conn->prepare($query);
$stmtLang->execute();
$lang = $stmtLang->fetchAll(PDO::FETCH_ASSOC);
$i = 1;

foreach ($lang as $key => $value) {
    $pdf->Cell(10, 5, $i . ".", 1, 0, "", TRUE);
    $pdf->Cell(45, 5, $value['language'], 1, 0, "", TRUE);
    $pdf->Cell(45, 5, $value['speaking'], 1, 0, "", TRUE);
    $pdf->Cell(45, 5, $value['reading'], 1, 0, "", TRUE);
    $pdf->Cell(45, 5, $value['writing'], 1, 1, "", TRUE);
    $i++;
}

$pdf->SetFont("Times", "", 16);
$pdf->Cell(0, 20, "Izglītība", 0, 1);
$pdf->SetFillColor(233, 229, 229);

$row = 3;
$hWithImg = 154;
$hNoImg = 119;
$countRow = $stmtLang->rowCount();
$heightWithImg = $hWithImg + (($countRow - $row) * 5);
$heightNoImg = $hNoImg + (($countRow - $row) * 5);

if (!empty($img[0]['img_name'])) {
    $pdf->Rect(10, $heightWithImg, 190, 2, 'F');

} else {
    $pdf->Rect(10, $heightNoImg, 190, 2, 'F');
}

$query = "SELECT * FROM school WHERE id='{$last_id}'";
// $query = "SELECT * FROM school WHERE id='1'";

$stmtSchool = $conn->prepare($query);
$stmtSchool->execute();
$school = $stmtSchool->fetchAll(PDO::FETCH_ASSOC);

foreach ($school as $data) {
    $pdf->SetFont("Times", "", 14);
    $pdf->Cell(80, 7, "Izglītības iestādes nosaukums:", 0, 0, "R");
    $pdf->SetFont("Times", "B", 14);
    $pdf->Cell(0, 7, $data['school'], 0, 1);
    $pdf->SetFont("Times", "", 14);
    $pdf->Cell(80, 7, "Periods:", 0, 0, "R");
    $pdf->Cell(0, 7, $data['year_from'] . "g. - " . $data['year_to'] . "g.", 0, 1);
    $pdf->Cell(80, 7, "Specialitāte:", 0, 0, "R");
    $pdf->Cell(0, 7, $data['profession'], 0, 1);
    $pdf->Cell(0, 10, "", 0, 1);
}

$pdf->output();

// $data_name = '';

// foreach ($datas as $data) {
//     $data_name = $data['name'] . '.pdf';
//     $pdf->output('D', $data_name);
// }

// try {
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $query = "INSERT INTO pdf (id, mime, data) VALUES (:id, :mime, :data)";

//     $stmt = $conn->prepare($query);

//     $stmt->execute(array(':id'=>$last_id, ':mime'=>'application/pdf', ':data'=>$data_name, PDO::PARAM_LOB));
    
// } catch (PDOException $e) {
//     echo $e->getMessage();
// }

// try {
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $query = "SELECT mime, data FROM pdf WHERE id='$last_id'";

//     $stmt = $conn->prepare($query);

//     $stmt->execute();
//     $pdf = $stmt->fetchAll(PDO::FETCH_BOUND);
//     header("Content-Type:" . $pdf['mime']);
//     echo $pdf['data'];;
    
// } catch (PDOException $e) {
//     echo $e->getMessage();
// }

?>

<?php
include_once('config.php');
include_once('fpdf182/fpdf.php');

$app_id = $_GET['id'];

// Create instance of PDF class
$pdf = new FPDF();

// Add 1 page in your PDF
$pdf->AddPage();

// Set Arial Bold font with size 22px
$pdf->SetFont("Arial", "B", 22);

// Write text with 0 width & height (it will still be visible)
$pdf->Cell(0, 0, "INVOICE");
$pdf->Ln();
$pdf->SetY(50);
// Sets the background color to light gray
$pdf->SetFillColor(209, 207, 207);
$pdf->SetFont("Arial", "B", 10);
// Cell
$pdf->Cell(40, 10, "Time of Print", 1, 0, "C", true);
$pdf->Cell(40, 10, "Client", 1, 0, "C", true);
$pdf->Cell(40, 10, "Service", 1, 0, "C", true);
$pdf->Cell(20, 10, "Price", 1, 0, "C", true);
$pdf->Cell(20, 10, "VAT", 1, 0, "C", true);
$pdf->Cell(20, 10, "Value", 1, 0, "C", true);

$pdf->Ln();
$pdf->SetFont("Arial", "", 10);
// Getting records from database

$result = mysqli_query($conn, "SELECT * FROM `web20_appointment` WHERE `app_id` = '{$app_id}'");
$total = 0;
$time = date("Y.m.d h:i:sa");
// Iterate through each record
while ($row = mysqli_fetch_object($result))
{
	$pdf->Cell(40, 20, $time, 1);
	$pdf->Cell(40, 20, $row->client_id, 1);
	$pdf->Cell(40, 20, $row->service_name, 1);
	$pdf->Cell(20, 20, "$" .$row->price, 1, "C");
	$pdf->Cell(20, 20, "$" .$row->vat, 1, "C");
	$pdf->Cell(20, 20, "$" .$row->total, 1, "C");
	$total += $row->total;
	// Moving cursor to next row
	$pdf->Ln();
}
$current_y = $pdf->GetY();
$current_x = $pdf->GetX();
$pdf->SetXY($current_x + 140, $current_y);
$pdf->Cell(20, 20, "TOTAL", 1, 0, "C", true);
$pdf->Cell(20, 20, "$" .$total, 1, "C");

// Creates a file in server
$title = "Invoice_".date("Y.m.d h:i:sa").".pdf";
$pdf->Output( 'D', $title, true );

?>
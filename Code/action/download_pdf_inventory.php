<?php
include_once('config.php');
include_once('fpdf182/fpdf.php');

// Create instance of PDF class
$pdf = new FPDF();

// Add 1 page in your PDF
$pdf->AddPage();

// Set Arial Bold font with size 22px
$pdf->SetFont("Arial", "B", 16);

// Write text "Products Table" with 0 width & height (it will still be visible)
$pdf->Cell(0, 0, "Products Table");

// Move the cursor to next line
$pdf->Ln();
$pdf->SetY(50);
// Sets the background color to light gray
$pdf->SetFillColor(209, 207, 207);
$pdf->SetFont("Arial", "B", 10);
// Cell
$pdf->Cell(40, 10, "Code", 1, 0, "C", true);
$pdf->Cell(40, 10, "Brand", 1, 0, "C", true);
$pdf->Cell(40, 10, "Category", 1, 0, "C", true);
$pdf->Cell(20, 10, "Quantity", 1, 0, "C", true);
$pdf->Cell(20, 10, "Price", 1, 0, "C", true);
$pdf->Cell(20, 10, "Value", 1, 0, "C", true);

$pdf->Ln();
$pdf->SetFont("Arial", "", 10);
// Getting records from database
$result = mysqli_query($conn, "SELECT * FROM `web20_product`");
$total = 0;
// Iterate through each record
while ($row = mysqli_fetch_object($result))
{
	$pdf->Cell(40, 20, $row->product_code, 1);
	$pdf->Cell(40, 20, $row->brand, 1);
	$pdf->Cell(40, 20, $row->category, 1);
	$pdf->Cell(20, 20, $row->quantity, 1, "C");
	$pdf->Cell(20, 20, "$" .$row->price, 1, "C");
	$value = $row->quantity * $row->price;
	$pdf->Cell(20, 20, "$" .$value, 1, "C");
	$total += $value;
	// Moving cursor to next row
	$pdf->Ln();
}
$current_y = $pdf->GetY();
$current_x = $pdf->GetX();
$pdf->SetXY($current_x + 140, $current_y);
$pdf->Cell(20, 20, "TOTAL", 1, 0, "C", true);
$pdf->Cell(20, 20, "$" .$total, 1, "C");

// Creates a file in server
$title = "Inventory.".date("Y.m.d h:i:sa").".pdf";
$pdf->Output( 'D', $title, true );

?>
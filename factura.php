if(count($otros_costos)>0){
    $pdf->Ln(14);
    $pdf->Cell(133);
    $pdf->SetFont('dejavusans','',10);
    $pdf->Cell(130,7,"  Otros Costos: ", '',0,0,'L',true);

}
$total = 0;

foreach($otros_costos as $costo){
    $total = $total + $costo->ingreso;
    $pdf->Ln(7);
    $pdf->Cell(133);
    $pdf->SetFont('dejavusans','',10);
    $pdf->Cell(40,7,'  '.$costo->descripcion, 'LTRB',0,0,'L',true);
    $pdf->SetFont('dejavusans','B',10);
    $pdf->Cell(90,7,'  $'.number_format($costo->ingreso).'  ','TRB',0,'R',0,true);
}

$pdf->Ln(14);
$pdf->Cell(133);
$pdf->SetFont('dejavusans','',10);
$pdf->Cell(40,7,'  TOTAL', 'LTRB',0,0,'L',true);
$pdf->SetFont('dejavusans','B',10);
$pdf->Cell(90,7,'  $'.number_format($reparacion->saldo + $total).'  ','TRB',0,'R',0,true);
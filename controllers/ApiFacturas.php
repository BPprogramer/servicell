<?php

namespace Controllers;

use Model\Ingreso;
use TCPDF;
use Model\Reparacion;

class ApiFacturas
{
    public static function facturaInicial()
    {

        if (!is_cliente() || !is_admin()) {
            $idReparacion = base64_decode($_GET['key']);

            $id = filter_var($idReparacion, FILTER_VALIDATE_INT);
            if (!$id) {
                echo json_encode(['type' => 'error', 'msg' => 'Hubo un error Intenta Nuevamente']);
                return;
            }
            $reparacion = Reparacion::find($id);
            $accesoriosArray = json_decode($reparacion->accesorios, true);
            $string = '';
            foreach ($accesoriosArray as $key => $value) {
                if ($value == true) {
                    $string .= $key . ', ';
                }
            }
            $string = substr($string, 0, -2);



            mb_internal_encoding('UTF-8');
            // $factura->formatearDatosNumber();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->setPrintHeader(false);

            $pdf->AddPage('p', 'A4');
            $pdf->SetMargins(17, 10, 17);
            // # Logo de la empresa formato png #


            $pdf->Image('../public/img_logo/logo_pdf.jpg', 21, 8, 43, 48, 'JPG');

            $pdf->Ln(2);




            // # Encabezado y datos de la empresa #
            $pdf->Cell(40);
            $pdf->SetFont('dejavusans', 'B', 13);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(150, 10, 'Servicio Técnico Profesional en Telefonía Móvil', 0, 0, 'C');


            $pdf->Ln(10);

            $pdf->Cell(40);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(150, 10, 'Carrera 4a#4-51 Primera Planta Hotel San Francisco - El Tablón de Gómez', 0, 0, 'C');
            $pdf->Ln(10);

            $pdf->Cell(40);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(150, 10, 'WhatsApp: 3186110319 -  Email: servicelltablon@outlook.es', 0, 0, 'C');



            $pdf->Ln(10);
            $pdf->Cell(40);
            $pdf->SetFont('dejavusans', 'B', 10);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(150, 10, 'ALEXÁNDER VELÁSQUEZ MARTÍNEZ', 0, 0, 'C');





            $pdf->Ln(25);

            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('dejavusans', 'B', 10);
            $pdf->SetFillColor(197, 211, 232);



            $pdf->Cell(30, 7, "  FECHA", 1, 0, 'L', true);



            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('dejavusans', 'B', 10);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(30, 7, "  $reparacion->fecha_ingreso", 'TRB', 0, 0, 'L', true);
            $pdf->Cell(59);
            $pdf->SetFont('dejavusans', 'B', 10);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  ORDEN", 1, 0, 'LR', true);
            $pdf->SetFont('dejavusans', 'B', 10);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->Cell(30, 7, "  $reparacion->codigo", 'LTBR', 0, 'C', 0, true);

            $pdf->Ln(10);
            //informacion cCliente
            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->Cell(88, 7, "INFORMACION DEL CLIENTE", 1, 0, 'C', true);
            $pdf->Cell(3);
            $pdf->Cell(88, 7, "INFORMACION DEL DISPOSITIVO", 1, 0, 'C', true);

            $pdf->Ln(7);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  Usuario: ", 'LTR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  " . strtoupper($reparacion->nombre), 'TR', 0, 0, 'L', true);

            $pdf->Cell(3);
            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  Marca: ", 'LTR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->Cell(58, 7, "  " . strtoupper($reparacion->marca), 'TR', 0, 0, 'L', true);

            $pdf->Ln(7);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  Cédula / NIT: ", 'LTR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  $reparacion->cedula_nit", 'TR', 0, 0, 'L', true);

            $pdf->Cell(3);
            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  Modelo: ", 'LTR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  " . strtoupper($reparacion->modelo), 'TR', 0, 0, 'L', true);

            $pdf->Ln(7);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  Celular: ", 'LTR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  $reparacion->celular", 'TRB', 0, 0, 'L', true);

            $pdf->Cell(3);
            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  IMEI 1: ", 'LTR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  $reparacion->imei_1", 'TRB', 0, 0, 'L', true);
            $pdf->Ln(7);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  Dirección: ", 'LTRB', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  " . strtoupper($reparacion->direccion), 'TRB', 0, 0, 'L', true);

            $pdf->Cell(3);
            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  IMEI 2: ", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  $reparacion->imei_2", 'TRB', 0, 0, 'L', true);



            $pdf->SetFont('dejavusans', 'B', 9);
            // $pdf->Cell(54,6,$reparacion->marca.'  ',1,0,'R',true);
            $pdf->Ln(15);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(65, 7, "  FALLA QUE REPORTA EL CLIENTE: ", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->Cell(114, 7, "  $reparacion->falla", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->Ln(7);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(65, 7, "  PROCEDIMIENTO A REALIZAR: ", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->Cell(114, 7, "  $reparacion->proceso", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->Ln(7);

            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(65, 7, "  ACCESORIOS: ", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->Cell(114, 7, "  $string", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->Ln(14);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  PAGINA : ", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', '', 8);
            $pdf->Cell(45, 7, "servicell.zonasoftware.online", 'LTBR', 0, 'C', 0, true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(20, 7, "  USUARIO: ", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', '', 8);
            $pdf->Cell(20, 7, "$reparacion->celular", 'LTBR', 0, 'C', 0, true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  CONTRASEÑA: ", 'LTBR', 0, 0, 'L', true);

            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', '', 8);
            $pdf->Cell(34, 7, "$reparacion->cedula_nit", 'LTBR', 0, 'C', 0, true);




            $pdf->Ln();
            $pdf->Ln();

            $pdf->SetFont('dejavusans', 'B', 10);

            $pdf->Cell(179, 7, "  OBSERVACIONES: ", 'LTR', 0, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->SetFont('dejavusans', '', 10);
            $pdf->setCellPaddings(4, 2, 4, 2);
            $pdf->MultiCell(179, 5, $reparacion->observacion, 'LRB', 'L', 1, 0, '', '', true);








            $pdf->Ln();

            $pdf->Ln(7);


            /* Informacion a pagar */



            $pdf->setCellPaddings(0, 0, 0, 0);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(40, 7, "  VALOR CONVENIDO: ", 'TBLR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(30, 7, '$' . number_format($reparacion->valor_convenido) . '  ', 'TBLR', 0, 'C', 0, true);

            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(22, 7, "  ABONO: ", 'TLBR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->Cell(30, 7, '$' . number_format($reparacion->abono), 'LTBR', 0, 'C', 0, true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(22, 7, "  SALDO: ", 'TBR', 0, 0, 'L', true);

            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->Cell(35, 7, '$' . number_format($reparacion->saldo), 'LTBR', 0, 'C', 0, true);


            $pdf->Ln(7);
            $pdf->Ln(7);
            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->Cell(90, 30, "  ", 'TBRB', '', 0, 0, 'L', true);



            $pdf->Cell(89, 30, "  ", 'TBRB', '', 0, 0, 'L', true);

            $pdf->Ln();
            $pdf->SetFillColor(197, 211, 232);

            $pdf->SetFont('dejavusans', 'B', 9);

            $pdf->Cell(90, 10, 'FIRMA DEL TÉCNICO', 'TBRB', 0, 'C', true);

            $pdf->SetFont('dejavusans', '', 9);
            // $pdf->SetFillColor(255,255,255);


            // $pdf->SetFillColor(197,211,232);

            $pdf->SetFillColor(197, 211, 232);
            $pdf->SetFont('dejavusans', 'B', 9);


            $pdf->Cell(89, 10, 'FIRMA PROPIETARIO DEL EQUIPO', 'TBRB', 0, 'C', true);






            $pdf->Ln(7);
            $pdf->Ln(7);

            $pdf->SetFillColor(220, 255, 220);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('dejavusans', '', 8.6);

            $pdf->Cell(170, 10, 'No se hace responsable por teléfonos o accesorios que no sean reclamados después de 30 días. ', 0, 0, 'C');
            $pdf->Ln(5);
            $pdf->Cell(170, 10, 'El propietario del equipo se hace responsable por la procedencia del celular. ', 0, 0, 'C');
            $pdf->Ln(5);



            $pdf->Output($reparacion->nombre . '-' . date('Y-m-d') . '.pdf', 'I');
        }
    }
    public static function facturaFinal()
    {

        if (!is_cliente() || !is_admin()) {
            $idReparacion = base64_decode($_GET['key']);

            $id = filter_var($idReparacion, FILTER_VALIDATE_INT);
            if (!$id) {
                echo json_encode(['type' => 'error', 'msg' => 'Hubo un error Intenta Nuevamente']);
                return;
            }
            $reparacion = Reparacion::find($id);
            $otros_costos = Ingreso::whereArray(['reparacion_id' => $reparacion->id]);

            $accesoriosArray = json_decode($reparacion->accesorios, true);
            $string = '';
            foreach ($accesoriosArray as $key => $value) {
                if ($value == true) {
                    $string .= $key . ', ';
                }
            }
            $string = substr($string, 0, -2);



            mb_internal_encoding('UTF-8');
            // $factura->formatearDatosNumber();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->setPrintHeader(false);

            $pdf->AddPage('p', 'A4');
            $pdf->SetMargins(17, 10, 17);
            // # Logo de la empresa formato png #


            $pdf->Image('../public/img_logo/logo_pdf.jpg', 21, 8, 43, 48, 'JPG');

            $pdf->Ln(2);




            // # Encabezado y datos de la empresa #
            $pdf->Cell(40);
            $pdf->SetFont('dejavusans', 'B', 13);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(150, 10, 'Servicio Técnico Profesional en Telefonía Móvil', 0, 0, 'C');


            $pdf->Ln(10);

            $pdf->Cell(40);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(150, 10, 'Carrera 4a#4-51 Primera Planta Hotel San Francisco - El Tablón de Gómez', 0, 0, 'C');
            $pdf->Ln(10);

            $pdf->Cell(40);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(150, 10, 'WhatsApp: 3186110319 -  Email: servicelltablon@outlook.es', 0, 0, 'C');



            $pdf->Ln(10);
            $pdf->Cell(40);
            $pdf->SetFont('dejavusans', 'B', 10);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(150, 10, 'ALEXÁNDER VELÁSQUEZ MARTÍNEZ', 0, 0, 'C');





            $pdf->Ln(25);

            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('dejavusans', 'B', 10);
            $pdf->SetFillColor(197, 211, 232);



            $pdf->Cell(30, 7, "  FECHA", 1, 0, 'L', true);



            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('dejavusans', 'B', 10);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(30, 7, "  $reparacion->fecha_ingreso", 'TRB', 0, 0, 'L', true);
            $pdf->Cell(59);
            $pdf->SetFont('dejavusans', 'B', 10);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  ORDEN", 1, 0, 'LR', true);
            $pdf->SetFont('dejavusans', 'B', 10);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->Cell(30, 7, "  $reparacion->codigo", 'LTBR', 0, 'C', 0, true);

            $pdf->Ln(10);
            //informacion cCliente
            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->Cell(88, 7, "INFORMACION DEL CLIENTE", 1, 0, 'C', true);
            $pdf->Cell(3);
            $pdf->Cell(88, 7, "INFORMACION DEL DISPOSITIVO", 1, 0, 'C', true);

            $pdf->Ln(7);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  Usuario: ", 'LTR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  " . strtoupper($reparacion->nombre), 'TR', 0, 0, 'L', true);

            $pdf->Cell(3);
            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  Marca: ", 'LTR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->Cell(58, 7, "  " . strtoupper($reparacion->marca), 'TR', 0, 0, 'L', true);

            $pdf->Ln(7);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  Cédula / NIT: ", 'LTR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  $reparacion->cedula_nit", 'TR', 0, 0, 'L', true);

            $pdf->Cell(3);
            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  Modelo: ", 'LTR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  " . strtoupper($reparacion->modelo), 'TR', 0, 0, 'L', true);

            $pdf->Ln(7);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  Celular: ", 'LTR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  $reparacion->celular", 'TRB', 0, 0, 'L', true);

            $pdf->Cell(3);
            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  IMEI 1: ", 'LTR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  $reparacion->imei_1", 'TRB', 0, 0, 'L', true);
            $pdf->Ln(7);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  Dirección: ", 'LTRB', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  " . strtoupper($reparacion->direccion), 'TRB', 0, 0, 'L', true);

            $pdf->Cell(3);
            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  IMEI 2: ", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(58, 7, "  $reparacion->imei_2", 'TRB', 0, 0, 'L', true);



            $pdf->SetFont('dejavusans', 'B', 9);
            // $pdf->Cell(54,6,$reparacion->marca.'  ',1,0,'R',true);
            $pdf->Ln(15);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(65, 7, "  FALLA QUE REPORTA EL CLIENTE: ", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->Cell(114, 7, "  $reparacion->falla", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->Ln(7);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(65, 7, "  PROCEDIMIENTO A REALIZAR: ", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->Cell(114, 7, "  $reparacion->proceso", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->Ln(7);

            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(65, 7, "  ACCESORIOS: ", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', '', 9);
            $pdf->Cell(114, 7, "  $string", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->Ln(14);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  PAGINA : ", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', '', 8);
            $pdf->Cell(45, 7, "servicell.zonasoftware.online", 'LTBR', 0, 'C', 0, true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(20, 7, "  USUARIO: ", 'LTBR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', '', 8);
            $pdf->Cell(20, 7, "$reparacion->celular", 'LTBR', 0, 'C', 0, true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(30, 7, "  CONTRASEÑA: ", 'LTBR', 0, 0, 'L', true);

            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', '', 8);
            $pdf->Cell(34, 7, "$reparacion->cedula_nit", 'LTBR', 0, 'C', 0, true);




            $pdf->Ln();
            $pdf->Ln();

            $pdf->SetFont('dejavusans', 'B', 10);

            $pdf->Cell(179, 7, "  OBSERVACIONES: ", 'LTR', 0, 0, 'L', true);
            $pdf->Ln(7);
            $pdf->SetFont('dejavusans', '', 10);
            $pdf->setCellPaddings(4, 2, 4, 2);
            $pdf->MultiCell(179, 5, $reparacion->observacion, 'LRB', 'L', 1, 0, '', '', true);








            $pdf->Ln();

            $pdf->Ln(7);


            /* Informacion a pagar */



            $pdf->setCellPaddings(0, 0, 0, 0);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(40, 7, "  VALOR CONVENIDO: ", 'TBLR', 0, 0, 'L', true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Cell(30, 7, '$' . number_format($reparacion->valor_convenido) . '  ', 'TBLR', 0, 'C', 0, true);

            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(22, 7, "  ABONO: ", 'TLBR', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->Cell(30, 7, '$' . number_format($reparacion->abono), 'LTBR', 0, 'C', 0, true);
            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->Cell(22, 7, "  SALDO: ", 'TBR', 0, 0, 'L', true);

            $pdf->SetFillColor(255, 255, 255);

            $pdf->SetFont('dejavusans', 'B', 9);
            $pdf->Cell(35, 7, '$' . number_format($reparacion->saldo), 'LTBR', 0, 'C', 0, true);




            if (count($otros_costos) > 0) {
                $pdf->Ln(14);
                $pdf->Cell(48);
                $pdf->SetFont('dejavusans', '', 9);
                $pdf->Cell(130, 7, "  COSTOS EXTRAS: ", '', 0, 0, 'L', true);
            }
            $total = 0;

            foreach ($otros_costos as $costo) {
                $total = $total + $costo->ingreso;
                $pdf->Ln(7);
                $pdf->Cell(49);

                $pdf->SetFillColor(197, 211, 232);
                $pdf->SetFont('dejavusans', 'B', 10);
                $pdf->Cell(90, 7, '  ' . strtoupper($costo->descripcion), 'LTRB', 0, 0, 'L', true);
                $pdf->SetFont('dejavusans', 'B', 10);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->Cell(40, 7, '$' . number_format($costo->ingreso), 'LTBR', 0, 'C', 0, true);
            }

            $pdf->Ln(14);
            $pdf->Cell(49);
            $pdf->SetFillColor(197, 211, 232);
            $pdf->SetFont('dejavusans', 'B', 10);
            $pdf->Cell(90, 7, '  GRAN TOTAL', 'LTRB', 0, 0, 'L', true);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('dejavusans', 'B', 10);
            $pdf->Cell(40, 7, '$' . number_format($reparacion->saldo + $total), 'LTBR', 0, 'C', 0, true);


            $pdf->Ln(7);
            $pdf->Ln(7);
            $pdf->SetFont('dejavusans', '', 9);
            $pdf->SetFillColor(197, 211, 232);

            $pdf->Cell(90, 30, "  ", 'TBRB', '', 0, 0, 'L', true);




            $pdf->Cell(89, 30, "  ", 'TBRB', '', 0, 0, 'L', true);

            $pdf->Ln();
            $pdf->SetFillColor(197, 211, 232);

            $pdf->SetFont('dejavusans', 'B', 9);

            $pdf->Cell(90, 10, 'FIRMA DEL TÉCNICO', 'TBRB', 0, 'C', true);

            $pdf->SetFont('dejavusans', '', 10);
            // $pdf->SetFillColor(255,255,255);


            // $pdf->SetFillColor(197,211,232);

            $pdf->SetFillColor(197, 211, 232);
            $pdf->SetFont('dejavusans', 'B', 10);


            $pdf->Cell(89, 10, 'FIRMA PROPIETARIO DEL EQUIPO', 'TBRB', 0, 'C', true);






            $pdf->Ln(7);
            $pdf->Ln(7);


            $pdf->SetFillColor(220, 255, 220);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('dejavusans', '', 8.6);

            $pdf->Cell(170, 10, 'No se hace responsable por teléfonos o accesorios que no sean reclamados después de 30 días. ', 0, 0, 'C');
            $pdf->Ln(5);
            $pdf->Cell(170, 10, 'El propietario del equipo se hace responsable por la procedencia del celular. ', 0, 0, 'C');
            $pdf->Ln(5);



            $pdf->Output($reparacion->nombre . '-' . date('Y-m-d') . '.pdf', 'I');
        }
    }
}

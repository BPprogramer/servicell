<?php 

namespace Controllers;

use Model\Ingreso;
use TCPDF;
use Model\Reparacion;

    class ApiFacturas{
        public static function facturaInicial(){

            if(!is_cliente( )|| !is_admin()){
                $idReparacion = base64_decode($_GET['key']);
              
                $id = filter_var($idReparacion, FILTER_VALIDATE_INT);
                if(!$id){
                    echo json_encode(['type'=>'error', 'msg'=>'Hubo un error Intenta Nuevamente']);
                    return;
                }
                $reparacion = Reparacion::find($id);
                $accesoriosArray = json_decode($reparacion->accesorios, true);
                $string = '';
                foreach($accesoriosArray as $key=>$value){
                    if($value==true){
                        $string.=$key. ', ';
                    }
                }
                $string = substr($string, 0 , -2);
           

              
                mb_internal_encoding('UTF-8');
                // $factura->formatearDatosNumber();
    
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                $pdf->setPrintHeader(false);
              
                $pdf->AddPage('p', 'A3');
                $pdf->SetMargins(17,10, 17);
                // # Logo de la empresa formato png #
    
            
                $pdf->Image('../public/img/LOGO_3.jpg',17,10,80,70,'JPG');

                $pdf->Ln(0);
        
        
        

                // # Encabezado y datos de la empresa #
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',11);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'Servicio técnico especializado - accesorios y repuestos - venta de celulares - ',0,0,'C');

                $pdf->Ln(7);
                $pdf->Cell(87);
                $pdf->Cell(150,10,'tablets - computadoras - memorias - reproductores mp3  ',0,0,'C');
            
                $pdf->Ln(7);
            
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'Nit: 98.355.002-2',0,0,'C');
                $pdf->Ln(7);
            
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'Matrícula Mercantil: 141377-1',0,0,'C');


        
                $pdf->Ln(7);
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'ALEXANDER VELASQUEZ M.',0,0,'C');
    
                $pdf->Ln(7);
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'WhatsApp: 3186110319',0,0,'C');
                $pdf->Ln(7);
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'servicelltablon@outlook.es',0,0,'C');
                $pdf->Ln(7);
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'El Tablón de Gómez',0,0,'C');
                $pdf->Ln(7);
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'Carrera 4a #4 - 51 Hotel San Francisco - Primer Pisi',0,0,'C');

                $pdf->Ln(20);

              //informacion cCliente
                $pdf->SetLineWidth(0.1);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetFillColor(255,255,255);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetTextColor(0,0,0);

                $pdf->Cell(130,7,"Información del Cliente",1,0,'C',true);
                $pdf->Cell(3);
                $pdf->Cell(130,7,"Información del Dispositivo",1,0,'C',true);

                $pdf->Ln(7);
    
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  Usuario: ", 'LT',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->nombre",'TR',0,0,'L',true);

                $pdf->Cell(3);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  Marca: ", 'LT',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->marca",'TR',0,0,'L',true);

                $pdf->Ln(7);
    
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  Cédula / NIT: ", 'LT',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->cedula_nit",'TR',0,0,'L',true);

                $pdf->Cell(3);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  Modelo: ", 'LT',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->modelo",'TR',0,0,'L',true);

                $pdf->Ln(7);
    
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  Celular: ", 'LT',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->celular",'TRB',0,0,'L',true);

                $pdf->Cell(3);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  IMEI 1: ", 'LT',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->imei_1",'TRB',0,0,'L',true);
                $pdf->Ln(7);
    
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  Dirección: ", 'LTB',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->direccion",'TRB',0,0,'L',true);

                $pdf->Cell(3);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  IMEI 2: ", 'LTB',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->imei_2",'TRB',0,0,'L',true);
           
      
       
                // $pdf->SetFont('dejavusans','B',10);
                // $pdf->Cell(54,6,$reparacion->marca.'  ',1,0,'R',true);
                $pdf->Ln(15);
                $pdf->Cell(263,7,"Falla Reportada por el Cliente:",1,0,'C',true);
                $pdf->Ln();
                
                $pdf->SetFont('dejavusans','',10);
                $pdf->MultiCell(263, 7, $reparacion->falla, 1, 'L', 1, 0, '', '', true);
                $pdf->SetFont('dejavusans','B',10);
                
                $pdf->Ln();
                $pdf->Cell(263,7,"Procedimiento a realizar:",1,0,'C',true);
                $pdf->Ln();

                $pdf->SetFont('dejavusans','',10);
                $pdf->MultiCell(263, 7, $reparacion->proceso, 1, 'L', 1, 0, '', '', true);
                $pdf->SetFont('dejavusans','B',10);
                
                $pdf->Ln();
                $pdf->Cell(263,7,"Observaciones:",1,0,'C',true);
                $pdf->Ln();

                $pdf->SetFont('dejavusans','',10);
                $pdf->MultiCell(263, 7, $reparacion->observacion, 1, 'L', 1, 0, '', '', true);

                $pdf->Ln();
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(263,7,"Accesorios",1,0,'C',true);
                $pdf->Ln(7);
         
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(263,7,$string,1,0,'C',true);
         
                $pdf->Ln();
                $pdf->Ln(7);

                /* Informacion a pagar */

           
    
                $pdf->Ln(7);
                $pdf->Cell(133);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(40,7,"  Fecha de Ingreso: ", 'LTR',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(90,7,$reparacion->fecha_ingreso.'  ','TR',0,'R',0,true);
                $pdf->Ln(7);
                $pdf->Cell(133);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(40,7,"  Valor Convenido: ", 'LTR',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(90,7,'$'.number_format($reparacion->valor_convenido).'  ','TR',0,'R',0,true);
                $pdf->Ln(7);
                $pdf->Cell(133);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(40,7,"  Abono: ", 'LTR',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(90,7,'$'.number_format($reparacion->abono).'  ','TR',0,'R',0,true);
                $pdf->Ln(7);
                $pdf->Cell(133);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(40,7,"  Saldo: ", 'LTRB',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(90,7,'$'.number_format($reparacion->saldo).'  ','TRB',0,'R',0,true);

               
                $pdf->Ln(7); 
                $pdf->Ln(7);      
                $pdf->Ln(7);
                $pdf->SetFillColor(220, 255, 220);


                $pdf->Output($reparacion->nombre.'-'.date('Y-m-d').'.pdf', 'I');
               
            }
            
        }
        public static function facturaFinal(){

            if(!is_cliente( )|| !is_admin()){
                $idReparacion = base64_decode($_GET['key']);
              
                $id = filter_var($idReparacion, FILTER_VALIDATE_INT);
                if(!$id){
                    echo json_encode(['type'=>'error', 'msg'=>'Hubo un error Intenta Nuevamente']);
                    return;
                }
                $reparacion = Reparacion::find($id);
                $otros_costos = Ingreso::whereArray(['reparacion_id'=>$reparacion->id]);
                
                $accesoriosArray = json_decode($reparacion->accesorios, true);
                $string = '';
                foreach($accesoriosArray as $key=>$value){
                    if($value==true){
                        $string.=$key. ', ';
                    }
                }
                $string = substr($string, 0 , -2);
           

              
                mb_internal_encoding('UTF-8');
                // $factura->formatearDatosNumber();
    
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                $pdf->setPrintHeader(false);
              
                $pdf->AddPage('p', 'A3');
                $pdf->SetMargins(17,10, 17);
                // # Logo de la empresa formato png #
    
            
                $pdf->Image('../public/img/LOGO_3.jpg',17,10,80,70,'JPG');

                $pdf->Ln(0);
        
        
        

                // # Encabezado y datos de la empresa #
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',11);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'Servicio técnico especializado - accesorios y repuestos - venta de celulares - ',0,0,'C');

                $pdf->Ln(7);
                $pdf->Cell(87);
                $pdf->Cell(150,10,'tablets - computadoras - memorias - reproductores mp3  ',0,0,'C');
            
                $pdf->Ln(7);
            
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'Nit: 98.355.002-2',0,0,'C');
                $pdf->Ln(7);
            
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'Matrícula Mercantil: 141377-1',0,0,'C');


        
                $pdf->Ln(7);
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'ALEXANDER VELASQUEZ M.',0,0,'C');
    
                $pdf->Ln(7);
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'WhatsApp: 3186110319',0,0,'C');
                $pdf->Ln(7);
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'servicelltablon@outlook.es',0,0,'C');
                $pdf->Ln(7);
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'El Tablón de Gómez',0,0,'C');
                $pdf->Ln(7);
                $pdf->Cell(87);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(150,10,'Carrera 4a #4 - 51 Hotel San Francisco - Primer Pisi',0,0,'C');

                $pdf->Ln(20);

              //informacion cCliente
                $pdf->SetLineWidth(0.1);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->SetFillColor(255,255,255);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetTextColor(0,0,0);

                $pdf->Cell(130,7,"Información del Cliente",1,0,'C',true);
                $pdf->Cell(3);
                $pdf->Cell(130,7,"Información del Dispositivo",1,0,'C',true);

                $pdf->Ln(7);
    
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  Usuario: ", 'LT',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->nombre",'TR',0,0,'L',true);

                $pdf->Cell(3);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  Marca: ", 'LT',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->marca",'TR',0,0,'L',true);

                $pdf->Ln(7);
    
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  Cédula / NIT: ", 'LT',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->cedula_nit",'TR',0,0,'L',true);

                $pdf->Cell(3);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  Modelo: ", 'LT',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->modelo",'TR',0,0,'L',true);

                $pdf->Ln(7);
    
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  Celular: ", 'LT',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->celular",'TRB',0,0,'L',true);

                $pdf->Cell(3);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  IMEI 1: ", 'LT',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->imei_1",'TRB',0,0,'L',true);
                $pdf->Ln(7);
    
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  Dirección: ", 'LTB',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->direccion",'TRB',0,0,'L',true);

                $pdf->Cell(3);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(30,7,"  IMEI 2: ", 'LTB',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(100,7,"$reparacion->imei_2",'TRB',0,0,'L',true);
           
      
       
                // $pdf->SetFont('dejavusans','B',10);
                // $pdf->Cell(54,6,$reparacion->marca.'  ',1,0,'R',true);
                $pdf->Ln(15);
                $pdf->Cell(263,7,"Falla Reportada por el Cliente:",1,0,'C',true);
                $pdf->Ln();
                
                $pdf->SetFont('dejavusans','',10);
                $pdf->MultiCell(263, 7, $reparacion->falla, 1, 'L', 1, 0, '', '', true);
                $pdf->SetFont('dejavusans','B',10);
                
                $pdf->Ln();
                $pdf->Cell(263,7,"Procedimiento a realizar:",1,0,'C',true);
                $pdf->Ln();

                $pdf->SetFont('dejavusans','',10);
                $pdf->MultiCell(263, 7, $reparacion->proceso, 1, 'L', 1, 0, '', '', true);
                $pdf->SetFont('dejavusans','B',10);
                
                $pdf->Ln();
                $pdf->Cell(263,7,"Observaciones:",1,0,'C',true);
                $pdf->Ln();

                $pdf->SetFont('dejavusans','',10);
                $pdf->MultiCell(263, 7, $reparacion->observacion, 1, 'L', 1, 0, '', '', true);

                $pdf->Ln();
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(263,7,"Accesorios",1,0,'C',true);
                $pdf->Ln(7);
         
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(263,7,$string,1,0,'C',true);
         
                $pdf->Ln();
                $pdf->Ln(7);

                /* Informacion a pagar */

           
    
                $pdf->Ln(7);
                $pdf->Cell(133);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(40,7,"  Fecha de Ingreso: ", 'LTR',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(90,7,$reparacion->fecha_ingreso.'  ','TR',0,'R',0,true);
                $pdf->Ln(7);
                $pdf->Cell(133);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(40,7,"  Valor Convenido: ", 'LTR',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(90,7,'$'.number_format($reparacion->valor_convenido).'  ','TR',0,'R',0,true);
                $pdf->Ln(7);
                $pdf->Cell(133);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(40,7,"  Abono: ", 'LTR',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(90,7,'$'.number_format($reparacion->abono).'  ','TR',0,'R',0,true);
                $pdf->Ln(7);
                $pdf->Cell(133);
                $pdf->SetFont('dejavusans','',10);
                $pdf->Cell(40,7,"  Saldo: ", 'LTRB',0,0,'L',true);
                $pdf->SetFont('dejavusans','B',10);
                $pdf->Cell(90,7,'$'.number_format($reparacion->saldo).'  ','TRB',0,'R',0,true);
                
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
       

                $pdf->Output($reparacion->nombre.'-'.date('Y-m-d').'.pdf', 'I');
               
            }
            
        }
    }
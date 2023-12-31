<?php 
    namespace Controllers;

use Model\Reparacion;

    class ApiInicio{
        public static function dashboard(){
            date_default_timezone_set('America/Bogota');
            $ingresos_totales = Reparacion::sumWhere('valor_final', 'estado',2);
            $gastos_totales = Reparacion::sumWhere('costo_final', 'estado',2);
            $ingresos_mes_actual = Reparacion::sumaPorFecha('valor_final', 'fecha_cierre', date('Y-m'), 'estado',2);
            //$costos_mes_actual = Reparacion::sumaPorFecha('costo_final', 'fecha_cierre', date('Y-m'), 'estado',2);
            
            $ganancias_mes_actual = $ingresos_mes_actual['suma'];

            $ingresos_3_meses = Reparacion::sumaPorFecha('valor_final', 'fecha_cierre', date('Y-m', strtotime('-3 month')), 'estado',2);
            //$costos_3_meses = Reparacion::sumaPorFecha('costo_final', 'fecha_cierre', date('Y-m', strtotime('-3 month')), 'estado',2);

            $ganancias_3_meses = $ingresos_3_meses['suma'];

            $pendientes = Reparacion::total('estado', 0);
            $reparadas = Reparacion::total('estado', 1);
            $cerradas = Reparacion::total('estado', 2);

            $info = [
                'ingresos_totales'=>$ingresos_totales['suma']??0,
                'gastos_totales'=>$gastos_totales['suma']??0,
                'ganancias'=>$ingresos_totales['suma']??0-$gastos_totales['suma']??0,
                'ganancias_mes_actual'=>$ganancias_mes_actual??0,
                'ganancias_3_meses'=>$ganancias_3_meses??0,
                'pendientes'=>$pendientes,
                'reparados'=>$reparadas,
                'cerrados'=>$cerradas
            ];
       
            echo json_encode($info);
        }
    }
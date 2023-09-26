<?php 
    namespace Model;

    use Model\ActiveRecord;

    class Ingreso extends ActiveRecord{
        protected static $tabla = 'ingresos';
        protected static $columnasDB = ['id','ingreso','descripcion', 'reparacion_id'];

        
        public $id;
        public $ingreso;
        public $descripcion;
        public $reparacion_id;


        
        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->ingreso = $args['ingreso'] ?? '';
            $this->descripcion = $args['descripcion'] ?? '';
            $this->reparacion_id = $args['reparacion_id'] ?? '';
            
        }

    
        public function formatearDatosFloat(){
            $this->ingreso = floatval(str_replace(',','',$this->ingreso));
           

        }
    }
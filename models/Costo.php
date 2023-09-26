<?php 
    namespace Model;

    use Model\ActiveRecord;

    class Costo extends ActiveRecord{
        protected static $tabla = 'costos';
        protected static $columnasDB = ['id','costo','descripcion', 'reparacion_id'];

        
        public $id;
        public $costo;
        public $descripcion;
        public $reparacion_id;


        
        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->costo = $args['costo'] ?? '';
            $this->descripcion = $args['descripcion'] ?? '';
            $this->reparacion_id = $args['reparacion_id'] ?? '';
            
        }

    
        public function formatearDatosFloat(){
            $this->costo = floatval(str_replace(',','',$this->costo));
           

        }
    }
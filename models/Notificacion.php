<?php 
    namespace Model;

    use Model\ActiveRecord;

    class Notificacion extends ActiveRecord{
        protected static $tabla = 'notificaciones';
        protected static $columnasDB = ['id','mensaje','imagenes', 'cliente_id','reparacion_id'];

        
        public $id;
        public $mensaje;
        public $imagenes;
        public $cliente_id;
        public $reparacion_id;


        
        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->mensaje = $args['mensaje'] ?? '';
            $this->imagenes = $args['imagenes'] ?? '';
            $this->cliente_id = $args['cliente_id'] ?? '';
            $this->reparacion_id = $args['reparacion_id'] ?? '';
            
        }

    
      
    }
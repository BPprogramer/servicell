<?php

    namespace Model;

    class Reparacion extends ActiveRecord {
        protected static $tabla = 'reparaciones';
        protected static $columnasDB = ['id', 'nombre', 'cedula_nit', 'celular', 'direccion','codigo' ,'marca', 'modelo', 'imei_1','imei_2', 'falla', 'proceso', 'valor_convenido', 'abono', 'saldo', 'valor_final', 'costo_final','accesorios','observacion','fecha_ingreso', 'fecha_cierre', 'estado','id_usuario', 'cliente_id'];

        public $id;
        public $nombre;
        public $cedula_nit;
        public $celular;
        public $direccion;
        public $codigo;
        public $marca;
        public $modelo;
        public $imei_1;
        public $imei_2;
        public $falla;
        public $proceso;
        public $valor_convenido;
        public $abono;
        public $saldo;
        public $valor_final;
        public $costo_final;
        public $accesorios;
        public $observacion;
        public $fecha_ingreso;
        public $fecha_cierre;
        public $estado;
        public $fecha;
        public $id_usuario;
        public $cliente_id;

        
        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->nombre = $args['nombre'] ?? '';
            $this->cedula_nit = $args['cedula_nit'] ?? '';
            $this->celular = $args['celular'] ?? '';
            $this->direccion = $args['direccion'] ?? '';
            $this->codigo = $args['direccion'] ?? null;
            $this->marca = $args['marca'] ?? '';
            $this->modelo = $args['modelo'] ?? '';
            $this->imei_1 = $args['imei_1'] ?? '';
            $this->imei_2 = $args['imei_2'] ?? '';
            $this->falla = $args['falla'] ?? '';
            $this->proceso = $args['proceso'] ?? '';
            $this->valor_convenido = $args['valor_convenido'] ?? '';
            $this->abono = $args['abono'] ?? '';
            $this->saldo = $args['saldo'] ?? '';
            $this->valor_final = $args['valor_final'] ?? '';
            $this->costo_final = $args['costo_final'] ?? '';
            $this->accesorios = $args['accesorios'] ?? '';
            $this->observacion = $args['observacion'] ?? '';
            $this->fecha_ingreso = $args['fecha_ingreso'] ?? '';
            $this->fecha_cierre = $args['fecha_cierre'] ?? '';
            $this->estado = $args['estado'] ?? '';

            $this->id_usuario = $args['id_usuario'] ?? '';
            $this->cliente_id = $args['cliente_id'] ?? '';
        }

    
        public function formatearDatosFloat(){
            $this->valor_convenido = floatval(str_replace(',','',$this->valor_convenido));
            $this->abono = floatval(str_replace(',','',$this->abono));
            $this->saldo = floatval(str_replace(',','',$this->saldo));

        }
    

 





   

   

   


}
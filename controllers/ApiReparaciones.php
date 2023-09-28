<?php 

    namespace Controllers;

    use Intervention\Image\ImageManagerStatic as Image;
    use Model\Reparacion;
    use Model\Costo;
use Model\Ingreso;
use Model\Notificacion;
use Model\Usuario;

    class ApiReparaciones{

        public static function reparaciones(){

            $reparaciones = Reparacion::all();
      
            $i=0;
            $datoJson = '{
             "data": [';
                 foreach($reparaciones as $key=>$reparacion){
                    $i++;

                    $acciones = "<div class='d-flex justify-content-center' >";
                    $acciones .="<button data-reparacion-id ='".$reparacion->id."' id='editar'  type='button' class='btn btn-sm bg-hover-azul mx-2 text-white toolMio'><span class='toolMio-text'>Editar</span><i class='fas fa-pen'></i></button>";
                    $acciones .= "<a class='btn btn-sm bg-hover-azul mx-2 text-white toolMio' href='/reparaciones/reparacion?id=$reparacion->id'><span class='toolMio-text'>Ver</span><i class='fa-solid fa-search'></i></a> ";
                    $acciones .="<button data-reparacion-id ='".$reparacion->id."' id='imprimir'  type='button' class='btn btn-sm bg-hover-azul mx-2 text-white toolMio' ><span class='toolMio-text'>Imprimir</span><i class='fas fa-print' ></i></a>";
                    $acciones .="<button data-reparacion-id ='".$reparacion->id."' id='eliminar'  type='button' class='btn btn-sm bg-hover-azul mx-2 text-white toolMio' ><span class='toolMio-text'>Eliminar</span><i class='fas fa-trash' ></i></a>";
                  
                    $acciones .="</div>";
 
                  
 
                    $estado = '';
                     if($reparacion->estado == 0){
                        $estado = "<div class='d-flex justify-content-center' >";
                        $estado .= "<button type='button' class='btn  w-75 btn-inline btn-secondary btn-sm ' style='min-width:70px'>En Proceso</button>";
                        $estado .= "</div >";
                     }elseif($reparacion->estado == 1){
                        $estado = "<div class='d-flex justify-content-center' >";
                        $estado .= "<button type='button' class='btn  w-75 btn-inline btn-success btn-sm ' style='min-width:70px'>Reparado</button>";
                        $estado .= "</div >";
                     }else{
                        $estado = "<div class='d-flex justify-content-center'>";
                        $estado .= "<button type='button' class='btn w-75 btn-inline bg-danger text-white btn-sm' style='min-width:70px'>Cerrado</button>";
                        $estado .= "</div >";
                     }
                     

                   
                   
                     
                     $datoJson.= '[
                             "'.$i.'",
                             "'.$reparacion->nombre.'",
                             "'.$reparacion->cedula_nit.'",
                             "'.$reparacion->celular.'",
                             "'.$reparacion->fecha_ingreso.'",
                             "'.$estado.'",
                             "'.$acciones.'"
                     ]';
                     if($key != count($reparaciones)-1){
                         $datoJson.=",";
                     }
                 }
       
             $datoJson.=  ']}';
            echo $datoJson;
        }
        public static function  crear(){
            if (session_status() != PHP_SESSION_ACTIVE) {
                session_start();
            } 
            date_default_timezone_set('America/Bogota');

            $usuario = new Usuario();
            $usuario->nombre = $_POST['nombre'];
            $usuario->email = $_POST['celular'];
            $usuario->password = $_POST['cedula_nit'];
            $usuario->hashPassword();
            $usuario->estado = 1;
            $usuario->roll = 2;

            $resultado = $usuario->guardar();
   

            if(!$resultado){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                
                return;
            }


            $fecha_actual = date('Y-m-d H:i:s');
            $reparacion = new Reparacion($_POST);
            $reparacion->valor_final = 0;
            $reparacion->costo_final = 0;
            $reparacion->fecha_ingreso = $fecha_actual;
            $reparacion->fecha_cierre = '2000-01-01';
            $reparacion->estado = 0;
            $reparacion->cliente_id = $resultado['id'];

            $reparacion->id_usuario = $_SESSION['id'];
            $reparacion->formatearDatosFloat();
            $resultado = $reparacion->guardar();
            if(!$resultado){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                
                return;
            }

           

            echo json_encode(['type'=>'success', 'msg'=>'Reparación agregada con Éxito']);
            return;
        }
  
        public static function reparacion(){

            $id = $_GET['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if(!$id){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error Intenta Nuevamente']);
                return;
            }
          

            $reparacion = Reparacion::find($_GET['id']);
            if(!$reparacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hay un Problema con el Reparacion Seleccionada']);
                return;
            }
            echo json_encode($reparacion);
            return;          

    
        }

        public static function editar(){

            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if(!$id){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error Intenta Nuevamente']);
                return;
            }
            $reparacion_anterior = Reparacion::find($_POST['id']);
         
            $reparacion = new Reparacion($_POST);
        
            if(!$reparacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hay un Problema con la Reparación Seleccionada']);
                return;
            }
            $reparacion->formatearDatosFloat();
            $reparacion->valor_final = 0;
            $reparacion->fecha_ingreso = $reparacion_anterior->fecha_ingreso;
            $reparacion->fecha_cierre = $reparacion_anterior->fecha_cierre;
            $reparacion->valor_final = $reparacion_anterior->valor_final;
            $reparacion->costo_final = $reparacion_anterior->costo_final;
            $reparacion->estado = $reparacion_anterior->estado;
            $reparacion->id_usuario = $reparacion_anterior->id_usuario;
            $reparacion->cliente_id = $reparacion_anterior->cliente_id;
            $resultado = $reparacion->guardar();
            if($resultado){
                echo json_encode(['type'=>'success', 'msg'=>'La Reparación ha  Actualizado con Exito']);
                return;
            }
            echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
            return;
       
        }
        public static function eliminar(){

            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if(!$id){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error Intenta Nuevamente']);
                return;
            }
            $reparacion = Reparacion::find($_POST['id']);
          
            
            if(!$reparacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hay un Problema con la Reparación Seleccionada']);
                return;
            }
           
            $cliente = Usuario::find($reparacion->cliente_id);
            
            $resultado = $reparacion->eliminar();
            if($resultado){
                $cliente->eliminar();
                echo json_encode(['type'=>'success', 'msg'=>'La Reparación ha  Eliminado con Exito']);
                return;
            }
            echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
            return;
       
        }

        public static function crearCosto(){
            
            $reparacion_id = $_POST['reparacion_id'];
            $reparacion_id = filter_var($reparacion_id, FILTER_VALIDATE_INT);
            if(!$reparacion_id){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
            $reparacion = Reparacion::find($reparacion_id);
            if(!$reparacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
           
            
            if($reparacion->estado==2){
                echo json_encode(['type'=>'error', 'msg'=>'No puedes agregar costos a una reparacion cerrada']);
                return;
            }
            
            $costo = new Costo($_POST);
            $costo->formatearDatosFloat();
            $resultado = $costo->guardar();
            if($resultado){
                echo json_encode(['type'=>'success', 'msg'=>'El Costo ha sido agragado con Exito']);
                return;
            }
            echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
            return;


        }
        public static function editarCosto(){
            
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if(!$id){
                header('Location:/reparaciones');
            }
            
            $costo = Costo::find($_POST['id']);
            if(!$costo){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }

            $reparacion = Reparacion::find($costo->reparacion_id);
            if(!$reparacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
            if($reparacion->estado==2){
                echo json_encode(['type'=>'error', 'msg'=>'No puedes editar costos de una reparacion cerrada']);
                return;
            }
            $costo->sincronizar($_POST);
            $costo->formatearDatosFloat();
            $resultado = $costo->guardar();
            if($resultado){
                echo json_encode(['type'=>'success', 'msg'=>'El Costo ha sido actualizado con Exito']);
                return;
            }
            echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
            return;


        }
        public static function eliminarCosto(){
            
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if(!$id){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }

            
            
            $costo = Costo::find($_POST['id']);
            if(!$costo){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }

            $reparacion = Reparacion::find($costo->reparacion_id);
            if(!$reparacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
            if($reparacion->estado==2){
                echo json_encode(['type'=>'error', 'msg'=>'No puedes eliminar costos de una reparacion cerrada']);
                return;
            }
            
            $resultado = $costo->eliminar();
            if($resultado){
                echo json_encode(['type'=>'success', 'msg'=>'El Costo ha sido eliminado con Exito']);
                return;
            }
            echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
            return;


        }
        public static function costos(){
            
            $reparacion_id = $_GET['id'];
            $reparacion_id = filter_var($reparacion_id, FILTER_VALIDATE_INT);
            if(!$reparacion_id){
                header('Location:/reparaciones');
            }
            $costos = Costo::whereArray(['reparacion_id'=> $reparacion_id]);
            if(!$costos){
                echo json_encode(['type'=>'error', 'msg'=>'No hay Costos Reistrados Aún']);
                return;
            }
            echo json_encode($costos);
        }

        public static function crearIngreso(){
           
            $reparacion_id = $_POST['reparacion_id'];
            $reparacion_id = filter_var($reparacion_id, FILTER_VALIDATE_INT);
            if(!$reparacion_id){
                header('Location:/reparaciones');
            }

            $reparacion = Reparacion::find($reparacion_id);
            if(!$reparacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
            if($reparacion->estado==2){
                echo json_encode(['type'=>'error', 'msg'=>'No puedes agregar ingresos a una reparación cerrada']);
                return;
            }
            
            $ingreso = new Ingreso($_POST);

            
            $ingreso->formatearDatosFloat();
            $resultado = $ingreso->guardar();
            if($resultado){
                echo json_encode(['type'=>'success', 'msg'=>'El Ingreso ha sido agragado con Exito']);
                return;
            }
            echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
            return;


        }
        public static function ingresos(){
            
            $reparacion_id = $_GET['id'];
            $reparacion_id = filter_var($reparacion_id, FILTER_VALIDATE_INT);
            if(!$reparacion_id){
                header('Location:/reparaciones');
            }
            $ingresos = Ingreso::whereArray(['reparacion_id'=> $reparacion_id]);
            if(!$ingresos){
                echo json_encode(['type'=>'error', 'msg'=>'No hay Ingresos Reistrados Aún']);
                return;
            }
            echo json_encode($ingresos);
        }
        public static function editarIngreso(){
           
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if(!$id){
                header('Location:/reparaciones');
            }
            
            $ingreso = Ingreso::find($_POST['id']);
            if(!$ingreso){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
            $reparacion = Reparacion::find($ingreso->reparacion_id);
            if(!$reparacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
            if($reparacion->estado==2){
                echo json_encode(['type'=>'error', 'msg'=>'No puedes editar ingresos de una reparación cerrada']);
                return;
            }
            $ingreso->sincronizar($_POST);
            $ingreso->formatearDatosFloat();
            $resultado = $ingreso->guardar();
            if($resultado){
                echo json_encode(['type'=>'success', 'msg'=>'El Ingreso ha sido actualizado con Exito']);
                return;
            }
            echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
            return;


        }
        public static function eliminarIngreso(){
           
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if(!$id){
                header('Location:/reparaciones');
            }
            
            $ingreso = Ingreso::find($_POST['id']);
            if(!$ingreso){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }

            $reparacion = Reparacion::find($ingreso->reparacion_id);
            if(!$reparacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
            if($reparacion->estado==2){
                echo json_encode(['type'=>'error', 'msg'=>'No puedes eliminar ingresos de una reparación cerrada']);
                return;
            }
            
            
            $resultado = $ingreso->eliminar();
            if($resultado){
                echo json_encode(['type'=>'success', 'msg'=>'El Ingreso ha sido eliminado con Exito']);
                return;
            }
            echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
            return;


        }

        public static function crearNotificacion(){
           

            $reparacion = Reparacion::find($_POST['reparacion_id']);
   
            if(!$reparacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
            if($reparacion->estado==2){
                echo json_encode(['type'=>'error', 'msg'=>'reparación cerrada']);
                return;
            }
           

            
            if(!empty($_FILES['imagenes']['tmp_name'][0])){
                $totalArchivos = count($_FILES["imagenes"]["name"]);
                for($i=0; $i<$totalArchivos; $i++){
               
                    $carpeta_imagenes = '../public/img/notificaciones';
            
                    //crear la carpeta si no existe
                    if(!is_dir($carpeta_imagenes)){
                        mkdir($carpeta_imagenes, 0777, true);
                    }
    
                    $imagen_png = Image::make($_FILES['imagenes']['tmp_name'][$i])->fit(800,800)->encode('png', 80); //imagen en png
                    $imagen_webp = Image::make($_FILES['imagenes']['tmp_name'][$i])->fit(800,800)->encode('webp', 80); //imagen en jpg
                  
    
                    $nombre_imagen = md5(uniqid(rand(),true));
         
                    $imagen_png->save($carpeta_imagenes.'/'.$nombre_imagen.".png");
                    $imagen_webp->save($carpeta_imagenes.'/'.$nombre_imagen.".webp");
                    $array_nombre_imagenes[] = $nombre_imagen;
    
                }
                $_POST['imagenes'] =implode(',', $array_nombre_imagenes);
                $_POST['cliente_id'] = $reparacion->cliente_id;

                $notificacion = new Notificacion($_POST);
                $resultado = $notificacion->guardar();

                if($resultado){
                    echo json_encode(['type'=>'success', 'msg'=>'La notificación se ha creado con Éxito']);
                    return;
                }
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
                    
            }else{
                $_POST['imagenes'] ='';
                $_POST['cliente_id'] = $reparacion->cliente_id;

                $notificacion = new Notificacion($_POST);
                $resultado = $notificacion->guardar();

                if($resultado){
                    echo json_encode(['type'=>'success', 'msg'=>'La notificación se ha creado con Éxito']);
                    return;
                }
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
            
           
        }
        public static function editarNotificacion(){
           
         
            $notificacion = Notificacion::find($_POST['id']);
            if(!$notificacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }

            $reparacion = Reparacion::find($notificacion->reparacion_id);
   
            if(!$reparacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
            if($reparacion->estado==2){
                echo json_encode(['type'=>'error', 'msg'=>'la reparación ya ha sido cerrada']);
                return;
            }
            $imagenes_actuales = $notificacion->imagenes;
         
           

            
            if(!empty($_FILES['imagenes']['tmp_name'][0])){

                if($notificacion->imagenes!=""){
                    $arrayImagenes = explode(',',$notificacion->imagenes);
                    $carpeta_imagenes = '../public/img/notificaciones';
                    
                    foreach($arrayImagenes as $imagen){
                    
                        
                        unlink($carpeta_imagenes.'/'.$imagen.".png");
                        unlink($carpeta_imagenes.'/'.$imagen.".webp");
                    }
                }
               
           


                $totalArchivos = count($_FILES["imagenes"]["name"]);
                for($i=0; $i<$totalArchivos; $i++){
               
                    $carpeta_imagenes = '../public/img/notificaciones';
            
                    //crear la carpeta si no existe
                    if(!is_dir($carpeta_imagenes)){
                        mkdir($carpeta_imagenes, 0777, true);
                    }
    
                    $imagen_png = Image::make($_FILES['imagenes']['tmp_name'][$i])->fit(800,800)->encode('png', 80); //imagen en png
                    $imagen_webp = Image::make($_FILES['imagenes']['tmp_name'][$i])->fit(800,800)->encode('webp', 80); //imagen en jpg
                  
    
                    $nombre_imagen = md5(uniqid(rand(),true));
         
                    $imagen_png->save($carpeta_imagenes.'/'.$nombre_imagen.".png");
                    $imagen_webp->save($carpeta_imagenes.'/'.$nombre_imagen.".webp");
                    $array_nombre_imagenes[] = $nombre_imagen;
    
                }
                $_POST['imagenes'] =implode(',', $array_nombre_imagenes);
                // $_POST['cliente_id'] = $reparacion->cliente_id;

                $notificacion->sincronizar($_POST);
                $resultado = $notificacion->guardar();

                if($resultado){
                    echo json_encode(['type'=>'success', 'msg'=>'La notificación ha sido actualizada con Éxito']);
                    return;
                }
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
                    
            }else{
             
                $_POST['imagenes'] = $imagenes_actuales;

                $notificacion->sincronizar($_POST);
            
                $resultado = $notificacion->guardar();

                if($resultado){
                    echo json_encode(['type'=>'success', 'msg'=>'La notificación ha sido actualizada con Éxito']);
                    return;
                }
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
            
           
        }

        public static function eliminarNotificacion(){
            
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if(!$id){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
            
            $notificacion = Notificacion::find($_POST['id']);
           
            if(!$notificacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
            }
            $notificacion_auxiliar = $notificacion;
            $resultado = $notificacion->eliminar();
            if(!$resultado){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Intenta nuevamente']);
                return;
             
            }

            if($notificacion_auxiliar->imagenes!=""){
                $arrayImagenes = explode(',',$notificacion_auxiliar->imagenes);
                $carpeta_imagenes = '../public/img/notificaciones';
                
                foreach($arrayImagenes as $imagen){
                
                    
                    unlink($carpeta_imagenes.'/'.$imagen.".png");
                    unlink($carpeta_imagenes.'/'.$imagen.".webp");
                }
            }

            echo json_encode(['type'=>'success', 'msg'=>'La notificación se ha eliminado con exito']);
            return;


        }

        public static function notificaciones(){
           
            $reparacion_id = $_GET['id'];
            $reparacion_id = filter_var($reparacion_id, FILTER_VALIDATE_INT);
            if(!$reparacion_id){
                header('Location:/reparaciones');
            }
            $notificaciones = Notificacion::whereArray(['reparacion_id'=> $reparacion_id]);
            if(!$notificaciones){
                echo json_encode(['type'=>'error', 'msg'=>'No hay notificaciones Registradass Aún']);
                return;
            }
            foreach($notificaciones as $notificacion){
                $notificacion->imagenes = explode(',',$notificacion->imagenes);
            }
        
            echo json_encode($notificaciones);
        }

        public static function estadoActual(){

 
              
            
            $reparacion_id = $_GET['id'];
            $reparacion_id = filter_var($reparacion_id, FILTER_VALIDATE_INT);
           
            $reparacion = Reparacion::find($reparacion_id);
            if(!$reparacion){
                echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Porfavor intenta nuevamente']);
                return;
            }
           
        
            echo json_encode($reparacion);
        }
        public static function cambiarEstado(){
            
            if($_POST['estado']==1){
                $ingresos = Ingreso::sumWhere('ingreso','reparacion_id', $_POST['reparacion_id']);
                $total_ingresos = $ingresos['suma'];

                $costos = Costo::sumWhere('costo','reparacion_id', $_POST['reparacion_id'] );
             
                $total_costos = $costos['suma']??0;
       
                $reparacion = Reparacion::find($_POST['reparacion_id']);
                $reparacion->valor_final = $reparacion->valor_convenido+$total_ingresos-$total_costos;
                $reparacion->costo_final = $total_costos;
                $reparacion->estado=$_POST['estado'];
                $resultado = $reparacion->guardar();
                if(!$resultado){
                    echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Porfavor intenta nuevamente']);
                    return;
                    
                }else{
                    echo json_encode(['type'=>'success', 'msg'=>'estado actualizado correctamente']);
                    return;
                }
                
            }else{
                date_default_timezone_set('America/Bogota');

                $usuario = Usuario::find($_POST['cliente_id']);
                $reparacion = Reparacion::find($_POST['reparacion_id']);
                $reparacion->estado=$_POST['estado'];
                $reparacion->fecha_cierre = date('Y-m-d');
                
                $resultado = $reparacion->guardar();
                if(!$resultado){
                    echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Porfavor intenta nuevamente']);
                    return;
                    
                }

                $resultado = $usuario->eliminar();
                if(!$resultado){
                    echo json_encode(['type'=>'error', 'msg'=>'Hubo un error, Porfavor intenta nuevamente']);
                    return;
                    
                }else{
                    echo json_encode(['type'=>'success', 'msg'=>'Reparación Cerrada exitosamente']);
                    return;
                }
            }
            
        }
        
        
    }
    
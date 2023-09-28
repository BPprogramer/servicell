<?php include_once __DIR__ . '/../templates/content-header.php'; ?>

<section class="content" id="infoClienteReparacion">

    <!-- Navegacion -->
    <div class="container-fluid mb-2" id="navReparacionCliente">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link color-texto active-nav" id="general" href="#">General</a>
            </li>
            <li class="nav-item">
                <a class="nav-link color-texto" id="notificaciones" href="#">Notificaciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link color-texto" id="avanzado" href="#">Costos Extras</a>
            </li>

        </ul>
    </div>
    <!-- Info general -->
    <div class="container-fluid">

        <div class="d-md-flex justify-content-between align-items-center">
            <p class="display-5 text-center ml-2">fecha: <strong><?php echo $reparacion->fecha_ingreso ?></strong></p>
            <p class="display-5 text-center ml-2">Valor Convenido <strong><?php echo '$' . number_format($reparacion->valor_convenido) ?></strong></p>
            <p class="display-5 text-center">Abono: <strong><?php echo '$' . number_format($reparacion->abono) ?></strong></p>
            <p class="display-5 text-center">Saldo: <strong><?php echo '$' . number_format($reparacion->saldo) ?></strong></p>

            <p class="mr-2">
                <button type="button" id="btnTotalReparacion" class="btn text-blanco btn-block bg-secondary  btn-sm"></button>
            </p>

           <!--  <p class="mr-2">
                <button type="button" id="btnImprimirReparacion" class="btn text-blanco btn-block bg-secondary  btn-sm">imprimir</button>
            </p> -->
            <p class="mr-2">
                <button type="button" id="btnEstadoReparacion" class="btn text-blanco btn-block   btn-sm"></button>
            </p>
        </div>
    </div>
    <input type="hidden" id="idReparacion" data-reparacion-id="<?php echo $reparacion->id?>">

        <!-- info General -->
        <hr class="border-top pb-1">
    <div class="container-fluid" id="info_general">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-widget widget-user-2">
                    <div class="widget-user-header bg-azul text-blanco" style="padding: 3px;">
                        <h3 class="widget-user-username">Información Del Cliente</h3>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link text-dark">
                                    Nombre <span class="float-right"><strong id="nombre"><?php echo $reparacion->nombre ?></strong></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link text-dark">
                                    Identificación <span class="float-right"><strong id="cedula_nit"><?php echo $reparacion->cedula_nit ?></strong></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link text-dark">
                                    Celular <span class="float-right"><strong id="celular"><?php echo $reparacion->celular ?></strong></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link text-dark">
                                    Dirección <span class="float-right"><strong id="direccion"><?php echo $reparacion->direccion ?></strong></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-widget widget-user-2">
                    <div class="widget-user-header bg-azul text-blanco" style="padding: 3px;">
                        <h3 class="widget-user-username">Información Del Dispositivo</h3>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link text-dark">
                                    Marca <span class="float-right"><strong id="nombre"><?php echo $reparacion->marca ?></strong></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link text-dark">
                                    Modelo <span class="float-right"><strong id="cedula_nit"><?php echo $reparacion->modelo ?></strong></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link text-dark">
                                    imei 1<span class="float-right"><strong id="celular"><?php echo $reparacion->imei_1 ?></strong></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link text-dark">
                                    imei 2 <span class="float-right"><strong id="direccion"><?php echo $reparacion->imei_2 ?></strong></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-widget widget-user-2">
                    <div class="widget-user-header bg-azul text-blanco" style="padding: 3px;">
                        <h3 class="widget-user-username">Información del caso</h3>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <div id="accordion">
                                    <div class="card mb-0">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link " data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Falla que reporta el Cliente
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseOne" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body">
                                                <?php echo $reparacion->falla ?>
                                            </div>
                                        </div>
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                    Procedimiento a realizar
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseTwo" class="collapse hide" aria-labelledby="headingTwo" data-parent="#accordion">
                                            <div class="card-body">
                                                <?php echo $reparacion->proceso ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </li>
                        </ul>
                    </div>
                </div>

            </div>


        </div>

    </div>
    <!-- Display para notificaciones -->
    <div class="container-fluid d-none mt-4" id="info_notificaciones" style="padding-left:0; padding-right:0">

        <div class="">

            <div class="card card-widget widget-user-2">
                <div class="widget-user-header bg-azul text-blanco" style="padding: 3px;">
                    <div class=" row d-flex justify-content-between">
                        <div class="col-md-8">
                            <h3 class="widget-user-username">Notificaciones al cliente <strong id="totalNotifiaciones"></strong></h3>
                        </div>
                        
                    </div>

                </div>
                <div class="card-footer p-0">
                    <div class="notificaciones" id="notificacion">
                        <table class="table table-striped text-md" id="tabla-notificaciones-cliente">

                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>

        <!-- Display para avanzado -->
    <div class="container-fluid d-none mt-4" id="info_avanzado">
      <div class="row">
      



        </div>
        <div class="col-md-6" style="padding-right: 0">

          <div class="card card-widget widget-user-2">
            <div class="widget-user-header bg-azul text-blanco" style="padding: 3px;">
              <div class="row d-flex justify-content-between">
                <div class="col-md-8">
                  <h3 class="widget-user-username">Costos Extras <strong id="totalIngresos">0.00</strong></h3>
                </div>
             
              </div>

            </div>
            <div class="card-footer p-0">
              <div class="ingresos" id="ingresos">
                <table class="table table-striped text-md" id="tabla-costos-cliente">

                </table>
              </div>
            </div>
          </div>



        </div>
      </div>



</section>

<div class="modal fade" id="modal-carrousel-imagenes">
  <div class="modal-dialog modal-img">
    <div class="modal-content" >
    
    <div class="modal-body body-80rem" id="contenedor_carrousel_grande">
        
      </div>

  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
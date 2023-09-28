<?php include_once __DIR__ . '/../templates/content-header.php'; ?>

<section class="content" id="reparacion">
  <div class="container-fluid mb-2" id="navReparacion">
    <ul class="nav nav-tabs">
      <li class="nav-item" >
        <a class="nav-link color-texto active-nav" id="general" href="#">General</a>
      </li>
      <li class="nav-item" >
        <a class="nav-link color-texto" id="notificaciones" href="#">Notificaciones</a>
      </li>
      <li class="nav-item" >
        <a class="nav-link color-texto" id="avanzado" href="#">Avanzado</a>
      </li>
     
    </ul>
  </div>

  <!-- display para General -->
  <div class="container-fluid" >
 
    <div class="d-md-flex justify-content-between align-items-center">
      <p class="display-5 text-center ml-2">fecha: <strong><?php echo $reparacion->fecha_ingreso ?></strong></p>
      <p class="display-5 text-center ml-2">Valor Convenido <strong><?php echo '$' . number_format($reparacion->valor_convenido) ?></strong></p>
      <p class="display-5 text-center">Abono: <strong><?php echo '$' . number_format($reparacion->abono) ?></strong></p>
      <p class="display-5 text-center">Saldo: <strong><?php echo '$' . number_format($reparacion->saldo) ?></strong></p>

      <p class="mr-2">
        <button type="button" id="btnTotalReparacion" class="btn text-blanco btn-block bg-secondary  btn-sm"></button>
      </p>

      <p class="mr-2">
        <button type="button" id="btnImprimirReparacion" class="btn text-blanco btn-block bg-secondary  btn-sm">imprimir</button>
      </p>
      <p class="mr-2">
        <button type="button" id="btnEstadoReparacion" class="btn text-blanco btn-block   btn-sm"></button>
      </p>
    </div>
  </div>
  <div class="container-fluid" >
    <!-- info General -->
    <hr class="border-top pb-1">
    <div class="row" id="info_general">
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
              <div class="col-md-4">
                <button type="button" class="btn btn-block bg-white text-azul font-weight-bold" id="agregar-notificacion">Enviar Notificación al cliente</button>
              </div>
            </div>

          </div>
          <div class="card-footer p-0">
            <div class="notificaciones" id="notificacion">
              <table class="table table-striped text-md" id="tabla-notificaciones">
      
              </table>
            </div>
          </div>
        </div>


      </div>
    </div>


 
    <!-- Display para avanzado -->
    <div class="container-fluid d-none mt-4" id="info_avanzado">
      <div class="row">
        <div class="col-md-6" style="padding-left: 0;">

          <div class="card card-widget widget-user-2">
            <div class="widget-user-header bg-danger text-blanco" style="padding: 3px;">
              <div class=" row d-flex justify-content-between">
                <div class="col-md-8">
                  <h3 class="widget-user-username">Costos <strong id="totalCostos"></strong></h3>
                </div>
                <div class="col-md-4">
                  <button type="button" class="btn btn-block bg-white text-azul font-weight-bold" id="agregar-costo">Agregar Costo</button>
                </div>
              </div>

            </div>
            <div class="card-footer p-0">
              <div class="costos" id="costos">
                <table class="table table-striped text-md" id="tabla-costos">

                </table>
              </div>
            </div>
          </div>



        </div>
        <div class="col-md-6" style="padding-right: 0">

          <div class="card card-widget widget-user-2">
            <div class="widget-user-header bg-success text-blanco" style="padding: 3px;">
              <div class="row d-flex justify-content-between">
                <div class="col-md-8">
                  <h3 class="widget-user-username">Ingresos Añadidos <strong id="totalIngresos">0.00</strong></h3>
                </div>
                <div class="col-md-4">
                  <button type="button" class="btn btn-block bg-white text-azul font-weight-bold" id="agregar-ingreso">Agregar Ingreso</button>
                </div>
              </div>

            </div>
            <div class="card-footer p-0">
              <div class="ingresos" id="ingresos">
                <table class="table table-striped text-md" id="tabla-ingresos">

                </table>
              </div>
            </div>
          </div>



        </div>
      </div>
<!--     </div> -->
</section>

<!-- Modal Notifiacion -->

<div class="modal fade" id="modal-notificacion">
  <div class="modal-dialog" style="max-width: 700px;">
    <div class="modal-content">
      <div class="modal-header bg-azul">
        <h4 class="modal-title  text-white ">Registrar y Enviar Notificaión</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="notificacionForm" enctype="multipart/form-data">
          <div class="card-body">

            <div class="form-group">
              <label for="mensaje">Mensaje</label>

              <div class="">
                <textarea class="form-control" name="mensaje" id="mensaje" placeholder="mensaje para el Cliente" rows="2"></textarea>

              </div>
            </div>


            <div class="form-group">
              <label for="imagenes">Imagenes</label>
              <input type="file" name="imagenes[]" id="imagenes" multiple>
            </div>
            <div class="imagenes row" id="contenedorImganes">

            </div>




          </div>

      </div>
      <!-- /.card-body -->
      <div class="card-footer">

        <div class="row justify-content-between">
          <div class="col-6">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          <div class="col-6 d-flex justify-content-end">
            <button type="submit" class="btn bg-hover-azul text-white" id="btnSubmitNotificacion">Enviar</button>
          </div>
        </div>


      </div>

      </form>
    </div>

  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>




<div class="modal fade" id="modal-costo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-azul">
        <h4 class="modal-title  text-white ">Registrar Costo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="costoForm">
          <div class="card-body">

            <div class="form-group">
              <label for="costo">Costo</label>
              <input type="costo" name="costo" class="form-control" id="costo" placeholder="Valor del Costo">
            </div>
            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <input type="Descripcion" name="descripcion" class="form-control" id="descripcion" placeholder="descripción del gasto, corta y consisa">
            </div>


          </div>

      </div>
      <!-- /.card-body -->
      <div class="card-footer">

        <div class="row justify-content-between">
          <div class="col-6">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          <div class="col-6 d-flex justify-content-end">
            <button type="submit" class="btn bg-hover-azul text-white" id="btnSubmitCosto">Enviar</button>
          </div>
        </div>

        <div id="inputContenedor"></div>
      </div>

      </form>
    </div>

  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ingreso">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-azul">
        <h4 class="modal-title  text-white ">Registrar Ingreso</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="ingresoForm">
          <div class="card-body">

            <div class="form-group">
              <label for="ingreso">Ingreso</label>
              <input type="ingreso" name="ingreso" class="form-control" id="ingreso" placeholder="Valor del ingreso">
            </div>
            <div class="form-group">
              <label for="descripcion_ingreso">Descripción</label>
              <input type="text" name="descripcion_ingreso" class="form-control" id="descripcion_ingreso" placeholder="descripción del Ingreso, corta y consisa">
            </div>


          </div>

      </div>
      <!-- /.card-body -->
      <div class="card-footer">

        <div class="row justify-content-between">
          <div class="col-6">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          <div class="col-6 d-flex justify-content-end">
            <button type="submit" class="btn bg-hover-azul text-white" id="btnSubmitIngreso">Enviar</button>
          </div>
        </div>

        <div id="inputContenedor"></div>
      </div>

      </form>
    </div>

  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>


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
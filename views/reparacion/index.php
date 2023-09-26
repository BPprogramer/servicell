
<?php   include_once __DIR__ .'/../templates/content-header.php';?>



<!-- Main content -->
<section class="content" id="reparaciones">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        
        <!-- /.card -->

        <div class="card">
          <div class="card-header">
              <div class="row justify-content-between">
                <div class="col-4">
                    <h3 class="card-title">Reparaciones En proceso </h3>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    <button type="button" id="registrar" class="btn bg-hover-azul text-blanco">
                        Agregar nueva Reparación
                    </button>
                </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="tabla" class="display responsive table w-100 table-bordered table-striped">
              <thead>
              <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Identificación</th>
                <th>Celular</th>
                <th>Fecha de Ingreso</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Acciones</th>
              </tr>
              </thead>
              
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
<!-- /.container-fluid -->
</section>

<div class="modal fade" id="modal-reparacion">
    <div class="modal-dialog modal-80rem">
      <div class="modal-content">
        <div class="modal-header bg-azul">
          <h4 class="modal-title  text-white ">Agregar Reparacion</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="reparacionForm">
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group row col-md-6 mr-md-3">
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre Completo del Cliente">
                                  
                        </div>
                    </div>
                    <div class="form-group row col-md-6">
                        <label for="cedula_nit" class="col-sm-2 col-form-label">CC / TI / NIT</label>
                        <div class="col-sm-10">
                            <input type="text" name="cedula_nit" class="form-control" id="cedula_nit" placeholder="identificación del Cliente CC/TI/NIT">
                                  
                        </div>
                    </div>
                  
                </div>
                <div class="form-row">
                    <div class="form-group row col-md-6 mr-md-3">
                        <label for="celular" class="col-sm-2 col-form-label">Celular</label>
                        <div class="col-sm-10">
                            <input type="number" name="celular" class="form-control" id="celular" placeholder="Celular del Cliente">
                                  
                        </div>
                    </div>
                    <div class="form-group row col-md-6">
                        <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
                        <div class="col-sm-10">
                            <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Dirección del Cliente">
                                  
                        </div>
                    </div>
                  
                </div>
                <div class="form-row">
                    <div class="form-group row col-md-6 mr-md-3">
                        <label for="marca" class="col-sm-2 col-form-label">Marca</label>
                        <div class="col-sm-4">
                            <select class="form-control select2" id="marca" style="width: 100%;">
                           
                        
                            </select>                     

                                  
                        </div>
                        <label for="modelo" class="col-sm-2 col-form-label">Modelo</label>
                        <div class="col-sm-4">
                            <input type="text" name="modelo" class="form-control" id="modelo" placeholder="Modelo del Equipo">
                                  
                        </div>
                    </div>
                 
                    <div class="form-group row col-md-6">
                        <label for="emeil" class="col-sm-2 col-form-label">IMEI</label>
                        <div class="col-sm-5">
                            <input type="text" name="emeil" class="form-control" id="imei_1" placeholder="IMEI 1">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" name="emeil" class="form-control" id="imei_2" placeholder="IMEI 2">
                        </div>
                    </div>
                  
                </div>
                <div class="form-row">
                    <div class="form-group row col-md-6 mr-md-3">
                        <label for="falla" class="col-sm-2 col-form-label">Falla</label>
                        <div class="col-sm-10">
                             <textarea class="form-control" id="falla" placeholder="Falla que reporta el cliente" rows="2"></textarea>
                                  
                        </div>
                    </div>
                    <div class="form-group row col-md-6">
                        <label for="proceso" class="col-sm-2 col-form-label">Proceso</label>
                        <div class="col-sm-10">
                             <textarea class="form-control" id="proceso" placeholder="Proceso a Realizar" rows="2"></textarea>
                        </div>
                    </div>
                  
                </div>


                <hr> 
            
                <div class="form-row">
                    <div class="form-group row col-md-6 mr-md-3">
                        <label for="valor_convenido" class="col-sm-3 col-form-label">Valor Convenido</label>
                        <div class="col-sm-9">
                            <input type="text" name="valor_convenido" class="form-control" id="valor_convenido" placeholder="Valor Convenido">
                                  
                        </div>
                    </div>
                    <div class="form-group row col-md-3 mr-2">
                        <label for="abono" class="col-sm-2 col-form-label">Abono</label>
                        <div class="col-sm-10">
                            <input type="text" name="abono" class="form-control" id="abono" placeholder="Abono">
                        </div>
                    </div>
                    <div class="form-group row col-md-3">
                        <label for="saldo" class="col-sm-2 col-form-label">Saldo</label>
                        <div class="col-sm-10">
                            <input type="text" name="saldo" class="form-control" id="saldo" placeholder="Saldo" readonly>
                        </div>
                    </div>
                  
                </div>
                <hr> 

                <div class="form-group">
                    <label for="nombre">Accesosorios Recibidos</label>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="cargador">
                                <label class="custom-control-label" for="cargador">Cargador</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="bateria">
                                <label class="custom-control-label" for="bateria">Bateria</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="tapa">
                                <label class="custom-control-label" for="tapa">Tapa Trasera</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="estuche">
                                <label class="custom-control-label" for="estuche">Estuche</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="sim">
                                <label class="custom-control-label" for="sim">Sim Card</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="sd">
                                <label class="custom-control-label" for="sd">Tarjeta SD</label>
                            </div>
                        </div>
                       
                    </div>
                    
                </div>

                <hr>

                <div class="form-row">
                    <div class="form-group row col-md-6 mr-md-3">
                        <label for="observacion" class="col-sm-3 col-form-label">observacion</label>
                        <div class="col-sm-9">
                             <textarea class="form-control" id="observacion" placeholder="Observaciones del cliente o técnico" rows="2"></textarea>
                                  
                        </div>
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
                        <button type="submit" class="btn bg-hover-azul text-white" id="btnSubmit">Enviar</button>
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


  <!-- 
    id
    nombre
    cedula_nit
    celular
    direccion
    modelo
    imei_1
    imei_2
    falla
    proceso
    valor_convenido
    abono
    saldo
    valor_final
    gasto_final
    accesorios
    observaciones
    fecha_ingreso
    fecha
    id_usuario
    

   -->
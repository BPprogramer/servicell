
<?php   include_once __DIR__ .'/../templates/content-header.php';?>



<!-- Main content -->
<section class="content" id="usuarios">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        
        <!-- /.card -->

        <div class="card">
          <div class="card-header">
              <div class="row justify-content-between">
                <div class="col-4">
                    <h3 class="card-title">Usuarios Registrados</h3>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    <button type="button" id="registrar" class="btn bg-hover-azul text-blanco">
                        Registrar Usuario
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
                <th>Nombre</th>
                <th>Email</th>
                <th class="text-center">Estado</th>
                <th>Roll</th>
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

<div class="modal fade" id="modal-usuario">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-azul">
          <h4 class="modal-title  text-white ">Crear Usuario</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="usuarioForm">
            <div class="card-body">

              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="nombre" name="nombre"  class="form-control" id="nombre" placeholder="Tu nombre">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" id="email" placeholder="Enter email">
              </div>
              <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado" class="form-control">
                        
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="roll">Roll</label>
                    <select id="roll" name="roll" class="form-control">
                        
                    </select>
                </div>
            </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
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
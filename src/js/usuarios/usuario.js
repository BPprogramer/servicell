

(function(){

    const usuarios = document.querySelector('#usuarios');
    if(usuarios){

        
        let tablaUsuarios; //para el datatable
        let id = null; //si tengo id es update si no lo tengo es create
     
        const btnRegistrarUsuario = document.querySelector('#registrar');
        const formulario = document.querySelector('#usuarioForm');
        const btnSubmit = document.querySelector('#btnSubmit');
        const nombre = document.querySelector('#nombre')
        const email = document.querySelector('#email')
        const estado = document.querySelector('#estado')
        const roll = document.querySelector('#roll')
        const password = document.querySelector('#password');
    

        //disparamos el modal
        btnRegistrarUsuario.addEventListener('click',function(){
            id=null;
            accionesModal();
        })
        
        mostrarUsuarios();
        verificarCargaTabla();
       

        function mostrarUsuarios(){
 
            $("#tabla").dataTable().fnDestroy(); //por si me da error de reinicializar
    
            tablaUsuarios = $('#tabla').DataTable({
                ajax: '/api/usuarios',
                "deferRender":true,
                "retrieve":true,
                "proccesing":true,
                responsive:true,
                initComplete: function () {
                    // Inicializa los botones después de que la tabla se haya creado
                    var buttons = new $.fn.dataTable.Buttons(tablaUsuarios, {
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
                    }).container().appendTo('#tabla_wrapper .col-md-6:eq(0)');
                }
            });
       
        }  

        function verificarCargaTabla(){
            tablaUsuarios.on('draw', eventosClickEditar);
        }

        function eventosClickEditar(){
            const btnsEditar = document.querySelectorAll('#editar');
            
            btnsEditar.forEach(btnEditar=>{
                btnEditar.addEventListener('click', function(e){
                    id=e.currentTarget.dataset.usuarioId;
                    accionesModal()
                })
            })

            const btnEliminar = document.querySelectorAll('#eliminar');
            btnEliminar.forEach(btnEliminar=>{
                btnEliminar.addEventListener('click', function(e){
                    const idUsuario = e.currentTarget.dataset.usuarioId;
                    alertaEliminarUsuario(idUsuario,e);
                })
            })
        }

        function alertaEliminarUsuario(id, e){
            const nombre = e.currentTarget.parentElement.parentElement.parentElement.childNodes[1].textContent;
            Swal.fire({
                icon:'warning',
                html: `<h2 class="">esta seguro de eliminar al usuario <span class="font-weight-bold"> ${nombre} </span>?</h2><br><p>Esta acción no se puede deshacer</p>`,
          
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: `Cancelar`,
                

            }).then(result=>{
                if(result.isConfirmed){
                    eliminarUsuario(id)
                }
            })
        }

        async function eliminarUsuario(id){
            const datos = new FormData();
            datos.append('id', id)
            url = 'http://localhost:3000/usuario/eliminar';
            try {
                const respuesta = await fetch(url,{
                    body:datos,
                    method: 'POST'
                })
                const resultado = await respuesta.json();
                
             
             
                eliminarToastAnterior();
            
                if(resultado.type=='error'){
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Error',
                     
                        body: resultado.msg
                      })
                }else{

                    $(document).Toasts('create', {
                        class: 'bg-azul text-blanco',
                        title: 'Completado',
                        
                        body: resultado.msg
                    })

                    setTimeout(()=>{
                        eliminarToastAnterior();
                    },8000)

                 
                    tablaUsuarios.ajax.reload(); 
                }
            } catch (error) { 
                console.log(error) 
            }
        }
        
        function accionesModal(){
            $('#usuarioForm').validate().destroy(); 
            formulario.reset();
            btnSubmit.disabled = false;

            limpiarSelect(estado)
            limpiarSelect(roll)

            const optionDisabledEstado = document.createElement('OPTION');
            optionDisabledEstado.setAttribute('disabled', 'disabled')
            optionDisabledEstado.setAttribute('selected', 'selected')
            optionDisabledEstado.textContent = '--Seleccione--';
            
            const optionEstado = document.createElement('OPTION');
            optionEstado.value = 0;
            optionEstado.textContent = 'Inactivo';
            const optionEstado1 = document.createElement('OPTION');
            optionEstado1.value = 1;
            optionEstado1.textContent = 'Activo';

            const optionDisabledRoll = document.createElement('OPTION');
            optionDisabledRoll.setAttribute('disabled', 'disabled')
            optionDisabledRoll.setAttribute('selected', 'selected')
            optionDisabledRoll.textContent = '--Seleccione--';
            
            const optionRoll = document.createElement('OPTION');
            optionRoll.value = 0;
            optionRoll.textContent = 'Vendedor';
            const optionRoll1 = document.createElement('OPTION');
            optionRoll1.value = 1;
            optionRoll1.textContent = 'Administrador';
            const optionRoll2 = document.createElement('OPTION');
            optionRoll2.value = 2;
            optionRoll2.textContent = 'Cliente';
            
            estado.appendChild(optionDisabledEstado)
            estado.appendChild(optionEstado)
            estado.appendChild(optionEstado1)
            roll.appendChild(optionDisabledRoll)
            roll.appendChild(optionRoll)
            roll.appendChild(optionRoll1)
            roll.appendChild(optionRoll2)

            $('#modal-usuario').modal('show');
            inicializarValidador();
            if(id){
                consultarUsuario();
            }
        }

        async function consultarUsuario(){
            try {
                const respuesta = await fetch(`/api/usuario?id=${id}`);
                const resultado = await respuesta.json();
                llenarFormulario(resultado);
            } catch (error) {
                console.log(error)
            }
        }

        function llenarFormulario(resultado){
           
            
            nombre.value = resultado.nombre;
            email.value = resultado.email;
       
            const optionEstado = estado.querySelector('option[value="' + resultado.estado + '"]');
            optionEstado.setAttribute("selected", "selected");
            const optionRoll = roll.querySelector('option[value="' + resultado.roll + '"]');
            optionRoll.setAttribute("selected", "selected");
       
        }
         
     
        async function enviarDatos(){
          
            const datos = new FormData();
            if(id){
                datos.append('id', id)
            }
            datos.append('nombre', (nombre.value).trim());
            datos.append('email', email.value);
            datos.append('estado', estado.value);
            datos.append('roll', roll.value);
            datos.append('password', password.value);
         
            btnSubmit.disabled = true;
            let url = '';
            if(id){
                url = 'http://localhost:3000/usuario/editar';
            }else{
                url = 'http://localhost:3000/usuario/crear';
            }
            

            try {
                const respuesta = await fetch(url,{
                    body:datos,
                    method: 'POST'
                })
                const resultado = await respuesta.json();
              //(Object.keys(resultado)[0])
                console.log(resultado)
                btnSubmit.disabled = false;
                eliminarToastAnterior();
                btnSubmit.disabled = false;
                if(resultado.type=='error'){
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Error',
                     
                        body: resultado.msg
                      })
                }else{

                    $(document).Toasts('create', {
                        class: 'bg-primary',
                        title: 'Completado',
                        
                        body: resultado.msg
                    })

                    setTimeout(()=>{
                        eliminarToastAnterior();
                    },4000)

                    formulario.reset();
                 
                    $('#modal-usuario').modal('hide');
                    tablaUsuarios.ajax.reload(); 
                }
   
            } catch (error) {  
            }
        }
        
      

        function eliminarToastAnterior(){
            if(document.querySelector('#toastsContainerTopRight')){
                document.querySelector('#toastsContainerTopRight').remove()
            }
        }
        function limpiarSelect(referencia){
            
            while(referencia.firstChild){
                referencia.removeChild(referencia.firstChild)
            }
            
        }
        function inicializarValidador() {
            $.validator.setDefaults({
              submitHandler: function () {
                 
                        enviarDatos();
                        

                    
              }
            });
            let passwordRules = {}
            let passwordMsg = {}
        
            if(!id){
       
                passwordRules = {
                    required: true,
                    minlength: 6   
                }
                passwordMsg = {
                        required: "El password es obligatorio",
                        minlength: "El Password debe tener al menos 6 caracteres"
                }
                
            }
    
             $('#usuarioForm').validate({
              rules: {
                nombre: {
                    required: true
                },
                email: {
                  required: true
                },
                estado:{
                    required: true,
                },
                roll:{
                    required: true,
                },
                password: passwordRules,
                terms: {
                  required: true
                },
              },
              messages: {
                nombre: {
                    required: "El nombre es obligatorio"
                },
                email: {
                  required: "El email es obligatorio"
                },
                estado:{
                    required: 'el estado es obligatorio',
                },
                roll:{
                    required: 'el Roll es obligatorio',
                },
                password: passwordMsg
              },
              errorElement: 'span',
              errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
              },
              highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
              },
              unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
              }
            });
          };
          $('#usuarioForm').on('valid', function(event) {
            inicializarValidador();
        });
    }
})();


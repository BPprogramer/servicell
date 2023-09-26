(function(){
    const tablaIngresos = document.querySelector('#tabla-ingresos');
    if(tablaIngresos){
        let idIngreso;
        const agregar_ingreso= document.querySelector('#agregar-ingreso');
        const formularioIngresos = document.querySelector('#ingresoForm');
        const ingreso = document.querySelector('#ingreso')
        const descripcion = document.querySelector('#descripcion_ingreso');
        const btnSubmitIngreso = document.querySelector('#btnSubmitIngreso')
        
        const totalIngresosSpan = document.querySelector('#totalIngresos');

        agregar_ingreso.addEventListener('click',function(e){
            
            accionesModalIngreso();
        })

        ingreso.addEventListener('input',function(e){
            const valor = formateraValorIngreso(e)
            ingreso.value = valor;
        })

        obtenerIngresos()

        function accionesModalIngreso(){
            formularioIngresos.reset();
            idIngreso = null;
            $('#modal-ingreso').modal('show');
            inicializarValidadorIngreso();

        }
        async function obtenerIngresos(){
            
            const id = obtenerIdUrl();
            const url =`http://localhost:3000/api/reparacion/ingresos?id=${id}`;
            try {
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();
            
                mostrarIngresos(resultado);
            } catch (error) {
                
            }

        }

        function mostrarIngresos(resultado){
          
            const tabla = document.querySelector('#tabla-ingresos');
            limpiarHtml(tabla)
           
            const tBody = document.createElement('tbody')
     
            const totalIngresos = resultado.reduce(function(acumulador, infoIngreso) {
                return acumulador + parseFloat(infoIngreso.ingreso)
              }, 0); 
     
            
            totalIngresosSpan.textContent = totalIngresos.toLocaleString('en')
      
            
            resultado.forEach(infoIngreso => {
                 const {id, ingreso, descripcion, reparacion_id} = infoIngreso;
                const tr = document.createElement('tr');

                const tdValor = document.createElement('td');
                tdValor.classList.add('py-2');
                tdValor.style.minWidth = '130px'
                tdValor.innerHTML = `Valor: $<strong>${parseFloat(ingreso).toLocaleString('en')}</strong>`
            


                const tdDescripcion = document.createElement('td');
                tdDescripcion.classList.add('py-2');
                
                tdDescripcion.innerHTML = `Descripcion: <strong style="max-width:30px !important">${descripcion}</strong>`

                const tdOpciones = document.createElement('td');
                tdOpciones.classList.add('py-2');
                tdOpciones.style.minWidth = '120px'
                
                const btnEditar = document.createElement('BUTTON');
                btnEditar.type = "button";
                btnEditar.classList.add('btn', 'btn-sm' ,'bg-hover-azul' ,'mx-2' ,'text-white', 'toolMio')
                btnEditar.innerHTML = "<span class='toolMio-text'>Editar</span><i class='fas fa-pen'></i>";

                btnEditar.onclick = function(){
                    llenarFormularioIngreso(infoIngreso)
                }

                const btnEliminar = document.createElement('BUTTON');
                btnEliminar.type = "button";
                btnEliminar.classList.add('btn', 'btn-sm' ,'bg-hover-azul' ,'mx-2' ,'text-white', 'toolMio')
                btnEliminar.innerHTML = "<span class='toolMio-text'>Eliminar</span><i class='fas fa-trash'></i>";
                btnEliminar.type = "button";
                btnEliminar.onclick = function(){
                    alertaEliminarIngreso(infoIngreso);
                }


                tdOpciones.appendChild(btnEditar)
                tdOpciones.appendChild(btnEliminar)

                tr.appendChild(tdValor)
                tr.appendChild(tdDescripcion)
                tr.appendChild(tdOpciones)
     
                tBody.appendChild(tr)


            });
          
            tabla.appendChild(tBody)
        }
        function alertaEliminarIngreso(ingresoInfo){
  
            Swal.fire({
                icon:'warning',
                html: `<h2 class="">esta seguro de eliminar el Ingreso de <span class="font-weight-bold"> ${(parseFloat(ingresoInfo.ingreso)).toLocaleString('en')} </span>?</h2><br><p>Esta acción no se puede deshacer</p>`,
          
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: `Cancelar`,
                

            }).then(result=>{
                if(result.isConfirmed){
                    eliminarIngreso(ingresoInfo.id)
                }
            })
        }
        async function eliminarIngreso(id){
    
            const datos = new FormData();
            datos.append('id', id);
    
            const url = '/api/reparacion/eliminar-ingreso';
           
            try {
                const respuesta = await fetch(url,{
                    body:datos,
                    method: 'POST'
                })
                const resultado = await respuesta.json();
          
                
         
            
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
                    obtenerIngresos();
                   
             
                    
                }
            } catch (error) { 
               
            }
        }

        
        function formateraValorIngreso(e){
      
            const valor = e.target.value;
            let valor_sin_formato = parseFloat(valor.replace(/,/g, ''));
            if(isNaN(valor_sin_formato)){
                valor_sin_formato = '';
            }
            const valor_formateado =  valor_sin_formato.toLocaleString('en');
            return valor_formateado ;
            
        }
        async function enviarDatosIngreso(){
            const datos = new FormData();
          
            datos.append('ingreso', ingreso.value);
            datos.append('descripcion', (descripcion.value).trim());
         
            btnSubmitIngreso.disabled = true;
            let url = '';
            if(idIngreso){
                if(idIngreso){
                    datos.append('id', idIngreso)
                }
                url = `/api/reparacion/editar-ingreso`;
               
            }else{
             
                url = '/api/reparacion/crear-ingreso';
                datos.append('reparacion_id', obtenerIdUrl());
            }

         
          

            try {
                const respuesta = await fetch(url,{
                    body:datos,
                    method: 'POST'
                })
                const resultado = await respuesta.json();
                
             
                eliminarToastAnterior();
                btnSubmitIngreso.disabled = false;
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
                    },4000)

                    formularioIngresos.reset();

                 
                    $('#modal-ingreso').modal('hide');
                    obtenerIngresos();
                }
   
            } catch (error) {  
            }
        }
        function obtenerIdUrl(){
         
            const  url = window.location.href;
            const  urlObj = new URL(url);
            return  id = urlObj.searchParams.get("id");
        }
        function llenarFormularioIngreso(resultado){
            idIngreso = resultado.id;
            $('#modal-ingreso').modal('show');
            inicializarValidadorIngreso();
            ingreso.value = (parseFloat(resultado.ingreso)).toLocaleString('en');
            descripcion.value = resultado.descripcion;

           
        }

        function inicializarValidadorIngreso() {
            $.validator.setDefaults({
              submitHandler: function () {
                        enviarDatosIngreso();
              }
            });
   
            
             $('#ingresoForm').validate({
              rules: {
                ingreso: {
                    required: true

                }
                
              },
              messages: {
                ingreso: {
                    required: "El valor del Ingreso es obligatorio"
                }
                

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
          $('#ingresoForm').on('valid', function(event) {
            inicializarValidadorIngreso();
        });

        function eliminarToastAnterior(){
            if(document.querySelector('#toastsContainerTopRight')){
                document.querySelector('#toastsContainerTopRight').remove()
            }
        }

        function limpiarHtml(tabla){
            while(tabla.firstChild){
                tabla.removeChild(tabla.firstChild)
            }
        }
    }
})();
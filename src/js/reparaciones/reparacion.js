(function(){
    const reparacion = document.querySelector('#reparacion');
    if(reparacion){
        let idCosto;
        const agregar_costo= document.querySelector('#agregar-costo');
        const formularioCostos = document.querySelector('#costoForm');
        const costo = document.querySelector('#costo')
        const descripcion = document.querySelector('#descripcion')
        const btnSubmitCosto = document.querySelector('#btnSubmitCosto')
        const totalCostosSpan = document.querySelector('#totalCostos');

        
        agregar_costo.addEventListener('click',function(e){
            
            accionesModalCosto();
        })
        costo.addEventListener('input',function(e){
            const valor = formateraValorCosto(e)
            costo.value = valor;
        })

        obtenerCostos();

        function accionesModalCosto(){
            formularioCostos.reset();
            idCosto = null;
            $('#modal-costo').modal('show');
            inicializarValidadorCosto();

        }

      

        async function obtenerCostos(){
            const id = obtenerIdUrl();
            const url =`${location.origin}/api/reparacion/costos?id=${id}`;
            try {
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();
                mostrarCostos(resultado);
            } catch (error) {
                
            }

        }


        function mostrarCostos(resultado){
            const tabla = document.querySelector('#tabla-costos');
            limpiarHtml(tabla)
           
            const tBody = document.createElement('tbody')
            const totalCostos = resultado.reduce(function(acumulador, infoCosto) {
                return acumulador + parseFloat(infoCosto.costo)
              }, 0); 
            totalCostosSpan.textContent = totalCostos.toLocaleString('en')
     
            
            resultado.forEach(infoCosto => {
                 const {id, costo, descripcion, reparacion_id} = infoCosto;
                const tr = document.createElement('tr');

                const tdValor = document.createElement('td');
                tdValor.classList.add('py-2');
                tdValor.style.minWidth = '130px'
                tdValor.innerHTML = `Valor: $<strong>${parseFloat(costo).toLocaleString('en')}</strong>`
            


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
                    llenarFormularioCosto(infoCosto)
                }

                const btnEliminar = document.createElement('BUTTON');
                btnEliminar.type = "button";
                btnEliminar.classList.add('btn', 'btn-sm' ,'bg-hover-azul' ,'mx-2' ,'text-white', 'toolMio')
                btnEliminar.innerHTML = "<span class='toolMio-text'>Eliminar</span><i class='fas fa-trash'></i>";
                btnEliminar.type = "button";
                btnEliminar.onclick = function(){
                    alertaEliminarCosto(infoCosto);
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
        
      
        function obtenerIdUrl(){
         
            const  url = window.location.href;
            const  urlObj = new URL(url);
            return  id = urlObj.searchParams.get("id");
        }

     
        function llenarFormularioCosto(resultado){
            idCosto = resultado.id;
            $('#modal-costo').modal('show');
            inicializarValidadorCosto();
            costo.value = (parseFloat(resultado.costo)).toLocaleString('en');
            descripcion.value = resultado.descripcion;

           
        }

        function formateraValorCosto(e){
      
            const valor = e.target.value;
            let valor_sin_formato = parseFloat(valor.replace(/,/g, ''));
            if(isNaN(valor_sin_formato)){
                valor_sin_formato = '';
            }
            const valor_formateado =  valor_sin_formato.toLocaleString('en');
            return valor_formateado ;
            
        }

        
        async function enviarDatosCosto(){
            const datos = new FormData();
          
            datos.append('costo', costo.value);
            datos.append('descripcion', (descripcion.value).trim());
         
            btnSubmitCosto.disabled = true;
            let url = '';
            if(idCosto){
                if(idCosto){
                    datos.append('id', idCosto)
                }
                url = `/api/reparacion/editar-costo`;
               
            }else{
             
                url = '/api/reparacion/crear-costo';
                datos.append('reparacion_id', obtenerIdUrl());
            }

            try {
                const respuesta = await fetch(url,{
                    body:datos,
                    method: 'POST'
                })
                const resultado = await respuesta.json();
                
          
                eliminarToastAnterior();
                btnSubmitCosto.disabled = false;
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

                    formularioCostos.reset();

                 
                    $('#modal-costo').modal('hide');
                    obtenerCostos();
                }
   
            } catch (error) {  
            }
        }

        function alertaEliminarCosto(costoInfo){
  
            Swal.fire({
                icon:'warning',
                html: `<h2 class="">esta seguro de eliminar el costo de <span class="font-weight-bold"> ${(parseFloat(costoInfo.costo)).toLocaleString('en')} </span>?</h2><br><p>Esta acción no se puede deshacer</p>`,
          
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: `Cancelar`,
                

            }).then(result=>{
                if(result.isConfirmed){
                    eliminarCosto(costoInfo.id)
                }
            })
        }
        async function eliminarCosto(id){
    
            const datos = new FormData();
            datos.append('id', id);
    
            const url = '/api/reparacion/eliminar-costo';
           
            try {
                const respuesta = await fetch(url,{
                    body:datos,
                    method: 'POST'
                })
                const resultado = await respuesta.json();
                console.log(resultado)
                
                // eliminarToastAnterior();
            
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
                    obtenerCostos();
                    console.log('recargano')
             
                    
                }
            } catch (error) { 
                console.log(error) 
            }
        }

        function inicializarValidadorCosto() {
            $.validator.setDefaults({
              submitHandler: function () {
                        enviarDatosCosto();
              }
            });
   
            
             $('#costoForm').validate({
              rules: {
                costo: {
                    required: true

                }
                
              },
              messages: {
                costo: {
                    required: "El valor del costo es obligatorio"
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
          $('#costoForm').on('valid', function(event) {
            inicializarValidadorCosto();
        });
    }

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
})();
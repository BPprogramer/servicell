(function(){
    const btnEstadoReparacion = document.querySelector('#btnEstadoReparacion');
    if(btnEstadoReparacion){
      
        const btnTotalReparacion = document.querySelector('#btnTotalReparacion');
        const btnImprimirReparacion = document.querySelector('#btnImprimirReparacion');
        consultarEstado();

        async function consultarEstado(){
            const id = obtenerIdUrl();
            const url = `http://localhost:3000/api/reparacion/estado-actual?id=${id}`;
            
            try {
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();
            
                setearEstado(resultado);
                setearTotal(resultado);
                setearImpresion(resultado);
                
            } catch (error) {
                
            }
        }
        function setearEstado(resultado){
            if(resultado.estado==0){
                btnEstadoReparacion.classList.add('bg-secondary');
                btnEstadoReparacion.textContent = 'Pendiente'
            }
            
            if(resultado.estado==1){
                btnEstadoReparacion.classList.remove('bg-secondary');
                btnEstadoReparacion.classList.add('bg-success');
                btnEstadoReparacion.textContent = 'Reparado'
            }if(resultado.estado==2){
                btnEstadoReparacion.classList.remove('bg-success');
                btnEstadoReparacion.classList.add('bg-danger');
                btnEstadoReparacion.textContent = 'Cerrado'
            }
            btnEstadoReparacion.dataset.estado = resultado.estado;
            if(resultado.estado!=2){
                btnEstadoReparacion.addEventListener('click', function(){
                    alertaCambiarEstado(resultado)
                })
            }
               
         
           
        }
        function alertaCambiarEstado(resultado){
            let mensaje = '';
            if(resultado.estado==0){
                mensaje = `<h2 class="">Acepta estar seguro de dar por  <span class="font-weight-bold"> REPARADO </span> el dispositvo?</h2><br><p>Esta acción no se puede deshacer</p> `
            }
            if(resultado.estado==1){
                mensaje = `<h2 class="">Acepta estar seguro de dar por  <span class="font-weight-bold"> FINALIZADA </span> esta reparación?</h2><br><p>Esta acción no se puede deshacer</p>`
            }
            Swal.fire({
                icon:'warning',
                html: mensaje,
          
                showCancelButton: true,
                confirmButtonText: 'Seguro',
                cancelButtonText: `Cancelar`,
                

            }).then(result=>{
                if(result.isConfirmed){
                    cambiarEstado(resultado)
                }
            })
        }
        async function cambiarEstado(resultado){
            const estado = parseInt(resultado.estado)+1;
     
            const datos = new FormData();
            datos.append('estado', estado);
            datos.append('reparacion_id', resultado.id)
            datos.append('cliente_id', resultado.cliente_id)
           
            const url = '/api/reparacion/cambiar-estado'
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
                    consultarEstado();
                 
                    
                }
            }catch(e){

            }
            
        }

        function setearImpresion(resultado){
            
            if(resultado.estado != 0){
           
                btnImprimirReparacion.addEventListener('click',function(){
                    imprimirReparado(resultado.id)
                })
            }
        }
        async function imprimirReparado(id){
          
           
            const url = `/api/factura-finalizada?key=${btoa(id)}`;
            try {
                const respuesta = await fetch(url)
                window.open(url, '_blank');
            } catch (error) {
                
            }
        }

        function setearTotal(resultado){
            if(resultado.estado==0){
                btnTotalReparacion.innerHTML = `Total: <strong></strong>`
            }else{
                const total_pagar = parseFloat(resultado.valor_final)-parseFloat(resultado.abono)+parseFloat(resultado.costo_final)
                btnTotalReparacion.innerHTML = `Total: <strong>$${(parseFloat(total_pagar)).toLocaleString('en')}</strong>`
            }
            
            
        }
        function obtenerIdUrl(){
         
            const  url = window.location.href;
            const  urlObj = new URL(url);
            return  id = urlObj.searchParams.get("id");
        }
        function eliminarToastAnterior(){
            if(document.querySelector('#toastsContainerTopRight')){
                document.querySelector('#toastsContainerTopRight').remove()
            }
          }
    }
})();
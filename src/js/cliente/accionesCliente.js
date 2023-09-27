(function(){
    const navReparacion = document.querySelector('#navReparacionCliente');
    if(navReparacion){
        const btnEstadoReparacion = document.querySelector('#btnEstadoReparacion');
        const btnTotalReparacion = document.querySelector('#btnTotalReparacion');
        const btnImprimirReparacion = document.querySelector('#btnImprimirReparacion');
        consultarEstado();

        
        async function consultarEstado(){
            const inputHiden = document.querySelector('#idReparacion');
            const id = inputHiden.dataset.reparacionId;
           
            const url = `${location.origin}/api/reparacion/estado-actual?id=${id}`;
            
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
        function setearTotal(resultado){
            if(resultado.estado==0){
                btnTotalReparacion.innerHTML = `Total: <strong></strong>`
            }else{
                const total_pagar = parseFloat(resultado.valor_final)-parseFloat(resultado.abono)+parseFloat(resultado.costo_final)
                btnTotalReparacion.innerHTML = `Total: <strong>$${(parseFloat(total_pagar)).toLocaleString('en')}</strong>`
            }
            
            
        }
        function setearImpresion(resultado){
            
            if(resultado.estado != 0){
           
                btnImprimirReparacion.addEventListener('click', function(e){
                    console.log('imprimiendo')
                })  
            }
        }
       
    }
})();
(function(){
  
    const costosCliente = document.querySelector('#tabla-costos-cliente');
   
    if(costosCliente){
        
        const totalIngresosSpan = document.querySelector('#totalIngresos');
        obtenerIngresos()
        async function obtenerIngresos(){
            
            const inputHiden = document.querySelector('#idReparacion');
            const id = inputHiden.dataset.reparacionId;
            const url =`http://localhost:3000/api/reparacion/ingresos?id=${id}`;
            try {
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();
            
                mostrarIngresos(resultado);
            } catch (error) {
                
            }

        }
        function mostrarIngresos(resultado){
          
          console.log(resultado)          
            const tabla = document.querySelector('#tabla-costos-cliente');
     
            
       
          
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

                
              

             

                tr.appendChild(tdValor)
                tr.appendChild(tdDescripcion)
       
     
                tBody.appendChild(tr)


            });
          
            tabla.appendChild(tBody)
        }
        function limpiarHtml(referencia){
            while(referencia.firstChild){
              referencia.removeChild(referencia.firstChild)
            }
        }
    }

})();
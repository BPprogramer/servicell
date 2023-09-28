(function(){
    const informacionCompleta = document.querySelector('#informacionCompleta');
    if(informacionCompleta){
        const ingresos = document.querySelector('#ingresos')
        const gastos = document.querySelector('#gastos')
        const ganancias = document.querySelector('#ganancias')
        const ganancias_mes_actual = document.querySelector('#ganancias_mes_actual')
        const ganancias_3_meses= document.querySelector('#ganancias_3_meses')
        const pendientes= document.querySelector('#pendientes')
        const reparados= document.querySelector('#reparados')
        const cerrados= document.querySelector('#cerrados')

        consultarInfo();
        async function consultarInfo(){
          
            const url = `${location.origin}/api/dashboard`;
            try {
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();
                console.log(resultado)
                imprimirResultados(resultado)
            } catch (error) {
                console.log(error)
            }
        }

        function imprimirResultados(resultado){
          
            ingresos.textContent = '$'+(parseFloat(resultado.ingresos_totales)+parseFloat(resultado.gastos_totales)).toLocaleString('en');
            gastos.textContent = '$'+(parseFloat(resultado.gastos_totales)).toLocaleString('en');
            ganancias.textContent = '$'+(parseFloat(resultado.ingresos_totales)).toLocaleString('en');
            ganancias_mes_actual.textContent = '$'+(parseFloat(resultado.ganancias_mes_actual)).toLocaleString('en');
            ganancias_3_meses.textContent = '$'+(parseFloat(resultado.ganancias_3_meses)).toLocaleString('en');
            pendientes.textContent = resultado.pendientes;
            reparados.textContent = resultado.reparados
            cerrados.textContent = resultado.cerrados
        }
    }
})();
(function(){
    const reparaciones = document.querySelector('#reparaciones');
    if(reparaciones){
        let tablaReparaciones;
        const marcasArray = ['NO ESPECIFICA','SAMSUMG', 'MOTOROLA',"NOKIA", 'LG', 'XIAOMI', 'KRONO', 'LENOVO', 'ALCATEL','HIUNDAI', 'IPHONE', 'SENDTEL','ASUS','TOSHIBA','DELL','HP','OPPO','REALME','HONOR','POCO','VIVO','ACER','SONY','BLU','CATERPILLAR','HTC', 'INFINIX','MICROSOFT','PANASONIC','SHARP','SONY ERICSSON', 'TLC', 'ZTE', 'OTRAS']
        const formulario = document.querySelector('#reparacionForm');
        let id = null;
        const nombre = document.querySelector('#nombre')
        const direccion = document.querySelector('#direccion')
        const marca = document.querySelector('#marca')
        const cedula_nit = document.querySelector('#cedula_nit')
        const celular = document.querySelector('#celular')
        const modelo = document.querySelector('#modelo')
        const imei_1 = document.querySelector('#imei_1')
        
        const imei_2 = document.querySelector('#imei_2')
        const falla = document.querySelector('#falla')
        const proceso = document.querySelector('#proceso')
        const valor_convenido = document.querySelector('#valor_convenido')
        const abono = document.querySelector('#abono')
        const saldo = document.querySelector('#saldo')
        const cargador = document.querySelector('#cargador')
        const bateria = document.querySelector('#bateria')
        const tapa = document.querySelector('#tapa')
        const estuche = document.querySelector('#estuche')
        const sim = document.querySelector('#sim')
        const sd = document.querySelector('#sd')
        const observacion = document.querySelector('#observacion')
        const btnRegistrarReparacion = document.querySelector('#registrar');
        checkOBJ  = {
            cargador:false,
            bateria:false,
            tapa:false,
            estuche:false,
            SIM:false,
            SD:false
        }
      
  
         mostrarReparaciones();
        // verificarCargaTabla();
     
        btnRegistrarReparacion.addEventListener('click',function(){
            abono.readOnly = false;
            valor_convenido.readOnly = false;
            id = null;
            llenarSelect('NO ESPECIFICA');
            accionesModal();
        })

        $('#reparaciones').on('click', '#editar',function(e){
            abono.readOnly = false;
            valor_convenido.readOnly = false;
            id=e.currentTarget.dataset.reparacionId;
         
            accionesModal();
             
        })

        $('#reparaciones').on('click', '#eliminar',function(e){
          
            const idReparacion = e.currentTarget.dataset.reparacionId;
            alertaEliminarReparacion(idReparacion,e);
             
        })
        $('#reparaciones').on('click', '#imprimir',function(e){
          
            const idReparacion = e.currentTarget.dataset.reparacionId;
            imprimirReparacion(idReparacion);
             
        })

        valor_convenido.addEventListener('input', function(e){
         
            valor_convenido.value =formaterValor(e);
            saldo.value =formaterValor(e);
            abono.value = 0;
           
        })
        abono.addEventListener('input', function(e){
            calcularDiferencia(e);
            abono.value = formaterValor(e);
            
        })

        async function imprimirReparacion(id){
        
            const url = `/api/factura?key=${btoa(id)}`;
            try {
                const respuesta = await fetch(url)
                window.open(url, '_blank');
            } catch (error) {
                
            }
        }

        function calcularDiferencia(e){
            const valor_acordado = valor_convenido.value
            const valor_acordado_sin_formato =  parseFloat(valor_acordado.replace(/,/g, ''));
            let abono = parseFloat(e.target.value.replace(/,/g, ''));
            if(abono ==''){
                abono = 0;
            }
            const saldo_pendiente = valor_acordado_sin_formato - abono;
       
            console.log(valor_acordado_sin_formato)
         
            if(isNaN(saldo_pendiente)){
                saldo_pendiente = '';
            }
            const valor_formateado =  saldo_pendiente.toLocaleString('en');
            saldo.value = valor_formateado;
            
        }

        function formaterValor(e){
            const valor = e.target.value;
            let valor_sin_formato = parseFloat(valor.replace(/,/g, ''));
            if(isNaN(valor_sin_formato)){
                valor_sin_formato = '';
            }
            const valor_formateado =  valor_sin_formato.toLocaleString('en');
            return valor_formateado ;
            
        }


       
        
        function alertaEliminarReparacion(id, e){
  
            const cliente = e.currentTarget.parentElement.parentElement.parentElement.childNodes[1].textContent;
            
            Swal.fire({
                icon:'warning',
                html: `<h2 class="">esta seguro de Cancelar la reparación del cliente <span class="font-weight-bold"> ${cliente} </span>?</h2><br><p>Esta acción no se puede deshacer</p>`,
          
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: `Cancelar`,
                

            }).then(result=>{
                if(result.isConfirmed){
                    eliminarReparacion(id)
                }
            })
        }
        async function eliminarReparacion(id){
            const datos = new FormData();
            datos.append('id', id);
    
            //url = 'http://localhost:3000/reparacion/eliminar';s
            const url = '/api/reparacion/eliminar'
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

                 
                    tablaReparaciones.ajax.reload(); 
                }
            } catch (error) { 
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Error',
                 
                    body: 'No es Posible eliminar La reparacion porque tiene gastos y/o ingrseso asociados'
                  })

                setTimeout(()=>{
                    eliminarToastAnterior();
                },8000)
            }
        }
        function mostrarReparaciones(){
 
            $("#tabla").dataTable().fnDestroy(); //por si me da error de reinicializar
    
            tablaReparaciones = $('#tabla').DataTable({
                ajax: '/api/reparaciones',
                "deferRender":true,
                "retrieve":true,
                "proccesing":true,
                responsive:true,
                initComplete: function () {
                    // Inicializa los botones después de que la tabla se haya creado
                    var buttons = new $.fn.dataTable.Buttons(tablaReparaciones, {
                        buttons: ["copy", "csv", "excel", "pdf", "print"]
                    }).container().appendTo('#tabla_wrapper .col-md-6:eq(0)');
                }
            });
            
            // $.ajax({
            //     url:'/api/reparaciones',
            //     dataType:'json',
            //     success:function(req){
            //         console.log(req)
            //     },
            //     error:function(error){
            //         console.log(error.resposeText)
            //     }
            // })
       
        }  
        

        function accionesModal(){
      
            formulario.reset();
            btnSubmit.disabled = false;
            $('#modal-reparacion').modal('show');
       
           
            
            
            inicializarValidador();
            if(id){
             
                consultarReparacion();
            }
        }

        async function  consultarReparacion(){
        
            try {
                const respuesta = await fetch(`/api/reparacion?id=${id}`);
                const resultado = await respuesta.json();
               
             
                llenarFormulario(resultado);
            } catch (error) {
                console.log(error)
            }
        }
        function llenarFormulario(resultado){
            const accesorios = JSON.parse(resultado.accesorios);
            nombre.value = resultado.nombre;
            cedula_nit.value = resultado.cedula_nit;
            celular.value = resultado.celular;
            direccion.value = resultado.direccion;
        
            llenarSelect( resultado.marca);
            
            modelo.value = resultado.modelo;
            imei_1.value = resultado.imei_1;
            imei_2.value = resultado.imei_2;
            falla.value = resultado.falla;
            proceso.value = resultado.proceso;
            valor_convenido.value = (parseFloat(resultado.valor_convenido)).toLocaleString('en')
            abono.value = (parseFloat(resultado.abono)).toLocaleString('en')
            saldo.value = (parseFloat(resultado.saldo)).toLocaleString('en')
            if(resultado.estado!=0){
                abono.readOnly = true;
                valor_convenido.readOnly = true;

            }
            if(accesorios.cargador==true){
                cargador.checked = true;
            }
            if(accesorios.bateria==true){
                bateria.checked = true;
            }
            if(accesorios.estuche==true){
                estuche.checked = true;
            }
            if(accesorios.tapa==true){
                tapa.checked = true;
            }
            if(accesorios.sim==true){
                sim.checked = true;
            }
          
            if(accesorios.sd==true){
                sd.checked = true;
            }
            observacion.value = resultado.observacion
          
           
        }
         

        async function enviarDatos(){
            const datos = new FormData();
            if(id){
                datos.append('id', id)
            }
            datos.append('nombre', (nombre.value).trim());
            datos.append('cedula_nit', (cedula_nit.value).trim());
            datos.append('celular', celular.value);
            datos.append('direccion', (direccion.value).trim());
            datos.append('marca', marca.value);
            datos.append('modelo', (modelo.value).trim());
            datos.append('imei_1', (imei_1.value).trim());
            datos.append('imei_2', (imei_2.value).trim());
            datos.append('falla', (falla.value).trim());
            datos.append('proceso', (proceso.value).trim());
            datos.append('valor_convenido', valor_convenido.value);
            datos.append('abono', abono.value);
            datos.append('saldo', saldo.value);
            datos.append('observacion', (observacion.value).trim());

            datos.append('accesorios',formatearCheckBox() );
         

            btnSubmit.disabled = true;
            let url = '';
            if(id){
      
                url = `/api/reparacion/editar`;
            }else{
                console.log('creando');
                url = '/api/reparacion/crear';
            }
            
            try {
                const respuesta = await fetch(url,{
                    body:datos,
                    method: 'POST'
                })
                const resultado = await respuesta.json();
          
                eliminarToastAnterior();
                btnSubmit.disabled = false;
                if(resultado.type=='error'){
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Error',
                     
                        body: resultado.msg
                      })
                }else{
                    tablaReparaciones.ajax.reload()

                    $(document).Toasts('create', {
                        class: 'bg-azul text-blanco',
                        title: 'Completado',
                        
                        body: resultado.msg
                    })

                    setTimeout(()=>{
                        eliminarToastAnterior();
                    },4000)

                    formulario.reset();

                 
                    $('#modal-reparacion').modal('hide');
                    //tablaReparaciones.ajax.reload(); 
                }
   
            } catch (error) {  
            }
        }

        function formatearCheckBox(){
            checkOBJ.cargador = cargador.checked;
            checkOBJ.tapa = tapa.checked;
            
            checkOBJ.bateria = bateria.checked;
            checkOBJ.estuche= estuche.checked;
            checkOBJ.sim= sim.checked;
            checkOBJ.sd = sd.checked;

            const jsonString =  JSON.stringify(checkOBJ)
            return  jsonString.replace(/\\/g, '');
            
        }

        function eliminarToastAnterior(){
            if(document.querySelector('#toastsContainerTopRight')){
                document.querySelector('#toastsContainerTopRight').remove()
            }
        }

        function inicializarValidador() {
            $.validator.setDefaults({
              submitHandler: function () {
                        enviarDatos();
              }
            });
   
            
             $('#reparacionForm').validate({
              rules: {
                nombre: {
                    required: true
                },
                cedula_nit:{
                    required: true
                },
                celular:{
                    required: true,
                    digits:true,
                    minlength:10,
                    maxlength:10
                },
                valor_convenido:{
                    required: true

                }
              },
              messages: {
                nombre: {
                    required: "El nombre de la categoría es obligatorio"
                },
                cedula_nit:{
                    required: 'El Número de identificación es obligatorio'
                },
                celular:{
                    required: 'El Celular de contacto es obligatorio',
                    digits:'El número de celular solo puede contener números',
                    minlength:'El número de celular debe de ser de 10 digitos',
                    maxlength:'El número de celular debe de ser de 10 digitos'
                },
                valor_convenido:{
                    required: 'El valor convenido es obligatorio'

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
          $('#reparacionForm').on('valid', function(event) {
            inicializarValidador();
        });
        function llenarSelect(optionSeleccionado){
   
          
            while(marca.firstChild){
                marca.removeChild(marca.firstChild)
            }
       
            marcasArray.forEach(marcaCelular => {
           
                const opcion =   document.createElement('OPTION');
                opcion.value = marcaCelular;
                opcion.textContent = marcaCelular;
                if(marcaCelular == optionSeleccionado){
               
                    opcion.selected = true;
                }
               
        
                marca.appendChild(opcion)
            });
        }
        $('.select2').select2()
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    
    }

  
})();
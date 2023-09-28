(function(){
    const tablaNotificaciones = document.querySelector('#tabla-notificaciones');
    if(tablaNotificaciones){
      
    
   
        const btnSubmitNotificacion = document.querySelector('#btnSubmitNotificacion')
        const agregar_notificacion= document.querySelector('#agregar-notificacion');
        const formularioNotificaciones = document.querySelector('#notificacionForm');
        const mensaje = document.querySelector('#mensaje');
        const imagenes = document.querySelector('#imagenes');
        const contenedorImagenes = document.querySelector("#contenedorImganes");
        let idNotificacion;

        agregar_notificacion.addEventListener('click',function(e){
            
            accionesModalNotifiacion();
       
        })
        obtenerNotificaciones();

        async function obtenerNotificaciones(){
          const id = obtenerIdUrl();
          const url =`${location.origin}/api/reparacion/notificaciones?id=${id}`;
          try {
              const respuesta = await fetch(url);
              const resultado = await respuesta.json();

              mostrarNotificaciones(resultado);
          } catch (error) {
              
          }

        }

        function llenarFormularioNotificacion(resultado){
          limpiarHtml(contenedorImagenes);
          idNotificacion = resultado.id;
          $('#modal-notificacion').modal('show');
          inicializarValidadorNofiticacion();
          mensaje.value = resultado.mensaje;
          if(resultado.imagenes.length!=0){
   
            resultado.imagenes.forEach(imagen =>{
          
              const image= document.createElement("img");
              image.classList.add('col-md-4','mb-3');
              image.src = `../img/notificaciones/${imagen}.png`
              image.setAttribute("alt", "no hay imágenes");
     
              contenedorImagenes.appendChild(image);
  
            })
          }
       
   
      }

      function alertaEliminarNotificacion(infoNotificacion){


        Swal.fire({
            icon:'warning',
            title:"Esta seguro de eliminar esta Notificación?",
            text:"Esta acción no se puede deshacer",
      
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: `Cancelar`,
            

        }).then(result=>{
            if(result.isConfirmed){
                eliminarNotificacion(infoNotificacion.id)
            }
        })
      }
      async function eliminarNotificacion(id){
    
        const datos = new FormData();
        datos.append('id', id);

        const url = '/api/reparacion/eliminar-notificacion';
       
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
                obtenerNotificaciones();
               
         
                
            }
        } catch (error) { 
           
        }
    }

        function mostrarNotificaciones(resultado){
       
          
          const tabla = document.querySelector('#tabla-notificaciones');
          limpiarHtml(tabla)
         
          const tBody = document.createElement('tbody')
       
          let numero = 0;
          resultado.forEach(infoNotificacion => {
            numero++;
              const {id, mensaje, imagenes} = infoNotificacion;
         

              const tr = document.createElement('tr');
              const td = document.createElement('TD')
              const div = document.createElement('DIV');
              div.classList.add('row', 'd-flex', 'justify-content-between')
              
              const parrafo = document.createElement('P');
              parrafo.classList.add('col-md-6');

              parrafo.innerHTML = `<strong>Mensaje:</strong><br>${mensaje}`;

              const divBtns = document.createElement('DIV');
              divBtns.classList.add('col-md2')
              const btnEditar = document.createElement('BUTTON');
              btnEditar.type = "button";
              btnEditar.classList.add('btn', 'btn-sm' ,'bg-hover-azul' ,'mx-2' ,'text-white', 'toolMio')
              btnEditar.innerHTML = "<span class='toolMio-text'>Editar</span><i class='fas fa-pen'></i>";
              btnEditar.style.maxHeight = "40px"
              btnEditar.style.maxWidth = "40px"

              btnEditar.onclick = function(){
                llenarFormularioNotificacion(infoNotificacion)
              }

              const btnEliminar = document.createElement('BUTTON');
              btnEliminar.type = "button";
              btnEliminar.classList.add('btn', 'btn-sm' ,'bg-hover-azul' ,'mx-2' ,'text-white', 'toolMio')
              btnEliminar.innerHTML = "<span class='toolMio-text'>Eliminar</span><i class='fas fa-trash'></i>";
              btnEliminar.type = "button";
              btnEliminar.style.maxHeight = "40px"
              btnEliminar.style.maxWidth = "40px"

              

              btnEliminar.onclick = function(){
                  alertaEliminarNotificacion(infoNotificacion);
              }
              
            
              const carrousel = document.createElement('DIV');
              carrousel.id = `carousel_${numero}`;
              carrousel.classList.add('carousel', 'slide', 'float-right', 'col-md-3');
          
              carrousel.dataset.ride = "carousel";
              carrousel.style.maxWidth = "40rem"
              carrousel.style.maxHeight = "40rem"
            
              carrousel.style.padding = "10px"
              

              const ol = document.createElement('OL');
              ol.classList.add('carousel-indicators');
            
              const carrouselInner = document.createElement('DIV');
              carrouselInner.classList.add("carousel-inner");
              let i = 1;
             
            
              imagenes.forEach(imagen => {
                  if(imagen!=''){
                    const li = document.createElement('LI');
                    li.dataset.target = `#carousel_${numero}`
                    li.dataset.slideTo = `${i}`;
                
                    const carrouselItem = document.createElement('DIV');
       
                    carrouselItem.classList.add('carousel-item');
                
                    const img = document.createElement('IMG');
                    img.classList.add('d-block', 'w-100')
                    img.src = `/img/notificaciones/${imagen}.png`;
                    // img.addEventListener('click',function(e){
                    //   console.log(e.target.src)
                    // })
              
                  
                    
                    if(i==1){
                      li.classList.add('active');
                      carrouselItem.classList.add('active');
                    }
                    ol.appendChild(li);
                    carrouselItem.appendChild(img)
                   
                    carrouselInner.appendChild(carrouselItem);
  
                    i++;
                  }
           
              });
              
             
            
              const prev = document.createElement('A');
         
              prev.classList.add('carousel-control-prev');
     
              prev.href = `#carousel_${numero}`;
              prev.setAttribute("role", "button");
              prev.dataset.slide = "prev";

              prev.innerHTML = `
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
              `

                
              const next = document.createElement('A');
         
              next.classList.add('carousel-control-next');
     
              next.href = `#carousel_${numero}`;
              next.setAttribute("role", "button");
              next.dataset.slide = "next";

              next.innerHTML = ` 
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
              `
       
              carrousel.appendChild(ol)
              carrousel.appendChild(carrouselInner);
              carrousel.appendChild(prev);
              carrousel.appendChild(next);
              carrousel.ondblclick = ()=>{
                  mostrarCarrouselModal(imagenes)
              }
             

              divBtns.appendChild(btnEditar)
              divBtns.appendChild(btnEliminar)
           
          
  
        
               div.appendChild(carrousel)
               div.appendChild(parrafo)
               div.appendChild(divBtns)
              td.appendChild(div);
      
              tr.appendChild(td)
   
              tBody.appendChild(tr)

            
              
          
              
          });
      
      
       
           tabla.appendChild(tBody)
          // const carrouseles = document.querySelectorAll('.mostrarImagenesGrander');
          // carrouseles.forEach(carrouselActual=>{
          //   carrouselActual.addEventListener('dblClick', function(){
          //     console.log('asfdasdf')
          //     mostrarCarrouselModal(carrouselActual)
              
          //   })
          // })
     
   
        }

      function mostrarCarrouselModal(imagenes){
        const contendorCarrouselgrande = document.querySelector('#contenedor_carrousel_grande');
      
        limpiarHtml(contendorCarrouselgrande);

        const carrouselGrande = document.createElement('DIV');
       

        carrouselGrande.id = `carousel_grande`;
        carrouselGrande.classList.add('carousel', 'slide', 'float-right', 'col-md-3');
       
     
        carrouselGrande.dataset.ride = "carousel";
        carrouselGrande.style.maxWidth = "40rem"
        carrouselGrande.style.maxHeight = "40rem"
        
      
        carrouselGrande.style.padding = "0px"
        

        const ol = document.createElement('OL');
        ol.classList.add('carousel-indicators');
      
        const carrouselGrandeInner = document.createElement('DIV');
        carrouselGrandeInner.classList.add("carousel-inner");
        let i = 1;
       
       
        imagenes.forEach(imagen => {
            if(imagen!=''){
              const li = document.createElement('LI');
              li.dataset.target = `#carousel_grande`
              li.dataset.slideTo = `${i}`;
          
              const carrouselGrandeItem = document.createElement('DIV');
 
              carrouselGrandeItem.classList.add('carousel-item');
          
              const img = document.createElement('IMG');
              img.classList.add('d-block', 'w-100')
              img.src = `/img/notificaciones/${imagen}.png`;
              // img.addEventListener('click',function(e){
              //   console.log(e.target.src)
              // })
        

              
              if(i==1){
                li.classList.add('active');
                carrouselGrandeItem.classList.add('active');
              }
              ol.appendChild(li);
              carrouselGrandeItem.appendChild(img)
             
              carrouselGrandeInner.appendChild(carrouselGrandeItem);

              i++;
            }
     
        });
        
        

        const prev = document.createElement('A');
   
        prev.classList.add('carousel-control-prev');

        prev.href = `#carousel_grande`;
        prev.setAttribute("role", "button");
        prev.dataset.slide = "prev";

        prev.innerHTML = `
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
        `
    
          
        const next = document.createElement('A');
   
        next.classList.add('carousel-control-next');

        next.href = `#carousel_grande`;
        next.setAttribute("role", "button");
        next.dataset.slide = "next";

        next.innerHTML = ` 
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
        `
        
      
        carrouselGrande.appendChild(ol)
        carrouselGrande.appendChild(carrouselGrandeInner);
        carrouselGrande.appendChild(prev);
        carrouselGrande.appendChild(next);

        $('#modal-carrousel-imagenes').modal('show')
        contendorCarrouselgrande.appendChild(carrouselGrande);
        
    
      }
     

        imagenes.addEventListener('change',function(e){
            limpiarHtml(contenedorImagenes);
            const imagenes = e.target.files;

            for (let i = 0; i < imagenes.length; i++) {
              const file = imagenes[i];
              const reader = new FileReader();
              reader.onload = function (e) {
                const image = document.createElement("img");
                image.src = e.target.result;
                image.classList.add('col-md-4','mb-3');
                contenedorImagenes.appendChild(image);
                
                return;
              };
          
              reader.readAsDataURL(file);
            }
        })
       
        function limpiarHtml(referencia){
          while(referencia.firstChild){
            referencia.removeChild(referencia.firstChild)
          }
        }




        function accionesModalNotifiacion(){
            formularioNotificaciones.reset();
            limpiarHtml(contenedorImagenes);
            $('#modal-notificacion').modal('show');
            inicializarValidadorNofiticacion();

        }
        function obtenerIdUrl(){
         
          const  url = window.location.href;
          const  urlObj = new URL(url);
          return  id = urlObj.searchParams.get("id");
      }
        async function enviarDatosNotifiacion(){
            const datos = new FormData();
       
            datos.append('mensaje', (mensaje.value).trim());
            datos.append('reparacion_id', obtenerIdUrl())
            const files = imagenes.files;
      
            if(files.length>0){
              for (let i = 0; i < files.length; i++) {
                datos.append("imagenes[]", files[i]);
              }
            }else{
             
              datos.append("imagenes[]", []);
            }
       
            btnSubmitNotificacion.disabled = true;

            let url = '';
            if(idNotificacion){
              
                datos.append('id', idNotificacion)
                url = '/api/reparacion/editar-notificacion';
                
               
            }else{
             
                url = '/api/reparacion/crear-notificacion';
          
            }
        


            try {
                const respuesta = await fetch(url,{
                    body:datos,
                    method: 'POST'
                })
                const resultado = await respuesta.json();
               
         
                eliminarToastAnterior();
                btnSubmitNotificacion.disabled = false;
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

                    formularioNotificaciones.reset();

                 
                    $('#modal-notificacion').modal('hide');
                    obtenerNotificaciones();
                }
             
              
   
            } catch (error) {  
            }
        }
        function eliminarToastAnterior(){
          if(document.querySelector('#toastsContainerTopRight')){
              document.querySelector('#toastsContainerTopRight').remove()
          }
        }

        function inicializarValidadorNofiticacion() {
      
            $.validator.setDefaults({
              submitHandler: function () {
                        enviarDatosNotifiacion();
              }
            });
   
            
             $('#notificacionForm').validate({
              rules: {
                mensaje: {
                    required: true

                }
                
              },
              messages: {
                mensaje: {
                    required: "El mensaje de la notifiación es Obligatorio"
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
          $('#notificacionForm').on('valid', function(event) {
            inicializarValidadorNofiticacion();
        });
    }
})();


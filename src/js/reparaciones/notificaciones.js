(function(){
    const tablaNotificaciones = document.querySelector('#tabla-notificaciones');
    if(tablaNotificaciones){
        const btnSubmitNotificacion = document.querySelector('#btnSubmitNotificacion')
        const agregar_notificacion= document.querySelector('#agregar-notificacion');
        const formularioNotificaciones = document.querySelector('#notificacionForm');
        const mensaje = document.querySelector('#mensaje');
        const imagenes = document.querySelector('#imagenes');
        const contenedorImagenes = document.querySelector("#contenedorImganes");

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
              parrafo.classList.add('col-md-8');

              parrafo.innerHTML = `<strong>Mensaje:</strong><br>${mensaje}`;
              
            
              const carrousel = document.createElement('DIV');
              carrousel.id = `carousel_${numero}`;
              carrousel.classList.add('carousel', 'slide', 'float-right');
          
              carrousel.dataset.ride = "carousel";
              carrousel.style.maxWidth = "350px"
            
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
           
              div.appendChild(parrafo)
              div.appendChild(carrousel)
              td.appendChild(div);
      
              tr.appendChild(td)
   
              tBody.appendChild(tr)
              
          
              
          });
      
      
       
          tabla.appendChild(tBody)
     
   
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

            url = '/api/reparacion/crear-notificacion';

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


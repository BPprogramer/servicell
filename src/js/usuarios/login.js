(function(){
    const loginForm = document.querySelector('#loginForm');

    if(loginForm){

        const email =  document.querySelector('#email');
        const password =  document.querySelector('#password');
        const btnSubmit = document.querySelector('#btnSubmit');
        inicializarValidador();


        async function enviarDatos(){
            btnSubmit.disabled=true;
            const datos = new FormData();
            datos.append('email', (email.value).trim())
            datos.append('password', password.value);
            
            try {
                const url = '/usuario/login';
                const respuesta = await fetch(url,{
                    body:datos,
                    method:'POST'
                })
                const resultado = await respuesta.json();
                elimiarToastAnterior();
                if(resultado.type=='error'){
                    btnSubmit.disabled=false;
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Error',
                     
                        body: resultado.msg
                      })
                }else{
                  if(resultado.roll==1){
                    window.location.href = '/inicio'
                  }
                  if(resultado.roll==2){
                
                    window.location.href = '/clientes'
                  }
                    
                }
            } catch (error) {
                
            }
        }
        function elimiarToastAnterior(){
            if(document.querySelector('#toastsContainerTopRight')){
                document.querySelector('#toastsContainerTopRight').remove()
            }
        }

        function inicializarValidador() {
          console.log('asdf')
            $.validator.setDefaults({
              submitHandler: function () {
                 
                enviarDatos();
                    
              }
            });
    
             $('#loginForm').validate({
              rules: {
               
                email: {
                  required: true
                },
                password:{
                    required: true,
                }
              },
              messages: {
               
                email: {
                  required: "El usuario es obligatorio"
                },
                password: {
                    required: "El password es obligatorio",
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
          $('#loginForm').on('valid', function(event) {
            inicializarValidador();
        });
    }
})();
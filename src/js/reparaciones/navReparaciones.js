(function(){
    const navReparacion = document.querySelector('#navReparacion');
    if(navReparacion){
        const general = document.querySelector('#general');
        const notificaciones = document.querySelector('#notificaciones');
        const avanzado = document.querySelector('#avanzado');
        const info_general = document.querySelector('#info_general');
        const info_notificaciones = document.querySelector('#info_notificaciones');
        const info_avanzado = document.querySelector('#info_avanzado');

        general.addEventListener('click',()=>{
            const active = document.querySelector('.active-nav');
            active.classList.remove('active-nav')
            general.classList.add('active-nav')

            const dNones = document.querySelectorAll('.d-none');
            dNones.forEach(dNone=>{
                dNone.classList.remove('d-none')
            })
            info_notificaciones.classList.add('d-none')
            info_avanzado.classList.add('d-none')
            
          
        })
        notificaciones.addEventListener('click',()=>{
            const active = document.querySelector('.active-nav');
            active.classList.remove('active-nav')
            notificaciones.classList.add('active-nav')

            const dNones = document.querySelectorAll('.d-none');
            dNones.forEach(dNone=>{
                dNone.classList.remove('d-none')
            })
            info_general.classList.add('d-none')
            info_avanzado.classList.add('d-none')
        })
        avanzado.addEventListener('click',()=>{
            const active = document.querySelector('.active-nav');
            active.classList.remove('active-nav')
            avanzado.classList.add('active-nav')

            const dNones = document.querySelectorAll('.d-none');
            dNones.forEach(dNone=>{
                dNone.classList.remove('d-none')
            })
            info_notificaciones.classList.add('d-none')
            info_general.classList.add('d-none')
        })
    }
})();
(function () {

    obtenerTareas();

    // Boton para mostrar el Modal de Agregar Tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    function mostrarFormulario() {
        const modal = document.createElement('DIV');

        modal.classList.add('modal');

        modal.innerHTML = `
            <form class="formulario nueva-tarea">
                <legend>Añade una nueva tarea</legend>
                <div class="campo">
                    <label>Tarea</label>
                    <input
                        type="text"
                        name="tarea"
                        placeholder="A;adir Tarea al proyecto actual"
                        id="tarea"
                    />
                </div>
                <div class="opciones">
                    <input type="submit" class="submit-nueva-tarea" value="Añadir Tarea"/>
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
            </form>
        `;

        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('animar'); 
        }, 200);

        modal.addEventListener('click', function (e) {
            e.preventDefault();

            if (e.target.classList.contains('cerrar-modal')) {

                const formulario = document.querySelector('.formulario');
                formulario.classList.add('cerrar'); 

                setTimeout(() => {
                    modal.remove();
                }, 500);
            }

            if (e.target.classList.contains('submit-nueva-tarea')) {
                submitFormularioNuevaTarea();
            }
            
        });

        document.querySelector('.dashboard').appendChild(modal);
    }

    function submitFormularioNuevaTarea() {
        const tarea = document.querySelector('#tarea').value.trim();
        
        if (tarea === '') {
            // Mostrar alerta de error
            mostrarAlerta('El nombre de la tarea es obligatorio', 'error', 
                document.querySelector('.formulario legend'));

            return;
        }

        // Pasa la validacion, entonces, llamamos:
        agregarTarea(tarea);
 
    }

    function mostrarAlerta(mensaje, tipo, referencia) {

        //Previene la creacion de multiples alertas
        const alertaPrevia = document.querySelector('.alerta');
        if (alertaPrevia) {
            alertaPrevia.remove();
        }

        // Creacion de la alerta
        const alerta = document.createElement('div');
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;

        // Inserta la alerta antes del Legend
        referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);

        // Eliminar la alerta des[ues de  segundos
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }

    // Consultar el Servidor para anadir una nueva tarea al proyecto actual
    async function agregarTarea(tarea) {
        // Construir la peticion
        const datos = new FormData();

        datos.append('nombre', tarea); // enviamos como peticion
        datos.append('url', obtenerProyecto());

        try {
            const url = 'http://localhost:3000/api/tarea';

            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos // Esto yo envio al servidor
            });

            console.log(respuesta);

            const resultado = await respuesta.json();

                console.log(resultado);

            mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector('.formulario legend'));

            if (resultado.tipo === 'exito') {
                const formulario = document.querySelector('.nueva-tarea');
                formulario.reset();
            }

        } catch (error) {
            console.log(error);
        }


    }

    function obtenerProyecto() {
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams.entries()); // Iterar el objeto

        return proyecto.id;
    }

    async function obtenerTareas(){
        try {
            const id = obtenerProyecto();

            const url = `/api/tareas?id=${id}`;

            const respuesta = await fetch(url);

            const resultado = await respuesta.json();

            // console.log(resultado.tareas);
            const {tareas} = resultado;

            console.log(tareas);
            mostrarTareas(tareas);

        } catch (error) {
            console.log(error);
        }
    }

    function mostrarTareas(tareas) {

        if (tareas.length === 0) {
            const contenedorTareas = document.querySelector('#listado-tareas');

            const textoNoTareas = document.createElement('li');
            textoNoTareas.textContent = 'No hay tareas';
            textoNoTareas.classList.add('no-tareas');

            contenedorTareas.appendChild(textoNoTareas);

            return;
        }

        tareas.forEach(tarea => {
            const contenedorTarea = document.createElement('li');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;

            console.log(contenedorTarea);
        });


    }

})();
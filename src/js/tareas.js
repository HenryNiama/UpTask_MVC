(function () {

    obtenerTareas();

    let tareas = [];
    let filtradas = [];


    // Boton para mostrar el Modal de Agregar Tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', function () {
        mostrarFormulario();
    });

    function mostrarFormulario(editar = false, tarea = {}) {

        console.log(editar);
        const modal = document.createElement('DIV');

        modal.classList.add('modal');

        modal.innerHTML = `
            <form class="formulario nueva-tarea">
                <legend>${editar ? 'Editar Tarea' : 'Añade una nueva tarea'}</legend>
                <div class="campo">
                    <label>Tarea</label>
                    <input
                        type="text"
                        name="tarea"
                        placeholder="${tarea.nombre ? 'Edita la tarea' : 'Anadir Tarea al proyecto actual'}"
                        id="tarea"
                        value="${tarea.nombre ? tarea.nombre : ''}"
                    />
                </div>
                <div class="opciones">
                    <input 
                        type="submit" 
                        class="submit-nueva-tarea" 
                        value="${tarea.nombre ? 'Guardar cambios' : 'Añadir Tarea'}"/>
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

                const nombreTarea = document.querySelector('#tarea').value.trim();
        
                if (nombreTarea === '') {
                    // Mostrar alerta de error
                    mostrarAlerta('El nombre de la tarea es obligatorio', 'error', 
                        document.querySelector('.formulario legend'));

                    return;
                }

                if (editar) { // Si es true
                    console.log('Editando tarea');

                    tarea.nombre = nombreTarea;
                    actualizarTarea(tarea);
                }else{
                    console.log('Agregando Nueva Tarea');
                    agregarTarea(nombreTarea);
                }
                
            }
            
        });

        document.querySelector('.dashboard').appendChild(modal);
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

                // Agregar el objeto de tarea al global de tareas
                const tareaObj = {
                    id: String(resultado.id),
                    nombre: tarea,
                    estado: "0", // porque es tarea nueva
                    proyectoId: resultado.proyectoId
                };

                // Agrego el objeto al arreglo global
                tareas = [...tareas, tareaObj]; 

                mostrarTareas();
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
            tareas = resultado.tareas;

            console.log(tareas);
            mostrarTareas();

        } catch (error) {
            console.log(error);
        }
    }

    function mostrarTareas() {

        limpiarTareasAntiguas();

        totalPendientes();
        totalCompletas();

        const arrayTareas = filtradas.length ? filtradas : tareas;

        if (arrayTareas.length === 0) {
            const contenedorTareas = document.querySelector('#listado-tareas');

            const textoNoTareas = document.createElement('li');
            textoNoTareas.textContent = 'No hay tareas';
            textoNoTareas.classList.add('no-tareas');

            contenedorTareas.appendChild(textoNoTareas);

            return;
        }

        const estados = {
            0: 'Pendiente',
            1: 'Completa'
        };

        arrayTareas.forEach(tarea => {
            const contenedorTarea = document.createElement('li');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;
            nombreTarea.ondblclick = function () {
                mostrarFormulario(true, {...tarea});
            }

            const opcionesDiv = document.createElement('div');
            opcionesDiv.classList.add('opciones');

            // Botones
            const btnEstadoTarea = document.createElement('button');
            btnEstadoTarea.classList.add('estado-tarea');
            btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`);
            btnEstadoTarea.textContent = estados[tarea.estado];
            btnEstadoTarea.dataset.estadoTarea = tarea.estado;
            btnEstadoTarea.ondblclick = function () {
                cambiarEstadoTarea({...tarea}); // Mandamos una copia del original
            };


            const btnEliminarTarea = document.createElement('BUTTON');
            btnEliminarTarea.classList.add('eliminar-tarea');
            btnEliminarTarea.dataset.idTarea = tarea.id;
            btnEliminarTarea.textContent = 'Eliminar';
            btnEliminarTarea.ondblclick = function () {
                confirmarEliminarTarea({...tarea});
            }
            
            opcionesDiv.appendChild(btnEstadoTarea);
            opcionesDiv.appendChild(btnEliminarTarea);

            contenedorTarea.appendChild(nombreTarea);
            contenedorTarea.appendChild(opcionesDiv);


            const listadoTareas = document.querySelector('#listado-tareas');
            listadoTareas.appendChild(contenedorTarea);

            console.log(listadoTareas);
        });
    }

    function limpiarTareasAntiguas() {
        const listadoTareas = document.querySelector('#listado-tareas');

        while (listadoTareas.firstChild) {
            listadoTareas.removeChild(listadoTareas.firstChild);
        }
    }

    function cambiarEstadoTarea(tarea) {
        const nuevoEstado = tarea.estado === "1" ? "0" : "1";
        tarea.estado = nuevoEstado;

        actualizarTarea(tarea);
    }

    async function actualizarTarea(tarea) {
        const {estado, id, nombre} = tarea;

        const datos = new FormData();

        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('url', obtenerProyecto());

        try {
            const url = 'http://localhost:3000/api/tarea/actualizar';

            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();

            if (resultado.respuesta.tipo === 'exito') {
                
                Swal.fire(
                    resultado.respuesta.mensaje,
                    resultado.respuesta.mensaje,
                    'success'
                );

                const modal = document.querySelector('.modal');
                if (modal) {
                    modal.remove();
                }

                tareas = tareas.map(tareaMemoria => {
                    if (tareaMemoria.id === id) {
                        tareaMemoria.estado = estado;
                        tareaMemoria.nombre = nombre;
                    }

                    return tareaMemoria;
                });

                mostrarTareas();
            }
        } catch (error) {
            console.log(error);
        }
    }

    function confirmarEliminarTarea(tarea) {
        Swal.fire({
            title: 'Eliminar Tarea?',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarTarea(tarea);
            }
        })
    }

    async function eliminarTarea(tarea) {

        const {estado, id, nombre} = tarea;

        const datos = new FormData();

        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('url', obtenerProyecto());

        try {
            const url = 'http://localhost:3000/api/tarea/eliminar';

            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();

            if (resultado.resultado) {

                Swal.fire('Eliminado correctamente!', resultado.mensaje, 'success');

                tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== tarea.id);

                mostrarTareas();
            }

        } catch (error) {
            
        }
    }

    // Filtros de busqueda
    const filtros = document.querySelectorAll('#filtros input[type="radio"]');

    filtros.forEach(radio => {
        radio.addEventListener('input', filtrarTareas);
    });


    function filtrarTareas(e) {
        const filtro = e.target.value;

        if (filtro !== '') {
            filtradas = tareas.filter(tarea => tarea.estado === filtro);
        }else{
            filtradas = [];
        }

        mostrarTareas();
    }

    function totalPendientes() {

        // Nos trae cuantas tareas estan pendientes:
        const totalPendientes = tareas.filter(tarea => tarea.estado === '0');

        const pedientesRadios = document.querySelector('#pendientes');

        if (totalPendientes.length === 0) {
            pedientesRadios.disabled = true;
        }else{
            pedientesRadios.disabled = false;
        }
    }

    function totalCompletas() {
        // Nos trae cuantas tareas estan pendientes:
        const totalCompletas = tareas.filter(tarea => tarea.estado === '1');

        const completasRadio = document.querySelector('#completadas');

        if (totalCompletas.length === 0) {
            completasRadio.disabled = true;
        }else{
            completasRadio.disabled = false;
        } 
    }



})();
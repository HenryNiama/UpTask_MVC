!function(){!async function(){try{const t="/api/tareas?id="+n(),a=await fetch(t),r=await a.json();e=r.tareas,console.log(e),o()}catch(e){console.log(e)}}();let e=[];function t(t=!1,c={}){console.log(t);const s=document.createElement("DIV");s.classList.add("modal"),s.innerHTML=`\n            <form class="formulario nueva-tarea">\n                <legend>${t?"Editar Tarea":"Añade una nueva tarea"}</legend>\n                <div class="campo">\n                    <label>Tarea</label>\n                    <input\n                        type="text"\n                        name="tarea"\n                        placeholder="${c.nombre?"Edita la tarea":"Anadir Tarea al proyecto actual"}"\n                        id="tarea"\n                        value="${c.nombre?c.nombre:""}"\n                    />\n                </div>\n                <div class="opciones">\n                    <input \n                        type="submit" \n                        class="submit-nueva-tarea" \n                        value="${c.nombre?"Guardar cambios":"Añadir Tarea"}"/>\n                    <button type="button" class="cerrar-modal">Cancelar</button>\n                </div>\n            </form>\n        `,setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},200),s.addEventListener("click",(function(i){if(i.preventDefault(),i.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{s.remove()},500)}if(i.target.classList.contains("submit-nueva-tarea")){const s=document.querySelector("#tarea").value.trim();if(""===s)return void a("El nombre de la tarea es obligatorio","error",document.querySelector(".formulario legend"));t?(console.log("Editando tarea"),c.nombre=s,r(c)):(console.log("Agregando Nueva Tarea"),async function(t){const r=new FormData;r.append("nombre",t),r.append("url",n());try{const n="http://localhost:3000/api/tarea",c=await fetch(n,{method:"POST",body:r});console.log(c);const s=await c.json();if(console.log(s),a(s.mensaje,s.tipo,document.querySelector(".formulario legend")),"exito"===s.tipo){document.querySelector(".nueva-tarea").reset();const a={id:String(s.id),nombre:t,estado:"0",proyectoId:s.proyectoId};e=[...e,a],o()}}catch(e){console.log(e)}}(s))}})),document.querySelector(".dashboard").appendChild(s)}function a(e,t,a){const n=document.querySelector(".alerta");n&&n.remove();const o=document.createElement("div");o.classList.add("alerta",t),o.textContent=e,a.parentElement.insertBefore(o,a.nextElementSibling),setTimeout(()=>{o.remove()},3e3)}function n(){const e=new URLSearchParams(window.location.search);return Object.fromEntries(e.entries()).id}function o(){if(function(){const e=document.querySelector("#listado-tareas");for(;e.firstChild;)e.removeChild(e.firstChild)}(),0===e.length){const e=document.querySelector("#listado-tareas"),t=document.createElement("li");return t.textContent="No hay tareas",t.classList.add("no-tareas"),void e.appendChild(t)}const a={0:"Pendiente",1:"Completa"};e.forEach(c=>{const s=document.createElement("li");s.dataset.tareaId=c.id,s.classList.add("tarea");const i=document.createElement("P");i.textContent=c.nombre,i.ondblclick=function(){t(!0,{...c})};const d=document.createElement("div");d.classList.add("opciones");const l=document.createElement("button");l.classList.add("estado-tarea"),l.classList.add(""+a[c.estado].toLowerCase()),l.textContent=a[c.estado],l.dataset.estadoTarea=c.estado,l.ondblclick=function(){!function(e){const t="1"===e.estado?"0":"1";e.estado=t,r(e)}({...c})};const u=document.createElement("BUTTON");u.classList.add("eliminar-tarea"),u.dataset.idTarea=c.id,u.textContent="Eliminar",u.ondblclick=function(){!function(t){Swal.fire({title:"Eliminar Tarea?",showCancelButton:!0,confirmButtonText:"Si",cancelButtonText:"No"}).then(a=>{a.isConfirmed&&async function(t){const{estado:a,id:r,nombre:c}=t,s=new FormData;s.append("id",r),s.append("nombre",c),s.append("estado",a),s.append("url",n());try{const a="http://localhost:3000/api/tarea/eliminar",n=await fetch(a,{method:"POST",body:s}),r=await n.json();r.resultado&&(Swal.fire("Eliminado correctamente!",r.mensaje,"success"),e=e.filter(e=>e.id!==t.id),o())}catch(e){}}(t)})}({...c})},d.appendChild(l),d.appendChild(u),s.appendChild(i),s.appendChild(d);const m=document.querySelector("#listado-tareas");m.appendChild(s),console.log(m)})}async function r(t){const{estado:a,id:r,nombre:c}=t,s=new FormData;s.append("id",r),s.append("nombre",c),s.append("estado",a),s.append("url",n());try{const t="http://localhost:3000/api/tarea/actualizar",n=await fetch(t,{method:"POST",body:s}),i=await n.json();if("exito"===i.respuesta.tipo){Swal.fire(i.respuesta.mensaje,i.respuesta.mensaje,"success");const t=document.querySelector(".modal");t&&t.remove(),e=e.map(e=>(e.id===r&&(e.estado=a,e.nombre=c),e)),o()}}catch(e){console.log(e)}}document.querySelector("#agregar-tarea").addEventListener("click",(function(){t()}))}();
const form = document.getElementById("form");
const cerrar = document.getElementById("cerrar");
const titulo = document.getElementById("tituloform");
const formulario = document.getElementById("formulario");

function abrirform(tipo, nitEditar = null){

    form.style.display = "flex";

    if(tipo === "agregar"){
        titulo.innerText = "Agregar Cliente";
        formulario.innerHTML = `
            <input id="nit" placeholder="Nit">
            <input id="first_name" placeholder="First Name">
            <input id="last_name" placeholder="Last Name">
            <input id="email" placeholder="Email">
            <input id="celular" placeholder="Celular">
            <button type="button" onclick="guardarCliente()">Guardar</button>
        `;
    }

    if(tipo === "editar"){
        titulo.innerText = "Editar Cliente";
        formulario.innerHTML = `
            <input id="nit" placeholder="Nit" readonly>
            <input id="first_name" placeholder="First Name">
            <input id="last_name" placeholder="Last Name">
            <input id="email" placeholder="Email">
            <input id="celular" placeholder="Celular">
            <button type="button" onclick="actualizarCliente()">Actualizar</button>
        `;

        document.getElementById("nit").value = nitEditar;
    }

    if(tipo === "buscar"){
        titulo.innerText = "Buscar Cliente";
        formulario.innerHTML = `
            <input id="nitBuscar" placeholder="Ingrese NIT">
            <button type="button" onclick="buscarCliente()">Buscar</button>
        `;
    }
}

/* 
   FUNCIONES AJAX
 */

function guardarCliente(){

    let datos = new URLSearchParams();
    datos.append("accion","agregar");
    datos.append("nit",document.getElementById("nit").value);
    datos.append("first_name",document.getElementById("first_name").value);
    datos.append("last_name",document.getElementById("last_name").value);
    datos.append("email",document.getElementById("email").value);
    datos.append("celular",document.getElementById("celular").value);

    fetch("api/clientes.php",{
        method:"POST",
        body:datos
    })
    .then(res=>res.json())
    .then(data=>{
        alert("Cliente agregado correctamente");
        location.reload();
    });
}

function actualizarCliente(){

    let datos = new URLSearchParams();
    datos.append("accion","editar");
    datos.append("nit",document.getElementById("nit").value);
    datos.append("first_name",document.getElementById("first_name").value);
    datos.append("last_name",document.getElementById("last_name").value);
    datos.append("email",document.getElementById("email").value);
    datos.append("celular",document.getElementById("celular").value);

    fetch("api/clientes.php",{
        method:"POST",
        body:datos
    })
    .then(res=>res.json())
    .then(data=>{
        alert("Cliente actualizado correctamente");
        location.reload();
    });
}

function eliminarCliente(nit){

    if(!confirm("¿Eliminar cliente?")) return;

    let datos = new URLSearchParams();
    datos.append("accion","eliminar");
    datos.append("nit",nit);

    fetch("api/clientes.php",{
        method:"POST",
        body:datos
    })
    .then(res=>res.json())
    .then(data=>{
        location.reload();
    });
}

function buscarCliente(){

    let datos = new URLSearchParams();
    datos.append("accion","buscar");
    datos.append("nit",document.getElementById("nitBuscar").value);

    fetch("api/clientes.php",{
        method:"POST",
        body:datos
    })
    .then(res=>res.json())
    .then(data=>{
        if(data){
            alert("Cliente encontrado:\n\n" +
                data.first_name + " " + data.last_name +
                "\nEmail: " + data.email +
                "\nCelular: " + data.celular
            );
        }else{
            alert("Cliente no encontrado");
        }
    });
}

function visualizarCliente(nit){

    let datos = new URLSearchParams();
    datos.append("accion","buscar");
    datos.append("nit",nit);

    fetch("api/clientes.php",{
        method:"POST",
        body:datos
    })
    .then(res=>res.json())
    .then(data=>{

        form.style.display = "flex";
        titulo.innerText = "Visualizar Cliente";

        formulario.innerHTML = `
            <input value="${data.nit}" readonly>
            <input value="${data.first_name}" readonly>
            <input value="${data.last_name}" readonly>
            <input value="${data.email}" readonly>
            <input value="${data.celular}" readonly>
            <button type="button" onclick="form.style.display='none'">
                Cerrar
            </button>
        `;
    });
}

/* EVENTOS BOTONES */

document.getElementById("agregar").onclick = () => abrirform("agregar");
document.getElementById("buscar").onclick = () => abrirform("buscar");

document.querySelectorAll(".btn-editar").forEach(btn=>{
    btn.onclick = function(){
        let fila = this.closest("tr");
        let nit = fila.children[0].innerText;
        abrirform("editar", nit);
    }
});

document.querySelectorAll(".btn-eliminar").forEach(btn=>{
    btn.onclick = function(){
        let fila = this.closest("tr");
        let nit = fila.children[0].innerText;
        eliminarCliente(nit);
    }
});

document.querySelectorAll(".btn-ver").forEach(btn=>{
    btn.onclick = function(){
        let fila = this.closest("tr");
        let nit = fila.children[0].innerText;
        visualizarCliente(nit);
    }
});

cerrar.onclick = () => form.style.display = "none";

window.onclick = function(e){
    if(e.target === form){
        form.style.display = "none";
    }
};

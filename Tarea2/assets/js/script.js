const getModal = () => document.getElementById("form");
const getTitulo = () => document.getElementById("tituloform");
const getContenedor = () => document.getElementById("formulario");

// Leer clientes desde PHP
function obtenerClientesJS() {
    const data = document.getElementById("datos-clientes-json");
    return data ? JSON.parse(data.textContent) : [];
}

function abrirform(tipo, valor = null) {

    const modal = getModal();
    const titulo = getTitulo();
    const contenedor = getContenedor();

    modal.style.display = "flex";
    contenedor.innerHTML = "";

    if (tipo === "agregar") {

        titulo.innerText = "Agregar Cliente";

        contenedor.innerHTML = `
            <input id="nit" placeholder="Nit">
            <input id="first_name" placeholder="Nombre">
            <input id="last_name" placeholder="Apellido">
            <input id="email" placeholder="Email">
            <input id="celular" placeholder="Celular">

            <button class="btn-confirmar-modal" onclick="guardarCliente()">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Cliente
            </button>
        `;
    }

    else if (tipo === "editar") {

        titulo.innerText = "Editar Cliente";

        contenedor.innerHTML = `
            <input id="nit" value="${valor}" readonly class="input-readonly">
            <input id="first_name" placeholder="Nombre">
            <input id="last_name" placeholder="Apellido">
            <input id="email" placeholder="Email">
            <input id="celular" placeholder="Celular">

            <button class="btn-actualizar-modal" onclick="actualizarCliente()">
                <i class="fa-solid fa-rotate"></i> Actualizar Datos
            </button>
        `;
    }

    else if (tipo === "agregarPedido") {

        titulo.innerText = "Nuevo Pedido";

        const clientes = obtenerClientesJS();

        const opciones = clientes.map(c =>
            `<option value="${c.nit}">${c.nit} - ${c.first_name} ${c.last_name}</option>`
        ).join("");

        contenedor.innerHTML = `
            <div class="bloque-buscador">
                <label class="label-buscador">BUSCAR CLIENTE (NIT O NOMBRE)</label>

                <input
                    type="text"
                    id="buscadorCliente"
                    placeholder="Escribe para filtrar..."
                    onkeyup="filtrarClientes()"
                >
            </div>

            <label class="label-select">Seleccionar Resultado</label>

            <select id="cliente_nit" size="3" class="select-clientes">
                ${opciones}
            </select>

            <input id="total" type="number" placeholder="Total $">

            <select id="estado">
                <option value="Pendiente">Pendiente</option>
                <option value="En proceso">En proceso</option>
                <option value="Entregado">Entregado</option>
            </select>

            <button class="btn-confirmar-modal" onclick="guardarPedido()">
                <i class="fa-solid fa-cart-plus"></i> Crear Pedido
            </button>
        `;
    }

    else if (tipo === "editarPedido") {

        titulo.innerText = "Editar Pedido #" + valor;

        contenedor.innerHTML = `
            <input id="id_pedido" value="${valor}" readonly class="input-readonly">

            <input id="total" type="number" placeholder="Total $">

            <select id="estado">
                <option value="Pendiente">Pendiente</option>
                <option value="En proceso">En proceso</option>
                <option value="Entregado">Entregado</option>
            </select>

            <button class="btn-confirmar-modal" onclick="actualizarPedido()">
                <i class="fa-solid fa-rotate"></i> Actualizar Pedido
            </button>
        `;
    }

    else if (tipo === "buscar") {

        titulo.innerText = "Buscar Cliente";

        contenedor.innerHTML = `
            <input id="nitBuscar" placeholder="Ingrese NIT del cliente">

            <button class="btn-confirmar-modal" onclick="buscarCliente()">
                <i class="fa-solid fa-magnifying-glass"></i> Buscar
            </button>

            <div id="resultadoBusqueda"></div>
        `;
}
}


// Cerrar modal
document.addEventListener("DOMContentLoaded", () => {

    const modal = getModal();
    const cerrar = document.getElementById("cerrar");

    if (cerrar) {
        cerrar.onclick = () => modal.style.display = "none";
    }

    window.onclick = (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    };

});


// ================== PEDIDOS ==================

// ================== CLIENTES ==================

function guardarCliente() {

    let datos = new URLSearchParams();

    datos.append("accion", "agregar");
    datos.append("nit", document.getElementById("nit").value);
    datos.append("first_name", document.getElementById("first_name").value);
    datos.append("last_name", document.getElementById("last_name").value);
    datos.append("email", document.getElementById("email").value);
    datos.append("celular", document.getElementById("celular").value);

    fetch("api/clientes.php", {
        method: "POST",
        body: datos
    }).then(() => location.reload());
}


function actualizarCliente() {

    let datos = new URLSearchParams();

    datos.append("accion", "editar");
    datos.append("nit", document.getElementById("nit").value);
    datos.append("first_name", document.getElementById("first_name").value);
    datos.append("last_name", document.getElementById("last_name").value);
    datos.append("email", document.getElementById("email").value);
    datos.append("celular", document.getElementById("celular").value);

    fetch("api/clientes.php", {
        method: "POST",
        body: datos
    }).then(() => location.reload());
}


function eliminarCliente(nit) {

    if (!confirm("¿Eliminar cliente " + nit + "?")) return;

    let datos = new URLSearchParams();

    datos.append("accion", "eliminar");
    datos.append("nit", nit);

    fetch("api/clientes.php", {
        method: "POST",
        body: datos
    }).then(() => location.reload());
}
function buscarCliente(){

    let nit = document.getElementById("nitBuscar").value;

    let datos = new URLSearchParams();
    datos.append("accion","buscar");
    datos.append("nit", nit);

    fetch("api/clientes.php",{
        method:"POST",
        body:datos
    })
    .then(res => res.json())
    .then(cliente => {

        let resultado = document.getElementById("resultadoBusqueda");

        if(cliente){
            resultado.innerHTML = `
                <p><strong>NIT:</strong> ${cliente.nit}</p>
                <p><strong>Nombre:</strong> ${cliente.first_name}</p>
                <p><strong>Apellido:</strong> ${cliente.last_name}</p>
                <p><strong>Email:</strong> ${cliente.email}</p>
                <p><strong>Celular:</strong> ${cliente.celular}</p>
            `;
        }else{
            resultado.innerHTML = "Cliente no encontrado";
        }

    });

}

function visualizarCliente(nit){

    let datos = new URLSearchParams();

    datos.append("accion", "buscar");
    datos.append("nit", nit);

    fetch("api/clientes.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(cliente => {

        abrirform("editar", nit);

        document.getElementById("first_name").value = cliente.first_name;
        document.getElementById("last_name").value = cliente.last_name;
        document.getElementById("email").value = cliente.email;
        document.getElementById("celular").value = cliente.celular;

    });
    

}
function guardarPedido() {

    let datos = new URLSearchParams();

    datos.append("accion", "agregar");
    datos.append("cliente_nit", document.getElementById("cliente_nit").value);
    datos.append("total", document.getElementById("total").value);
    datos.append("estado", document.getElementById("estado").value);

    fetch("api/pedidos.php", {
        method: "POST",
        body: datos
    }).then(() => location.reload());

}


function actualizarPedido() {

    let datos = new URLSearchParams();

    datos.append("accion", "editar");
    datos.append("id", document.getElementById("id_pedido").value);
    datos.append("total", document.getElementById("total").value);
    datos.append("estado", document.getElementById("estado").value);

    fetch("api/pedidos.php", {
        method: "POST",
        body: datos
    }).then(() => location.reload());

}


function eliminarPedido(id) {

    if (!confirm("¿Eliminar pedido #" + id + "?")) return;

    let datos = new URLSearchParams();

    datos.append("accion", "eliminar");
    datos.append("id", id);

    fetch("api/pedidos.php", {
        method: "POST",
        body: datos
    }).then(() => location.reload());

}


function filtrarClientes() {

    const filtro = document
        .getElementById("buscadorCliente")
        .value
        .toLowerCase();

    const opciones = document
        .getElementById("cliente_nit")
        .getElementsByTagName("option");

    for (let i = 0; i < opciones.length; i++) {

        const texto = opciones[i].text.toLowerCase();

        opciones[i].style.display = texto.includes(filtro)
            ? ""
            : "none";
    }
}
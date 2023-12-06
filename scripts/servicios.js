const contenido__contactos = document.querySelector("#contenido__contactosemergencia");
const contenido__examenes = document.querySelector("#contenido__examenes");

const form__modificar__contacto = document.querySelector("#form__modificarcontacto");
const form__eliminar__contacto = document.querySelector("#form__eliminarcontacto");
const form__modificar__examen = document.querySelector("#form__modificarexamen");
const form__eliminar__examen = document.querySelector("#form__eliminarexamen");
const btn__llamar = document.querySelector("#llamar");

let datos_modificar_contacto = JSON.parse(localStorage.getItem("datos_modificar_contacto"))  || {};
let cod_eliminar_contacto = localStorage.getItem("cod_eliminar_contacto") || '';
let datos_modificar_examen = JSON.parse(localStorage.getItem("datos_modificar_examen"))  || {};
let cod_eliminar_examen = localStorage.getItem("cod_eliminar_examen") || '';

let imagenes = [
    {
        "url": "img/911.webp",
        "nombre": "Servicios de emergencia 911",
        "descripcion": "Servicio de emergencias público, en casos de emergencia no dude en marcar.",
        "telefono": "911",
    },
    {
        "url": "img/ambulancia.jpg",
        "nombre": "Servicio de ambulancia",
        "descripcion": "Servicio de ambulancia privada para clientes de la clínica, por favor en casos de emergencia solicitarlo.",
        "telefono":"00000000",
    },
]


let atras = document.getElementById('atras');
let adelante = document.getElementById('adelante');
let imagen = document.getElementById('img');
let puntos = document.getElementById('puntos');
let texto = document.getElementById('texto')
let actual = 0
posicionCarrusel()

setModificarExamen(datos_modificar_examen);
setDeleteExamen(cod_eliminar_examen);
setModificarContacto(datos_modificar_contacto);
setDeleteContacto(cod_eliminar_contacto);

contenido__contactos.addEventListener('click', e => {
    if(e.target.id == 'btn__modificar'){
        //Obtengo el row donde seleccione la cita
        let contacto = e.target.parentElement.parentElement;

        let datos_modificar_contacto = {
            CodContacto : contacto.querySelector("#codigo").textContent,
            Nombre : contacto.querySelector("#nombre").textContent,
            Ubicacion : contacto.querySelector("#ubicacion").textContent,
            Telefono : contacto.querySelector("#telefono").textContent
        }

        localStorage.setItem("datos_modificar_contacto", JSON.stringify(datos_modificar_contacto));
        setModificarContacto(datos_modificar_contacto);
        //console.log(datos_modificar);

    }
    if(e.target.id == 'btn__borrar'){
        let cod_eliminar_contacto =  e.target.parentElement.parentElement.querySelector("#codigo").textContent;
        localStorage.setItem("cod_eliminar_contacto", cod_eliminar_contacto);
        setDeleteContacto(cod_eliminar_contacto);
        //console.log(cod_eliminar_contacto);
    }
})
contenido__examenes.addEventListener('click', e => {
    if(e.target.id == 'btn__modificar'){
        //Obtengo el row donde seleccione la cita
        let examen = e.target.parentElement.parentElement;

        let datos_modificar_examen = {
            CodExamen : examen.querySelector("#codigo").textContent,
            Tipo : examen.querySelector("#tipo").textContent,
            Fecha : examen.querySelector("#fecha").textContent,
            Estado : examen.querySelector("#estado").textContent,
            Resultado : examen.querySelector("#resultado").textContent,
            Descripcion : examen.querySelector("#descripcion").textContent
        }

        localStorage.setItem("datos_modificar_examen", JSON.stringify(datos_modificar_examen));
        setModificarExamen(datos_modificar_examen);
        //console.log(datos_modificar);

    }
    if(e.target.id == 'btn__borrar'){
        let cod_eliminar_examen =  e.target.parentElement.parentElement.querySelector("#codigo").textContent;
        localStorage.setItem("cod_eliminar_examen", cod_eliminar_examen);
        setDeleteExamen(cod_eliminar_examen);
        //console.log(cod_eliminar_contacto);
    }
})

function setModificarContacto (data) {
    if(data != {}){
        form__modificar__contacto.querySelector("#codigo").value = data.CodContacto;
        form__modificar__contacto.querySelector("#nombre").value = data.Nombre;
        form__modificar__contacto.querySelector("#ubicacion").value = data.Ubicacion;
        form__modificar__contacto.querySelector("#telefono").value = data.Telefono;
    }
}

function setDeleteContacto (id) {
    if(id!='') {
        form__eliminar__contacto.querySelector("#codigo").value = id;
    }
}

function setModificarExamen (data) {
    if(data != {}){
        form__modificar__examen.querySelector("#codigo").value = data.CodExamen;
        form__modificar__examen.querySelector("#fecha").value = data.Fecha;
        form__modificar__examen.querySelector("#tipo").value = data.Tipo;
        form__modificar__examen.querySelector("#resultado").value = data.Resultado;
        form__modificar__examen.querySelector("#descripcion").value = data.Descripcion;
        form__modificar__examen.querySelector("#estado").value = data.Estado;
    }
}

function setDeleteExamen (id) {
    if(id!='') {
        form__eliminar__examen.querySelector("#codigo").value = id;
    }
}

atras.addEventListener('click', function(){
    actual -=1

    if (actual == -1){
        actual = imagenes.length - 1
    }

    imagen.innerHTML = ` <img class="img" src="${imagenes[actual].url}" alt="logo pagina" loading="lazy"></img>`
    texto.innerHTML = `
    <h3>${imagenes[actual].nombre}</h3>
    <p>${imagenes[actual].descripcion}</p>
    <a onclick="window.open('tel:${imagenes[actual].telefono}');">Llamar <b id="llamar">${imagenes[actual].telefono}</b></a>
    `
    posicionCarrusel()
})  
adelante.addEventListener('click', function(){
    actual +=1

    if (actual == imagenes.length){
        actual = 0
    }

    imagen.innerHTML = ` <img class="img" src="${imagenes[actual].url}" alt="logo pagina" loading="lazy"></img>`
    texto.innerHTML = `
    <h3>${imagenes[actual].nombre}</h3>
    <p>${imagenes[actual].descripcion}</p>
    <a onclick="window.open('tel:${imagenes[actual].telefono}');">Llamar <b id="llamar">${imagenes[actual].telefono}</b></a>
    `
    posicionCarrusel()
})  

function posicionCarrusel() {
    puntos.innerHTML = ""
    for (var i = 0; i <imagenes.length; i++){
        if(i == actual){
            puntos.innerHTML += '<p class="bold">.<p>'
        }
        else{
            puntos.innerHTML += '<p>.<p>'
        }
    } 
}
const tabla__datos = document.querySelector("#tabla__datos");
const form__modificar = document.querySelector("#form__modificar");
const form__eliminar = document.querySelector("#form__eliminar");

let datos_modificar = JSON.parse(localStorage.getItem("datos_modificar"))  || {};
let cod_eliminar = localStorage.getItem("cod_eliminar") || '';
setDelete(cod_eliminar);
setModificar(datos_modificar);

tabla__datos.addEventListener('click', e => {
    if(e.target.id == 'btn__modificar'){
        //Obtengo el row donde seleccione la cita
        let cita = e.target.parentElement.parentElement;

        let datos_modificar = {
            CodCita : cita.querySelector("#codigo").textContent,
            Fecha : cita.querySelector("#fecha").textContent,
            Especialidad : cita.querySelector("#especialidad").textContent,
            MetodoReserva : cita.querySelector("#reserva").textContent,
            Descripcion : cita.querySelector("#descripcion").textContent,
            Estado : cita.querySelector("#estado").textContent
        }

        localStorage.setItem("datos_modificar", JSON.stringify(datos_modificar));
        setModificar(datos_modificar);
        //console.log(datos_modificar);

    }
    if(e.target.id == 'btn__borrar'){
        let cod_eliminar =  e.target.parentElement.parentElement.querySelector("#codigo").textContent;
        localStorage.setItem("cod_eliminar", cod_eliminar);
        setDelete(cod_eliminar);
        //console.log(cod_eliminar);
    }
})

function setModificar (data) {
    if(data != {}){
        form__modificar.querySelector("#codigo").value = data.CodCita;
        form__modificar.querySelector("#fecha").value = data.Fecha;
        form__modificar.querySelector("#especialidad").value = data.Especialidad;
        form__modificar.querySelector("#reserva").value = data.MetodoReserva;
        form__modificar.querySelector("#descripcion").value = data.Descripcion;
        form__modificar.querySelector("#estado").value = data.Estado;
    }
}

function setDelete (id) {
    if(id!='') {
        form__eliminar.querySelector("#codigo").value = id;
    }
}
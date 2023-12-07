const contenido__usuario = document.querySelector("#contenido__usuarios");

const form__eliminar__usuario = document.querySelector("#form__eliminarusuario");

contenido__usuario.addEventListener('click', e => {
    if(e.target.id == 'btn__borrar'){
        //console.log(e.target.parentElement.parentElement.querySelector("#codigo").textContent)
        let cod_eliminar_usuario =  e.target.parentElement.parentElement.querySelector("#codigo").textContent;
        localStorage.setItem("cod_eliminar_usuario", cod_eliminar_usuario);
        setDeleteUsuario(cod_eliminar_usuario);
    }
})

function setDeleteUsuario (id) {
    if(id!='') {
        form__eliminar__usuario.querySelector("#codigo").value = id;
    }
}
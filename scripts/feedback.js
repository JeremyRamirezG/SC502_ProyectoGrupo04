const contenido__feedback = document.querySelector("#contenido__feedback");

const form__eliminar__feedback = document.querySelector("#form__eliminarfeedback");

contenido__feedback.addEventListener('click', e => {
    if(e.target.id == 'btn__borrar'){
        //console.log(e.target.parentElement.parentElement.querySelector("#codigo").textContent)
        let cod_eliminar_feedback =  e.target.parentElement.parentElement.querySelector("#codigo").textContent;
        localStorage.setItem("cod_eliminar_feedback", cod_eliminar_feedback);
        setDeleteFeedback(cod_eliminar_feedback);
    }
})

function setDeleteFeedback (id) {
    if(id!='') {
        form__eliminar__feedback.querySelector("#codigo").value = id;
    }
}
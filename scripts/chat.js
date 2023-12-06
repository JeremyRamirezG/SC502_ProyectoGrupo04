function auto_load(){
    console.log("Carga");
    $.ajax({
      url: "chatEnLinea.php",
      cache: false,
      success: function(data){
         $("#contenido__chat").html(data);
      } 
    });
  }     
  $(document).ready(function(){     
    auto_load(); //Call auto_load() function when DOM is Ready     
  });     
  //Refresh auto_load() function after 10000 milliseconds
  setInterval(auto_load,1000);

$("#env__msj").click(function(){	
    var msj__usr = document.querySelector('#msj__usr').value;
    $.post("chatCRUD/enviar.php", {text: msj__usr});				
    ("#msj__usr").attr("value", "");
    loadChat();
    return false;
});

function loadChat(){
    var oldscrollHeight = $("#contenido__chat").attr("scrollHeight") - 20;

    $.ajax({
        url: "chatCRUD/chat.html",
        cache: false,
        success: function(html){		
            $("#contenido__chat").html(html);
            //Auto-scroll			
            var newscrollHeight = $("#contenido__chat").attr("scrollHeight") - 20;
            if(newscrollHeight > oldscrollHeight){
                $("#contenido__chat").animate({ scrollTop: newscrollHeight }, 'normal');
            }
          },
    });
}
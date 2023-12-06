<?php
session_start();
if(isset($_SESSION['id'])){   
	$text = $_POST['text'];
	
	$fp = fopen("chat.html", 'a');
	fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['nombreCompleto'].", ".$_SESSION['rol']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
	fclose($fp);
}
?>
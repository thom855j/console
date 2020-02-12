<?php

if(!empty($_POST)) {
    require '../app/server.php';
}
?>

<link rel="stylesheet" href="css/termynal.css">
<link rel="stylesheet" href="css/style.css">
<div id="termynal" data-termynal data-ty-typeDelay="25" data-ty-lineDelay="25">
    <?php 
    if(!empty($_SESSION)) {
        echo $_SESSION['input']; 
    }
    ?>
</div>
<form action="" name="message" method="POST" class="container">
        <b>$</b> <input name="input" type="text" id="input" size="1024" />
</form>

<script src="js/termynal.min.js" data-termynal-container="#termynal"></script>

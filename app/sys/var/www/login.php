<?php if(!session()['auth']): ?>

<div id="wrapper">
    
    <?php include 'templates/nav.php' ?>
    <div id="terminal" data-termynal data-ty-typeDelay="20" data-ty-lineDelay="250">  
        <p data-ty="input">Trying...</p>
        <p data-ty="input"><?php echo "Connected to terminal", " port ", $_SERVER['SERVER_PORT']; ?></p>

        <br data-ty>

        <?php if(isset($_COOKIE['session_visit'])): ?>
        <p data-ty="input">Last login: <?php echo $_COOKIE['session_visit']; ?></p>
        <?php endif; ?>
        <p data-ty="input">Copyright (c) 1984-1989 Datalære.</p>

        <br data-ty>

        <p data-ty="input">RC759 CP/M 86 - UNIX Inspired System.</p>

        <br data-ty>

        <p data-ty="input">Welcome!</p>
        <p data-ty="input">It is <?php echo date('H:i', time()), " on ", date('l, F d, Y'); ?> in Denmark.</p>

        <br data-ty>

        <p data-ty="input">Type HELP for detailed command list.</p>
        <p data-ty="input">Type NEWUSER to create an account.</p>
        
        <br data-ty>

    </div>
        <form name="message">
            <span data-ty="input" ><b>. </b> <input name="input" type="text" id="input" size="1024" /></span>
        </form>
</div>

<script type="text/javascript">
$(document).ready(function(){


    $("#input").focus();

    $("#input").inputhistory();

  
    //If user submits the form
    $("form").submit(function(e){

        e.preventDefault();

        var client = $("#input").val();
        var oldscrollHeight = $("#terminal").prop("scrollHeight") - 20; //Scroll height before the 

        $.ajax({
            type: "POST",
            url: "server.php?action=login",
            cache: false,
            data: {input: client},
            success: function(data){      

                if(data == 'ok') {

                    window.location = 'index.php?id=terminal';

                } else if (data == 'error') {

                    window.location = 'index.php?id=login';

                } else {

                    $("#terminal").append(data); //Insert chat log into the #terminal div  

                        //Auto-scroll           
                    var newscrollHeight = $("#terminal").prop("scrollHeight") - 20; //Scroll height after the request
                    if(newscrollHeight > oldscrollHeight){
                        $("#terminal").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                    } 
                }   
                              
            },
        });

         $("#input").prop("value", "");

        return false;

    });


}); 
</script>

<?php else:  header("Location: index.php?id=terminal"); ?>

<?php endif; ?>

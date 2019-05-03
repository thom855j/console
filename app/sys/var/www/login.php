<?php if(!session()['auth']): ?>

<div id="wrapper">
    
    <?php include 'templates/nav.php' ?>
    <div id="terminal" data-termynal data-ty-typeDelay="40" data-ty-lineDelay="250">  
        <p data-ty="input"><?php echo getVisitorIP(), " CONNECTED TO TERMINAL ", $_SERVER['SERVER_ADDR'], " ON PORT ", $_SERVER['SERVER_PORT']; ?></p>
        <br data-ty>
        <p data-ty="input"> WELCOME TO <?php echo $_SERVER['SERVER_NAME']; ?>.</p>
        <p data-ty="input">TERMINAL STATUS: ACTIVE</p>
    
        <br data-ty>

        <p data-ty="input">IT IS <?php echo date('H:i', time()), " on ", date('l, F d, Y'); ?>.</p>
        <?php if(isset($_COOKIE['session_visit'])): ?>
        <p data-ty="input">LAST VISIT <?php echo $_COOKIE['session_visit']; ?></p>
        <?php endif; ?>

        <br data-ty>

        <p data-ty="input">ALL CONNECTIONS ARE MONITORED AND RECORDED.</p>
        <p data-ty="input">ANY MALICIOUS AND/OR UNAUTHORIZED ACTIVITY IS STRICTLY FORBIDDEN.</p>
        <p data-ty="input">DISCONNECT IMMEDIATELY IF YOU ARE NOT AN AUTHORIZED USER!</p>

        <br data-ty>

        <p data-ty="input">LOGON:</p>
        
        <br data-ty>
    </div>
        <form name="message">
            <span data-ty="input"><b>> </b> <input name="input" type="text" id="input" size="1024" /></span>
        </form>
        <br>
    <table data-ty="input">
          <tr>
            <th>[ACTIVE TERMINALS]</th>
          </tr>
          <tr>
            <?php listHosts(APP . '/sys/dev/'); ?>
          </tr>
    </table>
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

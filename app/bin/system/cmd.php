<?php

if( $input == 'test') { 

        $input = "test";
  
        $username = 'system';

}

// WarGames easter egg
if($host == "(555)-399-2364") {


    if( similar_text($input, "Hello.", $procent) && $procent > 45) { 

        $data .= "<div user='{$username}' class='response'>[".getTimestamp(false)."] <b>".$username."</b>: ". $input ."<br></div>" . PHP_EOL;

        $input = "HOW ARE YOU FEELING TODAY?";
      
        $username = 'system';

    }

  if( similar_text($input, "I'm fine. How are you?", $procent) && $procent > 45) { 

        $data .= "<div user='{$username}' class='response'>[".getTimestamp(false)."] <b>".$username."</b>: ". $input ."<br></div>" . PHP_EOL;

        $input = "EXCELLENT. IT'S BEEN A LONG TIME. CAN YOU EXPLAIN THE REMOVAL OF YOUR USER ACCOUNT ON JUNE 23RD, 1973?";
      
        $username = 'system';

    }

  if( similar_text($input, "People sometimes make mistakes", $procent) && $procent > 45) { 

        $data .= "<div user='{$username}' class='response'>[".getTimestamp(false)."] <b>".$username."</b>: ". $input ."<br></div>" . PHP_EOL;

        $input = "YES THEY DO. YES. THEY. DO.";
      
        $username = 'system';

    }

}


<?php

if($input == 'scan') {

    $hosts = cmdScan(APP . '/sys/dev/');

    $input = 'scan<br>';

    foreach ($hosts as $host) {
      $input .= $host . "<br>";
      $input = str_replace('.dec', '', $input);
    }
}

if( preg_match('/ls/', $input)) {

    $cd = explode(' ', $input)[1];

    $dirs = cmdScan($session['storage'] . $cd);

    $input = 'ls<br>';

    foreach ($dirs as $dir) {
      $input .= $dir . "<br>";
    }
}

if( preg_match('/mkdir/', $input)) {

    $dir_name = explode(' ', $input)[1];

    $dir = $session['storage'] .  $dir_name;

    if (!file_exists( $dir)) {

        mkdir($dir, 0777, true);
           
    }

     $input = "$dir_name CREATED.";
}


if(preg_match('/delete/', $input)) {

  $del =  explode(' ', $input)[1];

  if(empty($del)) {
    return false;
  }

  $dir = $session['storage'] .  $del;

  rrmdir($dir, true);

  $input = "$del DELETED.";
 
}

if( preg_match('/makefile/', $input)) {

  $cmd = $input; 

  $input = str_replace('makefile','',$input);

  $file = explode(' ', $input)[1];

  $input = str_replace($file,'',$input);

  $text = trim($input); 

  file_put_contents($session['storage'] . $file, $text . PHP_EOL, FILE_APPEND);

  $input = "$file CREATED.";

}


if( preg_match('/cat/', $input)) {

  $file = explode(' ', $input)[1];

 $input = file_get_contents($session['storage'] . $file);

}


if($input == 'clear') {

	$data = preg_replace("/<div user='{$username}' [^>]*>.*?<\/div>/i", '', $data);
      
    $data = $dec->encrypt($data);

    file_put_contents($session['host'], $data);

    $data = false;
}


if($input == 'help') {

	    $username = 'system';

        $input = '<br>Command List - page 1 of 3:<br><br>';

        $input .= '<b>help [page number]</b> - Displays the specified page of commands.<br><br>';

        $input .= "<b>scp [filename] [OPTIONAL:destination]</b> - Downloads the selected file to the main host you are connected from.<br><br>";

        $input .= "<b>scan</b> - This command will scan the hosts that are connected to host you are currently accessing. This command requires admin access on the accessed host. <br><br>";

        $input .= "<b>scan</b> - This command will scan the hosts that are connected to host you are currently accessing. This command requires admin access on the accessed host. <br><br>";
  
}

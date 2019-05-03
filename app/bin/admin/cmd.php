<?php

if($input == 'clear session') {

        $data = '';

        $input = "SESSION CLEARED BY {$username}.";
  
        $username = 'system';
}

if($input == 'clear system') {

  $data = preg_replace("/<div user='system' [^>]*>.*?<\/div>/i", '', $data);
      
  $data = $dec->encrypt($data);

  file_put_contents($session['host'], $data);

  $data = false;
}


if(preg_match('/delete user/', $input)) {

  $del_user =  explode(' ', $input)[2];

  $user_path[] = APP . "etc/passwd/{$host}/{$del_user}.dec";

  array_push($user_path, APP . "../home/{$host}/{$username}");

  foreach ($user_path as $path) {
     rrmdir($path);
  }

  unset($user_path);


  $input = "$user USER ACCOUNT DELETED.";
 

}

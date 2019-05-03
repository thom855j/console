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

  if(empty($del_user)) {
    return false;
  }

  $user_path[] = APP . "sys/etc/passwd/{$host}/{$del_user}.dec";

  array_push($user_path, APP . "home/{$host}/{$del_user}");

  foreach ($user_path as $path) {
     rrmdir($path, true);
  }

  unset($user_path);

  $username = "system";

  logger("USER DELETED: {$del_user}", $session['log']);

  $input = "'$del_user' USER ACCOUNT DELETED.";
 

}

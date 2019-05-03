<?php


   $input = filterInput($_POST['input'], true);

   if( checkBlacklist(getVisitorIP(), APP . 'sys/etc/blacklist') ) {
        echo '<br>IP BLACKLISTED.<br>--CONNECTION TERMINATED--<br>';
        return false;
   }


    if($input == 'help') {

        echo "<br>LOGON HELP:<br><br>A VALID USER<br> A VALID TERMINAL<br> A VALID PASSWORD<br> OPTIONAL SECRET KEY.<br><br>IF YOU DON'T HAVE THESE CREDENTIALS, YOU CAN SETUP A NEW ACCOUNT.<br>TYPE 'USER@TERMINAL (KEY)' AND THEN USER PASSWORD.<br>";

        return false;
    }

    if($input == 'exit' || $input == 'logout') {

       session_clear();

       echo 'error';

       return false;
    }

    if( !session()['auth'] && !session()['password'] ){

        $connection = cmdConnect($input, APP . 'sys/etc/passwd/');


        if(!$connection) {

            echo '<br>IDENTIFICATION NOT RECOGNIZED BY SYSTEM.<br>';

            return false;

        } else {

            $username = session()['username'];

            $host = session()['host'];

            echo "PLEASE LOGON WITH USER PASSWORD:<br>";

            session(['password', true], true);

            return false;

        }

    } 


    if(session()['password']) {

        $password = $input;
    }


    if(session()['key'])  {

        $dec = new Encryptor(session()['key']);  

    } else {

        $dec = new Encryptor(false);

    }


    if(!session()['auth']) {

        $username = session()['username'];

        $host = session()['host'];

        $session['host'] = APP . "sys/dev/{$host}.dec";

        $session['user'] = APP . "sys/etc/passwd/{$host}/{$username}.dec";

        $session['passwd'] = APP . "sys/etc/passwd/{$host}/";

        $session['storage'] = APP . "home/{$host}/{$username}/";

        $session['log'] = APP . "log/{$host}.{$username}";
          
        $user_ip = getVisitorIP();

        $date = getTimestamp();
          
        $data = '';

    }


 if( file_exists($session['host']) ) { 

        $data = $dec->decrypt(file_get_contents($session['host']));

        if(!$data && !empty($data)) {
          
            session_clear();

            checkBlacklist(getVisitorIP(), APP . 'sys/etc/blacklist', true);
          
            echo '<br>IDENTIFICATION NOT RECOGNIZED BY SYSTEM.<br>--CONNECTION TERMINATED--<br>';

            return false;
        }
    }
      
    if(file_exists($session['user'])) {

            $user = unserialize($dec->decrypt(file_get_contents($session['user'])));


            if(password_verify($password, $user['password'])) {

                $data .= "<div user='{$username}' class='response'>[" . $date . "] PASSWORD VERIFIED. <b>". $username ."</b> (". $user_ip .") LOGGED IN.<br></div>". PHP_EOL;

            if($host == "(555)-399-2364") {
            $username = strtoupper($username);
            $data .= "<div user='system' class='response'><b>system:</b> GREETINGS {$username}.<br></div>".PHP_EOL;
            }

                //Simple welcome message
                $data = $dec->encrypt($data);

                file_put_contents($session['host'], $data);

                unset($data);

                session(['auth', true], true);

                logger("LOGGED INTO: {$host}", $session['log']);

                echo 'ok';

                return true;

            } else {
              
                if($input == 'exit'){
                    session_clear();
                    echo 'error';
                    return false;
                }

                if( !isset(session()['token']) ) {

                    session(['token', 1], true);

                }

                $token = session()['token'];
                

                if( $token ) {

                    session(['token', $token+1], true);

                    if($token == 4) {

                        session_clear();

                        checkBlacklist(getVisitorIP(), APP . 'sys/etc/blacklist', true);

                        echo 'error';

                        return false;
                    }

                }

                echo "IDENTIFICATION NOT RECOGNIZED BY SYSTEM. {$token} FAILED ATTEMPTS OUT OF 3<br>";
                echo "PLEASE LOGON WITH USER PASSWORD:<br>";

                return false;
            }
      }


        $session_data = [
            'ip' => $user_ip,
            'username' => filterInput($username, true),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'host' => filterInput($host, true),
        ];

       
        if (!file_exists($session['storage'])) {
            mkdir($session['storage'], 0777, true);
        }

        if ( !file_exists($session['passwd']) ) {
            mkdir($session['passwd'], 0777, true);
        }

        if ( !file_exists($session['user']) ) {
            file_put_contents($session['user'], $dec->encrypt(serialize($session_data)));
        }


        //Simple welcome message
         $data .= "<div user='{$username}' class='response'>[" . $date . "] PASSWORD VERIFIED. <b>". $username ."</b> (". $user_ip .") LOGGED IN.<br></div>". PHP_EOL;

        if($host == "(555)-399-2364") {
            $data .= "<div user='system' class='response'><b>system:</b> GREETINGS {$username}.<br></div>".PHP_EOL;
        }


        $data = $dec->encrypt($data);


        file_put_contents($session['host'], $data);

        unset($data);

        session(['auth', true], true);

        logger("LOGGED INTO: {$host}", $session['log']);

        echo 'ok';

        return true;

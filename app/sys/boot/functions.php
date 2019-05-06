<?php

function setColor() {

    $color = randColor();

    return "style='color: {$color};'";
}

function randColor() {

    $color = substr(md5(rand()), 0, 6);

    if($color == '000000') {

        randColor();

    } else {

        return "#{$color}";
    }
}

function logger($text, $path, $user) {
    if ($user) {
     $user = $user;
    } else {
     $user = getVisitorIP();
    }
    
    error_log(getTimestamp() . ' | ' .  $user . ' - ' . $text . PHP_EOL, 3, $path);
}

function getTimestamp($full_date = true) {
    if($full_date) {
        return date('Y-m-d H:i:s');
    } else {
        return date('H:i');
    }
}

function session($data = [], $append = false, $name = 'user') {


    if( isset($_SESSION[$name]) && !$append) { 

        return $_SESSION[$name];
    }


    if( !empty($data) && $append === false) {

        return $_SESSION[$name] = $data;

    } elseif(!empty($data) && $append === true) {

        return $_SESSION[$name][$data[0]] = $data[1]; 
    }

    return false;

} 

function filterInput($input, $lowercase = false) {

    if($lowercase) {
        return strtolower(  stripslashes( htmlspecialchars($input) ) );
    }

    return stripslashes( htmlspecialchars($input) );
}


function rrmdir($directory, $delete = false)
{
    $contents = glob($directory . '*');
    foreach($contents as $item)
    {
        if (is_dir($item))
            rrmdir($item . '/', true);
        else
            unlink($item);
    }
    if ($delete === true)
        rmdir($directory);
}


function session_clear() {

    // Finds all server sessions
    session_start();
    // Stores in Array
    $_SESSION = array();
    // Swipe via memory
    if (ini_get("session.use_cookies")) {
        // Prepare and swipe cookies
        $params = session_get_cookie_params();
        // clear cookies and sessions
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    // Just in case.. swipe these values too
    ini_set('session.gc_max_lifetime', 0);
    ini_set('session.gc_probability', 1);
    ini_set('session.gc_divisor', 1);
    // Completely destroy our server sessions..
    session_destroy();
}


function getVisitorIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

function getCountryByIp($ip) {
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
echo $details->country;
}

function lastVisit() {
 
    $inTwoMonths = 60 * 60 * 24 * 60 + time();
    return setcookie('session_visit', date("H:i - m/d/y"), $inTwoMonths);
}

function checkBlacklist($ip, $storage, $save = false) {

    $data = json_decode( file_get_contents($storage), true );

    if( empty($data) ) {
        $data = array();
    }

    if($save) {

        array_push($data, $ip);
        file_put_contents( $storage, json_encode($data) );
        unset($data);
        return true;

    } elseif( in_array($ip, $data) ) {

        unset($data);
        return true;
    }

    unset($data);

    return false;

}

function listHosts($dir) {
    $hosts = array_values(array_diff(scandir($dir), array('..', '.')));

    foreach ($hosts as $host) {
      $output .= '<td>' . $host . '</td>';
      $output = str_replace('.dec', '', $output);
    }

    echo $output;
}

// Commands
function cmdScan($dir)
{
    return array_values(array_diff(scandir($dir), array('..', '.')));
}

function cmdConnect($input, $storage = '') {

    $connection = [];


    if( preg_match('/@/', $input)  ) {

                $input = explode(' ', $input);


                if(count($input) == 0) {

                    return false;
                }


                if(count($input) == 2) {

                    $connection['username'] = explode('@', $input[0])[0];
                    $connection['password'] = false;
                    $connection['host'] = explode('@', $input[0])[1];
                    $connection['key'] = md5($input[1]);

                } else {

                    $connection['username'] = explode('@', $input[0])[0];
                    $connection['password'] = false;
                    $connection['host'] = explode('@', $input[0])[1];
                    $connection['key'] = false;

                }

                if( $connection['username'] =='' ||  $connection['host'] =='' ) {

                    return false;
                }

        $connection['id'] = uniqid();

        $connection['ip'] = getVisitorIP();

        session($connection);
        
        return $connection;  
                
     }

     return false;

}


// returns true if $needle is a substring of $haystack
function contains($needle, $haystack)
{
    return strpos($haystack, $needle) !== false;
}

<?php
// please copy config.sample.inc to config.inc
include dirname(__FILE__)."/config.inc";

// for now, we only support PDO
function live_db($url){
  $url = parse_url($url);
  if(class_exists('PDO')){
    $scheme = $url['scheme'] == 'mysqli' ? 'mysql' : $url['scheme'];
    $host = urldecode($url['host']);
    $db = substr(urldecode($url['path']), 1);
    $pwd = isset($url['pass']) ? urldecode($url['pass']) : '';
    $port = isset($url['port']) ? 'port='.urldecode($url['port']).';' : '';
    $dsn = "{$scheme}:host={$host};{$port}dbname={$db}";
    try{
      $dbh = new PDO($dsn, urldecode($url['user']), $pwd);
    }
    catch (PDOException $e){
      // do nothing to prevent except error
    }
    if(is_object($dbh)){
      return 'ok';
    }
    else{
      return 'x';
    }
  }
  else{
    // TODO: fallback to use mysqli_connect or mysql_connect 
    return 'unsupport';
  }
}

// for now, only support localhost
function live_memcache($ports = '11211'){
  if(function_exists('memcache_connect')){
    $ports = explode(',', $ports);
    foreach($ports as $p){
      $obj = @memcache_connect('localhost', $p);
      if(!is_object($obj)){
        $return .= $p.'-down';
      }
      else{
        $success++;
      }
    }
    if($success == count($ports)){
      return 'ok';
    }
    else{
      return $return;
    }
  }
  else{
    return 'missing_class';
  }
}

// for now, only see if port available
function live_smtp($port){
  return live_port($port);
}

function live_backend($url){
  // quick mode, check port
  if(is_numeric($url)){
    return live_port($url);
  }

  // socket
  // TODO: use async process to watch backend.
  $c = @file_get_contents($url, false, null, -1, 10);
  if(empty($c)){
    return 'x';
  }
  else{
    return 'ok';
  }
}

function live_port($port){
  static $netstat;

  if(empty($netstat)){
    $cmd = "netstat -plnt";
    ob_start();
    passthru($cmd);
    $netstat = ob_get_clean();
  }

  if(empty($netstat)){
    return 'x';
  }
  else{
    if(strstr($netstat, ':'.$port.' ')){
      return 'ok';
    }
    else{
      return 'x';
    }
  }
}

$now = time();
$cache = $cache ? $cache : 60;
$static_file = dirname(__FILE__).'/live.htm';
$str = 'ok ';
if($debug) $time_start = microtime(true);

if($now - filemtime($static_file) > $cache){
  foreach($live as $type => $setting) {
    $func = 'live_'.$type;
    if(function_exists($func) && !empty($setting)){
      $response = $func($setting);
    }
    if(empty($response)){
      $response = '_';
    }
    $str .= $type.':'.$response.' ';
  }
  trim($str);
  file_put_contents($static_file, $str);
}
else{
  ob_start();
  include $static_file;
  $str = ob_get_clean();
}

if($debug) $time_end = microtime(true);
echo $str;
if($debug) {
  $time = $time_end - $time_start;
  echo " ($time)";
}

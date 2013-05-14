<?php
# leave array value to blank for disable live detect
$live = array(
  'db' => 'scheme://username:password@host:port/db',     // you should create empty database for better security
  'memcache' => '11211,11212',                           // multiple instance seperate by comma, whithout space
  'smtp' => '25',
  'backend' => 'http://localhost:8080/live/test.php',    // you can also use port to get quick result
);

# another example: ok db:ok memcache:_ smtp:ok backend:ok
/*
$live = array(
  'db' => 'scheme://username:password@host:port/db',     // you should create empty database for better security
  'memcache' => '',                                      // disabled
  'smtp' => '25',                                        // port
  'backend' => '8080',                                   // port
);
*/

# cache in second
# will cache string into live.htm 
# after seconds, this cache will overwrite by newer string
$cache = 60; // second

# show duration and debug info
$debug = false;

if($debug) ini_set('display_errors', 1);
else ini_set('display_errors', 0);

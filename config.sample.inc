<?php
// initial setup
// leave blank for disable live detect
// for security reason, we suggest you can create empty db for test
$live = array(
  'db' => 'scheme://username:password@host:port/db',
  'memcache' => '11211,11212',
  'smtp' => '25',
  'backend' => 'http://localhost:8080/live/test.php', // you can also use port to get quick result
);

// another example: ok db:ok memcache:_ smtp:ok backend:ok
/*
$live = array(
  'db' => 'username:password@host:port',
  'memcache' => '',
  'smtp' => '25',
  'backend' => '8080',
);
*/

// in second
// will cache string into live.htm
// and see the period greater then second
$cache = 60; // second

// show time and debug
$debug = false;

if($debug) ini_set('display_errors', 1);
else ini_set('display_errors', 0);

<?php

/**
 * Database Configuration
 *
 * All of your system's database configuration settings go in here.
 * You can see a list of the default settings in craft/app/etc/config/defaults/db.php
 */

return array(

  '*' => array(
    // Config overrides for all of our environments
  ),

  'live' => array(
		'server' => 'localhost',
		'user' => 'root',
		'password' => 'udh4756fhdknd8',
		'database' => 'bryanthughes',
		'tablePrefix' => 'craft',
  ),

  'dev' => array(
    'server'      => 'localhost',
    'user'        => 'root',
    'password'    => 'udh4756fhdknd8',
    'database'    => 'bryanthughes',
    'tablePrefix' => 'craft',
  ),

  'local' => array(
		'server'      => 'localhost',
		'user'        => 'root',
		'password'    => 'root',
		'database'    => 'bryanthughes_local',
		'tablePrefix' => 'craft',
  ),

);

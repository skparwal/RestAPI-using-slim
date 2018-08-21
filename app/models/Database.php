<?php

namespace App\Models;

class Database {
	
  private static $instance;

  public static function getInstance(){
	global $app;
	$settings = $app->getContainer()->get('settings')['db'];
		  
    if (!isset(self::$instance)) {
      try {
        self::$instance = new \PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'].';charset=utf8',
        $settings['user'], $settings['pass']);
        self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        self::$instance->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
      } catch (Exception $ex) {
        echo $ex->getMessage();
      }
    }

    return self::$instance;
  }

  public static function prepare($sql){
	try {
	  $r = self::getInstance()->prepare($sql);
	} catch(Exception $e) {
	  $r = $e->getMessage();
	}
    return $r;
  }
  
  public static function lastInsertId() {
	  return self::getInstance()->lastInsertId();
  }
}

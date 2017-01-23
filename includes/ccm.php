<?php




/**
 * Base class for all CINC classes, provides common functionality.
 */
class CCM {
  use CCM_Utils;

  CONST LOG_NOTICE = 'notice';
  CONST MIGRATE_FOWARD = 'foward';
  CONST MIGRATE_BACKWARD = 'backward';

  private $current_version = 0;
  private $migration_files = [];
  private static $instance = null;

  public function __construct(){
    $this->log("Loading Migrations", 3);
    $this->migration_files = $this->locateFiles();

  }

  public static function getInstance(){
    if(is_null(self::$instance)){
      self::$instance = new self();
    }
    return self::$instance;
  }

  public static function init($type) {
    $instance = self::getInstance();
  }

  public function exists() {
    return FALSE;
  }

  /**()
   * Alias for init.
   */
  public static function config($type) {
    return CCM::init($type);
  }


  /**
   * drush command
   *
   * @param [$version]
   * @param [@step]
   */
   public function migrate_fast($version = null, $step = null) {
     //TODO Validate Files to run migration (shift the already runned ones)
     foreach($this->migration_files as $file) {
       include_once($file);
       $klass = $this->createMigrationFromFileName($file);
       $migrateItem = $klass->newInstance();
       $migrateItem->runMigration($klass);
     }
     $this->log("END of Running Migrations", 3);
   }


   public function migrate_up() {}

   public function migrate_add($migrateName) {
     $filename =  "";
     fopen($this->__migrationDir());
   }

}

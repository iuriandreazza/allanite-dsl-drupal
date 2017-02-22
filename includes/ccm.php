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

    /**
     * CCM constructor.
     */
    public function __construct(){
        $this->log("Loading Migrations", 3);
        $this->migration_files = $this->locateFiles();

    }

    /**
     * Get Instance, Singleton initialization
     * @return CCM
     */
    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Initialize CCM System DSL
     * @param $type
     */
    public static function init($type) {
        $instance = self::getInstance();
    }

    /**
     * @return bool
     */
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
     * @param null $version
     * @param null $step
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

    //TODO: Create Micrate Up
    public function migrate_up() {}

    /**
     * Create Migration File
     *
     * @param $migrateName
     * @param $params
     */
    public function migrate_add($migrateName, $params) {
        $this->log(print_r(func_get_args(), true),2);
        $migDetails = $this->parseMigrationName($migrateName);
        $filename =  date('YmdHis').$migDetails->filename;
        $fp = fopen(implode(DIRECTORY_SEPARATOR, array($this->__migrationDir(),$filename.'.php')), 'w+');
        $strTemplate = file_get_contents(implode(DIRECTORY_SEPARATOR, array(str_replace('ccm.php','',__FILE__),'class_template.tpl')));
        $strTemplate = str_replace('%CLASS_NAME%', $migDetails->className,$strTemplate);

        //Parse Type on Migration
        switch($params['type']){
            case 'Page':
                $strTemplate .= (new CCMNodeWrapper($params))->render();
                break;
            default:
                break;
        }

        //Parse Commands on Migration
        switch($migDetails->command){
            case 'Add':
                break;
            case 'Rem':
                break;
            case 'Upd':
                break;
        }

        fwrite($fp,$strTemplate."\n}");
        fclose($fp);
    }

}


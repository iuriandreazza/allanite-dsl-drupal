<?php

/**
 * Class CCM_Utils
 *
 * Contains usefull code about CCM Migration Itens
 *
 */
trait CCM_Utils {

    /**
     * Validate on the history if the file should be migrated or not
     *
     * @param $file
     * @return bool
     */
    private function __shouldRunMigrate($file){
        return true;
    }

    /**
     * Return the micration dir used to store migrate files
     *
     * @return string
     */
    private function __migrationDir() {
        return implode(array(DRUPAL_ROOT, 'ccm_migrations'), DIRECTORY_SEPARATOR);
    }

    /**
     * Log on the Drush Output mode
     *
     * @param $msg
     * @param int $lvl
     * @param null $error
     */
    public function log($msg, $lvl = 1,  $error = null) {
        drush_log(t(str_repeat("=", $lvl)."> $msg"), CCM::LOG_NOTICE, $error);
    }

    /**
     * Locate files for migrations
     *
     * @return array
     */
    public function locateFiles() {
        $migrationDir = $this->__migrationDir();
        return glob($migrationDir.DIRECTORY_SEPARATOR.'*.php');
    }

    /**
     * Return the classname from  the migration filename,
     * CamelCaseShouldBeUsed
     *
     * TODO: Review _getClassNameFromFileName, there is unsued code
     *
     * @param $fileName
     * @return string
     */
    protected function _getClassNameFromFileName($fileName) {
        $className = '';
        $fileName = str_replace('.php', '', $fileName);
        $fArr = explode('-', $fileName);
        $mid = array_shift($fArr);
        $fNormalized = implode($fArr,'-');
        for($i = 0; $i < strlen($fNormalized); $i++) {
            if($i == 0) {
                $fNormalized{$i} = strtoupper($fNormalized{$i});
            }
            if($fNormalized{$i} == '-') {
                $i++;
                $fNormalized{$i} = strtoupper($fNormalized{$i});
            }
            $className .= $fNormalized{$i};
        }
        return $className;
    }

    /**
     * Create Klass from migration File (using reflection)
     *
     * @param $file
     * @return ReflectionClass
     */
    public function createMigrationFromFileName($file) {
        $arName = explode(DIRECTORY_SEPARATOR,$file);
        $migrateFile = array_pop($arName);
        $klass = new ReflectionClass($this->_getClassNameFromFileName($migrateFile));
        return $klass;
    }


    /**
     * Parse Migration Name to obtain the correct classname (for generating) and correct filename
     *
     * @param $migrationName
     * @return stdClass
     */
    public function parseMigrationName($migrationName){
        $metadata = new stdClass();
        $fileName = preg_replace('/(Add|Rem|Upd)/i','',$migrationName);
        $normalizedFilename =  "";
        for($i = 0; $i < strlen($fileName); $i++) {
            if(ctype_upper($fileName{$i})){
                $fileName{$i} = strtolower($fileName{$i});
                $normalizedFilename .= '-'.$fileName{$i};
            }else{
                $normalizedFilename .= $fileName{$i};
            }
        }
        $metadata->command = str_replace($fileName, '', $migrationName);
        $metadata->filename = $normalizedFilename;
        $metadata->className = $migrationName;
        return $metadata;
    }

}

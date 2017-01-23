<?php

trait CCM_Utils {

  private function __shouldRunMigrate($file){
    return true;
  }

  private function __migrationDir() {
    return implode(array(DRUPAL_ROOT, 'ccm_migrations'), DIRECTORY_SEPARATOR);
  }

  public function log($msg, $lvl = 1,  $error = null) {
    drush_log(t(str_repeat("=", $lvl)."> $msg"), CCM::LOG_NOTICE, $error);
  }

  public function locateFiles() {
    $migrationDir = $this->__migrationDir();
    return glob($migrationDir.DIRECTORY_SEPARATOR.'*.php');
  }

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

  public function createMigrationFromFileName($file) {
    $arName = explode(DIRECTORY_SEPARATOR,$file);
    $migrateFile = array_pop($arName);
    $klass = new ReflectionClass($this->_getClassNameFromFileName($migrateFile));
    return $klass;
  }
}

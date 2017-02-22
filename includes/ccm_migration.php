<?php

require_once('ccm_utils.php');

/**
 * Class CCM_Migration
 *
 * Abstract class of CCM Migration, it contains
 * the code to run migrations itens
 *
 */
class CCM_Migration implements ICCM_Migration {
    use CCM_Utils;

    /**
     * Run migrations on the CMS
     *
     * @param $klass
     * @param string $direction
     * @return mixed
     */
    public function runMigration($klass, $direction = CCM::MIGRATE_FOWARD) {
        $this->log("Running Migration -> {$klass->getName()}", 4);
        if($klass->hasMethod('change')) {
            $this->change();
        }else if($klass->hasMethod('up') && $klass->hasMethod('down')){
            switch($direction) {
                case CCM::MIGRATE_FOWARD:
                    return $this->up();
                    break;
                case CCM::MIGRATE_BACKWARD:
                    return $this->down();
                    break;
            }
        }
    }

    // abstract function up();
    // abstract function down();
    // abstract function change();

}

trait CCM_MigrateItem {

}

<?php

/**
 * Module Initialize
 *
 * @return array
 */
function ccm_drush_command() {
  $items = array();

  $items['ccm:migrate'] = array(
    'description' => dt('run project content migrations'),
    'arguments' => array(
      'version' => dt('migrate to the specified version, if not specifed run to the latest'),
      'step' =>  dt('number of migrations to run (if has multiples to run)')
    ),
    'callback' => 'ccm_migrate_fast',
    // 'aliases' => array('ccm:m'),
    'required-arguments' => 0,
  );

  $items['ccm:migrate:up'] = array(
    'description' => dt('run project content migrations up'),
    'arguments' => array(
      'version' => dt('migrate to the specified version, if not specifed run to the latest'),
      'step' =>  dt('number of migrations to run (if has multiples to run)')
    ),
    'callback' => 'ccm_migrate_up',
    // 'aliases' => array('ccm:m'),
    'required-arguments' => 0,
  );

  $items['ccm:migrate:down'] = array(
    'description' => dt('run project content migrations down'),
    'arguments' => array(
      'version' => dt('migrate to the specified version, if not specifed run to the latest'),
      'step' =>  dt('number of migrations to run (if has multiples to run)')
    ),
    'callback' => 'ccm_migrate_down',
    // 'aliases' => array('ccm:m'),
    'required-arguments' => 0,
  );

  $items['ccm:rollback'] = array(
    'description' => dt('rollback project content migrations'),
    'arguments' => array(
      'version' => dt('migrate to the specified version, if not specifed run to the latest'),
      'step' =>  dt('number of migrations to run (if has multiples to run)')
    ),
    'callback' => 'ccm_migrate_rollback',
    // 'aliases' => array('ccm:m'),
    'required-arguments' => 0,
  );
  $items['ccm:migrate:redo'] = array(
    'description' => dt('redo last project content migrations'),
    'arguments' => array(
      'version' => dt('migrate to the specified version, if not specifed run to the latest'),
      'step' =>  dt('number of migrations to run (if has multiples to run)')
    ),
    'callback' => 'ccm_migrate_redo',
    // 'aliases' => array('ccm:m'),
    'required-arguments' => 0,
  );
  $items['ccm:reset'] = array(
    'description' => dt('reset all project content migrations'),
    'arguments' => array(
      'version' => dt('migrate to the specified version, if not specifed run to the latest'),
      'step' =>  dt('number of migrations to run (if has multiples to run)')
    ),
    'callback' => 'ccm_migrate_reset',
    // 'aliases' => array('ccm:m'),
    'required-arguments' => 0,
  );

  //Commands to Generate Migrations
  $items['ccm:add'] = array(
    'description' => dt('add a new  migration to the  project'),
    'arguments' => array(
      'migration_name' => dt('migration name'),
//      'type' => dt('Type (Page,...)'),
//      'name' => dt('Name (...)'),
//      'title' => dt('Title...'),
    ),
    'callback' => 'ccm_migrate_add',
    'required-arguments' => 1,
  );
  $items['ccm:del'] = array(
    'description' => dt('remove a new  migration to the  project'),
    'arguments' => array(
      'migration_name' => dt('migration name')
    ),
    'callback' => 'ccm_migrate_del',
    'required-arguments' => 1,
  );


  // $items['cinc-content-type'] = array(
  //   'description' => dt('Create, read, update, delete content types.'),
  //   'arguments' => array(
  //     'type' => dt('Content type machine name.'),
  //   ),
  //   'aliases' => array('cinc-ct'),
  //   'required-arguments' => 1,
  // );

  return $items;
}

/**
 * DRUSH Commands
 */


//ccm:migrate
function ccm_migrate_fast($version = null, $step = null) {
  $ccm = CCM::getInstance();
  $ccm->log('Running Migration Fast Foward', 3);
  return $ccm->migrate_fast($version, $step);
}

//ccm:migrate:up
function ccm_migrate_up($version = null, $step = null) {
  $ccm = CCM::getInstance();
  if(is_null($version) && is_null($step)){
      $ccm->log('Running Migration', 3);
  }
  if(!is_null($version) && is_null($step)){
    $ccm->log("Running Migration to version $version", 3);
  }

  if(!is_null($version) && !is_null($step)){
    $ccm->log("Running Migration to version $version and just run $steps steps towards", 3);
  }

  return $ccm->migrate_up($version, $step);
}

//ccm:migrate:down
function ccm_migrate_down() {}

//ccm:rollback
function ccm_migrate_rollback() {}

//ccm:migrate:redo
function ccm_migrate_redo() {}

//ccm::reset
function ccm_migrate_reset() {}


//ccm:migrate:add
function ccm_migrate_add($migrationName) {
  $ccm = CCM::getInstance();
  $ccm->log("Adding Migration $migrationName", 3);
  $params = array();
  foreach(array_slice(func_get_args(), 1) as $param){
      list($key, $value) = explode('=', $param);
      $params[$key] = $value;
  }
  return $ccm->migrate_add($migrationName, $params);
}

//ccm:migrate:del
function ccm_migrate_del($migrationName) {

}

<?php
$xpdo_meta_map['spLink']= array (
  'package' => 'startpage',
  'version' => '1.1',
  'table' => 'sp_links',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'scheme' => NULL,
    'link' => NULL,
    'domain' => NULL,
    'screenshots' => 0,
    'update' => 1,
    'createdon' => '0000-00-00 00:00:00',
    'updatedon' => '0000-00-00 00:00:00',
  ),
  'fieldMeta' => 
  array (
    'scheme' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '10',
      'phptype' => 'string',
      'null' => false,
    ),
    'link' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
    ),
    'domain' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
    ),
    'screenshots' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 0,
    ),
    'update' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 1,
    ),
    'createdon' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'string',
      'null' => false,
      'default' => '0000-00-00 00:00:00',
    ),
    'updatedon' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'string',
      'null' => true,
      'default' => '0000-00-00 00:00:00',
    ),
  ),
  'indexes' => 
  array (
    'link' => 
    array (
      'alias' => 'link',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'link' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'active' => 
    array (
      'alias' => 'update',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'update' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
);

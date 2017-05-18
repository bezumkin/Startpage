<?php
$xpdo_meta_map['spUserLink']= array (
  'package' => 'startpage',
  'version' => '1.1',
  'table' => 'sp_user_links',
  'extends' => 'xPDOObject',
  'fields' => 
  array (
    'link' => NULL,
    'user' => NULL,
    'rank' => 0,
    'createdon' => '0000-00-00 00:00:00',
  ),
  'fieldMeta' => 
  array (
    'link' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'int',
      'null' => false,
      'pk' => 'true',
    ),
    'user' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'int',
      'null' => false,
      'pk' => 'true',
    ),
    'rank' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'int',
      'null' => true,
      'default' => 0,
    ),
    'createdon' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'string',
      'null' => false,
      'default' => '0000-00-00 00:00:00',
    ),
  ),
  'indexes' => 
  array (
    'PRIMARY' => 
    array (
      'alias' => 'PRIMARY',
      'primary' => true,
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
        'user' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
);

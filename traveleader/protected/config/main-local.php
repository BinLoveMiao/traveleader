<?php
//
//// uncomment the following to define a path alias
//// Yii::setPathOfAlias('local','path/to/local-folder');
//
//// This is the main Web application configuration. Any writable
//// CWebApplication properties can be configured here.
return array(
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=traveleader',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
            'tablePrefix' => ''
        )
        )
    );
<?php

/************************
 * Alias Definition Area
 ************************/
$configDir = dirname(__FILE__);
$frontend = dirname($configDir); //Protected folder
$backend = $frontend . DIRECTORY_SEPARATOR . 'backend';
$rootDir = dirname($frontend); //Project entry == basePath in Basic Version
$extDir = $frontend . DIRECTORY_SEPARATOR . 'extensions';
Yii::setPathOfAlias('backend', $backend);
Yii::setPathOfAlias('widgets', $frontend . DIRECTORY_SEPARATOR . 'widgets');
// Yiistrap configuration
Yii::setPathOfAlias('bootstrap', $extDir . DIRECTORY_SEPARATOR . 'bootstrap'); // Change if necessary
// YiiWheels configuration
Yii::setPathOfAlias('yiiwheels', $extDir . DIRECTORY_SEPARATOR . 'yiiwheels'); // Change if necessary
// Xupload configuration
Yii::setPathOfAlias('xupload', $extDir . DIRECTORY_SEPARATOR . 'xupload'); // Change if necessary

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => $frontend,
    'name' => '领贤旅游',
    'language' => 'zh_cn',
    'theme' => 'leather',
    // preloading 'log' component
    'preload' => array('log'),//, 'translate'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.helpers.*',
        'application.modules.cms.models.*',
        'application.modules.mall.models.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
//        'application.modules.translate.TranslateModule',
        'bootstrap.helpers.TbHtml',
        'ext.shoppingCart.*',
        'application.modules.install.models.*',
        'application.modules.install.components.*',
    	'application.extensions.xupload.models.*',
    	'application.extensions.image.*',
    	'ext.bootstrap.widgets.*',
    	'ext.yiibooster.components.*',
    ),
    // path aliases
    'aliases' => array(
        // Uncomment the following statement to register path alias.
        //    'alias' => realpath(__DIR__ . '/../extensions/aliasRealPath'), // change it to fit your need
    	'xupload' => 'ext.xupload'
    ),
    'modules' => array(
        'plugin' => array(
            'class' => 'application.modules.plugin.PluginModule', # Module path alias
            'pluginRoot' => 'application.plugin',   # Folder for plugins,make sure it is writeable.
            'layout' => '//layouts/main',            # layout of admin control panel.
        ),
        'comment'=>array(
            'class'=>'ext.comment-module.CommentModule',
            'commentableModels'=>array(
                // define commentable Models here (key is an alias that must be lower case, value is the model class name)
                'post'=>'Post'
            ),
            // set this to the class name of the model that represents your users
            'userModelClass'=>'User',
            // set this to the username attribute of User model class
            'userNameAttribute'=>'username',
            // set this to the email attribute of User model class
            'userEmailAttribute'=>'email',
            // you can set controller filters that will be added to the comment controller {@see CController::filters()}
//          'controllerFilters'=>array(),
            // you can set accessRules that will be added to the comment controller {@see CController::accessRules()}
//          'controllerAccessRules'=>array(),
            // you can extend comment class and use your extended one, set path alias here
//          'commentModelClass'=>'comment.models.Comment',
        ),
        'install',
        // uncomment the following to enable the Gii tool
        'member',
//        'translate',
        'cms' => array(
            'class' => 'application.modules.cms.CmsModule'
        ),
        'user' => array(
            'class' => 'application.modules.user.UserModule',
            # encrypting method (php hash function)
            'hash' => 'md5',
            # send activation email
            'sendActivationMail' => true,
            # allow access for non-activated users
            'loginNotActiv' => false,
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,
            # automatically login from registration
            'autoLogin' => true,
            # registration path
            'registrationUrl' => array('/user/registration'),
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
            # login form path
            'loginUrl' => array('/user/login'),
            # page after login
            'returnUrl' => array('/user/profile'),
            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),
        'mall' => array(
            'class' => 'application.modules.mall.MallModule'
        ),
        'review',
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array('bootstrap.gii'),
        ),
        'ajaxuploader'=>array(
        		'userModel'=>'Biodata',  //change to the model that has the pix column
        		'userPixColumn'=>'pix',  //column to save the filename
        		'folder'=>'images', //the dest folder(should be in the same folder level as protected folder)
        
        ),
    ),
    // application components
    'components' => array(
        'plugin' => array(
            'class' => 'application.modules.plugin.components.HookRender', # HookRender path alias
        ),
        'seo' => array(
            'class' => 'application.modules.yiiseo.components.SeoExt',
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'class' => 'WebUser',
            'loginUrl' => array('/user/login'),
            'stateKeyPrefix' => 'front_',
        ),
//        'bootstrap' => array(
//            'class' => 'bootstrap.components.Bootstrap',
//            'responsiveCss' => true,
//            'fontAwesomeCss' => true,
////            'enableCdn' => true,
//        ),
        // yiistrap configuration
        'bootstrap' => array(
            'class' => 'ext.yiibooster.components.Bootstrap',
        ),
        
        //'booster' => array(
        //		'class' => 'ext.yiibooster.components.',
        //),
        // yiiwheels configuration
        'yiiwheels' => array(
            'class' => 'yiiwheels.YiiWheels',
        ),
        'cart' => array(
            'class' => 'ext.shoppingCart.EShoppingCart',
        ),
        'mailer' => array(
            'class' => 'ext.mailer.EMailer',
            'pathViews' => 'application.views.email',
            'pathLayouts' => 'application.views.email.layouts'
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'page/<key:\w+>' => 'page/index',
//                'catalog/<cat:\w+>' => 'catalog/index',
//                'catalog/<cat:\w+>/<prop:.*?*>' => 'catalog/index',
                'list/<category_id:\d+>' => 'item/index',
                'item-list-<key:\w+>' => 'item/list',
//                        'item-<id:\d+>' => 'item/view',
                'item/<id:\d+>/<title:.*?>' => 'item/view',
                'article/<id:\d+>/<title:.*?>' => 'article/view',
                'member/orderlist/<id:\d+>' => 'member/orderlist/view',
                '<_c:\w+>/<id:\d+>' => '<_c>/view',
                '<_c:\w+>/<_a:\w+>/<id:\d+>' => '<_c>/<_a>',
                '<_c:\w+>/<_a:\w+>' => '<_c>/<_a>',
                '<_m:\w+>/<_c:\w+>/<id:\d+>' => '<_m>/<_c>/view',
                '<_m:\w+>/<_c:\w+>/<_a:\w+>-<id:\d+>' => '<_m>/<_c>/<_a>',
                '<_m:\w+>/<_c:\w+>/<_a:\w+>' => '<_m>/<_c>/<_a>',
            ),
        ),

        /* setup message translation method */
        'messages' => array(
            'class' => 'CPhpMessageSource',
//            'basePath' => 'protected/messages',
//            'onMissingTranslation' => array('Ei18n', 'missingTranslation'),
//            'sourceMessageTable' => 'source_message',
//            'translatedMessageTable' => 'message'
        ),
        /* setup global translate application component */
//        'translate' => array(
//            'class' => 'translate.components.Ei18n',
//            'createTranslationTables' => true,
//            'connectionID' => 'db',
//            'languages' => array(
//                'en' => 'English',
//                'de' => 'German',
//                'zh_cn' => 'Chinese',
//                'en_us' => 'America',
//                'ru' => 'Russian'
//            )
//        ),
        'cache' => array(
            'class' => 'system.caching.CFileCache',
        ),
        'settings' => array(
            'class' => 'ext.CmsSettings',
            'cacheComponentId' => 'cache',
            'cacheId' => 'global_website_settings',
            'cacheTime' => 0,
            'tableName' => '{{settings}}',
            'dbComponentId' => 'db',
            'createTable' => true,
            'dbEngine' => 'InnoDB',
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=traveleader',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => ''
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                array(
                    'class' => 'CWebLogRoute',
                    'levels' => 'error, warning',
                    'showInFireBug' => true,
                ),
            ),
        ),
        
        'image'=>array(
        		'class'=>'application.extensions.image.CImageComponent',
        		// GD or ImageMagick
        		'driver'=>'GD',
        		// ImageMagick setup path
        		//'params'=>array('directory'=>'D:/Program Files/ImageMagick-6.4.8-Q16'),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);
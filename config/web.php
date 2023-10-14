<?php
use app\models\Setting;
use yii\helpers\Url;
use kartik\datecontrol\Module;
use app\models\User; 

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
// var_dump(\Yii::$app->user->id);

$config = [ 
	

		'timeZone' => 'Asia/Kolkata',
		'id' => 'main',
		'name' => 'Easy Go',
		'basePath' => dirname ( __DIR__ ),
		'bootstrap' => [ 
				'log' ,
		],
		'aliases' => [ 
				'@bower' => '@vendor/bower-asset',
				'@npm' => '@vendor/npm-asset' 
		],
		
		'components' => [ 
			'config' => array(
				'class' => 'app\components\SettingConfig'),
			   //   'cache'=>3600,
			 //),
			
				'assetManager' => [ 
						'bundles' => [ 
								'yii\web\JqueryAsset' => [ 
										'sourcePath' => null, // do not publish the bundle
										'js' => [ 
												'https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js'  // use custom jquery
										
										] 
										],
										
						
						] 
				],
				'request' => [ 
						// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
						'cookieValidationKey' => 'FressaTechweblabs' 
				],
				'i18n' => [
					'translations' => [
					   'app*' => [
						  'class' => 'yii\i18n\PhpMessageSource',
						  'fileMap' => [
							 'app' => 'app.php'
						  ],
					   ],
					],
				 ],
				
				'cache' => [ 
						'class' => 'yii\caching\FileCache' 
				],
				'user' => [ 
						'identityClass' => 'app\models\User',
						'enableAutoLogin' => true 
				],
				'defaultRoute' => 'site/index',
				'errorHandler' => [ 
						'errorAction' => 'site/error' 
				],
				
				
				
				'mailer' => [ 
					'enableSwiftMailerLogging' =>True,
						'class' => 'yii\swiftmailer\Mailer',
						// send all mails to a file by default. You have to set
						// 'useFileTransport' to false and configure a transport
						// for the mailer to send real emails.
						// 'useFileTransport' => false,
						'transport' => [
							'class' => 'Swift_SmtpTransport',
							'host' => 'smtp.sendgrid.net',  
							'username' => 'apikey',
							'password' => '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',
							'port' => '465', 
							'encryption' => 'ssl', 
						],
				],
				'log' => [ 
						'traceLevel' => YII_DEBUG ? 3 : 0,
						'targets' => [ 
								[ 
										'class' => 'yii\log\FileTarget',
										'categories' => ['yii\swiftmailer\Logger::add'],
										'levels' => [ 
												'error',
												'warning' 
										] 
								] 
						] 
				],
				'view' => [ 
						'theme' => [ 
								'pathMap' => [ 
										'@app/views' => '@app/views' 
								],
								'basePath' => '@app/themes',
								'baseUrl' => '@web/themes' 
						] 
				],
				
				'db' => $db,
				'urlManager' => [ 
						'class' => 'yii\web\UrlManager',
						// Disable index.php
						'showScriptName' => false,
						// Disable r= routes
						'enablePrettyUrl' => true,
						'rules' => [ 
								'' => 'site/index' ,
								'privacy-policy' => 'site/privacy-policy',
								'terms-conditions' => 'site/terms-conditions',
								'all-stores' => 'site/all-stores',
								'all-categories' => 'site/all-categories',
								'join' => 'site/join',
								'signin' => 'site/signin',
								'store/<slug:[0-9a-zA-Z\-]+>/' => 'site/store',
								//'categories' => 'site/categories',
								'categories/<slug:[0-9a-zA-Z\-]+>/' => 'site/categories',
								'<controller:\w+>/<id:\d+>' => '<controller>/view',
								'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
								'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
								'media' => 'media/default/index' 
						] 
				] ,
				'orderStatus' =>[
					'class' => 'app\components\OrderStats',
				],
				'stats' =>[
					'class' => 'app\components\Dashboard',
				],
				'orderDispatch' =>[
					'class' => 'app\components\OrderDispatch',
				],
				'notification' => [
					'class' => 'app\components\FirebaseNotification',
				],
				'otp'=>[
					'class' => 'app\components\SendOtp',
				]
		
		],
		'modules' => [ 
			'noty' => [
				'class' => 'lo\modules\noty\Module',
			],
			
			'admin' => [
				'class' => 'app\modules\admin\Module',
			],
				'comingsoon' => [ 
						'class' => 'app\modules\comingsoon\Module' 
				],
				'email-templates' => [
					'class' => bl\emailTemplates\EmailTemplates::class,
					'languageProvider' => [
					   'class' => bl\emailTemplates\providers\ConfigLanguageProvider::class,
					   'languages' => [
						[
							'locale' => 'en',
							'label' => 'English',
						],
					],
					'defaultLanguage' => [
						'locale' => 'en',
						'label' => 'English',
					],
					
					]
				],
			
				'support' => [ 
						'class' => 'app\modules\support\Module' 
				],
				'media' => [ 
						'class' => 'app\modules\media\Module' 
				],
				'gridview' => [
					'class' => 'kartik\grid\Module',
				],
				'api' => [ 
						'class' => 'app\modules\api\API' 
				], 
				'datecontrol' => [
					'class' => 'kartik\datecontrol\Module',
		
					// format settings for displaying each date attribute (ICU format example)
					'displaySettings' => [
						Module::FORMAT_DATE => 'dd-MM-yyyy',
						Module::FORMAT_TIME => 'HH:mm:ss a',
						Module::FORMAT_DATETIME => 'dd-MM-yyyy HH:mm:ss a',
					],
		
					// format settings for saving each date attribute (PHP format example)
					'saveSettings' => [
						Module::FORMAT_DATE => 'php:U', // saves as unix timestamp
						Module::FORMAT_TIME => 'php:H:i:s',
						Module::FORMAT_DATETIME => 'php:Y-m-d',
					],
		
					// set your display timezone
					'displayTimezone' => 'Asia/Kolkata',
		
					// set your timezone for date saved to db
					'saveTimezone' => 'UTC',
		
					// automatically use kartik\widgets for each of the above formats
					'autoWidget' => true,
		
					// use ajax conversion for processing dates from display format to save format.
					'ajaxConversion' => true,
		
					// default settings for each widget from kartik\widgets used when autoWidget is true
					'autoWidgetSettings' => [
						Module::FORMAT_DATE => ['type' => 2, 'pluginOptions' => ['autoclose' => true]], // example
						Module::FORMAT_DATETIME => [], // setup if needed
						Module::FORMAT_TIME => [], // setup if needed
					],
		
					// custom widget settings that will be used to render the date input instead of kartik\widgets,
					// this will be used when autoWidget is set to false at module or widget level.
					'widgetSettings' => [
						Module::FORMAT_DATE => [
							'class' => 'yii\jui\DatePicker', // example
							'options' => [
								'dateFormat' => 'php:d-M-Y',
								'options' => ['class' => 'form-control'],
							],
						],
					],
					// other settings
				],
				
				
		],
		'params' => $params ,
		// 'preload' => 'config'
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment.
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],

    ];
}

return $config;

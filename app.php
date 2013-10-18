<?php
require __DIR__.'/vendor/autoload.php';
session_cache_limiter(false);
session_start();
$mode = 'local';
if (array_key_exists('MODE', $_SERVER)) {
	$mode = $_SERVER['MODE'];
} else {
	if (file_exists(__DIR__.'/env.live')) {
		$mode = 'live';
	} elseif (file_exists(__DIR__.'/env.local')) {
		$mode = 'local';
	}
}

// Prepare app
$app = new \Slim\Slim();
$app->setName('JIRA Attachments Gallery');
$app->config('debug', true);
$app->config('mode', $mode);
$app->config('view', new \Slim\Views\Twig());
$app->config('templates.path', realpath('views'));
$env = $app->environment();
$app->add(new \Slim\Middleware\SessionCookie(array(
		'expires' => '20 minutes',
		'path' => '/',
		'domain' => null,
		'secure' => false,
		'httponly' => false,
		'name' => 'slim_session',
		'secret' => 'CHANGE_ME',
		'cipher' => MCRYPT_RIJNDAEL_256,
		'cipher_mode' => MCRYPT_MODE_CBC
)));
$app->flashKeep();

$logWriter = null;

// if live mode
$app->configureMode('live', function () use ($app, $env) {
	$env['URLBASE'] = 'http://tupilabs.com/jira-attachments';
	$env['URLIMG'] = '/img/';
	$env['URLFULLIMG'] = $env['URLBASE'] . $env['URLIMG'];
	$env['URLCSS'] = '/css/';
	$env['URLJS'] = '/js/';
	$env['GATRACKER'] = 'UA-????';
	$app->config('debug', false);

	$logWriter = new \Slim\Extras\Log\DateTimeFileWriter(array('path' => __DIR__.'/logs'));
});

// if local mode
$app->configureMode('local', function () use ($app, $env) {
	$env['URLBASE'] = 'http://127.0.0.1';
	$env['URLIMG'] = '/img/';
	$env['URLFULLIMG'] = $env['URLBASE'] . $env['URLIMG'];
	$env['URLCSS'] = '/css/';
	$env['URLJS'] = '/js/';
	//$env['GATRACKER'] = '';
	$app->config('debug', true);

	$out = array();
	exec(sprintf("php %s/bundle.php", __DIR__), $out);

	if (count($out) > 1) {
		printf('<div><pre><code>%s</code></pre></div>', implode(PHP_EOL, $out));
	}

	$logWriter = new \Slim\Extras\Log\DateTimeFileWriter(array('path' => __DIR__.'/logs'));
});

#$app->getLog()->setWriter($logWriter);

$log = new \Monolog\Logger('jira-attachments');
$log->pushHandler(new \Monolog\Handler\StreamHandler('logs/jira-attachments.log', \Psr\Log\LogLevel::DEBUG));
$app->log = $log;

// Create monolog logger and store logger in container as singleton
// (Singleton resources retrieve the same log resource definition each time)
// $app->container->singleton('log', function () {
// 	$log = new \Monolog\Logger('jira-attachments');
// 	$log->pushHandler(new \Monolog\Handler\StreamHandler('logs/jira-attachments.log', \Psr\Log\LogLevel::DEBUG));
// 	return $log;
// });

// Prepare view
// $app->view(new \Slim\Views\Twig());
// $app->view->parserOptions = array(
// 		'debug' => true,
// 		'charset' => 'utf-8',
// 		'cache' => realpath('templates/cache'),
// 		'auto_reload' => true,
// 		'strict_variables' => false,
// 		'autoescape' => true
// );
 $app->view->parserExtensions = array(new \Slim\Views\TwigExtension());

// Define routes
require __DIR__.'/routes.php';

// Run app
$app->run();

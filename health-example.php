<?php

use BB\WPHealthCheck\WordPressApplicationCheck;
use BB\WPHealthCheck\WordPressFileSystemCheck;
use BB\WPHealthCheck\WordPressPageLoadCheck;
use BB\WPHealthCheck\Diagnostics\BuildInfo;
use BB\WPHealthCheck\SendJsonResponseHealthCheckFactory;
use Symfony\Component\HttpFoundation\JsonResponse;

$mysqli = new mysqli(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASSWORD'),
    getenv('DB_NAME')
);

$webRootDir = new SplFileObject('/path/to/webroot');
$wordPressRootDir = new SplFileObject('path/to/wordpress/root/');
$wordPressConfigFile = new SplFileObject('path/to/wordpress/config/file');

// $buildInfo defaults to []
$buildInfoArray = [
    'buildVersion' => getenv('BUILD_VERSION'),
    'libraryImageVersion' => getenv('LIBRARY_IMAGE_VERSION'),
];
$buildInfo = new BuildInfo($buildInfo);

$sendJsonResponseHealthCheckFactory = new SendJsonResponseHealthCheckFactory(
    'Application is awesome',
    'There is something wrong with the application',
    new JsonResponse()
);

$wpFileSystemCheck = new WordPressFileSystemCheck();
$wpFileSystemCheck->setWebRootDir($webRootDir)
    ->setWordPressRootDir($wordPressRootDir)
    ->setWordPressConfigFile($wordPressConfigFile)
    ->constructSubSystemDiagnostics();


$wpPageLoadCheck = new WordPressPageLoadCheck();
$wpPageLoadCheck->setRelativeURLTocheck('wp-activate.php')
    ->setExpectedTransferTimeSecs(2)
    ->setResponseTimeOutSecs(5)
    ->setConnectionTimeOutSecs(5);

$wpApplicationCheck = (new WordPressApplicationCheck($sendJsonResponseHealthCheckFactory))
    ->setWordPressFileSystemCheck($wpFileSystemCheck)
    ->setMysqli($mysqli)
    ->setBuildInfo($buildInfo)
    ->setWordPressPageLoadCheck($wpPageLoadCheck);

$wpApplicationCheck->displayHealthCheckReport();

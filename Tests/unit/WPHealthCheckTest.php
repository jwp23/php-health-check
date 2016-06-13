<?php
namespace BB\WPHealthCheck\Tests\unit;

use BB\WPHealthCheck\WPHealthCheck;
use Codeception\Util\JsonType;
use Codeception\Util\Stub;

class WPHealthCheckTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testWebRootDirectoryDoesNotExist()
    {
        $webRootDir          = Stub::make('\SplFileInfo', ['isFile' => false]);
        $wordPressRootDir    = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressConfigFile = Stub::make('\SplFileInfo', ['isFile' => true]);
        $jsonResponse        = Stub::make('Symfony\Component\HttpFoundation\JsonResponse');
        $responseTimeMs      = 2000;
        $wpActivateFile      = Stub::make('\SplFileInfo', ['isFile' => true]);

        $wpHealthCheckMock = Stub::makeEmptyExcept(
            'BB\WPHealthCheck\WPHealthCheck',
            'healthCheck',
            [
                'webRootDir'              => $webRootDir,
                'wordPressRootDir'        => $wordPressRootDir,
                'wordPressConfigFile'     => $wordPressConfigFile,
                'jsonResponse'            => $jsonResponse,
                'responseTimeMs'          => $responseTimeMs,
                'wpActivateFile'          => $wpActivateFile,
                'buildInfo'               => [
                    'buildVersion'        => '123',
                    'libraryImageVersion' => '456',
                ],
                'canAppServerConnectToDb' => true,
                'canWordPressConnectToDb' => true,
            ]);

        $expectedResponse = [
            'status'                         => WPHealthCheck::HTTP_BAD,
            'message'                        => WPHealthCheck::STATUS_NOT_OK_MESSAGE,
            'buildInfo'                      => [
                'buildVersion'        => '123',
                'libraryImageVersion' => '456',
            ],
            'webRootDirExistsCheck'          => WPHealthCheck::CHECK_NOT_PASS_MESSAGE,
            'wordPressRootDirExistsCheck'    => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressConfigFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wp-activate.phpFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canAppServerConnectToDb'        => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canWordPressConnectToDb'        => WPHealthCheck::CHECK_PASS_MESSAGE,
            'responseTimeCheck'              => WPHealthCheck::CHECK_PASS_MESSAGE,
        ];
        $jsonResponse     = new JsonType($expectedResponse);
        $jsonResponse->matches($wpHealthCheckMock->healthCheck());
    }

    public function testWordPressRootDirectoryDoesNotExist()
    {
        $webRootDir          = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressRootDir    = Stub::make('\SplFileInfo', ['isFile' => false]);
        $wordPressConfigFile = Stub::make('\SplFileInfo', ['isFile' => true]);
        $jsonResponse        = Stub::make('Symfony\Component\HttpFoundation\JsonResponse');
        $responseTimeMs      = 2000;
        $wpActivateFile      = Stub::make('\SplFileInfo', ['isFile' => true]);

        $wpHealthCheckMock = Stub::makeEmptyExcept(
            'BB\WPHealthCheck\WPHealthCheck',
            'healthCheck',
            [
                'webRootDir'              => $webRootDir,
                'wordPressRootDir'        => $wordPressRootDir,
                'wordPressConfigFile'     => $wordPressConfigFile,
                'jsonResponse'            => $jsonResponse,
                'responseTimeMs'          => $responseTimeMs,
                'wpActivateFile'          => $wpActivateFile,
                'buildInfo'               => [
                    'buildVersion'        => '123',
                    'libraryImageVersion' => '456',
                ],
                'canAppServerConnectToDb' => true,
                'canWordPressConnectToDb' => true,
            ]);

        $expectedResponse = [
            'status'                         => WPHealthCheck::HTTP_BAD,
            'message'                        => WPHealthCheck::STATUS_NOT_OK_MESSAGE,
            'buildInfo'                      => [
                'buildVersion'        => '123',
                'libraryImageVersion' => '456',
            ],
            'webRootDirExistsCheck'          => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressRootDirExistsCheck'    => WPHealthCheck::CHECK_NOT_PASS_MESSAGE,
            'wordPressConfigFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wp-activate.phpFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canAppServerConnectToDb'        => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canWordPressConnectToDb'        => WPHealthCheck::CHECK_PASS_MESSAGE,
            'responseTimeCheck'              => WPHealthCheck::CHECK_PASS_MESSAGE,
        ];
        $jsonResponse     = new JsonType($expectedResponse);
        $jsonResponse->matches($wpHealthCheckMock->healthCheck());
    }

    public function testWordPressConfigFileDoesNotExist()
    {
        $webRootDir          = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressRootDir    = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressConfigFile = Stub::make('\SplFileInfo', ['isFile' => false]);
        $jsonResponse        = Stub::make('Symfony\Component\HttpFoundation\JsonResponse');
        $responseTimeMs      = 2000;
        $wpActivateFile      = Stub::make('\SplFileInfo', ['isFile' => true]);

        $wpHealthCheckMock = Stub::makeEmptyExcept(
            'BB\WPHealthCheck\WPHealthCheck',
            'healthCheck',
            [
                'webRootDir'              => $webRootDir,
                'wordPressRootDir'        => $wordPressRootDir,
                'wordPressConfigFile'     => $wordPressConfigFile,
                'jsonResponse'            => $jsonResponse,
                'responseTimeMs'          => $responseTimeMs,
                'wpActivateFile'          => $wpActivateFile,
                'buildInfo'               => [
                    'buildVersion'        => '123',
                    'libraryImageVersion' => '456',
                ],
                'canWordPressConnectToDb' => true,
                'canAppServerConnectToDb' => true,
            ]);

        $expectedResponse = [
            'status'                         => WPHealthCheck::HTTP_BAD,
            'message'                        => WPHealthCheck::STATUS_NOT_OK_MESSAGE,
            'buildInfo'                      => [
                'buildVersion'        => '123',
                'libraryImageVersion' => '456',
            ],
            'webRootDirExistsCheck'          => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressRootDirExistsCheck'    => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressConfigFileExistsCheck' => WPHealthCheck::CHECK_NOT_PASS_MESSAGE,
            'wp-activate.phpFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canAppServerConnectToDb'        => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canWordPressConnectToDb'        => WPHealthCheck::CHECK_PASS_MESSAGE,
            'responseTimeCheck'              => WPHealthCheck::CHECK_PASS_MESSAGE,
        ];
        $jsonResponse     = new JsonType($expectedResponse);
        $jsonResponse->matches($wpHealthCheckMock->healthCheck());
    }

    public function testWPActivateFileDoesNotExist()
    {
        $webRootDir          = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressRootDir    = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressConfigFile = Stub::make('\SplFileInfo', ['isFile' => true]);
        $jsonResponse        = Stub::make('Symfony\Component\HttpFoundation\JsonResponse');
        $responseTimeMs      = 2000;
        $wpActivateFile      = Stub::make('\SplFileInfo', ['isFile' => false]);

        $wpHealthCheckMock = Stub::makeEmptyExcept(
            'BB\WPHealthCheck\WPHealthCheck',
            'healthCheck',
            [
                'webRootDir'              => $webRootDir,
                'wordPressRootDir'        => $wordPressRootDir,
                'wordPressConfigFile'     => $wordPressConfigFile,
                'jsonResponse'            => $jsonResponse,
                'responseTimeMs'          => $responseTimeMs,
                'wpActivateFile'          => $wpActivateFile,
                'buildInfo'               => [
                    'buildVersion'        => '123',
                    'libraryImageVersion' => '456',
                ],
                'canAppServerConnectToDb' => true,
                'canWordPressConnectToDb' => true,
            ]);

        $expectedResponse = [
            'status'                         => WPHealthCheck::HTTP_BAD,
            'message'                        => WPHealthCheck::STATUS_NOT_OK_MESSAGE,
            'buildInfo'                      => [
                'buildVersion'        => '123',
                'libraryImageVersion' => '456',
            ],
            'webRootDirExistsCheck'          => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressRootDirExistsCheck'    => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressConfigFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wp-activate.phpFileExistsCheck' => WPHealthCheck::CHECK_NOT_PASS_MESSAGE,
            'canAppServerConnectToDb'        => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canWordPressConnectToDb'        => WPHealthCheck::CHECK_PASS_MESSAGE,
            'responseTimeCheck'              => WPHealthCheck::CHECK_PASS_MESSAGE,
        ];
        $jsonResponse     = new JsonType($expectedResponse);
        $jsonResponse->matches($wpHealthCheckMock->healthCheck());
    }

    public function testCanAppServerConnectToDbFalse()
    {
        $webRootDir          = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressRootDir    = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressConfigFile = Stub::make('\SplFileInfo', ['isFile' => true]);
        $jsonResponse        = Stub::make('Symfony\Component\HttpFoundation\JsonResponse');
        $responseTimeMs      = 2000;
        $wpActivateFile      = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wpHealthCheckMock   = Stub::makeEmptyExcept(
            'BB\WPHealthCheck\WPHealthCheck',
            'healthCheck',
            [
                'webRootDir'              => $webRootDir,
                'wordPressRootDir'        => $wordPressRootDir,
                'wordPressConfigFile'     => $wordPressConfigFile,
                'jsonResponse'            => $jsonResponse,
                'responseTimeMs'          => $responseTimeMs,
                'wpActivateFile'          => $wpActivateFile,
                'buildInfo'               => [
                    'buildVersion'        => '123',
                    'libraryImageVersion' => '456',
                ],
                'canAppServerConnectToDb' => false,
                'canWordPressConnectToDb' => true,
            ]);
        $expectedResponse    = [
            'status'                         => WPHealthCheck::HTTP_BAD,
            'message'                        => WPHealthCheck::STATUS_NOT_OK_MESSAGE,
            'buildInfo'                      => [
                'buildVersion'        => '123',
                'libraryImageVersion' => '456',
            ],
            'webRootDirExistsCheck'          => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressRootDirExistsCheck'    => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressConfigFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wp-activate.phpFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canAppServerConnectToDb'        => WPHealthCheck::CHECK_NOT_PASS_MESSAGE,
            'canWordPressConnectToDb'        => WPHealthCheck::CHECK_PASS_MESSAGE,
            'responseTimeCheck'              => WPHealthCheck::CHECK_PASS_MESSAGE,
        ];
        $jsonResponse        = new JsonType($expectedResponse);
        $jsonResponse->matches($wpHealthCheckMock->healthCheck());
    }


    public function testCanWordPressConnectToDbFalse()
    {
        $webRootDir          = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressRootDir    = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressConfigFile = Stub::make('\SplFileInfo', ['isFile' => true]);
        $jsonResponse        = Stub::make('Symfony\Component\HttpFoundation\JsonResponse');
        $responseTimeMs      = 2000;
        $wpActivateFile      = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wpHealthCheckMock   = Stub::makeEmptyExcept(
            'BB\WPHealthCheck\WPHealthCheck',
            'healthCheck',
            [
                'webRootDir'              => $webRootDir,
                'wordPressRootDir'        => $wordPressRootDir,
                'wordPressConfigFile'     => $wordPressConfigFile,
                'jsonResponse'            => $jsonResponse,
                'responseTimeMs'          => $responseTimeMs,
                'wpActivateFile'          => $wpActivateFile,
                'buildInfo'               => [
                    'buildVersion'        => '123',
                    'libraryImageVersion' => '456',
                ],
                'canAppServerConnectToDb' => true,
                'canWordPressConnectToDb' => true,
            ]);
        $expectedResponse    = [
            'status'                         => WPHealthCheck::HTTP_BAD,
            'message'                        => WPHealthCheck::STATUS_NOT_OK_MESSAGE,
            'buildInfo'                      => [
                'buildVersion'        => '123',
                'libraryImageVersion' => '456',
            ],
            'webRootDirExistsCheck'          => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressRootDirExistsCheck'    => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressConfigFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wp-activate.phpFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canAppServerConnectToDb'        => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canWordPressConnectToDb'        => WPHealthCheck::CHECK_NOT_PASS_MESSAGE,
            'responseTimeCheck'              => WPHealthCheck::CHECK_PASS_MESSAGE,
        ];
        $jsonResponse        = new JsonType($expectedResponse);
        $jsonResponse->matches($wpHealthCheckMock->healthCheck());
    }

    public function testHealthCheckPasses()
    {
        $webRootDir          = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressRootDir    = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressConfigFile = Stub::make('\SplFileInfo', ['isFile' => true]);
        $jsonResponse        = Stub::make('Symfony\Component\HttpFoundation\JsonResponse');
        $responseTimeMs      = 2000;
        $wpActivateFile      = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wpHealthCheckMock   = Stub::makeEmptyExcept(
            'BB\WPHealthCheck\WPHealthCheck',
            'healthCheck',
            [
                'webRootDir'              => $webRootDir,
                'wordPressRootDir'        => $wordPressRootDir,
                'wordPressConfigFile'     => $wordPressConfigFile,
                'jsonResponse'            => $jsonResponse,
                'responseTimeMs'          => $responseTimeMs,
                'wpActivateFile'          => $wpActivateFile,
                'buildInfo'               => [
                    'buildVersion'        => '123',
                    'libraryImageVersion' => '456',
                ],
                'canAppServerConnectToDb' => true,
                'canWordPressConnectToDb' => true,
            ]);
        $expectedResponse    = [
            'status'                         => WPHealthCheck::HTTP_OK,
            'message'                        => WPHealthCheck::STATUS_OK_MESSAGE,
            'buildInfo'                      => [
                'buildVersion'        => '123',
                'libraryImageVersion' => '456',
            ],
            'webRootDirExistsCheck'          => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressRootDirExistsCheck'    => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressConfigFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wp-activate.phpFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canAppServerConnectToDb'        => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canWordPressConnectToDb'        => WPHealthCheck::CHECK_PASS_MESSAGE,
            'responseTimeCheck'              => WPHealthCheck::CHECK_PASS_MESSAGE,
        ];
        $jsonResponse        = new JsonType($expectedResponse);
        $jsonResponse->matches($wpHealthCheckMock->healthCheck());
    }

    public function testStatusCheckWhenHealthCheckFails()
    {
        $wpHealthCheckMock = Stub::makeEmptyExcept(
            'BB\WPHealthCheck\WPHealthCheck',
            'statusCheck',
            ['healthCheck' => false]
        );
        $expectedResponse  = [
            'status'  => WPHealthCheck::HTTP_BAD,
            'message' => WPHealthCheck::STATUS_NOT_OK_MESSAGE,
        ];
        $jsonResponse      = new JsonType([$expectedResponse]);
        $jsonResponse->matches($wpHealthCheckMock->statusCheck());
    }

    public function testStatusCheckWhenHealthCheckPasses()
    {
        $wpHealthCheckMock = Stub::makeEmptyExcept(
            'BB\WPHealthCheck\WPHealthCheck',
            'statusCheck',
            ['healthCheck' => true]
        );
        $expectedResponse  = [
            'status'  => WPHealthCheck::HTTP_OK,
            'message' => WPHealthCheck::STATUS_OK_MESSAGE,
        ];
        $jsonResponse      = new JsonType([$expectedResponse]);
        $jsonResponse->matches($wpHealthCheckMock->statusCheck());
    }

    public function testBuildInformationIsUnavailable()
    {
        $webRootDir          = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressRootDir    = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressConfigFile = Stub::make('\SplFileInfo', ['isFile' => true]);
        $jsonResponse        = Stub::make('Symfony\Component\HttpFoundation\JsonResponse');
        $responseTimeMs      = 2000;
        $wpActivateFile      = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wpHealthCheckMock   = Stub::makeEmptyExcept(
            'BB\WPHealthCheck\WPHealthCheck',
            'healthCheck',
            [
                'webRootDir'              => $webRootDir,
                'wordPressRootDir'        => $wordPressRootDir,
                'wordPressConfigFile'     => $wordPressConfigFile,
                'jsonResponse'            => $jsonResponse,
                'responseTimeMs'          => $responseTimeMs,
                'wpActivateFile'          => $wpActivateFile,
                'buildInfo'               => [],
                'canAppServerConnectToDb' => true,
                'canWordPressConnectToDb' => true,
            ]);
        $expectedResponse    = [
            'status'                         => WPHealthCheck::HTTP_OK,
            'message'                        => WPHealthCheck::STATUS_OK_MESSAGE,
            'buildInfo'                      => null,
            'webRootDirExistsCheck'          => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressRootDirExistsCheck'    => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressConfigFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wp-activate.phpFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canWordPressConnectToDb'        => WPHealthCheck::CHECK_NOT_PASS_MESSAGE,
            'responseTimeCheck'              => WPHealthCheck::CHECK_PASS_MESSAGE,
        ];
        $jsonResponse        = new JsonType($expectedResponse);
        $jsonResponse->matches($wpHealthCheckMock->healthCheck());
    }

    public function testBuildInformationIsAvailable()
    {
        $webRootDir          = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressRootDir    = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wordPressConfigFile = Stub::make('\SplFileInfo', ['isFile' => true]);
        $jsonResponse        = Stub::make('Symfony\Component\HttpFoundation\JsonResponse');
        $responseTimeMs      = 2000;
        $wpActivateFile      = Stub::make('\SplFileInfo', ['isFile' => true]);
        $wpHealthCheckMock   = Stub::makeEmptyExcept(
            'BB\WPHealthCheck\WPHealthCheck',
            'healthCheck',
            [
                'webRootDir'              => $webRootDir,
                'wordPressRootDir'        => $wordPressRootDir,
                'wordPressConfigFile'     => $wordPressConfigFile,
                'jsonResponse'            => $jsonResponse,
                'responseTimeMs'          => $responseTimeMs,
                'wpActivateFile'          => $wpActivateFile,
                'buildInfo'               => [
                    'buildVersion'        => '123',
                    'libraryImageVersion' => '456',
                ],
                'canAppServerConnectToDb' => true,
                'canWordPressConnectToDb' => true,
            ]);
        $expectedResponse    = [
            'status'                         => WPHealthCheck::HTTP_OK,
            'message'                        => WPHealthCheck::STATUS_OK_MESSAGE,
            'buildInfo'                      => [
                'buildVersion'        => '123',
                'libraryImageVersion' => '456',
            ],
            'webRootDirExistsCheck'          => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressRootDirExistsCheck'    => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wordPressConfigFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'wp-activate.phpFileExistsCheck' => WPHealthCheck::CHECK_PASS_MESSAGE,
            'canWordPressConnectToDb'        => WPHealthCheck::CHECK_NOT_PASS_MESSAGE,
            'responseTimeCheck'              => WPHealthCheck::CHECK_PASS_MESSAGE,
        ];
        $jsonResponse        = new JsonType($expectedResponse);
        $jsonResponse->matches($wpHealthCheckMock->healthCheck());
    }
}

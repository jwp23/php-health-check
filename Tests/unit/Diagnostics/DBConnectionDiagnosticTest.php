<?php

namespace BB\WPHealthCheck\Tests\unit\Diagnostics;

use BB\WPHealthCheck\Tests\unit\Mocks\MysqliMock;
use Codeception\Util\Stub;

class DBConnectionDiagnosticTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testRunDiagnosticSetsDidDiagnosticPassPropertyFalse()
    {
        $mysqli = new MysqliMock();
        $mysqli->connect_error = 'Something went wrong';
        $dbConnectionDiagnostic = Stub::make(
            'BB\WPHealthCheck\Diagnostics\DBConnectionDiagnostic',
            [
                'mysqli' => $mysqli,

            ]
        );
        $dbConnectionDiagnostic->runDiagnostic();
        $this->assertFalse($dbConnectionDiagnostic->hasDiagnosticPassed());
    }

    public function testRunDiagnosticSetsDiagnosticResultPropertyFalse()
    {
        $mysqli = new MysqliMock();
        $mysqli->connect_error = 'Something went wrong';
        $dbConnectionDiagnostic = Stub::make(
            'BB\WPHealthCheck\Diagnostics\DBConnectionDiagnostic',
            [
                'mysqli' => $mysqli,

            ]
        );
        $dbConnectionDiagnostic->runDiagnostic();
        $this->assertFalse($dbConnectionDiagnostic->getDiagnosticResult());
    }

    public function testRunDiagnosticSetsDidDiagnosticPassPropertyTrue()
    {
        $mysqli = new MysqliMock();
        $mysqli->connect_error = null;
        $dbConnectionDiagnostic = Stub::make(
            'BB\WPHealthCheck\Diagnostics\DBConnectionDiagnostic',
            [
                'mysqli' => $mysqli,

            ]
        );
        $dbConnectionDiagnostic->runDiagnostic();
        $this->assertTrue($dbConnectionDiagnostic->hasDiagnosticPassed());
    }

    public function testRunDiagnosticSetsDiagnosticResultPropertyTrue()
    {
        $mysqli = new MysqliMock();
        $mysqli->connect_error = null;
        $dbConnectionDiagnostic = Stub::make(
            'BB\WPHealthCheck\Diagnostics\DBConnectionDiagnostic',
            [
                'mysqli' => $mysqli,

            ]
        );
        $dbConnectionDiagnostic->runDiagnostic();
        $this->assertTrue($dbConnectionDiagnostic->getDiagnosticResult());
    }
}

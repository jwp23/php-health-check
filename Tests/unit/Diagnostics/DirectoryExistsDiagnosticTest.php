<?php

namespace BB\WPHealthCheck\Tests\unit\Diagnostics;

use BB\WPHealthCheck\Tests\unit\Mocks\SplFileObjectMock;
use BB\WPHealthCheck\Diagnostics\DirectoryExistsDiagnostic;

class DirectoryExistsDiagnosticTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testDidDiagnosticPassIfDirDoesNotExist()
    {
        $directory = new SplFileObjectMock();
        $directory->setIsDirFalse();
        $directoryDiagnostic = new DirectoryExistsDiagnostic('foo', $directory);
        $directoryDiagnostic->runDiagnostic();
        $this->assertFalse($directoryDiagnostic->hasDiagnosticPassed());
    }

    public function testGetDiagnosticResultIfDirDoesNotExist()
    {
        $directory = new SplFileObjectMock();
        $directory->setIsDirFalse();
        $directoryDiagnostic = new DirectoryExistsDiagnostic('foo', $directory);
        $directoryDiagnostic->runDiagnostic();
        $this->assertFalse($directoryDiagnostic->getDiagnosticResult());
    }

    public function testDidDiagnosticPassIfDirExists()
    {
        $directory = new SplFileObjectMock();
        $directory->setIsDirTrue();
        $directoryDiagnostic = new DirectoryExistsDiagnostic('foo', $directory);
        $directoryDiagnostic->runDiagnostic();
        $this->assertTrue($directoryDiagnostic->hasDiagnosticPassed());
    }

    public function testGetDiagnosticResultIfDirExists()
    {
        $directory = new SplFileObjectMock();
        $directory->setIsDirTrue();
        $directoryDiagnostic = new DirectoryExistsDiagnostic('foo', $directory);
        $directoryDiagnostic->runDiagnostic();
        $this->assertTrue($directoryDiagnostic->getDiagnosticResult());
    }
}

<?php

namespace BB\WPHealthCheck\Tests\unit\Diagnostics;

use BB\WPHealthCheck\Tests\unit\Mocks\SplFileObjectMock;
use BB\WPHealthCheck\Diagnostics\FileExistsDiagnostic;

class FileExistsDiagnosticTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testDidDiagnosticPassIfFileDoesNotExist()
    {
        $file = new SplFileObjectMock();
        $file->setIsFileFalse();
        $fileDiagnostic = new FileExistsDiagnostic('foo', $file);
        $fileDiagnostic->runDiagnostic();
        $this->assertFalse($fileDiagnostic->hasDiagnosticPassed());
    }

    public function testGetDiagnosticResultIfFileDoesNotExist()
    {
        $file = new SplFileObjectMock();
        $file->setIsFileFalse();
        $fileDiagnostic = new FileExistsDiagnostic('foo', $file);
        $fileDiagnostic->runDiagnostic();
        $this->assertFalse($fileDiagnostic->getDiagnosticResult());
    }

    public function testDidDiagnosticPassIfFileExists()
    {
        $file = new SplFileObjectMock();
        $file->setIsFileTrue();
        $fileDiagnostic = new FileExistsDiagnostic('foo', $file);
        $fileDiagnostic->runDiagnostic();
        $this->assertTrue($fileDiagnostic->hasDiagnosticPassed());
    }

    public function testGetDiagnosticResultIfFileExists()
    {
        $file = new SplFileObjectMock();
        $file->setIsFileTrue();
        $fileDiagnostic = new FileExistsDiagnostic('foo', $file);
        $fileDiagnostic->runDiagnostic();
        $this->assertTrue($fileDiagnostic->getDiagnosticResult());
    }
}

<?php

namespace BB\WPHealthCheck\Tests\unit\Diagnostics;

use BB\WPHealthCheck\Tests\unit\Mocks\SplFileObjectMock;
use BB\WPHealthCheck\Diagnostics\IsReadableDiagnostic;

class IsReadableDiagnosticTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testDidDiagnosticPassIfIsReadableFalse()
    {
        $splFile = new SplFileObjectMock();
        $splFile->setIsReadableFalse();
        $splFileDiagnostic = new IsReadableDiagnostic('foo', $splFile);
        $splFileDiagnostic->runDiagnostic();
        $this->assertFalse($splFileDiagnostic->hasDiagnosticPassed());
    }

    public function testGetDiagnosticResultIfIsReadableFalse()
    {
        $splFile = new SplFileObjectMock();
        $splFile->setIsReadableFalse();
        $splFileDiagnostic = new IsReadableDiagnostic('foo', $splFile);
        $splFileDiagnostic->runDiagnostic();
        $this->assertFalse($splFileDiagnostic->getDiagnosticResult());
    }

    public function testDidDiagnosticPassIfIsReadableTrue()
    {
        $splFile = new SplFileObjectMock();
        $splFile->setIsReadableTrue();
        $splFileDiagnostic = new IsReadableDiagnostic('foo', $splFile);
        $splFileDiagnostic->runDiagnostic();
        $this->assertTrue($splFileDiagnostic->hasDiagnosticPassed());
    }

    public function testGetDiagnosticResultIfIsReadableTrue()
    {
        $splFile = new SplFileObjectMock();
        $splFile->setIsReadableTrue();
        $splFileDiagnostic = new IsReadableDiagnostic('foo', $splFile);
        $splFileDiagnostic->runDiagnostic();
        $this->assertTrue($splFileDiagnostic->getDiagnosticResult());
    }
}

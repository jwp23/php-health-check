<?php
namespace Diagnostics;

use BB\WPHealthCheck\Diagnostics\AdditionalInfo;

class AdditionalInfoTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testConstructAdditionalInfoArgument()
    {
        $additionalInfo = new AdditionalInfo('generic description', 'foo');
        $additionalInfo->runDiagnostic();
        $this->assertSame('foo', $additionalInfo->getDiagnosticResult());
    }

    public function testDidDiagnosticPassReturnsTrue()
    {
        $additionalInfo = new AdditionalInfo('generic description', 'foo');
        $additionalInfo->runDiagnostic();
        $this->assertTrue($additionalInfo->hasDiagnosticPassed());
    }
}

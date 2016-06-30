<?php
namespace BB\WPHealthCheck\Tests\unit;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Codeception\Util\Stub;
use BB\WPHealthCheck\Tests\unit\Mocks\SimpleDiagnosticTest;
use BB\WPHealthCheck\SendJsonResponseHealthCheckFactory;

class SendJsonResponseHealthFactoryTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testDisplayHealthCheckReportStatusCodeUnhealthy()
    {
        $jsonResponse = new JsonResponse();
        $diagnosticFoo = new SimpleDiagnosticTest(false);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );

        $sendJsonResponseHealthCheckFactory = Stub::make(
            'BB\WPHealthCheck\SendJsonResponseHealthCheckFactory',
            [
                'jsonResponse' => $jsonResponse,
                'diagnosticContainer' => $diagnosticContainer,
            ]
        );
        $sendJsonResponseHealthCheckFactory->displayHealthCheckReport();
        $this->assertSame(
            JsonResponse::HTTP_BAD_REQUEST,
            $jsonResponse->getStatusCode()
        );
    }

    public function testDisplayHealthCheckReportStatusCodeHealthy()
    {
        $jsonResponse = new JsonResponse();
        $diagnosticFoo = new SimpleDiagnosticTest(true);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );

        $sendJsonResponseHealthCheckFactory = Stub::make(
            'BB\WPHealthCheck\SendJsonResponseHealthCheckFactory',
            [
                'jsonResponse' => $jsonResponse,
                'diagnosticContainer' => $diagnosticContainer,
            ]
        );
        $sendJsonResponseHealthCheckFactory->displayHealthCheckReport();
        $this->assertSame(
            JsonResponse::HTTP_OK,
            $jsonResponse->getStatusCode()
        );
    }

    public function testDisplayStatusCheckReportStatusCodeUnhealthy()
    {
        $jsonResponse = new JsonResponse();
        $diagnosticFoo = new SimpleDiagnosticTest(false);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );

        $sendJsonResponseHealthCheckFactory = Stub::make(
            'BB\WPHealthCheck\SendJsonResponseHealthCheckFactory',
            [
                'jsonResponse' => $jsonResponse,
                'diagnosticContainer' => $diagnosticContainer,
            ]
        );
        $sendJsonResponseHealthCheckFactory->displayStatusCheckReport();
        $this->assertSame(
            JsonResponse::HTTP_OK,
            $jsonResponse->getStatusCode()
        );
    }

    public function testDisplayStatusCheckReportStatusCodeHealthy()
    {
        $jsonResponse = new JsonResponse();
        $diagnosticFoo = new SimpleDiagnosticTest(true);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );

        $sendJsonResponseHealthCheckFactory = Stub::make(
            'BB\WPHealthCheck\SendJsonResponseHealthCheckFactory',
            [
                'jsonResponse' => $jsonResponse,
                'diagnosticContainer' => $diagnosticContainer,
            ]
        );
        $sendJsonResponseHealthCheckFactory->displayStatusCheckReport();
        $this->assertSame(
            JsonResponse::HTTP_OK,
            $jsonResponse->getStatusCode()
        );
    }

    public function testDisplayHealthCheckReportJsonResponseUnhealthy()
    {

        $jsonResponse = new JsonResponse();
        $diagnosticFoo = new SimpleDiagnosticTest(false);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            [
                'diagnosticCollection' => [$diagnosticFoo],
            ]
        );

        $healthOkStatusMessage = 'Everything is awesome';
        $healthNotOkStatusMessage = 'Something is wrong';
        $sendJsonResponseHealthCheckFactory = Stub::make(
            'BB\WPHealthCheck\SendJsonResponseHealthCheckFactory',
            [
                'jsonResponse' => $jsonResponse,
                'diagnosticContainer' => $diagnosticContainer,
                'healthOkStatusMessage' => $healthOkStatusMessage,
                'healthNotOkStatusMessage' => $healthNotOkStatusMessage,
            ]
        );
        $sendJsonResponseHealthCheckFactory->displayHealthCheckReport();
        $expectedData = new \stdClass();
        $expectedData->status = JsonResponse::HTTP_BAD_REQUEST;
        $expectedData->message = $healthNotOkStatusMessage;
        $this->assertSame(
            json_encode($expectedData, JSON_PRETTY_PRINT),
            $jsonResponse->getContent()
        );
    }

    public function testDisplayHealthCheckReportJsonResponseHealthy()
    {

        $jsonResponse = new JsonResponse();
        $diagnosticFoo = new SimpleDiagnosticTest(true);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );

        $healthOkStatusMessage = 'Everything is awesome';
        $healthNotOkStatusMessage = 'Something is wrong';
        $sendJsonResponseHealthCheckFactory = Stub::make(
            'BB\WPHealthCheck\SendJsonResponseHealthCheckFactory',
            [
                'jsonResponse' => $jsonResponse,
                'diagnosticContainer' => $diagnosticContainer,
                'healthOkStatusMessage' => $healthOkStatusMessage,
                'healthNotOkStatusMessage' => $healthNotOkStatusMessage,
            ]
        );
        $sendJsonResponseHealthCheckFactory->displayHealthCheckReport();
        $expectedData = new \stdClass();
        $expectedData->status = JsonResponse::HTTP_OK;
        $expectedData->message = $healthOkStatusMessage;
        $this->assertSame(
            json_encode($expectedData, JSON_PRETTY_PRINT),
            $jsonResponse->getContent()
        );
    }

    public function testDisplayStatusCheckReportJsonResponseUnhealthy()
    {

        $jsonResponse = new JsonResponse();
        $diagnosticFoo = new SimpleDiagnosticTest(false);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );

        $healthOkStatusMessage = 'Everything is awesome';
        $healthNotOkStatusMessage = 'Something is wrong';
        $sendJsonResponseHealthCheckFactory = Stub::make(
            'BB\WPHealthCheck\SendJsonResponseHealthCheckFactory',
            [
                'jsonResponse' => $jsonResponse,
                'diagnosticContainer' => $diagnosticContainer,
                'healthOkStatusMessage' => $healthOkStatusMessage,
                'healthNotOkStatusMessage' => $healthNotOkStatusMessage,
            ]
        );
        $sendJsonResponseHealthCheckFactory->displayStatusCheckReport();
        $expectedData = new \stdClass();
        $expectedData->status = JsonResponse::HTTP_BAD_REQUEST;
        $expectedData->message = $healthNotOkStatusMessage;
        $expectedData->statusChecks = [
            $diagnosticFoo->getDiagnosticDescription() =>
                $diagnosticFoo->getDiagnosticResult(),
        ];
        $this->assertSame(
            json_encode($expectedData, JSON_PRETTY_PRINT),
            $jsonResponse->getContent()
        );
    }

    public function testDisplayStatusCheckReportJsonResponseHealthy()
    {
        $jsonResponse = new JsonResponse();
        $diagnosticFoo = new SimpleDiagnosticTest(true);
        $diagnosticContainer = Stub::make(
            'BB\WPHealthCheck\DiagnosticContainer',
            ['diagnosticCollection' => [$diagnosticFoo]]
        );

        $healthOkStatusMessage = 'Everything is awesome';
        $healthNotOkStatusMessage = 'Something is wrong';
        $sendJsonResponseHealthCheckFactory = Stub::make(
            'BB\WPHealthCheck\SendJsonResponseHealthCheckFactory',
            [
                'jsonResponse' => $jsonResponse,
                'diagnosticContainer' => $diagnosticContainer,
                'healthOkStatusMessage' => $healthOkStatusMessage,
                'healthNotOkStatusMessage' => $healthNotOkStatusMessage,
            ]
        );
        $sendJsonResponseHealthCheckFactory->displayStatusCheckReport();
        $expectedData = new \stdClass();
        $expectedData->status = JsonResponse::HTTP_OK;
        $expectedData->message = $healthOkStatusMessage;
        $expectedData->statusChecks = [
            $diagnosticFoo->getDiagnosticDescription() =>
                $diagnosticFoo->getDiagnosticResult(),
        ];
        $this->assertSame(
            json_encode($expectedData, JSON_PRETTY_PRINT),
            $jsonResponse->getContent()
        );
    }
}

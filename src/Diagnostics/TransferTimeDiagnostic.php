<?php

namespace BB\WPHealthCheck\Diagnostics;

use BB\WPHealthCheck\Validation\Validator;
use GuzzleHttp\TransferStats;

class TransferTimeDiagnostic extends TransferStatsDiagnostic
{
    /**
     * @Assert\Type("integer")
     */
    protected $expectedTransferTimeSecs;

    /**
     * @var TransferStats
     */
    protected $transferStats;

    public function __construct($description, $expectedTransferTimeSecs = 2)
    {
        parent::__construct($description);
        $this->expectedTransferTimeSecs = $expectedTransferTimeSecs;
        Validator::validate($this);
    }

    public function runDiagnostic()
    {
        $transferStats = $this->getGuzzleTransferStates();
        $this->didDiagnosticPass = $transferStats->getTransferTime() <=
            $this->expectedTransferTimeSecs;
        $this->diagnosticResult = $this->didDiagnosticPass;
    }
}

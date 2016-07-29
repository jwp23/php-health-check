<?php

namespace BB\WPHealthCheck\Diagnostics;

use GuzzleHttp\TransferStats;

abstract class TransferStatsDiagnostic extends SimpleDiagnostic implements
    AccessGuzzleTransferStatsInterface
{
    /**
     * @var TransferStats
     */
    protected $transferStats;

    public function setGuzzleTransferStats(TransferStats $transferStats)
    {
        $this->transferStats = $transferStats;
    }

    public function getGuzzleTransferStates()
    {
        return $this->transferStats;
    }
}

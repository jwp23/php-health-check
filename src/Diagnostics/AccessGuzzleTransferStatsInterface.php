<?php

namespace BB\WPHealthCheck\Diagnostics;

use GuzzleHttp\TransferStats;

interface AccessGuzzleTransferStatsInterface
{
    /**
     * @param TransferStats $transferStats
     * @return void
     */
    public function setGuzzleTransferStats(TransferStats $transferStats);

    /**
     * @return TransferStats;
     */
    public function getGuzzleTransferStates();
}

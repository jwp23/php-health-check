<?php

namespace BB\WPHealthCheck;

interface GetDiagnosticCollectionInterface
{
    /**
     * @return DiagnosticCollectionInterface
     */
    public function getDiagnosticCollection();
}

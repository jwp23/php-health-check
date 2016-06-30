<?php

namespace BB\WPHealthCheck\Diagnostics;

interface DiagnosticInterface
{
    public function getDiagnosticDescription();

    /**
     * @return bool
     */
    public function hasDiagnosticPassed();

    /**
     * @return mixed
     */
    public function getDiagnosticResult();

    /**
     * @return void
     */
    public function runDiagnostic();
}

<?php

namespace BB\WPHealthCheck\Diagnostics;

use BB\WPHealthCheck\Validation\Validator;

abstract class SimpleDiagnostic implements DiagnosticInterface
{

    /**
     * @Assert\Type("string")
     */
    protected $description;

    /**
     * @var bool
     */
    protected $didDiagnosticPass = false;

    /**
     * @var mixed
     */
    protected $diagnosticResult;

    public function __construct($description)
    {
        $this->description = $description;
        Validator::validate($this);
    }

    /**
     * @return string
     */
    public function getDiagnosticDescription()
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function hasDiagnosticPassed()
    {
        return $this->didDiagnosticPass;
    }

    /**
     * @return mixed
     */
    public function getDiagnosticResult()
    {
        return $this->diagnosticResult;
    }

    /**
     * @return void
     */
    abstract public function runDiagnostic();
}

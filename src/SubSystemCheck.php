<?php

namespace BB\WPHealthCheck;

abstract class SubSystemCheck implements GetDiagnosticCollectionInterface
{
    protected $diagnosticCollection;
    
    public function __construct(
        DiagnosticCollectionInterface $diagnosticCollection
    ) {
        $this->diagnosticCollection = $diagnosticCollection;
    }

    public function getDiagnosticCollection()
    {
        return $this->diagnosticCollection;
    }
    
    abstract public function constructSubSystemDiagnostics();
}

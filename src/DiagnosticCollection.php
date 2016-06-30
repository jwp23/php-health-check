<?php

namespace BB\WPHealthCheck;

use BB\WPHealthCheck\Diagnostics\DiagnosticInterface;
use ArrayIterator;

class DiagnosticCollection implements DiagnosticCollectionInterface
{
    /**
     * @var DiagnosticInterface[]
     */
    protected $diagnosticArray = [];

    public function addDiagnostic(DiagnosticInterface $diagnostic)
    {
        $this->diagnosticArray[] = $diagnostic;

        return $this;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->diagnosticArray);
    }
    
    public function count()
    {
        return count($this->diagnosticArray);
    }
}

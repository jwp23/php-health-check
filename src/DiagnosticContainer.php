<?php


namespace BB\WPHealthCheck;

use BB\WPHealthCheck\Diagnostics\DiagnosticInterface;
use IteratorAggregate;
use ArrayIterator;

class DiagnosticContainer implements IteratorAggregate
{

    /**
     * @var DiagnosticCollectionInterface
     */
    protected $diagnosticCollection;

    public function __construct(
        DiagnosticCollectionInterface $diagnosticCollection
    ) {
        $this->diagnosticCollection = $diagnosticCollection;
    }

    public function addDiagnostic(DiagnosticInterface $diagnostic)
    {
        $this->diagnosticCollection->addDiagnostic($diagnostic);

        return $this;
    }

    protected function validateDiagnosticCollection()
    {
        if (count($this->diagnosticCollection) === 0) {
            throw new \Exception(
                'count of $diagnosticCollection property is 0'
            );
        }
    }

    public function isApplicationHealthy()
    {
        $this->validateDiagnosticCollection();

        $healthyResultCounter = 0;
        foreach ($this->diagnosticCollection as $diagnostic) {
            if ($diagnostic->hasDiagnosticPassed()) {
                $healthyResultCounter++;
            }
        }
        return $healthyResultCounter === count($this->diagnosticCollection);
    }

    public function runFullDiagnostics()
    {
        $this->validateDiagnosticCollection();

        foreach ($this->diagnosticCollection as $diagnostic) {
            $diagnostic->runDiagnostic();
        }

        return $this;
    }

    public function runDiagnosticsUntilFail()
    {
        $this->validateDiagnosticCollection();

        foreach ($this->diagnosticCollection as $diagnostic) {
            $diagnostic->runDiagnostic();

            if (!$diagnostic->hasDiagnosticPassed()) {
                return $this;
            }
        }

        return $this;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->diagnosticCollection);
    }
}

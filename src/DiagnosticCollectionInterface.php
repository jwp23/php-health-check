<?php

namespace BB\WPHealthCheck;

use BB\WPHealthCheck\Diagnostics\DiagnosticInterface;
use IteratorAggregate;
use Countable;

interface DiagnosticCollectionInterface extends IteratorAggregate, Countable
{
    public function addDiagnostic(DiagnosticInterface $diagnostic);
}

<?php

namespace BB\WPHealthCheck\Diagnostics;

use mysqli;

class DBConnectionDiagnostic extends SimpleDiagnostic
{

    protected $mysqli;

    public function __construct($description, mysqli $mysqli)
    {
        parent::__construct($description);
        $this->mysqli = $mysqli;
    }

    public function runDiagnostic()
    {
        $this->didDiagnosticPass = is_null($this->mysqli->connect_error);
        $this->mysqli->close();
        $this->diagnosticResult = $this->didDiagnosticPass;
    }
}

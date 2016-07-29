<?php


namespace BB\WPHealthCheck;

use BB\WPHealthCheck\Diagnostics\BuildInfo;
use BB\WPHealthCheck\Diagnostics\DBConnectionDiagnostic;
use mysqli;

class WordPressApplicationCheck extends ApplicationCheck
{

    /**
     * @var WordPressFileSystemCheck
     */
    protected $wpFileSystemCheck;

    /**
     * @var mysqli
     */
    protected $mysqli;

    /**
     * @var BuildInfo
     */
    protected $buildInfo;

    /**
     * @var WordPressPageLoadCheck
     */
    protected $wpPageLoadCheck;


    public function __construct(HealthCheckFactory $healthCheckFactory)
    {
        parent::__construct($healthCheckFactory);
    }

    public function setWordPressFileSystemCheck(WordPressFileSystemCheck $wpFileSystemCheck)
    {
        $this->wpFileSystemCheck = $wpFileSystemCheck;
        return $this;
    }

    public function setMysqli(mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
        return $this;
    }

    public function setBuildInfo(BuildInfo $buildInfo)
    {
        $this->buildInfo = $buildInfo;
        return $this;
    }

    public function setWordPressPageLoadCheck(WordPressPageLoadCheck $wpPageLoadCheck)
    {
        $this->wpPageLoadCheck = $wpPageLoadCheck;
        return $this;
    }

    protected function addSubSystemDiagnostics(SubSystemCheck $subSystemCheck)
    {
        $subSystemDiagnostics = $subSystemCheck->getDiagnosticCollection();
        foreach ($subSystemDiagnostics as $diagnostic) {
            $this->addDiagnostic($diagnostic);
        }
    }
    
    protected function addApplicationDiagnostics()
    {
        $dbConnectionDiagnostic = new DBConnectionDiagnostic(
            'Can application server connect to database',
            $this->mysqli
        );
        $this->addDiagnostic($this->buildInfo)
            ->addDiagnostic($dbConnectionDiagnostic);
        
        $this->wpFileSystemCheck->constructSubSystemDiagnostics();
        $this->wpPageLoadCheck->constructSubSystemDiagnostics();

        $this->addSubSystemDiagnostics($this->wpFileSystemCheck);
        $this->addSubSystemDiagnostics($this->wpPageLoadCheck);
    }
}

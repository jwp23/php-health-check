<?php

namespace BB\WPHealthCheck;

use SplFileObject;
use BB\WPHealthCheck\Diagnostics\DirectoryExistsDiagnostic;
use BB\WPHealthCheck\Diagnostics\IsReadableDiagnostic;
use BB\WPHealthCheck\Diagnostics\FileExistsDiagnostic;

class WordPressFileSystemCheck extends SubSystemCheck
{
    protected $webRootDir;
    protected $wordPressRootDir;
    protected $wordPressConfigFile;

    public function __construct()
    {
        parent::__construct(new DiagnosticCollection());
    }

    public function setWebRootDir(SplFileObject $webRootDir)
    {
        $this->webRootDir = $webRootDir;
        return $this;
    }
    
    public function setWordPressRootDir(SplFileObject $wordPressRootDir)
    {
        $this->wordPressRootDir = $wordPressRootDir;
        return $this;
    }
    
    public function setWordPressConfigFile(SplFileObject $wordPressConfigFile)
    {
        $this->wordPressConfigFile = $wordPressConfigFile;
        return $this;
    }

    public function constructSubSystemDiagnostics()
    {
        $webRootExistsDiagnostic = new DirectoryExistsDiagnostic(
            'Does Web Root Directory exist?',
            $this->webRootDir
        );
        $webRootReadableDiagnostic = new IsReadableDiagnostic(
            'Is Web Root Directory readable?',
            $this->webRootDir
        );
        $wpRootExistsDiagnostic = new DirectoryExistsDiagnostic(
            'Does WordPress Root Directory Exist?',
            $this->wordPressRootDir
        );
        $wpRootReadableDiagnostic = new IsReadableDiagnostic(
            'Is WordPress Root Directory readable?',
            $this->wordPressRootDir
        );
        $configExistsDiagnostic = new FileExistsDiagnostic(
            'Does wp-config.php exist?',
            $this->wordPressConfigFile
        );
        $configReadableDiagnostic = new IsReadableDiagnostic(
            'Is wp-config.php readable?',
            $this->wordPressConfigFile
        );

        $this->diagnosticCollection
            ->addDiagnostic($webRootExistsDiagnostic)
            ->addDiagnostic($webRootReadableDiagnostic)
            ->addDiagnostic($wpRootExistsDiagnostic)
            ->addDiagnostic($wpRootReadableDiagnostic)
            ->addDiagnostic($configExistsDiagnostic)
            ->addDiagnostic($configReadableDiagnostic);
    }
}

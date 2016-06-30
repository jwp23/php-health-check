<?php

namespace BB\WPHealthCheck\Tests\unit\Mocks;

class SplFileObjectMock extends \SplFileObject
{

    private $isReadableTrue;
    private $isDirTrue;
    private $isFileTrue;

    public function __construct()
    {

        parent::__construct('php://memory');
    }

    public function isDir()
    {
        return $this->isDirTrue;
    }

    public function isFile()
    {
        return $this->isFileTrue;
    }

    public function isReadable()
    {
        return $this->isReadableTrue;
    }

    public function setIsReadableTrue()
    {
        $this->isReadableTrue = true;
    }

    public function setIsReadableFalse()
    {
        $this->isReadableTrue = false;
    }

    public function setIsDirTrue()
    {
        $this->isDirTrue = true;
    }

    public function setIsDirFalse()
    {
        $this->isDirTrue = false;
    }

    public function setIsFileTrue()
    {
        $this->isFileTrue = true;
    }

    public function setIsFileFalse()
    {
        $this->isFileTrue = false;
    }
}

<?php

declare(strict_types=1);

namespace App\FileChecker;

/**
 * This class checks the csv file for existence and readability
 */

class CsvFileChecker implements FileChecker
{
    private string $errorMessage="";

    public function checkFile(string $filename): bool
    {
        if(!file_exists($filename) || !is_readable($filename)){
            $this->errorMessage="File read error";
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
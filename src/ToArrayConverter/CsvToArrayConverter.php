<?php

declare(strict_types=1);

namespace App\ToArrayConverter;


use App\FileChecker\CsvFileChecker;
use App\FileChecker\FileChecker;

/**
 * This class convert csv file to array and it store conversion errors.
 */
class CsvToArrayConverter implements ToArrayConverter
{
    private array $convertErrors;
    private FileChecker $fileChecker;
    private const ROW_LENGTH = 1000;

    public function __construct()
    {
        $this->fileChecker = new CsvFileChecker();
        $this->convertErrors = [];
    }

    private function addError(string $productCode, string $errorMessage):void{
        if(isset($this->convertErrors[$productCode])) {
            $this->convertErrors[$productCode] .= $errorMessage . "\n";
        }
        else{
            $this->convertErrors[$productCode] = $errorMessage . "\n";
        }
    }

    //conversion process
    public function convert(string $filename, string $delimiter = ","): array
    {
        $convertedArray=[];
        if(!$this->fileChecker->checkFile($filename)) {
            return $convertedArray;
        }
        $header=null;
        $handle = fopen($filename, 'r');
        if(!$handle){
            return [];
        }
        $header = fgetcsv($handle, self::ROW_LENGTH, $delimiter);
        while (($row = fgetcsv($handle, self::ROW_LENGTH, $delimiter)) !== false)  {
            if (!$this->validateNoFieldIsMissing($header, $row)) {
                continue;
            }
            $convertedArray[] = array_combine($header, $row);
        }
        fclose($handle);
        return $convertedArray;
    }

    public function getConvertErrors(): array
    {
        return $this->convertErrors;
    }

    private function validateNoFieldIsMissing(array $header, array $row):bool
    {
        if(count($row) != count($header)){
            $productCode=$row[0];
            $this->addError($productCode,"Field is missing error");
            return false;
        }
        return true;
    }
}

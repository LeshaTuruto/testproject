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
            echo $this->fileChecker->getErrorMessage();
            return $convertedArray;
        }
        $header=null;
        if(($handle = fopen($filename, 'r')) !== false){
            while (($row = fgetcsv($handle, self::ROW_LENGTH, $delimiter)) !== false)
            {
                if(!$header) {
                    $header = $row;
                }
                else {
                    if(count($row) === count($header)) {
                        $convertedArray[] = array_combine($header, $row);
                    }
                    else{
                        $productCode = $row[0];
                        $this->addError($productCode, "Conversion error");
                    }
                }
            }
            fclose($handle);
        }
        return $convertedArray;
    }

    /**
     * @return array
     */
    public function getConvertErrors(): array
    {
        return $this->convertErrors;
    }
}

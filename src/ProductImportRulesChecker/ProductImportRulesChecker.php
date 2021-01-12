<?php

declare(strict_types=1);

namespace App\ProductImportRulesChecker;

/**
 * This class check import rules to each product from csv file.
 */
class ProductImportRulesChecker
{

    private string $errorMessage;
    private const COST = "Cost in GBP";
    private const STOCK = "Stock";

    public function __construct()
    {
        $this->errorMessage = "";
    }

    public function check(array $product):bool
    {
        if($this->checkFirstRule($product) && $this->checkSecondRule($product) && $this->checkThirdRule($product)){
            return true;
        }
        else{
            return false;
        }
    }
    //first rule
    private function checkFirstRule(array $product):bool
    {
        $answer=true;
        if($product[self::COST] < 5.0){
            $this->errorMessage.= "Product cost is less than 5 GBP"."\n";
            $answer=false;
        }
        if($product[self::STOCK]<10){
            $this->errorMessage.= "Product stock is less than 10"."\n";
            $answer = false;
        }
        return $answer;
    }

    //second rule
    private function checkSecondRule(array $product):bool
    {
        if($product[self::COST] > 1000.0){
            $this->errorMessage.= "Product cost is more than 1000 GBP"."\n";
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
    //Since we have many products, we need to reset Error message
    public function resetErrorMessage():void{
        $this->errorMessage = "";
    }
}

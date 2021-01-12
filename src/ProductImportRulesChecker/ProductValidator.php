<?php

declare(strict_types=1);

namespace App\ProductImportRulesChecker;

/**
 * This class check import rules to each product from csv file.
 */
class ProductValidator
{

    private string $errorMessage;
    private const COST = "Cost in GBP";
    private const STOCK = "Stock";

    public function __construct()
    {
        $this->errorMessage = "";
    }

    public function validate(array $product): void
    {
        $this->validateProductCost($product);
        $this->validateProductStock($product);
    }
    //product cost validation
    private function validateProductCost(array $product): bool
    {
        $result=true;
        if($product[self::COST] < 5.0){
            $this->errorMessage.= "Product cost is less than 5 GBP"."\n";
            $result=false;
        }
        if($product[self::COST] > 1000.0){
            $this->errorMessage.= "Product cost is more than 1000 GBP"."\n";
            $result = false;
        }
        return $result;
    }

    //sproduct stock validation
    private function validateProductStock(array $product): bool
    {
        if($product[self::STOCK] < 10){
            $this->errorMessage.= "Product stock is less than 10"."\n";
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
    public function resetErrorMessage(): void
    {
        $this->errorMessage = "";
    }

}

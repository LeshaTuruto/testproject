<?php

declare(strict_types=1);

namespace App\ProductsSpotter;


use App\ProductImportRulesChecker\ProductImportRulesChecker;

/**
 * This class spots products parameters;
 * Removes products with repeatable code;
 * Applies the third rule to products.
 * Also this class can show spot errors.
 */

class ProductsSpotter
{
    private const DATE_DISCONTINUED = "dtmDiscontinued";
    private const COST = "Cost in GBP";
    private const STOCK = "Stock";
    private const IS_DISCONTINUED = "Discontinued";
    private const CORRECT_ANSWER = "yes";
    private const PRODUCT_CODE = "Product Code";
    private ProductImportRulesChecker $productRuleChecker;
    private array $errors;
    private array $products;

    public function __construct(array $products, array $errors)
    {
        $this->products = $products;
        $this->productRuleChecker = new ProductImportRulesChecker();
        $this->errors = $errors;
    }

    public function spotProducts():array
    {
        $this->spotProductsProductCode();
        $this->spotProductsParams();
        $this->spotProductsThirdRule();
        $spottedProducts = [];
        $i = 0;
        foreach ($this->products as $product){
            if($this->productRuleChecker->check($product)){
                $spottedProducts[] = $product;
            }
            else{
                if(isset($this->errors[$product[self::PRODUCT_CODE]])) {
                    $this->errors[$product[self::PRODUCT_CODE]] .= $this->productRuleChecker->getErrorMessage();
                }
                else{
                    $this->errors[$product[self::PRODUCT_CODE]] = $this->productRuleChecker->getErrorMessage();
                }
            }
            $this->productRuleChecker->resetErrorMessage();
        }
        return $spottedProducts;
    }

    //converts string cost to float and string stock to int.
    private function spotProductsParams():void
    {
        foreach ($this->products as &$product){

            $product[self::COST] = floatval($product[self::COST]);
            $product[self::STOCK] = intval($product[self::STOCK]);
            if($product[self::IS_DISCONTINUED] !== self::CORRECT_ANSWER){
                $product[self::IS_DISCONTINUED] = false;
            }
            else{
                $product[self::IS_DISCONTINUED] = true;
            }
        }
    }
    //third rule
    private function spotProductsThirdRule():void
    {
        foreach ($this->products as &$product){
            if($product[self::IS_DISCONTINUED]){
                $product[self::DATE_DISCONTINUED] = new \DateTime();
            }
            else{
                $product[self::DATE_DISCONTINUED] = null;
            }
        }
    }

    /**
     * @param array $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    //remove products with repeatable code.
    private function spotProductsProductCode():void
    {
        $spottedProducts = [];
        for($i = 0; $i < count($this->products); $i++){
            if($i < (count($this->products) - 1)) {
                if ($this->products[$i][self::PRODUCT_CODE] === $this->products[$i + 1][self::PRODUCT_CODE]) {

                } else {
                    $spottedProducts[] = $this->products[$i];
                }
            }
            else{
                $spottedProducts[] = $this->products[$i];
            }
        }
        $this->setProducts($spottedProducts);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    // convert Errors to readable string.
    public function getStringErrors():string{
        $stringErrors = "";
        foreach ($this->errors as $key => $error){
            $stringErrors .= "[".$key."]: ".$error;
        }
        return $stringErrors;
    }

}

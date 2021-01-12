<?php

declare(strict_types=1);

namespace App\ProductImporterToDatabase;


use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * This class import converted array from the csv file into MysqlDatabase
 */
class ProductImporterToMysqlDatabase implements ProductImporterToDatabase
{
    private const DATE_DISCONTINUED = "dtmDiscontinued";
    private const COST = "Cost in GBP";
    private const STOCK = "Stock";
    private const PRODUCT_CODE = "Product Code";
    private const PRODUCT_NAME = "Product Name";
    private const PRODUCT_DESCRIPTION = "Product Description";
    private array $errormessage;
    private EntityManagerInterface $em;
    private ProductRepository $productRepository;

    public function __construct(EntityManagerInterface $em, ProductRepository $productRepository)
    {
        $this->em = $em;
        $this->productRepository = $productRepository;
    }

    public function import(array $products): bool
    {
        foreach ($products as $product) {
            //If the product is not in the database, we create new product.
            if(!$this->isImported($product)){
                $dateAdded = new \DateTime();
                $InsertingProduct = new Product($product[self::PRODUCT_NAME], $product[self::PRODUCT_DESCRIPTION],
                    $product[self::PRODUCT_CODE], $dateAdded, $product[self::DATE_DISCONTINUED], $dateAdded, $product[self::COST],
                $product[self::STOCK]);
            }
            else{
                //If the product is in the database, we just edit our product according to the information from the converted array.
                $InsertingProduct = $this->productRepository->findOneByCode($product[self::PRODUCT_CODE]);
                $InsertingProduct->setProductName($product[self::PRODUCT_NAME]);
                $InsertingProduct->setProductDesc($product[self::PRODUCT_DESCRIPTION]);
                $InsertingProduct->setProductStock($product[self::STOCK]);
                $InsertingProduct->setProductPrice($product[self::COST]);
                $InsertingProduct->setDateDiscontinued($product[self::DATE_DISCONTINUED]);
                $dateEdited = new \DateTime();
                $InsertingProduct->setStmTimeStamp($dateEdited);
            }
            $this->em->persist($InsertingProduct);
        }
        $this->em->flush();
        return true;
    }
    public function isImported(array $product):bool{


        //This function checks if the product is in the database.

        if(($findedProduct = $this->productRepository->findOneByCode($product[self::PRODUCT_CODE])) !== null){
            return true;
        }
        else{
            return false;
        }
    }
}

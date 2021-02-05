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
    private EntityManagerInterface $em;
    private ProductRepository $productRepository;
    private bool $isFounded = false;

    public function __construct(EntityManagerInterface $em, ProductRepository $productRepository)
    {
        $this->em = $em;
        $this->productRepository = $productRepository;
    }

    public function import(array $products): bool
    {
        foreach ($products as $product) {
            $InsertingProduct = $this->getOrCreate($product);
            if($this->isFounded){
                //If the product is in the database, we just edit our product according to the information from the converted array.
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

    private function getOrCreate(array $productData): Product
    {
        $product = $this->productRepository->findOneByCode($productData[self::PRODUCT_CODE]);
        if($product === null){
            $product = Product::withProductData($productData);
        }
        else{
            $this->isFounded = true;
        }
        return $product;
    }
}

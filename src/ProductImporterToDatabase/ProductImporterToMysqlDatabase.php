<?php

declare(strict_types=1);

namespace App\ProductImporterToDatabase;


use App\Entity\Tblproductdata;
use App\Repository\TblproductdataRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * This class import converted array from the csv file into MysqlDatabase
 */
class ProductImporterToMysqlDatabase implements ProductImporterToDatabase
{
    private const DATE_DISCONTINUED="dtmDiscontinued";
    private const COST="Cost in GBP";
    private const STOCK="Stock";
    private const PRODUCT_CODE="Product Code";
    private const PRODUCT_NAME="Product Name";
    private const PRODUCT_DESCRIPTION="Product Description";
    private array $errormessage;
    private EntityManagerInterface $em;
    private TblproductdataRepository $productRepository;

    public function __construct(EntityManagerInterface $em,TblproductdataRepository $productRepository)
    {
        $this->em=$em;
        $this->productRepository=$productRepository;
    }

    public function import(array $products): bool
    {
        foreach ($products as $product) {
            //If the product is not in the database, we create new product.
            if(!$this->isImported($product)){
                $dateAdded=new \DateTime();
                $InsertingProduct = new Tblproductdata();
                $InsertingProduct->setStrproductcode($product[self::PRODUCT_CODE]);
                $InsertingProduct->setDtmadded($dateAdded);
            }
            else{
                //If the product is in the database, we just edit our product according to the information from the converted array.
                $InsertingProduct=$this->productRepository->findOneByCode($product[self::PRODUCT_CODE]);
            }
            $InsertingProduct->setStrproductname($product[self::PRODUCT_NAME]);
            $InsertingProduct->setStrproductdesc($product[self::PRODUCT_DESCRIPTION]);
            $InsertingProduct->setIntproductstock($product[self::STOCK]);
            $InsertingProduct->setFloatproductprice($product[self::COST]);
            $InsertingProduct->setDtmdiscontinued($product[self::DATE_DISCONTINUED]);
            $dateAdded=new \DateTime();
            $InsertingProduct->setStmtimestamp($dateAdded);
            $this->em->persist($InsertingProduct);
        }
        $this->em->flush();
        return true;
    }
    public function isImported(array $product):bool{


        //This function checks if the product is in the database.

        if(($findedProduct=$this->productRepository->findOneByCode($product[self::PRODUCT_CODE]))!==null){
            return true;
        }
        else{
            return false;
        }
    }
}

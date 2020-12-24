<?php

declare(strict_types=1);

namespace App\ProductImporterToDatabase;


interface ProductImporterToDatabase
{
    public function import(array $products):bool;
}
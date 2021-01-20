<?php

declare(strict_types=1);

namespace App\ToArrayConverter;


interface ToArrayConverter
{
    public function convert(string $filename, string $delimiter=","):array;
}
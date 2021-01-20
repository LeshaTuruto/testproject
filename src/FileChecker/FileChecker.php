<?php

declare(strict_types=1);

namespace App\FileChecker;


interface FileChecker
{
    public function checkFile(string $filename):bool;
}

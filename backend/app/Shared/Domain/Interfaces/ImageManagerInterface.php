<?php

namespace App\Shared\Domain\Interfaces;

interface ImageManagerInterface
{
    public function store(string $fileContent, string $fileName, string $folder): string;

    public function delete(string $filePath);
}

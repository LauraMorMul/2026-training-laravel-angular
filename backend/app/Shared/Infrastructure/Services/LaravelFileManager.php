<?php

namespace App\Shared\Infrastructure\Services;

use App\Shared\Domain\Interfaces\ImageManagerInterface;
use Illuminate\Support\Facades\Storage;
use Override;

class LaravelFileManager implements ImageManagerInterface
{
    public function store(string $fileContent, string $fileName, string $folder): string
    {
        $path = $folder.'/'.$fileName;
        Storage::disk('public')->put($path, $fileContent);

        return $path;
    }

    #[Override]
    public function delete(string $filePath): void
    {
        Storage::disk('public')->delete($filePath);
    }
}

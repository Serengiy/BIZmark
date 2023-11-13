<?php

namespace App\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class  FakerImageService extends Base
{
    public function storeTestImages(string $sourceDirectory, string $targetDirectory):string
    {
        if(!Storage::exists($targetDirectory)){
            Storage::makeDirectory($targetDirectory);
        }
        $image = $this->generator->file(
            base_path('tests/Fixtures/Images/'. $sourceDirectory),
            Storage::path($targetDirectory),
            false);
        $path = Storage::url($targetDirectory . '/' . $image);
        return $path;
    }
}

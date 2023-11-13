<?php

namespace App\Traits\Models;

class SlugOptions
{
    public string $slugFiled;
    public string $slugFrom;
    public string $separator = '-';
    public bool $skipSlugGenerating = false;
    public bool $makeSlugUnique = true;
    public int $slugSuffix = 1;
    public static function create():static
    {
        return new static();
    }

    public function nonUniqueSlug():self
    {
        $this->makeSlugUnique = false;
        return $this;
    }

    public function generateSlugFrom(string $slugFrom): self
    {
        $this->slugFrom = $slugFrom;
        return $this;
    }
    public function saveSlugsTo($slugFiled):self
    {
        $this->slugFiled  = $slugFiled;
        return $this;
    }

    public function useSeparator(string $separator):self
    {
        $this->separator = $separator;
        return $this;
    }

    public function skipSlugGenerating(bool $value): self
    {
        $this->skipSlugGenerating = $value;
        return $this;
    }

    public function isSkipped():bool
    {
        return $this->skipSlugGenerating;
    }

};

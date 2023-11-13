<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    protected SlugOptions $slugOptions;
    abstract static function getOptions(): SlugOptions;
    protected static function bootHasSlug()
    {
        static::creating(function (Model $model){
            $model->generateSlugOnCreate();
        });
    }

    protected function generateSlugOnCreate()
    {
        $this->slugOptions = self::getOptions();

        if($this->slugOptions->skipSlugGenerating){
            return;
        }

        if($this->hasSlug() && !$this->isSlugExists($this->{$this->slugOptions->slugFiled})){
            return;
        }

        $this->addSlug();
    }

    protected function addSlug(): void
    {
        $slug = $this->{$this->slugOptions->slugFiled} ?? $this->makeNoneUniqueSlug();

        if($this->slugOptions->makeSlugUnique){
            $slug = $this->makeUniqueSlug($slug);
        }

        $slugField = $this->slugOptions->slugFiled;
        $this->{$slugField} = $slug;
    }

    private function hasSlug():bool
    {
        return (bool) ($this->{$this->slugOptions->slugFiled});
    }

    private function makeNoneUniqueSlug():string
    {
        $slug = Str::slug($this->{$this->slugOptions->slugFrom}, $this->slugOptions->separator);
        $this->{$this->slugOptions->slugFiled} = $slug;
        return $slug;
    }

    private function makeUniqueSlug($slug): string
    {
        if($this->isSlugExists($slug)){
            $slug = $this->addSuffix($slug);
        }
        return $slug;
    }

    private function isSlugExists($slug): bool
    {
        $slugQuery = $this->query()->where(
            $this->slugOptions->slugFiled,
            $slug
        );
//        $query = $this->newQuery()
//            ->where(self::slugColumn(), $slug)
//            ->where($this->getKeyName(), '!=', $this->getKey())
//            ->withoutGlobalScopes();

        return $slugQuery->exists();
    }

    private function addSuffix($slug):string
    {
        $i = $this->slugOptions->slugSuffix;
        while($this->isSlugExists($slug)){
            $slug = $this->{$this->slugOptions->slugFiled}.$this->slugOptions->separator.$i++;
        }

        return $slug;
    }
}

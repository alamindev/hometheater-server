<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Str;

class Slug
{
    /**
     * @param $title
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public static function createSlug($title, $id = 0, $model = "Page")
    {
        // Normalize the title
        $slug = Str::slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        if ($model === 'Page') {
            $allSlugs = Self::getRelatedSlugsPage($slug, $id);
        } else {
            $allSlugs = Self::getRelatedSlugsPost($slug, $id);
        }

        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    protected static function getRelatedSlugsPage($slug, $id = 0)
    {
        return Page::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
    protected static function getRelatedSlugsPost($slug, $id = 0)
    {
        return Post::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}
<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\View;

use Illuminate\View\FileViewFinder as Finder;
use Spatie\Regex\Regex;

final class FileViewFinder extends Finder
{
    /**
     * Get an array of possible view files.
     *
     * @param string $name
     *
     * @return array
     */
    protected function getPossibleViewFiles($name)
    {
        return array_map(function ($extension) use ($name) : string {
            $regex = Regex::match('/\d.\d/', $name);

            if ($regex->hasMatch()) {
                $name = rtrim(explode($regex->result(), $name)[0], '.');

                return str_replace('.', '/', $name).'/'.$regex->result().'.'.$extension;
            }

            return str_replace('.', '/', $name).'.'.$extension;
        }, $this->extensions);
    }
}

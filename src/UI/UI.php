<?php

namespace ARKEcosystem\UserInterface;

use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;

class UI
{
    private static array $errorMessages = [];

    public static function bootErrorMessages(): void
    {
        foreach ([401, 403, 404, 419, 429, 500, 503] as $code) {
            static::useErrorMessage($code, trans('ui::errors.'.$code));
        }
    }

    public static function getErrorMessage(int $code): string
    {
        return static::$errorMessages[$code];
    }

    public static function useErrorMessage(int $code, string $message): void
    {
        static::$errorMessages[$code] = $message;
    }

    public static function getPaginationData(AbstractPaginator $paginator): array
    {
        ['pageName' => $pageName] = $paginator->getOptions();

        // Extracts the query params that will be added to the page form
        $urlParams = collect(Arr::dot(Arr::except(request()->query(), [$pageName])))
            ->mapWithKeys(function ($value, $key) {
                $parts = explode('.', $key);
                // Add square brackets to the query params when needed, example: `&state['all']=1`
                $key = collect($parts)
                    ->slice(1)
                    ->reduce(fn ($key, $part) => $key.'['.$part.']', $parts[0]);

                return [$key => $value];
            });

        return compact('pageName', 'urlParams');
    }
}

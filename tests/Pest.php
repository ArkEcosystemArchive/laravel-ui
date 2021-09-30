<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use NunoMaduro\LaravelMojito\InteractsWithViews;
use Tests\TestCase;

uses(TestCase::class, InteractsWithViews::class, RefreshDatabase::class)->in(__DIR__);

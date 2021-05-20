<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Http\Controllers;

use Illuminate\Http\Request;

class ImageCropController extends Controller
{
    public function __invoke(Request $request): array
    {
        $this->validate($request, ['image' => config('ui.crop-image.validation')]);

        $file = $request->file('image');
        $path = $file->storePubliclyAs(config('ui.crop-image.folder'), $file->hashName(), config('ui.crop-image.disk'));

        return ['url' => asset($path)];
    }
}

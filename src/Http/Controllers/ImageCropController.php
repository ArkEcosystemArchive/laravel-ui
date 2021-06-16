<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

final class ImageCropController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request): array
    {
        $this->validate($request, ['image' => config('ui.crop-image.validation')]);

        /** @var UploadedFile $file */
        $file = $request->file('image');
        $file->storeAs(config('ui.crop-image.folder'), $file->hashName(), config('ui.crop-image.disk'));

        return ['url' => $file->hashName()];
    }
}

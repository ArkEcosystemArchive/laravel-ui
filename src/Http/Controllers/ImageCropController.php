<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Http\Controllers;

use Illuminate\Http\Request;
use Livewire\TemporaryUploadedFile;

class ImageCropController extends Controller
{
    public function __invoke(Request $request): array
    {
        $this->validate($request, [
            'image' => 'required|image',
        ]);

        $file = $request->file('image');

        $path = $file->storePubliclyAs(
            config('ui.wysiwyg.folder'),
            $file->hashName(),
            config('ui.wysiwyg.disk')
        );

        return ['url' => asset($path)];

//        $this->validate($request, [
//            'image' => (array) config('ui.crop-image.validation', ['required', 'image']),
//        ]);

//        $file = $request->file('image');

//        return TemporaryUploadedFile::createFromBase($file);

//        $path = $file->storePubliclyAs(
//            config('ui.wysiwyg.folder'),
//            $file->hashName(),
//            config('ui.wysiwyg.disk')
//        );

//        return ['url' => asset($path)];
    }
}

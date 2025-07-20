<?php

namespace App\Http\Traits;

use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    public function storeImage($path, $image)
    {
        $path = $image->storeAs("public/{$path}", $image->hashName());
        return basename($path);
    }

    public function deleteImage($path, $data, $image = true): bool
    {
        if (Storage::disk('public')->exists($path) && !empty($data->image) && $image) {
            Storage::disk('public')->delete("{$path}/{$data->image}");
            return true;
        }
        return false;
    }
}

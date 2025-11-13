<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class PreviewController extends Controller
{
    /**
     * Stream a PDF stored on the "public" disk.
     * $hash is Crypt::encryptString($relativePath) where
     * $relativePath looks like "previews/yourfile.pdf".
     */
    public function show(string $hash)
    {
        try {
            $relativePath = Crypt::decryptString($hash);
        } catch (\Throwable $e) {
            abort(404, 'Invalid preview link.');
        }

        $disk = Storage::disk('public');
        if (!$disk->exists($relativePath)) {
            abort(404, 'Preview file missing.');
        }

        $absolutePath = $disk->path($relativePath);

        return response()->file($absolutePath, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.basename($absolutePath).'"',
        ]);
    }
}

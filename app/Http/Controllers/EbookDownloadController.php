<?php

namespace App\Http\Controllers;

use App\Models\EbookLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class EbookDownloadController extends Controller
{
    public function download($token, Request $request)
    {
        $link = EbookLink::where('token', $token)->first();
        if (!$link) abort(404);

        if (!$link->canDownload()) {
            abort(403, 'This link is expired or has reached its download limit.');
        }

        // increment attempts
        $link->increment('attempts');

        $path = $link->file_path;
        if (!Storage::disk('public')->exists($path) && !Storage::exists($path)) {
            abort(404, 'File not found.');
        }

        // Choose disk
        $disk = Storage::disk('public')->exists($path) ? Storage::disk('public') : Storage::disk();

        // Optional watermark hook for PDFs
        if (config('ebooks.watermark_pdf') && str_ends_with(strtolower($path), '.pdf')) {
            // Stub: you can integrate a real PDF stamper here if needed
        }

        $filename = basename($path);
        $mime = $disk->mimeType($path) ?? 'application/octet-stream';
        $stream = $disk->readStream($path);

        return Response::stream(function() use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'Cache-Control'       => 'no-store, no-cache',
        ]);
    }
}

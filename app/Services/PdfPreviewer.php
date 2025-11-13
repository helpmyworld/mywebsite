<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class PdfPreviewer
{
    /**
     * Build a preview from a file stored on the public disk (absolute path).
     * If $maxPages is null, it uses config('preview.pages', 5).
     */
    public static function makePreviewFromLocal(string $sourceLocalPath, int $maxPages = null): string
    {
        $maxPages = $maxPages ?? config('preview.pages', 5);

        if (!file_exists($sourceLocalPath)) {
            throw new \RuntimeException("Source PDF not found at {$sourceLocalPath}");
        }

        $pdf = new Fpdi();
        $pageCount = self::getPageCount($sourceLocalPath);

        $take = max(1, min($maxPages, $pageCount));

        for ($page = 1; $page <= $take; $page++) {
            $pdf->AddPage();
            $tpl = $pdf->importPage($page);
            $size = $pdf->getTemplateSize($tpl);
            $pdf->useTemplate($tpl, 0, 0, $size['width'], $size['height'], true);
        }

        // Save into public/previews
        $previewsDisk = Storage::disk('public');
        if (!$previewsDisk->exists('previews')) {
            $previewsDisk->makeDirectory('previews');
        }

        $basename = pathinfo($sourceLocalPath, PATHINFO_FILENAME);
        $targetRel = 'previews/'.uniqid($basename.'_').'.pdf';
        $targetAbs = $previewsDisk->path($targetRel);

        $pdf->Output($targetAbs, 'F');

        return $targetRel; // relative path on public disk
    }

    /**
     * Build a preview from a PDF that lives on S3 at $s3Path (e.g., "uploads/ebooks/foo.pdf").
     * Downloads a temp copy, generates the preview, returns public-relative path.
     */
    public static function makePreviewFromS3(string $s3Path, int $maxPages = null): string
    {
        $maxPages = $maxPages ?? config('preview.pages', 5);

        $s3 = Storage::disk('s3');
        if (!$s3->exists($s3Path)) {
            throw new \RuntimeException("S3 PDF not found at {$s3Path}");
        }

        // Download to local temp file
        $tmp = tempnam(sys_get_temp_dir(), 'ebook_').'.pdf';
        file_put_contents($tmp, $s3->get($s3Path));

        try {
            return self::makePreviewFromLocal($tmp, $maxPages);
        } finally {
            @unlink($tmp);
        }
    }

    /**
     * Very small helper to count pages using FPDI.
     */
    protected static function getPageCount(string $localPath): int
    {
        // FPDI requires setting the source to count pages:
        $fpdi = new Fpdi();
        return $fpdi->setSourceFile($localPath);
    }
}

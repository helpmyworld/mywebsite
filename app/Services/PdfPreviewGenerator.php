<?php

namespace App\Services;

use setasign\Fpdi\Fpdi;

class PdfPreviewGenerator
{
    /**
     * Create a preview PDF from the first $maxPages pages of $sourcePath.
     * Returns a path relative to the "public" disk, e.g. "previews/preview_123_1695200000.pdf".
     */
    public function generate(string $sourcePath, int $maxPages, int $productId): string
    {
        $pdf = new Fpdi();

        // Load the source file
        $pageCount = $pdf->setSourceFile($sourcePath);
        $limit = min($maxPages, $pageCount);

        for ($pageNo = 1; $pageNo <= $limit; $pageNo++) {
            $tplId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($tplId);
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);
        }

        // Save to storage/app/public/previews/...
        $relative = 'previews/preview_' . $productId . '_' . time() . '.pdf';
        $full = storage_path('app/public/' . $relative);
        @mkdir(dirname($full), 0775, true);

        $pdf->Output($full, 'F');
        return $relative;
    }
}

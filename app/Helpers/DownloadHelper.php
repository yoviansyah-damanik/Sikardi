<?php

namespace App\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;

class DownloadHelper
{
    public static function downloadPdf(String $view, array $payload, String $filename, String $paper = 'A4', String $orientation = 'landscape')
    {
        try {
            $pdf = PDF::loadView('download.' . $view, $payload)
                ->setPaper($paper, $orientation)
                ->output();

            return response()->streamDownload(
                function () use ($pdf) {
                    print($pdf);
                },
                $filename . '.pdf'
            );
        } catch (\Exception $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}

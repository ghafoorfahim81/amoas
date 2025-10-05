<?php

namespace App\Services;

use App\Booking;
use Mpdf\Mpdf;

class PDFService
{
    // new static class for generating PDF instance
    public static function pdf()
    {
        $defaultConfig = (new \Mpdf\Config\ConfigVariables)->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables)->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        return new Mpdf([
            'fontDir' => array_merge($fontDirs, [
                __DIR__.'/custom/font/directory',
            ]),
            'fontdata' => $fontData + [
                'IranSans' => [
                    'R' => 'IranSansRegular.ttf',
                    'B' => 'IranSansBold.ttf',
                ],
            ],
            'default_font' => 'IranSans',
            'mode' => 'utf-8',
            'format' => 'A4',
            'charset_in' => 'UTF-8',
            'allow_charset_conversion' => true,
            'curlFollowLocation' => true,
            'curlAllowUnsafeSslRequests' => false,
        ]);
    }

    public function generateBookingConfirmationPdf(Booking $booking)
    {
        $isPdf = true;
        $mpdf = self::pdf();

        $html = view('print-booking-success-new', compact('booking', 'isPdf'))->render();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('', 'S'); // Output as string
    }
}

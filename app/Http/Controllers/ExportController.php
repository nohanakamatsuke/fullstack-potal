<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function download_storage(Request $request)
    {
        $filePath = 'receipts/bI6GfC5AhzMsifmuTcJezjAbYe2r06VHumcMoVjl.png';
        $fileName = 'test1.png';
        $mimeType = Storage::disk('public')->mimeType($filePath);
        $headers = [['Content-Type' => $mimeType]];

        return Storage::disk('public')->download($filePath, $fileName, $headers);
    }

    public function download_response(Request $request)
    {
        $filePath = Storage::path('public/receipts/Hmn3VdyWmYcgkgcLFq2CI27S7hfL7qmz4vLUKwhN.png');
        $fileName = 'test2.png';
        $mimeType = Storage::mimeType($filePath);
        $headers = [['Content-Type' => $mimeType]];

        return response()->download($filePath, $fileName, $headers);
    }

    public function csv_stream(Request $request)
    {
        $response_headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=export.csv',
            'Pragma' => 'no-cache',
            'Expires' => 0,
        ];

        $results = [
            ['id', 'name', 'class'],
            [1, 'John', '1-A'],
            [2, 'Tom', '1-B'],
            [3, 'Mary', '2-A'],
            [4, 'May', '2-B'],
        ];
        $callback = function () use ($results) {
            $resource = fopen('php://output', 'w');
            foreach ($results as $row) {
                fputcsv($resource, $row);
            }
            fclose($resource);
        };

        return response()->stream($callback, 200, $response_headers);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    /**
     * Mostra la gallery con link temporaneo
     */
    public function gallery(Request $request, string $token)
    {
        $order = Order::where('download_token', $token)->first();

        if (!$order || !$order->isDownloadValid()) {
            abort(404, 'Link non valido o scaduto');
        }

        $photos = $order->lead->photos;

        return view('download.gallery', compact('order', 'photos'));
    }

    /**
     * Download di una singola foto
     */
    public function photo(Request $request, string $token, int $photoId)
    {
        $order = Order::where('download_token', $token)->first();

        if (!$order || !$order->isDownloadValid()) {
            abort(404, 'Link non valido o scaduto');
        }

        $photo = Photo::where('id', $photoId)
                     ->where('lead_id', $order->lead_id)
                     ->firstOrFail();

        if (!Storage::disk($photo->disk)->exists($photo->path)) {
            abort(404, 'File non trovato');
        }

        return Storage::disk($photo->disk)->download($photo->path, $photo->original_name);
    }

    /**
     * Download di tutte le foto come ZIP
     */
    public function downloadAll(Request $request, string $token): StreamedResponse
    {
        $order = Order::where('download_token', $token)->first();

        if (!$order || !$order->isDownloadValid()) {
            abort(404, 'Link non valido o scaduto');
        }

        $photos = $order->lead->photos;
        $zipName = "foto_{$order->lead->name}_{$order->event->name}.zip";

        $response = new StreamedResponse(function () use ($photos) {
            $zip = new \ZipArchive();
            $tempFile = tempnam(sys_get_temp_dir(), 'gallery');
            
            if ($zip->open($tempFile, \ZipArchive::CREATE) === TRUE) {
                foreach ($photos as $photo) {
                    if (Storage::disk($photo->disk)->exists($photo->path)) {
                        $zip->addFromString(
                            $photo->original_name,
                            Storage::disk($photo->disk)->get($photo->path)
                        );
                    }
                }
                $zip->close();
            }

            readfile($tempFile);
            unlink($tempFile);
        });

        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $zipName . '"');

        return $response;
    }
}

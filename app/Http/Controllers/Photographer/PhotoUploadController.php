<?php

namespace App\Http\Controllers\Photographer;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoUploadController extends Controller
{
    /**
     * Form per upload foto
     */
    public function create(Lead $lead)
    {
        // Verifica che il lead appartenga al fotografo loggato
        if ($lead->photographer_id !== auth()->id()) {
            abort(403, 'Non autorizzato ad accedere a questo lead');
        }

        return view('photographer.photos.upload', compact('lead'));
    }

    /**
     * Upload singola foto
     */
    public function store(Request $request, Lead $lead)
    {
        // Verifica che il lead appartenga al fotografo loggato
        if ($lead->photographer_id !== auth()->id()) {
            abort(403, 'Non autorizzato a caricare foto per questo lead');
        }

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:20480', // 20MB max
        ]);

        $uploadedFile = $request->file('photo');
        $originalName = $uploadedFile->getClientOriginalName();
        $filename = Str::uuid() . '.' . $uploadedFile->getClientOriginalExtension();
        
        // Salva nel storage
        $path = $uploadedFile->storeAs(
            "photos/{$lead->event_id}/{$lead->id}", 
            $filename, 
            'public'
        );

        // Crea record nel database
        $photo = Photo::create([
            'filename' => $filename,
            'original_name' => $originalName,
            'path' => $path,
            'disk' => 'public',
            'mime_type' => $uploadedFile->getMimeType(),
            'size' => $uploadedFile->getSize(),
            'metadata' => $this->getImageMetadata($uploadedFile),
            'lead_id' => $lead->id,
            'event_id' => $lead->event_id,
            'uploaded_by' => auth()->id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'photo' => $photo,
                'message' => 'Foto caricata con successo'
            ]);
        }

        return redirect()
               ->route('photographer.leads.show', $lead)
               ->with('success', 'Foto caricata con successo');
    }

    /**
     * Upload multiplo foto
     */
    public function uploadMultiple(Request $request, Lead $lead)
    {
        // Verifica che il lead appartenga al fotografo loggato
        if ($lead->photographer_id !== auth()->id()) {
            abort(403, 'Non autorizzato a caricare foto per questo lead');
        }

        $request->validate([
            'photos.*' => 'required|image|mimes:jpeg,png,jpg|max:20480',
        ]);

        $uploadedPhotos = [];

        foreach ($request->file('photos') as $uploadedFile) {
            $originalName = $uploadedFile->getClientOriginalName();
            $filename = Str::uuid() . '.' . $uploadedFile->getClientOriginalExtension();
            
            $path = $uploadedFile->storeAs(
                "photos/{$lead->event_id}/{$lead->id}", 
                $filename, 
                'public'
            );

            $photo = Photo::create([
                'filename' => $filename,
                'original_name' => $originalName,
                'path' => $path,
                'disk' => 'public',
                'mime_type' => $uploadedFile->getMimeType(),
                'size' => $uploadedFile->getSize(),
                'metadata' => $this->getImageMetadata($uploadedFile),
                'lead_id' => $lead->id,
                'event_id' => $lead->event_id,
                'uploaded_by' => auth()->id(),
            ]);

            $uploadedPhotos[] = $photo;
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'photos' => $uploadedPhotos,
                'count' => count($uploadedPhotos),
                'message' => count($uploadedPhotos) . ' foto caricate con successo'
            ]);
        }

        return redirect()
               ->route('photographer.leads.show', $lead)
               ->with('success', count($uploadedPhotos) . ' foto caricate con successo');
    }

    /**
     * Cancella foto
     */
    public function destroy(Lead $lead, Photo $photo)
    {
        // Verifica autorizzazioni
        if ($lead->photographer_id !== auth()->id() || $photo->lead_id !== $lead->id) {
            abort(403, 'Non autorizzato a eliminare questa foto');
        }

        // Elimina file fisico
        if (Storage::disk($photo->disk)->exists($photo->path)) {
            Storage::disk($photo->disk)->delete($photo->path);
        }

        // Elimina record database
        $photo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Foto eliminata con successo'
        ]);
    }

    /**
     * Estrai metadata dall'immagine
     */
    private function getImageMetadata($file): array
    {
        $metadata = [];

        try {
            $imageSize = getimagesize($file->getRealPath());
            
            if ($imageSize !== false) {
                $metadata['width'] = $imageSize[0];
                $metadata['height'] = $imageSize[1];
            }
        } catch (\Exception $e) {
            // Ignora errori di metadata
        }

        return $metadata;
    }
}

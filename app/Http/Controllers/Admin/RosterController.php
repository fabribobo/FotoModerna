<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpectedStudent;
use App\Models\Event;
use Illuminate\Http\Request;

class RosterController extends Controller
{
    /**
     * Mostra l'elenco delle matricole attese per l'evento
     */
    public function index(Event $event)
    {
        $students = $event->expectedStudents()
                          ->with('matchedLead')
                          ->orderBy('matricola')
                          ->get();

        return view('admin.events.roster', compact('event', 'students'));
    }

    /**
     * Importa l'elenco delle matricole (una per riga, opzionalmente con nome)
     */
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'list' => 'required|string',
        ]);

        $imported = 0;

        foreach (preg_split('/\r\n|\r|\n/', trim($validated['list'])) as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            // Formati accettati per riga: "matricola", "matricola;Nome Cognome", "matricola,Nome Cognome"
            $parts = preg_split('/[;,\t]/', $line, 2);
            $matricola = trim($parts[0]);
            $name = isset($parts[1]) ? trim($parts[1]) : null;

            if ($matricola === '') {
                continue;
            }

            ExpectedStudent::updateOrCreate(
                ['event_id' => $event->id, 'matricola' => $matricola],
                array_filter(['name' => $name], fn ($value) => $value !== null && $value !== '')
            );

            $imported++;
        }

        return redirect()
               ->route('admin.events.roster', $event)
               ->with('success', "Importate {$imported} matricole.");
    }

    /**
     * Rimuove una matricola dall'elenco atteso
     */
    public function destroy(Event $event, ExpectedStudent $student)
    {
        if ($student->event_id !== $event->id) {
            abort(404);
        }

        $student->delete();

        return redirect()
               ->route('admin.events.roster', $event)
               ->with('success', 'Matricola rimossa.');
    }
}

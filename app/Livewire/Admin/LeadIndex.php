<?php

namespace App\Livewire\Admin;

use App\Models\Lead;
use Livewire\Component;
use Livewire\WithPagination;

class LeadIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $eventId = null;
    public ?int $photographerId = null;
    public string $orderStatus = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'eventId' => ['except' => null],
        'photographerId' => ['except' => null],
        'orderStatus' => ['except' => ''],
    ];

    protected $updatesQueryString = ['search', 'eventId', 'photographerId', 'orderStatus'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingEventId(): void
    {
        $this->resetPage();
    }

    public function updatingPhotographerId(): void
    {
        $this->resetPage();
    }

    public function updatingOrderStatus(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Lead::with(['event', 'photographer', 'order'])
            ->latest();

        if ($this->search !== '') {
            $search = '%' . $this->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('email', 'like', $search)
                  ->orWhere('phone', 'like', $search);
            });
        }

        if ($this->eventId) {
            $query->where('event_id', $this->eventId);
        }

        if ($this->photographerId) {
            $query->where('photographer_id', $this->photographerId);
        }

        if ($this->orderStatus !== '') {
            if ($this->orderStatus === 'none') {
                $query->whereDoesntHave('order');
            } else {
                $query->whereHas('order', function ($q) {
                    $q->where('payment_status', $this->orderStatus);
                });
            }
        }

        $leads = $query->paginate(20);

        $events = \App\Models\Event::orderBy('event_date', 'desc')->get();
        $photographers = \App\Models\User::role('fotografo')->orderBy('name')->get();

        return view('livewire.admin.lead-index', [
            'leads' => $leads,
            'events' => $events,
            'photographers' => $photographers,
        ]);
    }
}

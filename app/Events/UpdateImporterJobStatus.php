<?php

namespace App\Events;

use App\Enums\ImporterStatuses;
use App\Importers\GeojsonFeaturesImporter;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class UpdateImporterJobStatus implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        private GeojsonFeaturesImporter $importer,
        private ImporterStatuses $status)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('importer-status'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'importer' => $this->importer::class,
            'status' => $this->status->value,
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ];
    }

}

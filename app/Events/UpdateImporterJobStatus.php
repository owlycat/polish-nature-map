<?php

namespace App\Events;

use App\Enums\ImporterStatuses;
use App\Importers\GeojsonFeaturesImporter;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\Models\ImporterStatus;

class UpdateImporterJobStatus implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $importer;
    public string $status;
    public string $timestamp;

    /**
     * Create a new event instance.
     */
    public function __construct(
        GeojsonFeaturesImporter $importer,
        ImporterStatuses $status)
    {
        $this->importer = $importer::class;
        $this->status = $status->value;
        $this->timestamp = now()->format('Y-m-d H:i:s');

        ImporterStatus::create(
            [
            'job_name' => $this->importer,
            'job_status' => $this->status,
            'job_timestamp' => $this->timestamp
            ]
        );
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
}

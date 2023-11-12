<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\WikipediaSearchHelper;
use App\Models\SpatialFeature;


class UpdatePlacesDescriptionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $wikipediaSearch = new WikipediaSearchHelper();

        $spatialFeatures = SpatialFeature::whereNull('description')->get();

        foreach ($spatialFeatures as $spatialFeature) {
            $data = $wikipediaSearch->query($spatialFeature->name);
    
            $spatialFeature->description = $data;
    
            $spatialFeature->save();
        }
    }
}

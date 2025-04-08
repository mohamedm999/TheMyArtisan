<?php

namespace App\Console\Commands;

use App\Models\ArtisanProfile;
use Illuminate\Console\Command;

class ApproveAllArtisansCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artisans:approve-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Approve all pending artisans';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Find artisans that are not approved or rejected
        // This includes both 'active' (default) and 'pending' (if exists in schema)
        $pendingArtisans = ArtisanProfile::where('status', '!=', ArtisanProfile::STATUS_APPROVED)
            ->where('status', '!=', ArtisanProfile::STATUS_REJECTED)
            ->get();

        $count = $pendingArtisans->count();

        if ($count === 0) {
            $this->info("No pending artisans found to approve.");
            return 0;
        }

        $this->info("Found {$count} artisans pending approval.");

        if ($this->confirm("Do you want to approve all {$count} artisans?")) {
            // Show progress bar
            $bar = $this->output->createProgressBar($count);
            $bar->start();

            foreach ($pendingArtisans as $artisan) {
                $artisan->status = ArtisanProfile::STATUS_APPROVED;
                $artisan->save();
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info("All {$count} artisans have been approved successfully!");
            return 0;
        }

        $this->info("Operation cancelled.");
        return 0;
    }
}

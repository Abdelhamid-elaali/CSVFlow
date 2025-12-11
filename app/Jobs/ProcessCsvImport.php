<?php

namespace App\Jobs;

use App\Models\ImportedUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessCsvImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        try {
            Log::info('ProcessCsvImport started', ['filePath' => $this->filePath]);

            if (!Storage::exists($this->filePath)) {
                throw new \Exception("CSV file not found at path: " . $this->filePath);
            }

            $fileContent = Storage::get($this->filePath);
            Log::info('CSV file content read', ['length' => strlen($fileContent)]);

            $rows = array_map('str_getcsv', explode("\n", $fileContent));
            Log::info('CSV rows parsed', ['total_rows' => count($rows)]);

            // Remove header row
            $headers = array_shift($rows);
            Log::info('CSV headers', ['headers' => $headers]);

            $importedCount = 0;
            $skippedCount = 0;
            foreach ($rows as $row) {
                // Skip empty rows
                if (empty($row) || empty($row[0])) {
                    continue;
                }

                // Use firstOrCreate to prevent duplicates
                $user = ImportedUser::firstOrCreate(
                    [
                        'first_name' => $row[0] ?? '',
                        'last_name' => $row[1] ?? '',
                        'telephone' => $row[2] ?? '',
                    ],
                    [
                        'verified' => false
                    ]
                );

                if ($user->wasRecentlyCreated) {
                    Log::info('ImportedUser created', ['id' => $user->id, 'first_name' => $row[0]]);
                    $importedCount++;
                } else {
                    Log::info('ImportedUser already exists, skipped', ['id' => $user->id, 'first_name' => $row[0]]);
                    $skippedCount++;
                }
            }

            Log::info('CSV import completed', ['imported_count' => $importedCount, 'skipped_count' => $skippedCount]);

            // Clean up the file after processing
            Storage::delete($this->filePath);

        } catch (\Exception $e) {
            // Log the error
            Log::error('CSV Import Error: ' . $e->getMessage());
            throw $e;
        }
    }
}

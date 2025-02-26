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
            if (!Storage::exists($this->filePath)) {
                throw new \Exception("CSV file not found at path: " . $this->filePath);
            }

            $fileContent = Storage::get($this->filePath);
            $rows = array_map('str_getcsv', explode("\n", $fileContent));
            
            // Remove header row
            $headers = array_shift($rows);
            
            foreach ($rows as $row) {
                // Skip empty rows
                if (empty($row) || empty($row[0])) {
                    continue;
                }
                
                ImportedUser::create([
                    'first_name' => $row[0] ?? '',
                    'last_name' => $row[1] ?? '',
                    'telephone' => $row[2] ?? '',
                    'verified' => false
                ]);
            }

            // Clean up the file after processing
            Storage::delete($this->filePath);
            
        } catch (\Exception $e) {
            // Log the error
            Log::error('CSV Import Error: ' . $e->getMessage());
            throw $e;
        }
    }
}

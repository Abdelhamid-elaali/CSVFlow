<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCsvImport;
use App\Models\ImportedUser;
use App\Models\VerifiedUser;
use Illuminate\Http\Request;

class CsvImportController extends Controller
{
    public function index()
    {
        return view('csv.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $path = $file->store('CSV');

        \Log::info('CSV file uploaded', ['path' => $path, 'original_name' => $file->getClientOriginalName()]);

        ProcessCsvImport::dispatch($path);

        \Log::info('ProcessCsvImport job dispatched', ['path' => $path]);

        return redirect()->route('csv.verify')->with('message', 'Importation in progress');
    }

    public function verify()
    {
        $users = ImportedUser::where('verified', false)->get();
        return view('csv.verify', compact('users'));
    }

    public function confirm(Request $request)
    {
        $ids = $request->input('verified_ids', []);

        // Check if any records were selected
        if (empty($ids)) {
            return redirect()->route('csv.verify')->with('warning', 'Please select at least one record to confirm.');
        }

        // Get selected users from imported_users
        $usersToVerify = ImportedUser::whereIn('id', $ids)->get();

        // Save each user to verified_users table
        foreach ($usersToVerify as $user) {
            VerifiedUser::create([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'telephone' => $user->telephone,
                'verified_at' => now(),
            ]);
        }

        // Mark as verified in imported_users
        ImportedUser::whereIn('id', $ids)->update(['verified' => true]);

        $count = count($ids);
        return redirect()->route('csv.verify')->with('message', $count . ' ' . ($count === 1 ? 'record has' : 'records have') . ' been verified and saved');
    }
}

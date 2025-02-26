<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessCsvImport;
use App\Models\ImportedUser;
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

        ProcessCsvImport::dispatch($path);

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
        ImportedUser::whereIn('id', $ids)->update(['verified' => true]);

        return redirect()->route('csv.verify')->with('message', 'Selected records have been verified');
    }
}

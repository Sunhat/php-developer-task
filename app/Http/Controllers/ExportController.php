<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Course;
use App\Models\Student;
use App\Models\DownloadLog;
use App\Services\StudentCSVOutput;
use Illuminate\Http\Request;
use Bueltge\Marksimple\Marksimple;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\ExportSelectedDownloadLogRequest;
use App\Http\Requests\ExportSelectedStudentsRequest;

class ExportController extends Controller
{
    public function __construct()
    {
        // Only to test in the browser api auth
        Auth::loginUsingId(1);
    }

    public function welcome()
    {
        $ms = new Marksimple();

        return view('hello', [
            'content' =>  $ms->parseFile('../README.md'),
        ]);
    }

    /**
     * View all students found in the database
     */
    public function viewStudents()
    {
        $students = Student::with('course')->get();

        return view('view_students', compact(['students']));
    }

    /**
     * View all students found in the database
     */
    public function viewDownloadHistory()
    {
        $downloads = DownloadLog::all();

        return view('view_downloads', compact(['downloads']));
    }

    /**
     * View all students found in the database
     */
    public function exportDownloadLog($id)
    {
        try {
            $download = DownloadLog::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['Could not find Download Log item.']);
        }
        $path = Storage::disk('local')->path($download->path);
        return response()->download($path, $download->download_name);
    }

    /**
     * Exports selected students data to a CSV file
     */
    public function export(ExportSelectedStudentsRequest $request)
    {
        $students = Student::whereIn('id', $request->studentId)->with('course')->get();

        $csv = new StudentCSVOutput($students);
        $location = $csv->save();

        DownloadLog::create([
            'path' => $csv->getShortStoragePath(),
            'download_name' => $csv->getDownloadFilename(),
        ]);
        
        return response()->download($location, $csv->getDownloadFilename());
    }

    /**
     * Exports all student data to a CSV file
     */
    public function exportStudentsToCSV()
    {
        $students = Student::with('course')->all();

        $csv = new StudentCSVOutput($students);
        $location = $csv->save();

        // $csv = CSVOutput::fromCSV('', Student::class);
        // $csv = CSVOutput::fromModel($students);
        // $csv = CSVOutput::fromFile('test.csv', Student::class);

        DownloadLog::create([
            'path' => $csv->getShortStoragePath(),
            'download_name' => $csv->getDownloadFilename(),
        ]);
        
        return response()->download($location, $csv->getDownloadFilename());
    }
}

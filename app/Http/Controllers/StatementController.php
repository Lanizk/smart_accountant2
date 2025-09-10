<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Class;
use App\Models\Term;
use Illuminate\Support\Facades\Storage;

class StatementController extends Controller
{


    public function single(Student $student)
    {
        $invoices = $student->invoices()->with(['items', 'payments'])->get();

        $pdf = Pdf::loadView('statements.single', compact('student', 'invoices'));
        return $pdf->download("Statement-{$student->name}.pdf");
    }


    public function bulk(Request $request)
    {
    $query = Student::with(['invoices.items', 'invoices.payments']);

    // Apply filters
    if ($request->has('class_id')) {
        $query->where('class_id', $request->class_id);
    }

    if ($request->has('term_id')) {
        $query->whereHas('invoices', function($q) use ($request) {
            $q->where('term_id', $request->term_id);
        });
    }

    $students = $query->get();

    if ($students->isEmpty()) {
        return back()->with('error', 'No students found for the selected filters.');
    }

    $zipFileName = 'Statements-' . now()->format('Y-m-d') . '.zip';
    $zipPath = storage_path("app/public/{$zipFileName}");

    $zip = new ZipArchive;
    if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
        foreach ($students as $student) {
            $pdf = Pdf::loadView('statements.single', [
                'student' => $student,
                'invoices' => $student->invoices()->where('term_id', $request->term_id)->get(),
            ]);

            $pdfPath = "Statement-{$student->name}.pdf";
            $zip->addFromString($pdfPath, $pdf->output());
        }
        $zip->close();
    }

    return response()->download($zipPath);
}


}

<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    

    class FileController extends Controller
    {
        public function upload(Request $request)
        {
            $request->validate([
                'file' => 'required|mimes:pdf|max:10240', // Max 10MB
            ]);

            $file = $request->file('file');

            $filename = time() . '-' . $file->getClientOriginalName();

            $path = $file->storeAs('public/uploads', $filename);

            return back()->with('success', 'PDF uploaded successfully')->with('file', basename($path));
        }

        public function download($file)
        {
            $filePath = storage_path('app/public/uploads/' . $file);

            if (file_exists($filePath)) {
                return response()->download($filePath);
            } else {
                abort(404);
            }
        }
    }

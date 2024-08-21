<?php

namespace App\Http\Controllers;

use App\Models\ApplicationAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationAttachmentController extends Controller
{
    public function index($applicationId)
    {
        $attachments = ApplicationAttachment::where('ApplicationID', $applicationId)->get();
        return response()->json($attachments, 200);
    }

    public function show($applicationId, $id)
    {
        $attachment = ApplicationAttachment::where('ApplicationID', $applicationId)->where('AttachmentID', $id)->firstOrFail();
        return response()->json($attachment, 200);
    }

    public function store(Request $request, $applicationId)
    {
        $request->validate([
            'Files' => 'required|array',
            'Files.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $attachments = [];

        foreach ($request->file('Files') as $file) {
            $originalFileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $originalFileName, 'public');

            $attachment = ApplicationAttachment::create([
                'ApplicationID' => $applicationId,
                'FilePath' => $filePath,
            ]);

            $attachments[] = $attachment;
        }

        return response()->json($attachments, 201);
    }

    public function destroy($applicationId, $id)
    {
        $attachment = ApplicationAttachment::where('ApplicationID', $applicationId)->where('AttachmentID', $id)->firstOrFail();
        Storage::delete('public/' . $attachment->FilePath);
        $attachment->delete();

        return response()->json(['message' => 'Attachment deleted successfully'], 200);
    }

    public function download($applicationId, $id)
    {
        $attachment = ApplicationAttachment::where('ApplicationID', $applicationId)->where('AttachmentID', $id)->firstOrFail();
        $filePath = 'public/' . $attachment->FilePath;

        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        }

        return response()->json(['message' => 'File not found'], 404);
    }
}

<?php
// app/Http/Controllers/AttachmentController.php
 
namespace App\Http\Controllers;
 
use App\Models\TaskAttachment;
use Illuminate\Support\Facades\Storage;
 
class AttachmentController extends Controller
{
    public function destroy(TaskAttachment $attachment)
    {
        abort_if($attachment->task->user_id !== auth()->id(), 403);
        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();
 
        return back()->with('success', 'Lampiran berhasil dihapus!');
    }
}
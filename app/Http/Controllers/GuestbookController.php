<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GuestbookController extends Controller
{
    public function __construct()
    {
        // Check authentication before each method
        if (!session('admin_logged_in')) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $guestbooks = Guestbook::orderBy('visit_date', 'desc')->paginate(10);
        return view('guestbook.index', compact('guestbooks'));
    }

    public function create()
    {
        return view('guestbook.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'organization' => 'required|string|max:255',
            'visit_date' => 'required|date',
            'message' => 'required|string',
            'photo' => 'nullable|string',
        ]);

        $data = $request->except('photo');

        if ($request->filled('photo')) {
            $data['photo'] = $this->storeCameraPhoto($request->input('photo'));
        }

        Guestbook::create($data);
        return redirect()->route('guestbook.index')->with('success', 'Data tamu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $guestbook = Guestbook::findOrFail($id);
        return view('guestbook.edit', compact('guestbook'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'organization' => 'required|string|max:255',
            'visit_date' => 'required|date',
            'message' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $guestbook = Guestbook::findOrFail($id);
        $guestbook->update($request->all());
        return redirect()->route('guestbook.index')->with('success', 'Data tamu berhasil diperbarui');
    }

    public function destroy($id)
    {
        Guestbook::findOrFail($id)->delete();
        return redirect()->route('guestbook.index')->with('success', 'Data tamu berhasil dihapus');
    }

    public function export()
    {
        $guestbooks = Guestbook::all();
        $filename = 'guestbook-' . date('Y-m-d') . '.csv';

        $headers = array(
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        );

        $callback = function () use ($guestbooks) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama', 'Email', 'Telepon', 'Organisasi', 'Tanggal Kunjungan', 'Pesan', 'Status', 'Dibuat']);
            
            $no = 1;
            foreach ($guestbooks as $entry) {
                fputcsv($file, [
                    $no++,
                    $entry->name,
                    $entry->email,
                    $entry->phone,
                    $entry->organization,
                    $entry->visit_date,
                    $entry->message,
                    $entry->status,
                    $entry->created_at,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function storeCameraPhoto(string $photo): ?string
    {
        if (!preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $photo, $matches)) {
            return null;
        }

        $extension = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
        $image = base64_decode(substr($photo, strpos($photo, ',') + 1), true);

        if ($image === false) {
            return null;
        }

        $path = 'guestbook-photos/' . Str::uuid() . '.' . $extension;
        Storage::disk('public')->put($path, $image);

        return $path;
    }
}

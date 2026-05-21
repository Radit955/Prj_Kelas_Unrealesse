<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(15);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title'   => 'required|string|max:255',
            'body'    => 'required|string',
            'type'    => 'required|in:info,warning,danger',
            'pinned'  => 'nullable|boolean',
        ];

        if (Schema::hasColumn('announcements','display_mode')) {
            $rules['display_mode'] = 'nullable|in:notification,dashboard,fullscreen';
            $rules['closeable']    = 'nullable|boolean';
            $rules['expires_at']   = 'nullable|date';
        }

        $data = $request->validate($rules);
        $data['pinned']    = $request->boolean('pinned');
        $data['closeable'] = $request->boolean('closeable', true);
        if (isset($data['display_mode']) && !$data['display_mode']) {
            $data['display_mode'] = 'dashboard';
        }
        $data['created_by'] = auth()->id();
        $data['published_at'] = now();

        Announcement::create($data);

        return redirect()->route('admin.announcements.index')->with('success','Pengumuman berhasil dibuat.');
    }

    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $rules = [
            'title'   => 'required|string|max:255',
            'body'    => 'required|string',
            'type'    => 'required|in:info,warning,danger',
            'pinned'  => 'nullable|boolean',
        ];

        if (Schema::hasColumn('announcements','display_mode')) {
            $rules['display_mode'] = 'nullable|in:notification,dashboard,fullscreen';
            $rules['closeable']    = 'nullable|boolean';
            $rules['expires_at']   = 'nullable|date';
        }

        $data = $request->validate($rules);
        $data['pinned']    = $request->boolean('pinned');
        $data['closeable'] = $request->boolean('closeable', true);
        if (isset($data['display_mode']) && !$data['display_mode']) {
            $data['display_mode'] = 'dashboard';
        }

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')->with('success','Pengumuman diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements.index')->with('success','Pengumuman dihapus.');
    }
}

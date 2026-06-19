<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->get();

        return view('admin.notifications', compact('notifications'));
    }

    public function read($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->update([
            'status' => 'Sudah Dibaca',
        ]);

        return redirect()->route('admin.notifications')
            ->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notifications')
            ->with('success', 'Notifikasi berhasil dihapus.');
    }
}
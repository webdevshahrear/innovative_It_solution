<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::latest()->paginate(15);
        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function update(Request $request, Subscriber $subscriber)
    {
        $request->validate([
            'status' => 'required|in:active,unsubscribed'
        ]);

        $subscriber->update(['status' => $request->status]);

        return back()->with('success', 'Subscriber status updated.');
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'Subscriber deleted successfully.');
    }
}

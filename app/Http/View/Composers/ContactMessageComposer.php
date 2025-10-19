<?php

namespace App\Http\View\Composers;

use App\Models\ContactMessage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ContactMessageComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            $unreadMessagesCount = ContactMessage::where('status', 'unread')->count();
            $recentMessages = ContactMessage::latest()->take(3)->get();

            $view->with('unreadMessagesCount', $unreadMessagesCount);
            $view->with('recentMessages', $recentMessages);
        } else {
            // Provide default values for non-admin users
            $view->with('unreadMessagesCount', 0);
            $view->with('recentMessages', collect());
        }
    }
}
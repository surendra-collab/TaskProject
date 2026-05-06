<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $shortUrlsQuery = ShortUrl::query()->with('user.company');
        
        if ($user->role === 'admin') {
            $shortUrlsQuery->where('company_id', $user->company_id);
        } elseif ($user->role === 'member') {
            $shortUrlsQuery->where('user_id', $user->id);
        }

        $shortUrls = $shortUrlsQuery->latest()->limit(10)->get();
        $teamMembers = collect();
        if ($user->role === 'admin') {
            $teamMembers = User::query()->where('company_id', $user->company_id)->where('id', '!=', $user->id)->orderBy('name')->get();
        }

        $clients = collect();
        if ($user->role === 'super_admin') {
            $clients = User::query()->whereIn('role', ['admin', 'member'])->with('company')
                ->orderBy('name')->get();
        }

        $invitations = Invitation::where('inviter_id', $user->id)->latest()->limit(10)->get();

        return view('dashboard', compact('shortUrls', 'teamMembers', 'clients', 'invitations'));
    }
}

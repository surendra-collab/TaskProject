<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class ShortUrlController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = ShortUrl::query()->with('user.company');

        if ($user->role === User::ROLE_SUPER_ADMIN) {
            $query->whereRaw('1 = 0');
        } elseif ($user->role === User::ROLE_ADMIN) {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('company_id', '!=', $user->company_id)->orWhereNull('company_id');
            });
        } elseif ($user->role === User::ROLE_MEMBER) {
            $query->where('user_id', '!=', $user->id);
        }

        $shortUrls = $query->latest()->get();

        return view('short_urls.index', compact('shortUrls'));
    }

    public function create(Request $request)
    {
        $this->authorizeCreate($request->user());

        return view('short_urls.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();
        try {
                $validator = Validator::make($request->all(), [
                    'original_url'   => 'required',                   
                ]);

                if($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }else{
                    ShortUrl::create([
                        'user_id' => $user->id,
                        'original_url' => $request->original_url,
                        'company_id' => $user->company_id,
                        'code' => Str::lower(Str::random(8)),
                    ]);
                    Session::flash('success', 'Short URL created successfully');
                    return redirect()->route('dashboard');
                }
            } catch (\Exception $e) {
                Session::flash('error', $e->getMessage());
                return back()->withErrors(['original_url' => $e->getMessage()])->withInput();
            }
    }

    public function resolve(Request $request, string $code)
    {
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        return redirect()->away($shortUrl->original_url);
    }

}

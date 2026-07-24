<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        $canCreate = $user->role != 'SuperAdmin';

        if ($user->role == 'SuperAdmin') {
            $urls = DB::table('urls')->get();
        } elseif ($user->role == 'Admin') {
            $urls = DB::table('urls')
                ->where('company_id', $user->company_id)
                ->get();
        } else {
            $urls = DB::table('urls')
                ->where('user_id', $user->id)
                ->get();
        }

        return view('url', compact('urls', 'canCreate'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role == 'SuperAdmin') {
            abort(403);
        }

        $request->validate([
            'original_url' => ['required', 'url'],
        ]);

        $originalUrl = $request->input('original_url');

        do {
            $shortCode = Str::random(6);
        } while (DB::table('urls')->where('short_code', $shortCode)->exists());

        DB::table('urls')->insert([
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'original_url' => $originalUrl,
            'short_code' => $shortCode,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()
            ->with('success', 'URL Created Successfully')
            ->with('original_url', $originalUrl)
            ->with('generated_url', url('/u/' . $shortCode));
    }

    public function redirectUrl($code)
    {
        $url = DB::table('urls')->where('short_code', $code)->first();

        if ($url) {
            return redirect($url->original_url);
        }

        abort(404);
    }
}

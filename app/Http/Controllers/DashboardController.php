<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $urls = collect();
        $members = collect();
        $clients = collect();

        if ($user->role == 'SuperAdmin') {
            $clients = DB::table('companies')
                ->leftJoin('users', 'companies.id', '=', 'users.company_id')
                ->select('companies.id', 'companies.name', DB::raw('count(users.id) as users_count'))
                ->groupBy('companies.id', 'companies.name')
                ->get();

            $urls = DB::table('urls')
                ->join('users', 'urls.user_id', '=', 'users.id')
                ->join('companies', 'urls.company_id', '=', 'companies.id')
                ->select('urls.*', 'users.name as user_name', 'companies.name as company_name')
                ->latest('urls.created_at')
                ->get();
        } elseif ($user->role == 'Admin') {
            $members = DB::table('users')
                ->where('company_id', $user->company_id)
                ->where('role', '!=', 'SuperAdmin')
                ->orderByRaw("CASE role WHEN 'Admin' THEN 0 WHEN 'Member' THEN 1 ELSE 2 END")
                ->orderBy('name')
                ->get();

            $urls = DB::table('urls')
                ->join('users', 'urls.user_id', '=', 'users.id')
                ->select('urls.*', 'users.name as user_name')
                ->where('urls.company_id', $user->company_id)
                ->latest('urls.created_at')
                ->get();
        } else {
            $urls = DB::table('urls')
                ->where('user_id', $user->id)
                ->latest('created_at')
                ->get();
        }

        return view('dashboard', compact('urls', 'members', 'clients'));
    }
}

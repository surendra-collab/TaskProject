<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $invitations = Invitation::where('inviter_id', $user->id)->with(['company', 'inviter'])->latest()->get();

        return view('invitations.index', compact('invitations'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();

        return view('invitations.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'role' => ['required', 'in:admin,member'],
            'company_id' => ['nullable', 'integer', 'exists:companies,id'],
            'new_company_name' => ['nullable', 'string', 'max:255'],
        ]);

        $creatingNewCompany = filled($data['new_company_name'] ?? null);
        
        if ($creatingNewCompany) {

            $chk = Company::where('name', $data['new_company_name'])->first();
            if($chk) {
                return back()->withErrors(['new_company_name' => 'Company name already exists.'])->withInput();
            }
            $company = Company::firstOrCreate(['name' => $data['new_company_name']]);
        }
        $companyId = ($request->company_id) ? $request->company_id :  $company->id;

        Invitation::create([
            'inviter_id' => $user->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'company_id' => $companyId,
        ]);

        $inviteUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make('password'),
            'role' => $data['role'],
            'company_id' => $companyId ?? null,
        ]);

       //after smtp started, send email notification to the inviter and invited user

        return redirect()->route('invitations.index');
    }
}

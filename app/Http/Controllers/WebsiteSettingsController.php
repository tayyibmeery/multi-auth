<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyInformation;
use Illuminate\Http\Request;

class WebsiteSettingsController extends Controller
{
    public function dashboard()
    {
        $company = CompanyInformation::first();
        return view('admin.website.dashboard', compact('company'));
    }

    public function company()
    {
        $company = CompanyInformation::first();
        return view('admin.website.company', compact('company'));
    }

    public function updateCompany(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'about' => 'required|string',
            'mission' => 'required|string',
            'vision' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'working_hours' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
        ]);

        $company = CompanyInformation::first();

        if ($company) {
            $company->update($validated);
        } else {
            CompanyInformation::create($validated);
        }

        return redirect()->route('admin.company.index')->with('success', 'Company information updated successfully.');
    }
}
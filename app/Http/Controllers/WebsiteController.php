<?php
namespace App\Http\Controllers;

use App\Models\ServiceProduct;
use App\Models\CompanyInformation;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function home()
    {
        $products = ServiceProduct::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $company = CompanyInformation::first();
        $featuredProducts = ServiceProduct::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->get();

        return view('website.home', compact('products', 'company', 'featuredProducts'));
    }

    public function about()
    {
        $company = CompanyInformation::first();
        return view('website.about', compact('company'));
    }

    public function products()
    {
        $products = ServiceProduct::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $company = CompanyInformation::first();
        return view('website.products', compact('products', 'company'));
    }

    public function contact()
    {
        $company = CompanyInformation::first();
        return view('website.contact', compact('company'));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        ContactMessage::create($validated);

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
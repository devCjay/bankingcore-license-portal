<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\LicenseVerification;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function index()
    {
        return view('licenses.index', [
            'licenses' => License::latest()->paginate(15),
            'total' => License::count(),
            'active' => License::where('status', 'active')->count(),
            'suspended' => License::where('status', 'suspended')->count(),
            'verifications' => LicenseVerification::latest()->limit(8)->get(),
        ]);
    }

    public function create()
    {
        return view('licenses.form', [
            'license' => new License([
                'license_key' => License::generateKey(),
                'product_name' => 'BankCore',
                'status' => 'active',
                'max_activations' => 1,
            ]),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        License::create($this->validatedData($request));

        return redirect()->route('licenses.index')->with('success', 'License created successfully.');
    }

    public function edit(License $license)
    {
        return view('licenses.form', [
            'license' => $license,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, License $license)
    {
        $license->update($this->validatedData($request, $license));

        return redirect()->route('licenses.index')->with('success', 'License updated successfully.');
    }

    public function destroy(License $license)
    {
        $license->delete();

        return redirect()->route('licenses.index')->with('success', 'License deleted successfully.');
    }

    private function validatedData(Request $request, ?License $license = null): array
    {
        $id = $license ? $license->id : 'NULL';

        $data = $request->validate([
            'license_key' => ['required', 'string', 'max:190', 'unique:licenses,license_key,' . $id],
            'customer_name' => ['nullable', 'string', 'max:190'],
            'customer_email' => ['nullable', 'email', 'max:190'],
            'product_name' => ['required', 'string', 'max:190'],
            'domain' => ['nullable', 'string', 'max:190'],
            'allowed_domains' => ['nullable', 'string'],
            'status' => ['required', 'in:active,suspended,expired'],
            'max_activations' => ['required', 'integer', 'min:1', 'max:100'],
            'expires_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['allowed_domains'] = collect(preg_split('/\r\n|\r|\n|,/', $data['allowed_domains'] ?? ''))
            ->map(fn ($domain) => strtolower(trim($domain)))
            ->filter()
            ->unique()
            ->values()
            ->all();

        return $data;
    }
}

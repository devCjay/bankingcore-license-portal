<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\LicenseVerification;
use Illuminate\Http\Request;

class LicenseVerificationController extends Controller
{
    public function verify(Request $request)
    {
        $data = $request->validate([
            'license_key' => ['required', 'string'],
            'domain' => ['nullable', 'string', 'max:190'],
            'email' => ['nullable', 'email', 'max:190'],
            'product' => ['nullable', 'string', 'max:190'],
        ]);

        $domain = $this->normalizeDomain($data['domain'] ?? $request->getHost());
        $license = License::where('license_key', $data['license_key'])->first();
        $result = $this->validateLicense($license, $domain, $data['email'] ?? null, $data['product'] ?? null);

        LicenseVerification::create([
            'license_id' => $license?->id,
            'license_key' => $data['license_key'],
            'domain' => $domain,
            'email' => $data['email'] ?? null,
            'ip_address' => $request->ip(),
            'status' => $result['valid'] ? 'valid' : 'invalid',
            'message' => $result['message'],
            'payload' => $data,
        ]);

        if ($result['valid'] && $license) {
            $license->forceFill([
                'last_verified_at' => now(),
                'activation_count' => max($license->activation_count, count($license->domains())),
            ])->save();
        }

        return response()->json($result, $result['valid'] ? 200 : 422);
    }

    private function validateLicense(?License $license, string $domain, ?string $email, ?string $product): array
    {
        if (!$license) {
            return ['valid' => false, 'message' => 'License key was not found.'];
        }

        if ($license->status !== 'active') {
            return ['valid' => false, 'message' => 'License is ' . $license->status . '.'];
        }

        if ($license->isExpired()) {
            return ['valid' => false, 'message' => 'License has expired.'];
        }

        if ($product && strcasecmp($license->product_name, $product) !== 0) {
            return ['valid' => false, 'message' => 'License is not valid for this product.'];
        }

        if ($email && $license->customer_email && strcasecmp($license->customer_email, $email) !== 0) {
            return ['valid' => false, 'message' => 'License email does not match.'];
        }

        $domains = array_map(fn ($item) => $this->normalizeDomain($item), $license->domains());

        if (!$domains) {
            $license->forceFill([
                'domain' => $domain,
                'allowed_domains' => [$domain],
                'activation_count' => 1,
            ])->save();

            return ['valid' => true, 'message' => 'License verified and bound to domain.', 'license_status' => 'active'];
        }

        if (in_array($domain, $domains, true)) {
            return ['valid' => true, 'message' => 'License verified successfully.', 'license_status' => 'active'];
        }

        if (count($domains) < $license->max_activations) {
            $domains[] = $domain;
            $license->forceFill([
                'allowed_domains' => array_values(array_unique($domains)),
                'activation_count' => count(array_unique($domains)),
            ])->save();

            return ['valid' => true, 'message' => 'License verified and added to allowed domains.', 'license_status' => 'active'];
        }

        return ['valid' => false, 'message' => 'License activation limit reached for this domain.'];
    }

    private function normalizeDomain(string $domain): string
    {
        $domain = strtolower(trim($domain));
        $domain = preg_replace('#^https?://#', '', $domain);

        return rtrim(explode('/', $domain)[0], '/');
    }
}

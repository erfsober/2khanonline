<?php

namespace App\Http\Controllers\khanonline;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\ContactUs;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function aboutUs(): View
    {
        $aboutUs = AboutUs::query()->first();

        abort_if($aboutUs === null, 404);

        return view('2khanonline.about-us.index', [
            'aboutUs' => $aboutUs,
            'imageUrl' => $aboutUs->getFirstMediaUrl('img') ?: null,
        ]);
    }

    public function contactUs(): View
    {
        $contactUs = ContactUs::query()->first();

        abort_if($contactUs === null, 404);

        $telegram = $contactUs->telegram ?? null;
        $whatsApp = $contactUs->whatsapp ?? null;
        $location = trim((string) ($contactUs->location ?? ''));

        $lat = null;
        $lng = null;
        $hasLocation = false;

        if ($location !== '' && str_contains($location, ',')) {
            $parts = explode(',', $location);
            $parsedLat = floatval($parts[0] ?? 0);
            $parsedLng = floatval($parts[1] ?? 0);

            if ($parsedLat !== 0.0 && $parsedLng !== 0.0) {
                $lat = $parsedLat;
                $lng = $parsedLng;
                $hasLocation = true;
            }
        }

        return view('2khanonline.contact-us.index', [
            'contactUs' => $contactUs,
            'telegram' => $telegram,
            'whatsApp' => $whatsApp,
            'telegramUrl' => $this->telegramUrl($telegram),
            'whatsAppUrl' => $this->whatsAppUrl($whatsApp),
            'hasLocation' => $hasLocation,
            'lat' => $lat,
            'lng' => $lng,
        ]);
    }

    private function telegramUrl(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            $host = parse_url($value, PHP_URL_HOST);

            return Str::contains((string) $host, ['telegram.me', 't.me']) ? $value : null;
        }

        $username = ltrim($value, '@');

        return $username !== '' ? 'https://t.me/' . $username : null;
    }

    private function whatsAppUrl(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            $host = parse_url($value, PHP_URL_HOST);

            return Str::contains((string) $host, ['wa.me', 'whatsapp.com']) ? $value : null;
        }

        $phone = preg_replace('/[^0-9+]/', '', $value);
        $phone = ltrim((string) $phone, '+');

        return $phone !== '' ? 'https://wa.me/' . $phone : null;
    }
}

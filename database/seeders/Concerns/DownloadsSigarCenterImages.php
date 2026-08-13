<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Spatie\MediaLibrary\HasMedia;

trait DownloadsSigarCenterImages
{
    protected function sigarCenterImageUrl(string $key): string
    {
        return [
            'marlboro-filter-plus-extra' => 'https://sigarcenter.com/wp-content/uploads/2026/06/marlboro-filter-plus-extra-1-e1781031024290.webp',
            'marlboro-red' => 'https://sigarcenter.com/wp-content/uploads/2025/03/marlboro-red-100s-cigarette-e1743120262851.webp',
            'marlboro-gold' => 'https://sigarcenter.com/wp-content/uploads/2026/03/marlboro-gold-arabic-cigarette-e1779622666722.webp',
            'marlboro-shuffle' => 'https://sigarcenter.com/wp-content/uploads/2026/04/marlboro-shuffle-arab-back-cigarette.webp',
            'marlboro-flavor-code' => 'https://sigarcenter.com/wp-content/uploads/2026/02/marlboro-flavor-code-cigarette.webp',
            'marlboro-gold-touch' => 'https://sigarcenter.com/wp-content/uploads/2025/08/marlboro-gold-touch-cigarette-1.webp',
            'marlboro-edge' => 'https://sigarcenter.com/wp-content/uploads/2025/04/marlboro-edge-blue-cigarette.webp',
            'marlboro-edge-prime' => 'https://sigarcenter.com/wp-content/uploads/2026/02/marlboro-edge-prime-cigarette.webp',
            'captain-black-dark-crema' => 'https://sigarcenter.com/wp-content/uploads/2025/02/Captain-Black-Little-Cigars-Dark-Crema.webp',
            'captain-black-grape' => 'https://sigarcenter.com/wp-content/uploads/2025/02/Captain-Black-Little-Cigars-Grape.webp',
            'captain-black-peach' => 'https://sigarcenter.com/wp-content/uploads/2025/02/Captain-Black-Little-Cigars-Peach.webp',
            'captain-black-mango' => 'https://sigarcenter.com/wp-content/uploads/2025/02/Captain-Black-Little-Cigars-Mango.webp',
            'captain-black-cherise' => 'https://sigarcenter.com/wp-content/uploads/2025/02/Captain-Black-Little-Cigars-Cherise.webp',
            'chapman-cherry' => 'https://sigarcenter.com/wp-content/uploads/2025/03/chapman-cherry-no-3-nano-cigarette-e1742980538272.webp',
            'chapman-vanilla' => 'https://sigarcenter.com/wp-content/uploads/2025/03/chapman-vanilla-no-2-king-cigarette-e1743002780969.webp',
            'esse-lights' => 'https://sigarcenter.com/wp-content/uploads/2025/03/esse-blue-lights-cigarette-e1742977507402.webp',
            'esse-black' => 'https://sigarcenter.com/wp-content/uploads/2025/03/esse-black-cigarette-e1742909115979.webp',
            '520-green' => 'https://sigarcenter.com/wp-content/uploads/2025/03/520-2-ways-green-cigarette-e1743064350688.webp',
            '520-purple' => 'https://sigarcenter.com/wp-content/uploads/2025/03/520-2-ways-purple-cigarette-e1743065365911.webp',
            'gtm-double-apple' => 'https://sigarcenter.com/wp-content/uploads/2026/06/GTM-Double-Apple-e1782292710253.webp',
            'gtm-cherry' => 'https://sigarcenter.com/wp-content/uploads/2026/06/GTM-Cherry-filter-cigarette--e1781769168877.webp',
            'milano-vanilla' => 'https://sigarcenter.com/wp-content/uploads/2025/12/milano-vanilla-cigarette.webp',
            'milano-strawberry' => 'https://sigarcenter.com/wp-content/uploads/2025/12/milano-strawberry-cigarette.webp',
            'maddox-nano' => 'https://sigarcenter.com/wp-content/uploads/2025/03/maddox-sweet-blend-nano-black-cigarette-e1743003284403.webp',
            'oscar-black' => 'https://sigarcenter.com/wp-content/uploads/2025/02/Oscar-Black-Nano-e1743163442181.webp',
            'teton-peach' => 'https://sigarcenter.com/wp-content/uploads/2026/08/teton-peach-e1786086892798.png',
        ][$key] ?? 'https://sigarcenter.com/wp-content/uploads/2025/03/marlboro-red-100s-cigarette-e1743120262851.webp';
    }

    protected function addSigarCenterImage(HasMedia $model, string $url, string $name): void
    {
        $path = $this->downloadSigarCenterImage($url);

        $model->addMedia($path)
            ->usingName($name)
            ->withCustomProperties(['source_url' => $url])
            ->toMediaCollection('image');
    }

    protected function downloadSigarCenterImage(string $url): string
    {
        $extension = pathinfo(parse_url($url, PHP_URL_PATH) ?: '', PATHINFO_EXTENSION) ?: 'webp';
        $directory = storage_path('app/seed-images');
        $path = $directory.'/'.md5($url).'.'.$extension;

        File::ensureDirectoryExists($directory);

        if (! File::exists($path)) {
            try {
                $response = Http::retry(2, 250)->timeout(20)->get($url);

                if ($response->successful()) {
                    File::put($path, $response->body());
                }
            } catch (\Throwable $e) {
                // Silently fall back when the source site is unreachable.
            }
        }

        if (File::exists($path)) {
            return $path;
        }

        // Keep local seeding usable when the source site is temporarily unavailable.
        $fallback = public_path('assets/img/products/1.png');

        if (! File::exists($fallback)) {
            throw new \RuntimeException("Unable to download seed image: {$url}");
        }

        return $fallback;
    }
}

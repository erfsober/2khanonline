<?php

namespace App\Services\Sms;

use App\Exceptions\OtpException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MedianaService
{
    private readonly string $apiKey;
    private readonly string $baseUrl;
    private readonly string $patternCode;

    public function __construct()
    {
        $this->apiKey = config('services.mediana.api_key', '');
        $this->baseUrl = config('services.mediana.base_url', 'https://api.mediana.ir');
        $this->patternCode = config('services.mediana.pattern_code', '');
    }

    public function sendOtp(string $phone, string $code): void
    {
        if (empty($this->apiKey)) {
            throw OtpException::smsFailed('سرویس پیامک پیکربندی نشده است.');
        }

        if (empty($this->patternCode)) {
            throw OtpException::smsFailed('الگوی پیامک پیکربندی نشده است.');
        }

        try {
            $response = $this->client()->post($this->baseUrl.'/sms/v1/send/otp', [
                'patternCode' => $this->patternCode,
                'recipient' => $phone,
                'otp' => $code,
            ]);

            $this->handleResponse($response);
        } catch (OtpException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('Mediana SMS failed', [
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);

            throw OtpException::smsFailed();
        }
    }

    private function client(): PendingRequest
    {
        return Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'Accept' => 'application/json',
        ])->timeout(10);
    }

    private function handleResponse(Response $response): void
    {
        if ($response->successful()) {
            return;
        }

        $body = $response->json();
        $message = $body['message'] ?? $body['error'] ?? null;

        Log::warning('Mediana SMS API error', [
            'status' => $response->status(),
            'message' => $message,
        ]);

        throw OtpException::smsFailed($message);
    }
}

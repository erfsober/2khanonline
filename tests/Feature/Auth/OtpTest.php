<?php

namespace Tests\Feature\Auth;

use App\Exceptions\OtpException;
use App\Models\Otp;
use App\Services\Auth\OtpService;
use App\Services\Sms\MedianaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Mockery;
use Tests\TestCase;

class OtpTest extends TestCase
{
    use RefreshDatabase;

    private string $phone = '09123456789';

    private function mockSms(?MedianaService $mock = null): void
    {
        $this->app->bind(MedianaService::class, fn () => $mock ?? $this->noopSms());
    }

    private function noopSms(): MedianaService
    {
        $sms = Mockery::mock(MedianaService::class);
        $sms->shouldReceive('sendOtp')->andReturnNull();

        return $sms;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_otp_code_is_randomly_generated(): void
    {
        $this->mockSms();

        $codes = [];

        for ($i = 0; $i < 10; $i++) {
            Otp::query()->where('phone', $this->phone)->update([
                'verified_at' => now(),
                'created_at' => now()->subMinutes(5),
            ]);
            Cache::flush();

            $this->post(route('auth.phone'), ['phone' => $this->phone]);

            $otp = Otp::query()->where('phone', $this->phone)->latest()->first();
            $codes[] = $otp->code;
        }

        $uniqueCodes = array_unique($codes);
        $this->assertGreaterThan(1, count($uniqueCodes), 'OTP codes should be random');
    }

    public function test_otp_is_stored_in_database(): void
    {
        $this->mockSms();

        $this->post(route('auth.phone'), ['phone' => $this->phone]);

        $this->assertDatabaseHas('otps', [
            'phone' => $this->phone,
        ]);

        $otp = Otp::query()->where('phone', $this->phone)->first();
        $this->assertNotNull($otp->expires_at);
        $this->assertNull($otp->verified_at);
        $this->assertStringContainsString(':', $otp->code, 'Code should contain hash:salt');
    }

    public function test_expired_otp_is_rejected(): void
    {
        $salt = bin2hex(random_bytes(16));
        $otp = Otp::create([
            'phone' => $this->phone,
            'code' => hash('sha256', '12345'.$salt).':'.$salt,
            'expires_at' => now()->subMinutes(10),
        ]);

        $this->post(route('auth.verify'), [
            'phone' => $this->phone,
            'otp' => '12345',
        ]);

        $this->assertDatabaseMissing('otps', ['id' => $otp->id]);
    }

    public function test_wrong_otp_is_rejected(): void
    {
        $salt = bin2hex(random_bytes(16));
        Otp::create([
            'phone' => $this->phone,
            'code' => hash('sha256', '12345'.$salt).':'.$salt,
            'expires_at' => now()->addMinutes(5),
        ]);

        $this->post(route('auth.verify'), [
            'phone' => $this->phone,
            'otp' => '99999',
        ]);

        $otp = Otp::query()->where('phone', $this->phone)->first();
        $this->assertNull($otp->verified_at);
    }

    public function test_correct_otp_is_verified(): void
    {
        $salt = bin2hex(random_bytes(16));
        $code = '12345';
        Otp::create([
            'phone' => $this->phone,
            'code' => hash('sha256', $code.$salt).':'.$salt,
            'expires_at' => now()->addMinutes(5),
        ]);

        $this->post(route('auth.verify'), [
            'phone' => $this->phone,
            'otp' => $code,
        ]);

        $otp = Otp::query()->where('phone', $this->phone)->first();
        $this->assertNotNull($otp->verified_at);
        $this->assertTrue(auth()->guard('web')->check());
    }

    public function test_verified_otp_cannot_be_reused(): void
    {
        $salt = bin2hex(random_bytes(16));
        $code = '12345';
        Otp::create([
            'phone' => $this->phone,
            'code' => hash('sha256', $code.$salt).':'.$salt,
            'expires_at' => now()->addMinutes(5),
            'verified_at' => now(),
        ]);

        $this->post(route('auth.verify'), [
            'phone' => $this->phone,
            'otp' => $code,
        ]);

        $this->assertFalse(auth()->guard('web')->check());
    }

    public function test_send_otp_enforces_cooldown(): void
    {
        $this->mockSms();

        $this->post(route('auth.phone'), ['phone' => $this->phone]);

        $response = $this->post(route('auth.phone'), ['phone' => $this->phone]);

        $response->assertSessionHasErrors('resend');
    }

    public function test_send_otp_enforces_hourly_phone_limit(): void
    {
        $this->mockSms();

        for ($i = 0; $i < 5; $i++) {
            Otp::query()->where('phone', $this->phone)->update(['verified_at' => now()]);
            Cache::forget('otp_hourly_phone:'.$this->phone);
            Cache::forget('otp_cooldown:'.$this->phone);

            $this->post(route('auth.phone'), ['phone' => $this->phone]);
        }

        $response = $this->post(route('auth.phone'), ['phone' => $this->phone]);

        $response->assertSessionHasErrors('resend');
    }

    public function test_failed_verifications_trigger_lockout(): void
    {
        $salt = bin2hex(random_bytes(16));
        Otp::create([
            'phone' => $this->phone,
            'code' => hash('sha256', '12345'.$salt).':'.$salt,
            'expires_at' => now()->addMinutes(5),
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('auth.verify'), [
                'phone' => $this->phone,
                'otp' => '00000',
            ]);
        }

        $response = $this->post(route('auth.verify'), [
            'phone' => $this->phone,
            'otp' => '12345',
        ]);

        $response->assertSessionHasErrors('otp');
        $this->assertFalse(auth()->guard('web')->check());
    }

    public function test_mediana_api_is_called_with_correct_payload(): void
    {
        config(['services.mediana.api_key' => 'test-key', 'services.mediana.pattern_code' => 'test-pattern']);
        Http::fake(['*' => Http::response(['status' => 'ok'], 200)]);

        $sms = new MedianaService();
        $sms->sendOtp('09123456789', '12345');

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.mediana.ir/sms/v1/send/otp'
                && $request->hasHeader('X-API-KEY', 'test-key')
                && $request->data()['recipient'] === '09123456789'
                && $request->data()['otp'] === '12345'
                && $request->data()['patternCode'] === 'test-pattern';
        });
    }

    public function test_mediana_api_failure_throws_exception(): void
    {
        config(['services.mediana.api_key' => 'test-key', 'services.mediana.pattern_code' => 'test-pattern']);
        Http::fake(['*' => Http::response(['message' => 'Invalid API key'], 401)]);

        $sms = new MedianaService();

        $this->expectException(OtpException::class);
        $sms->sendOtp('09123456789', '12345');
    }

    public function test_previous_otps_are_invalidated_on_new_send(): void
    {
        $this->mockSms();

        $salt = bin2hex(random_bytes(16));
        $oldOtp = Otp::create([
            'phone' => $this->phone,
            'code' => hash('sha256', '11111'.$salt).':'.$salt,
            'expires_at' => now()->addMinutes(5),
        ]);
        Otp::query()->where('id', $oldOtp->id)->update(['created_at' => now()->subMinutes(5)]);

        $this->post(route('auth.phone'), ['phone' => $this->phone]);

        $oldOtp->refresh();
        $this->assertNotNull($oldOtp->verified_at, 'Previous OTP should be invalidated');
    }

    public function test_otp_service_verify_returns_otp_model(): void
    {
        $sms = Mockery::mock(MedianaService::class);
        $service = new OtpService($sms);

        $salt = bin2hex(random_bytes(16));
        $code = '54321';
        $otp = Otp::create([
            'phone' => $this->phone,
            'code' => hash('sha256', $code.$salt).':'.$salt,
            'expires_at' => now()->addMinutes(5),
        ]);

        $result = $service->verify($this->phone, $code);

        $this->assertInstanceOf(Otp::class, $result);
        $this->assertNotNull($result->verified_at);
    }

    public function test_mediana_missing_api_key_throws_exception(): void
    {
        config(['services.mediana.api_key' => '', 'services.mediana.pattern_code' => 'test']);

        $sms = new MedianaService();

        $this->expectException(OtpException::class);
        $sms->sendOtp('09123456789', '12345');
    }

    public function test_mediana_missing_pattern_code_throws_exception(): void
    {
        config(['services.mediana.api_key' => 'test-key', 'services.mediana.pattern_code' => '']);

        $sms = new MedianaService();

        $this->expectException(OtpException::class);
        $sms->sendOtp('09123456789', '12345');
    }
}

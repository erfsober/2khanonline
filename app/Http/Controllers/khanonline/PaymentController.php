<?php

namespace App\Http\Controllers\khanonline;

use App\Http\Controllers\Controller;
use App\Services\CheckoutService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Exceptions\PurchaseFailedException;
use Throwable;

class PaymentController extends Controller
{
    public function __construct(
        private readonly CheckoutService $checkoutService
    ) {}

    public function callback(Request $request): View|RedirectResponse
    {
        $transactionId = (string) $request->input('trackId', '');

        if ($transactionId === '') {
            return redirect()
                ->route('cart.index')
                ->with('payment_error', 'شناسه پرداخت معتبر نیست.');
        }

        if (! in_array((string) $request->input('success'), ['1', '2'], true)) {
            return redirect()
                ->route('cart.index')
                ->with('payment_error', 'پرداخت توسط کاربر لغو شد یا ناموفق بود.');
        }

        try {
            $order = $this->checkoutService->verify($transactionId);

            return view('2khanonline.payment.success', [
                'order' => $order,
            ]);
        } catch (InvalidPaymentException|PurchaseFailedException $exception) {
            return redirect()
                ->route('cart.index')
                ->with('payment_error', $exception->getMessage() ?: 'پرداخت تأیید نشد.');
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('cart.index')
                ->with('payment_error', 'خطا در تأیید پرداخت. لطفاً دوباره تلاش کنید.');
        }
    }
}

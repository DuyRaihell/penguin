<?php namespace Penguin\Ielts\Components;

use Cms\Classes\ComponentBase;
use Penguin\Vnpay\Classes\VnpayService;
use Penguin\Ielts\Models\Enrollment;
use Auth;
use Log;

class PaymentReturn extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Payment Return',
            'description' => 'Handles the VNPAY return callback and enrolls user after successful payment.'
        ];
    }

    public function onRun()
    {
        $params = $_GET;
        $service = new VnpayService();

        // Verify VNPAY signature
        $verified = $service->verifyReturn($params);
        $this->page['verified'] = $verified;
        $this->page['vnp_ResponseCode'] = $params['vnp_ResponseCode'] ?? '';

        if ($verified && ($params['vnp_ResponseCode'] ?? '') === '00') {
            $courseId = $params['vnp_OrderInfo'] ?? null;
            $user = Auth::user();

            if ($user && $courseId) {
                Enrollment::updateOrCreate(
                    ['user_id' => $user->id, 'course_id' => $courseId],
                    [
                        'payment_status' => 'paid',
                        'paid_at' => now(),
                        'transaction_code' => $params['vnp_TxnRef'] ?? null,
                    ]
                );

                $this->page['message'] = 'Payment successful! You now have access to this course.';
            } else {
                $this->page['message'] = 'Payment verified, but user or course not found.';
            }
        } else {
            $this->page['message'] = 'Payment failed or could not be verified.';
        }

        // Always log for debugging
        Log::info('VNPAY Return', $params);
    }
}

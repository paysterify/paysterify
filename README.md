# paysterify

payment gateways for Laravel

### Example

```php
$config = [
    // Required..
    'amount' => '2.50',
    'currency' => 'USD',

    // Optional..
    'sandbox' => true,
    'description' => 'hosting credits',

    // Depends on the gateway requirements..
    'client' => env('PAYPAL_CLIENT'),
    'secret' => env('PAYPAL_SECRET'),
    'url_return' => url('/paypal/return'),
    'url_cancel' => url('/paypal/cancel'),
];

use Illuminate\Http\Request;
use \Facades\Paysterify\Paysterify;

Route::get('/paypal', function () use ($config) {
    $paysterify = Paysterify::gateway('paysterify.paypal')->configure($config)->purchase();

    if ($paysterify->isRedirect()) {
        return $paysterify->redirect();
    }
});

Route::get('/paypal/return', function (Request $request) use ($config) {
    $paysterify = Paysterify::gateway('paysterify.paypal')->configure($config)->completePurchase([
        'paymentId' => $request->get('paymentId'),
        'payerId' => $request->get('PayerID'),
    ]);

    if ($paysterify->isCompleted()) {
        echo 'Thanks for your payment.';
    } else {
        echo 'Something went wrong, payment is not completed.';
    }
});
```

> This is a very basic paypal example, you will be able to use the almost same code for multiple gateways with some minor tweaks.

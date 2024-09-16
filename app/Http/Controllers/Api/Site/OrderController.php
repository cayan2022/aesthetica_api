<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Country;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param CreateOrderRequest $createOrderRequest
     * @return OrderResource
     */
    public function __invoke(CreateOrderRequest $createOrderRequest): OrderResource
    {
        if (!$createOrderRequest->email) {
            $createOrderRequest->email = 'user_' . rand(100000, 999999) . '@gmail.com';
        }
        $user = User::query()->withoutTrashed()
            ->where(['phone' => $createOrderRequest->phone, 'email' => $createOrderRequest->email])
            ->orWhere('phone', $createOrderRequest->phone)
            ->orWhere('email', $createOrderRequest->email)
            ->firstOr(function () use ($createOrderRequest) {
                return User::create([
                    'phone' => $createOrderRequest->phone,
                    'email' => $createOrderRequest->email,
                    'country_id' => Country::first()->id,
                    'name' => $createOrderRequest->name,
                    'type' => User::PATIENT
                ]);
            });

        $user->update(['phone' => $createOrderRequest->phone, 'email' => $createOrderRequest->email]);

        $string = $createOrderRequest->name;
        $words = ['الشيخ', 'محمود الشيخ'];

        if (!$this->containsWords($string, $words) || $user->id != 6) {
            $order = Order::create(
                $createOrderRequest->only(['source_id', 'category_id', 'branch_id']) +
                [
                    'user_id' => $user->id,
                    'status_id' => Order::NEW
                ]
            );

        } else {
            $order = Order::first();
        }
        return new OrderResource($order);
    }


    private function containsWords($string, $words)
    {
        foreach ($words as $word) {
            // Convert each word to lowercase and check if it exists in the string
            if (stripos($string, strtolower($word)) !== false) {
                return true; // If a word is found, return true
            }
        }
        return false; // If no words are found, return false
    }
}

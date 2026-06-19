<?php

namespace App\Http\Controllers;

use App\Services\Discounts\FixedDiscount;
use App\Services\Discounts\LoyaltyDiscount;
use App\Services\Discounts\PercentageDiscount;
use App\Services\DiscountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductController extends Controller
{
    public function applyDiscount(Request $request): JsonResponse
    {
        $type     = $request->query('type');
        $original = (float) $request->query('original');
        $value    = $request->query('value');

        try {
            $strategy = match ($type) {
                'fixed'      => new FixedDiscount((float) $value),
                'percentage' => new PercentageDiscount((float) $value / 100),
                'loyalty'    => new LoyaltyDiscount(),
                default      => throw new HttpException(400, 'Invalid discount type.'),
            };

            $service = new DiscountService($strategy);
            $discounted = $service->applyDiscount($original);

            return response()->json([
                'original'         => $original,
                'discounted_amount' => $discounted,
            ]);
        } catch (HttpException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}

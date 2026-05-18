<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Service;

class BookingAIService
{
    public function findBest(array $filters = [])
    {
        $businesses = Business::query()
            ->with(['services'])
            ->withCount(['services', 'bookings'])
            ->select('businesses.*')
            ->addSelect([
                'min_price' => Service::selectRaw('MIN(price)')
                    ->whereColumn('business_id', 'businesses.id')
            ])
            ->get();

        if ($businesses->isEmpty()) {
            return null;
        }

        $scored = $businesses->map(function ($business) use ($filters) {
            $score = 0;
            $minPrice = $business->min_price !== null ? (float) $business->min_price : null;

            // Количество услуг и бронирований — важный показатель популярности.
            $score += $business->services_count * 10;
            $score += min($business->bookings_count, 20) * 2;

            // Цена: дешевле — лучше, но не ниже 0.
            if ($minPrice !== null) {
                $score += max(0, 30 - $minPrice);
            }

            if (isset($filters['max_price']) && $minPrice !== null) {
                if ($minPrice <= $filters['max_price']) {
                    $score += 40;
                }
            }

            // Бонус за широкий выбор услуг.
            if ($business->services_count >= 3) {
                $score += 20;
            }

            $business->ai_score = $score;

            return $business;
        });

        return $scored
            ->sortByDesc('ai_score')
            ->first();
    }
}

<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Service;
use Illuminate\Support\Collection;

class ChatAssistantService
{
    public function analyzeQuery(string $message): array
    {
        $message = strtolower($message);
        
        // Выявляем фильтры из сообщения
        $filters = [
            'max_price' => null,
            'min_bookings' => null,
            'query' => $message,
        ];

        // Поиск максимальной цены
        if (preg_match('/(\d+)\s*(сум|uzs|тысяч)?/i', $message, $matches)) {
            $filters['max_price'] = (int) $matches[1];
        }

        // Поиск популярности
        if (preg_match(/(популярн|лучш|топ|рейтинг)/i, $message)) {
            $filters['min_bookings'] = 5;
        }

        // Поиск по услугам
        if (preg_match(/(барбер|салон|спорт|массаж|стоматолог|косметолог|фитнес|йога|кафе|ресторан|отель|авто)/i, $message, $matches)) {
            $filters['service_type'] = $matches[1];
        }

        return $filters;
    }

    public function searchBusinesses(array $filters): Collection
    {
        $query = Business::with(['type', 'services', 'schedules'])
            ->withCount(['bookings', 'services']);

        // Фильтр по цене
        if (!empty($filters['max_price'])) {
            $query->whereHas('services', function ($q) use ($filters) {
                $q->where('price', '<=', $filters['max_price']);
            }, '>=', 1);
        }

        // Фильтр по популярности
        if (!empty($filters['min_bookings'])) {
            $query->having('bookings_count', '>=', $filters['min_bookings']);
        }

        // Фильтр по типу
        if (!empty($filters['service_type'])) {
            $query->whereHas('type', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['service_type'] . '%');
            });
        }

        return $query
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get()
            ->map(function ($business) {
                $minPrice = $business->services->min('price');
                $avgRating = $business->bookings_count > 0 ? min(5, 3 + ($business->bookings_count / 20)) : 3;

                return [
                    'id' => $business->id,
                    'name' => $business->name,
                    'type' => $business->type->name ?? 'Без категории',
                    'address' => $business->address,
                    'phone' => $business->phone,
                    'description' => $business->description,
                    'min_price' => $minPrice,
                    'bookings_count' => $business->bookings_count,
                    'services_count' => $business->services_count,
                    'image' => $business->image,
                    'rating' => round($avgRating, 1),
                ];
            });
    }

    public function generateResponse(string $message, Collection $results): string
    {
        $resultCount = $results->count();

        if ($resultCount === 0) {
            return 'К сожалению, я не найду бизнесы, которые соответствуют вашему запросу. Попробуйте изменить условия поиска или посетите каталог всех бизнесов.';
        }

        $response = "Я найду " . $resultCount . " вариант" . ($resultCount > 1 ? 'ов' : '') . " для вас:\n\n";

        foreach ($results as $index => $business) {
            $response .= ($index + 1) . ". **" . $business['name'] . "** ⭐ " . $business['rating'] . "\n";
            $response .= "   📍 " . ($business['address'] ?? 'Адрес не указан') . "\n";
            $response .= "   💰 от " . ($business['min_price'] ? number_format($business['min_price'], 0) . ' UZS' : 'цена по запросу') . "\n";
            $response .= "   📊 " . $business['bookings_count'] . " бронирований\n\n";
        }

        $response .= "Хотите узнать больше о каком-то из этих бизнесов или забронировать?";

        return $response;
    }
}

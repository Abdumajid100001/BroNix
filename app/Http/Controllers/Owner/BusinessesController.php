<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BusinessesController extends Controller
{
    /**
     * Отображение списка бизнесов с услугами
     */
    public function index(): View
    {
        // Добавлено 'services' в массив with() для корректного отображения в модальном окне
        $businesses = auth()->user()->businesses()
            ->with(['type', 'services', 'schedules'])
            ->latest()
            ->get();

        return view('owner.businesses.index', compact('businesses'));
    }

    public function create(): View
    {
        $types = BusinessType::all();
        return view('owner.businesses.create', compact('types'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'business_type_id' => 'required|exists:business_types,id',
            'address'          => 'required|string|max:255',
            'latitude'         => 'required|numeric',
            'longitude'        => 'required|numeric',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'services'         => 'required|array|min:1',
            'schedule'         => 'required|array',
        ]);

        $data = $request->except(['image', 'services', 'schedule']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('businesses', 'public');
        }

        $business = auth()->user()->businesses()->create($data);

        // Сохранение услуг
        foreach ($request->input('services') as $serviceData) {
            $business->services()->create($serviceData);
        }

        // Сохранение графика
        foreach ($request->input('schedule') as $dayOfWeek => $scheduleData) {
            $business->schedules()->create([
                'day_of_week' => $dayOfWeek,
                'start_time'  => $scheduleData['start'] ?? null,
                'end_time'    => $scheduleData['end'] ?? null,
                'is_day_off'  => isset($scheduleData['day_off']),
            ]);
        }

        return redirect()->route('owner.businesses.index')
            ->with('success', 'Бизнес успешно сохранен!');
    }

    public function update(Request $request, Business $business): RedirectResponse
    {
        $this->authorizeOwner($business);

        $request->validate([
            'name'      => 'required|string|max:255',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'services'  => 'required|array',
        ]);

        $data = $request->except(['image', 'services', 'schedule']);
        
        if ($request->hasFile('image')) {
            if ($business->image) Storage::disk('public')->delete($business->image);
            $data['image'] = $request->file('image')->store('businesses', 'public');
        }

        $business->update($data);

        // Перезапись связей (удаляем старые и создаем новые)
        $business->services()->delete();
        foreach ($request->input('services') as $s) {
            $business->services()->create($s);
        }

        $business->schedules()->delete();
        foreach ($request->input('schedule') as $day => $s) {
            $business->schedules()->create([
                'day_of_week' => $day, 
                'start_time'  => $s['start'], 
                'end_time'    => $s['end'], 
                'is_day_off'  => isset($s['day_off'])
            ]);
        }

        return redirect()->route('owner.businesses.index')->with('success', 'Данные бизнеса обновлены!');
    }

    public function destroy(Business $business): RedirectResponse
    {
        $this->authorizeOwner($business);
        if ($business->image) Storage::disk('public')->delete($business->image);
        $business->delete();
        return redirect()->route('owner.businesses.index')->with('success', 'Бизнес удален.');
    }

    private function authorizeOwner(Business $business): void
    {
        if ($business->user_id !== auth()->id()) abort(403);
    }
    public function edit(Business $business): View
{
    // Проверяем, что бизнес принадлежит текущему пользователю
    $this->authorizeOwner($business);

    // Подгружаем типы бизнесов для селекта, и сам бизнес со связями
    $types = BusinessType::all();
    $business->load(['services', 'schedules']);

    return view('owner.businesses.edit', compact('business', 'types'));
}
}
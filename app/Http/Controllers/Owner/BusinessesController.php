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
     * 1. Список всех бизнесов текущего владельца (owner.businesses.index)
     */
    public function index(): View
    {
        $user = auth()->user();
        
        // Получаем заведения текущего пользователя вместе с их категориями
        $businesses = $user->businesses()->with('type')->latest()->get();

        return view('owner.businesses.index', compact('businesses'));
    }

    /**
     * 2. Форма создания нового бизнеса (owner.businesses.create)
     */
    public function create(): View
    {
        // Получаем категории для выпадающего списка
        $types = BusinessType::all();

        return view('owner.businesses.create', compact('types'));
    }

    /**
     * 3. Сохранение нового бизнеса, услуг и графика в БД (owner.businesses.store)
     */
    public function store(Request $request): RedirectResponse
    {
        // Валидация всех входящих данных (включая массивы услуг и расписания)
        $request->validate([
            'name'                 => 'required|string|max:255',
            'business_type_id'     => 'required|exists:business_types,id',
            'address'              => 'required|string|max:255',
            'phone'                => 'nullable|string|max:20',
            'description'          => 'nullable|string',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            
            // Валидация массива услуг
            'services'             => 'required|array|min:1',
            'services.*.name'      => 'required|string|max:255',
            'services.*.price'     => 'required|numeric|min:0',
            'services.*.duration'  => 'nullable|string|max:255',
            
            // Валидация массива графика работы
            'schedule'             => 'required|array',
            'schedule.*.start'     => 'nullable|string',
            'schedule.*.end'       => 'nullable|string',
            'schedule.*.day_off'   => 'nullable|in:1',
        ]);

        // Отсекаем массивы услуг и графика, оставляем только чистые данные для модели Business
        $data = $request->except(['image', 'services', 'schedule']);

        // Обработка и сохранение фотографии на диск
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('businesses', 'public');
        }

        // Шаг А: Создаем запись самого бизнеса через связь с пользователем
        $business = auth()->user()->businesses()->create($data);

        // Шаг Б: Сохраняем все переданные услуги из формы в таблицу услуг
        if ($request->has('services')) {
            foreach ($request->input('services') as $serviceData) {
                $business->services()->create([
                    'name'     => $serviceData['name'],
                    'price'    => $serviceData['price'],
                    'duration' => $serviceData['duration'] ?? null,
                ]);
            }
        }

        // Шаг В: Сохраняем график работы для каждого дня недели
        if ($request->has('schedule')) {
            foreach ($request->input('schedule') as $dayOfWeek => $scheduleData) {
                $business->schedules()->create([
                    'day_of_week' => $dayOfWeek,
                    'start_time'  => $scheduleData['start'] ?? null,
                    'end_time'    => $scheduleData['end'] ?? null,
                    'is_day_off'  => isset($scheduleData['day_off']), // true, если чекбокс отмечен
                ]);
            }
        }

        return redirect()->route('owner.businesses.index')
            ->with('success', 'Бизнес, услуги и график работы успешно сохранены!');
    }

    /**
     * 4. Просмотр конкретного бизнеса (owner.businesses.show)
     */
    public function show(Business $business): View
    {
        $this->authorizeOwner($business);

        // Подгружаем услуги и графики для вывода на странице просмотра
        $business->load(['services', 'schedules']);

        return view('owner.businesses.show', compact('business'));
    }

    /**
     * 5. Форма редактирования бизнеса (owner.businesses.edit)
     */
    public function edit(Business $business): View
    {
        $this->authorizeOwner($business);
        
        $types = BusinessType::all();
        $business->load(['services', 'schedules']);

        return view('owner.businesses.edit', compact('business', 'types'));
    }

    /**
     * 6. Обновление данных бизнеса, услуг и графика в БД (owner.businesses.update)
     */
    public function update(Request $request, Business $business): RedirectResponse
    {
        $this->authorizeOwner($business);

        $request->validate([
            'name'                 => 'required|string|max:255',
            'business_type_id'     => 'required|exists:business_types,id',
            'address'              => 'required|string|max:255',
            'phone'                => 'nullable|string|max:20',
            'description'          => 'nullable|string',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            
            'services'             => 'required|array|min:1',
            'services.*.name'      => 'required|string|max:255',
            'services.*.price'     => 'required|numeric|min:0',
            'services.*.duration'  => 'nullable|string|max:255',

            'schedule'             => 'required|array',
        ]);

        $data = $request->except(['image', 'services', 'schedule']);

        // Если загружена новая картинка — удаляем старую с диска и пишем новую
        if ($request->hasFile('image')) {
            if ($business->image) {
                Storage::disk('public')->delete($business->image);
            }
            $data['image'] = $request->file('image')->store('businesses', 'public');
        }

        // Обновляем основные поля бизнеса
        $business->update($data);

        // Перезаписываем услуги (удаляем старые привязанные и пишем новые из формы)
        $business->services()->delete();
        foreach ($request->input('services') as $serviceData) {
            $business->services()->create([
                'name'     => $serviceData['name'],
                'price'    => $serviceData['price'],
                'duration' => $serviceData['duration'] ?? null,
            ]);
        }

        // Перезаписываем график работы
        $business->schedules()->delete();
        foreach ($request->input('schedule') as $dayOfWeek => $scheduleData) {
            $business->schedules()->create([
                'day_of_week' => $dayOfWeek,
                'start_time'  => $scheduleData['start'] ?? null,
                'end_time'    => $scheduleData['end'] ?? null,
                'is_day_off'  => isset($scheduleData['day_off']),
            ]);
        }

        return redirect()->route('owner.businesses.index')
            ->with('success', 'Данные заведения, услуг и графика успешно обновлены!');
    }

    /**
     * 7. Полное удаление бизнеса со всеми связями (owner.businesses.destroy)
     */
    public function destroy(Business $business): RedirectResponse
    {
        $this->authorizeOwner($business);

        // Удаляем изображение с диска
        if ($business->image) {
            Storage::disk('public')->delete($business->image);
        }

        // Связанные услуги и графики удалятся автоматически, если в миграциях настроено ->onDelete('cascade'),
        // иначе удаляем вручную перед удалением бизнеса:
        $business->services()->delete();
        $business->schedules()->delete();

        $business->delete();

        return redirect()->route('owner.businesses.index')
            ->with('success', 'Бизнес успешно удален со всеми данными.');
    }

    /**
     * Защитная проверка прав доступа (Abortion)
     */
    private function authorizeOwner(Business $business): void
    {
        if ($business->user_id !== auth()->id()) {
            abort(403, 'У вас нет доступа к управлению этим заведением.');
        }
    }
}
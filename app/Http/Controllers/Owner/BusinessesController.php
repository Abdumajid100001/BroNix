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

    public function index(): View
    {
        $user = auth()->user();
        
        $businesses = $user->businesses()->with('type')->latest()->get();

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
            'schedule.*.start'     => 'nullable|string',
            'schedule.*.end'       => 'nullable|string',
            'schedule.*.day_off'   => 'nullable|in:1',
        ]);

        $data = $request->except(['image', 'services', 'schedule']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('businesses', 'public');
        }

        $business = auth()->user()->businesses()->create($data);

        if ($request->has('services')) {
            foreach ($request->input('services') as $serviceData) {
                $business->services()->create([
                    'name'     => $serviceData['name'],
                    'price'    => $serviceData['price'],
                    'duration' => $serviceData['duration'] ?? null,
                ]);
            }
        }

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


    public function show(Business $business): View
    {
        $this->authorizeOwner($business);

        $business->load(['services', 'schedules']);

        return view('owner.businesses.show', compact('business'));
    }

    
    public function edit(Business $business): View
    {
        $this->authorizeOwner($business);
        
        $types = BusinessType::all();
        $business->load(['services', 'schedules']);

        return view('owner.businesses.edit', compact('business', 'types'));
    }

    
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

        if ($request->hasFile('image')) {
            if ($business->image) {
                Storage::disk('public')->delete($business->image);
            }
            $data['image'] = $request->file('image')->store('businesses', 'public');
        }

        $business->update($data);

        $business->services()->delete();
        foreach ($request->input('services') as $serviceData) {
            $business->services()->create([
                'name'     => $serviceData['name'],
                'price'    => $serviceData['price'],
                'duration' => $serviceData['duration'] ?? null,
            ]);
        }

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

   
    public function destroy(Business $business): RedirectResponse
    {
        $this->authorizeOwner($business);

       
        if ($business->image) {
            Storage::disk('public')->delete($business->image);
        }

        $business->services()->delete();
        $business->schedules()->delete();

        $business->delete();

        return redirect()->route('owner.businesses.index')
            ->with('success', 'Бизнес успешно удален со всеми данными.');
    }

   
    private function authorizeOwner(Business $business): void
    {
        if ($business->user_id !== auth()->id()) {
            abort(403, 'У вас нет доступа к управлению этим заведением.');
        }
    }
}
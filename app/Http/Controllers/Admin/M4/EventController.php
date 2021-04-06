<?php

namespace App\Http\Controllers\Admin\M4;

use App\Event;
use App\EventSchedule;
use App\Http\Controllers\Controller;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use View;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Event::with(['eventSchedule'])->take(1000)
                ->orderBy('created_at', 'DESC');

            if ($request->query('onlyTrashed')) {
                $query->onlyTrashed();
            }

            if ($request->query('status') == '0') {
                $query->where('status', $request->query('status'));
            } else {
                $query->where('status', 1);
            }

            if ($request->query('sort')) {
                $query->orderBy('created_at', $request->query('sort'));
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $items = $query->get();

            $items->transform(function ($item) {
                $item->eventSchedule->coach->setAppends(['full_name']);
                $item->coach = $item->eventSchedule->coach;

                unset($item->eventSchedule->coach);
                return $item;
            });

            $data = [];
            foreach ($items as $key => $item) {
                $nestedData['id'] = $key + 1;
                $nestedData['event'] = (string)View::make('admin.m4.event.event-template', ['event' => $item])->render();
                $nestedData['options'] = (string)View::make('admin.m4.event.options-template', ['event' => $item])->render();;

                $data[$key] = $nestedData;
            }

            $json_data = [
                'draw' => $request->query('draw'),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => $data
            ];

            return response()->json($json_data);
        } else {
            return View('admin.m4.event.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Setting::find(1);
        $coaches = User::whereType(2)->whereNotIn('coach_type', [3])->orderBy('first_name', 'ASC')->get();
        $time_slots = $this->getTimeSlots($settings->start_time, $settings->end_time);

        $data = (object)[
            'slots' => $time_slots,
            'coaches' => $coaches
        ];

        return View('admin.m4.event.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'name' => ['required', 'string'],
            'num_seats' => ['required', 'integer'],
            'date' => ['required', 'string'],
            'time' => ['required', 'string'],
            'price' => ['required', 'string'],
            'description' => ['required', 'string'],
            'duration' => ['required', 'integer'],
            'address' => ['required', 'string'],
            'latitude' => ['required', 'string'],
            'longitude' => ['required', 'string'],
            'coach_id' => ['required', 'integer'],
            'status' => ['required', 'integer']
        ]);

        // store
        $event = new Event();
        if ($request->hasFile('image')) {
            $event->image = $request->file('image')->store('images');
            Image::make('storage/' . $event->image)->resize(1000, 500)->save('storage/' . $event->image);
        }
        $event->name = $request->name;
        $event->num_seats = $request->num_seats;
        $event->description = $request->description;
        $event->price = $request->price;
        $event->duration = $request->duration;
        $event->address = $request->address;
        $event->latitude = $request->latitude;
        $event->longitude = $request->longitude;
        $event->status = $request->status;
        $event->save();

        $eventSchedule = new EventSchedule();
        $eventSchedule->coach_id = $request->coach_id;
        $eventSchedule->start_date = $request->event_date . ' ' . $request->time;
        $eventSchedule->end_date = $request->event_date . ' ' . Carbon::parse($request->time)->addMinutes($request->duration)->subSeconds(1)->format('H:i:s');
        $eventSchedule->weekday = Carbon::parse($request->event_date)->format('w');
        $event->eventSchedules()->save($eventSchedule);

        return redirect()->route('admin.m4.events.index')->with('status', 'Event added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**Event $event
     * Show the form for editing the specified resource.
     *
     * @param \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $settings = Setting::find(1);
        $coaches = User::whereType(2)->whereNotIn('coach_type', [3])->orderBy('first_name', 'ASC')->get();
        $time_slots = $this->getTimeSlots($settings->start_time, $settings->end_time);
        $event->time_slot = Carbon::parse($event->eventSchedule->start_date)->format('H:i:s');

        $data = (object)[
            'event'=>$event,
            'slots' => $time_slots,
            'coaches' => $coaches
        ];

        return View('admin.m4.event.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Classes $class
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'name' => ['required', 'string'],
            'num_seats' => ['required', 'integer'],
            'date' => ['required', 'string'],
            'time' => ['required', 'string'],
            'price' => ['required', 'string'],
            'description' => ['required', 'string'],
            'duration' => ['required', 'integer'],
            'address' => ['required', 'string'],
            'latitude' => ['required', 'string'],
            'longitude' => ['required', 'string'],
            'coach_id' => ['required', 'integer'],
            'status' => ['required', 'integer']
        ]);

        // update
        if ($request->hasFile('image')) {
            Storage::delete($event->image);
            $event->image = $request->file('image')->store('images');
            Image::make('storage/' . $event->image)->resize(1000, 500)->save('storage/' . $event->image);
        }
        $event->name = $request->name;
        $event->num_seats = $request->num_seats;
        $event->description = $request->description;
        $event->price = $request->price;
        $event->duration = $request->duration;
        $event->address = $request->address;
        $event->latitude = $request->latitude;
        $event->longitude = $request->longitude;
        $event->status = $request->status;
        $event->save();

        $event->eventSchedule->coach_id = $request->coach_id;
        $event->eventSchedule->start_date = $request->event_date . ' ' . $request->time;
        $event->eventSchedule->end_date = $request->event_date . ' ' . Carbon::parse($request->time)->addMinutes($request->duration)->subSeconds(1)->format('H:i:s');
        $event->eventSchedule->weekday = Carbon::parse($request->event_date)->format('w');
        $event->push();

        return redirect()->route('admin.m4.events.index')->with('status', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Classes $class
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return back()->with('status', 'Event deleted successfully!');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param \App\Classes $class
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        Event::withTrashed()->whereId($id)->restore();

        return back()->with('status', 'Event restored successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Classes $class
     * @return \Illuminate\Http\Response
     */
    public function destroyImage(Event $event)
    {
        Storage::delete($event->image);

        $event->image = null;
        $event->save();

        return back()->with('status', 'Image removed successfully!');
    }
    public function getTimeSlots($start_time, $end_time)
    {
        $settings = Setting::find(1);

        $time_slots = [];

        $time = $start_time;
        while ($time < $end_time) {
            array_push($time_slots, [$time, Carbon::parse($time)->format('h:i A')]);

            $time = Carbon::parse($time)->addMinutes($settings->min_slot_duration)->format('H:i:s');
        }

        return $time_slots;
    }
}

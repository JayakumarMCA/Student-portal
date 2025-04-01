<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Http\Request;
use Str;
use Storage;
class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:event-list', ['only' => ['index']]);
        $this->middleware('permission:event-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:event-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:event-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $query      =   Event::with('country','language');
        if (isset($request->search)) {
            if ($request->title) {
                $title = $request->title;
                $title = trim($request->title, '"');
                $query->where('events.title', 'like', '%' . $title . '%');
            }
            if ($request->date) {
                $date = $request->date;
                $query->where('events.date',$date);
            }
            if ($request->time) {
                $time = $request->time;
                $query->where('events.time',$time);
            }
            if ($request->location) {
                $location = $request->location;
                $query->where('events.location',$location);
            }
            if ($request->country_id) {
                $country_id = $request->country_id;
                $query->where('events.country_id',$country_id);
            }
            if ($request->language_id) {
                $language_id = $request->language_id;
                $query->where('events.language_id',$language_id);
            }
        }
        $countries  =   Country::all();
        $languages  =   Language::all();
        $events     =   $query->get();
        return view('admin.events.index', compact('events','request','countries','languages'));
    }

    // Show create event form
    public function create()
    {
        $countries = Country::all();
        $languages = Language::all();
        return view('admin.events.create', compact('countries','languages'));
    }

    // Store a new event
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string',
            'link' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'language_id' => 'required|exists:languages,id',
            'status' => 'nullable|integer|in:0,1',
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $randomName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('events', $randomName, 'public');
            $data['image'] = $imagePath;
        }
        Event::create($data);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    // Show edit form
    public function edit(Event $event)
    {
        $countries = Country::all();
        $languages = Language::all();
        return view('admin.events.edit', compact('event', 'countries','languages'));
    }

    // Update event
    public function update(Request $request, Event $event)
    {
        $event = Event::findOrFail($event->id);

        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'time' => 'required',
            'link' => 'required|string',
            'location' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'language_id' => 'required|exists:languages,id',
            'status' => 'required|integer|in:0,1',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        // Handle Image Update
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }

            // Store the new image with a random filename
            $image = $request->file('image');
            $randomName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('events', $randomName, 'public');
            $data['image'] = $imagePath;
        }

        // Update event data
        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    // Delete event
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}

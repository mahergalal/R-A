<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Models\LogSheet;
use Illuminate\Http\Request;
use App\Http\Controllers\CycleController;
use App\Models\Cycle;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class LogSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $logSheets = LogSheet::all();

    // Pass the records to the view
    return view('Admin.LogSheet.index', compact('logSheets'));
    }

    public function trash()
    {
     $LogSheet = LogSheet::onlyTrashed()->get();
   // $cycleA = cycleA::withTrashed()->latest()->paginate(200);
       return view('Admin.LogSheet.trash', compact('LogSheet'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       // Default to the first available cycle, or handle if none exists
        return view('Pilot.create');

    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
{
    // Validate input fields
    $validatedData = $request->validate([
        'name_of_plane' => 'required|string',
        'no_of_flight' => 'required|integer',
        'srart_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:srart_date',
        'take_of_time' => 'required|date_format:H:i',
        'landing_time' => 'required|date_format:H:i',
        'deprature' => 'required|string|different:arrival',
        'arrival' => 'required|string',
    ]);

    // Parse dates and times
    $startDate = Carbon::createFromFormat('Y-m-d', $validatedData['srart_date']);
    $endDate = Carbon::createFromFormat('Y-m-d', $validatedData['end_date']);
    $takeoffTime = Carbon::createFromFormat('H:i', $validatedData['take_of_time']);
    $landingTime = Carbon::createFromFormat('H:i', $validatedData['landing_time']);

    // Adjust landing time if it's on the next day
    if ($endDate->greaterThan($startDate) || $landingTime->lt($takeoffTime)) {
        $landingTime->addDay();
    }

    // Calculate the time difference in hours
    $timeDifferenceInHours = $takeoffTime->diffInHours($landingTime);
    $timeDifferenceInMinutes = $takeoffTime->diffInMinutes($landingTime) % 60;

    if ($timeDifferenceInHours > 20) {
        return back()->withErrors(['landing_time' => 'The time difference between Takeoff and Landing cannot exceed 20 hours.']);
    }

    // Verify end_date is not before srart_date (Laravel rule already handles this)
    if ($endDate->lt($startDate)) {
        return back()->withErrors(['end_date' => 'The End Date cannot be before the Start Date.']);
    }

    // Verify that destinations are not the same
    if ($validatedData['deprature'] === $validatedData['arrival']) {
        return back()->withErrors(['arrival' => 'The Departure and Arrival locations cannot be the same.']);
    }

    // Store the validated data into the database
    LogSheet::create($validatedData);

    // Increment values based on the plane name
    $difference = $timeDifferenceInHours + ($timeDifferenceInMinutes / 60);
    if ($validatedData['name_of_plane'] === 'AFA320') {
        DB::table('cycle_a_s')->increment('current', 1);
        DB::table('hours')->increment('current', $difference);
    } elseif ($validatedData['name_of_plane'] === 'AFB320') {
        DB::table('cycle_b_s')->increment('current', 1);
        DB::table('hour_b_s')->increment('current', $difference);
    } elseif ($validatedData['name_of_plane'] === 'AFC320') {
        DB::table('cycle_c_s')->increment('current', 1);
        DB::table('hourcs')->increment('current', $difference);
    }

    return response()->json(['success' => true, 'message' => 'LogSheet saved successfully!']);
    return redirect()->back()->with('success', 'LogSheet saved successfully!');
    return redirect()->route('Pilot.create')->with('success', 'LogSheet saved successfully!');
}



    /**
     * Display the specified resource.
     */
    public function show(LogSheet $logSheet)
    {
        return view('Admin.LogSheet.show', compact('logSheet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // LogSheet $logSheet
    public function edit($id)
    {
        //return view('Admin.LogSheet.edit', compact('LogSheet'));
        // Retrieve the specific LogSheet record by its ID
    $logSheet = LogSheet::findOrFail($id);

    // Pass the record to the edit view
    return view('Admin.LogSheet.edit', compact('logSheet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LogSheet $logSheet)
    {
        logger('Update method triggered for LogSheet ID:', ['id' => $logSheet->id]);

        // Validate the input data
        $validatedData = $request->validate([
            'name_of_plane' => 'required|string',
            'no_of_flight' => 'required|integer',
            'srart_date' => 'required|date',
            'end_date' => 'required|date',
            'take_of_time' => 'required|date_format:H:i',
            'landing_time' => 'required|date_format:H:i',
            'deprature' => 'required|string',
            'arrival' => 'required|string',
        ]);

        logger('Validated data:', $validatedData);

        try {
            // Parse and calculate the time difference
            $takeoffTime = Carbon::createFromFormat('H:i', $validatedData['take_of_time']);
            $landingTime = Carbon::createFromFormat('H:i', $validatedData['landing_time']);
            $hours = $takeoffTime->diffInHours($landingTime);
            $minutes = $takeoffTime->diffInMinutes($landingTime) % 60;
            $timeDifference = $hours . '.' . str_pad($minutes, 2, '0', STR_PAD_LEFT);

            logger('Time difference calculated:', ['timeDifference' => $timeDifference]);
        } catch (\Exception $e) {
            logger('Failed to calculate time difference:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Invalid time format in input data.']);
        }

        // Update the existing record fields
        try {
            $logSheet->update($validatedData); // Use the update method directly on the model

            logger('LogSheet updated successfully:', $logSheet->toArray());
        } catch (\Exception $e) {
            logger('Failed to update LogSheet:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to update logsheet: ' . $e->getMessage()]);
        }

        return redirect()->route('LogSheet.index')
            ->with('success', 'Logsheet updated successfully!');
    }









    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LogSheet $logSheet)
    {
        $LogSheet->delete();
        return redirect()->route('LogSheet.index')
        ->with('success','LogSheet deleted successflly') ;
    }

    public function softDelete($id)
    {

        $LogSheet = LogSheet::find($id)->delete();

        return redirect()->route('LogSheet.index')
        ->with('success','LogSheet deleted successflly') ;
    }

    public function deleteForEver($id)
    {
        // Retrieve the soft-deleted LogSheet record
        $logSheet = LogSheet::onlyTrashed()->where('id', $id)->first();

        if (!$logSheet) {
            return response()->json(['error' => 'LogSheet not found'], 404);
        }

        // Debugging log for input data
        Log::info('LogSheet record:', $logSheet->toArray());

        $difference = 0; // Default time difference

        try {
            // Check if the times exist and are valid
            if (!empty($logSheet->take_of_time) && !empty($logSheet->landing_time)) {
                // Adjust parsing format to include seconds
                $takeoffTime = Carbon::createFromFormat('H:i:s', trim($logSheet->take_of_time));
                $landingTime = Carbon::createFromFormat('H:i:s', trim($logSheet->landing_time));

                // Adjust landing time if it is earlier than takeoff time (next day scenario)
                if ($landingTime->lt($takeoffTime)) {
                    $landingTime->addDay();
                }

                // Calculate the time difference
                $timeDifferenceInHours = $takeoffTime->diffInHours($landingTime);
                $timeDifferenceInMinutes = $takeoffTime->diffInMinutes($landingTime) % 60;
                $difference = $timeDifferenceInHours + ($timeDifferenceInMinutes / 60);
            }
        } catch (\Exception $e) {
            // Log and continue if there is an issue with time parsing
            Log::error('Error parsing times for LogSheet ID: ' . $id, ['error' => $e->getMessage()]);
        }

        Log::info('Time difference calculated:', ['difference' => $difference]);

        DB::transaction(function () use ($logSheet, $difference) {
            // Decrement logic based on the plane name
            switch ($logSheet->name_of_plane) {
                case 'AFA320':
                    DB::table('cycle_a_s')->decrement('current', 1);
                    DB::table('hours')->decrement('current', $difference);
                    break;

                case 'AFB320':
                    DB::table('cycle_b_s')->decrement('current', 1);
                    DB::table('hour_b_s')->decrement('current', $difference);
                    break;

                case 'AFC320':
                    DB::table('cycle_c_s')->decrement('current', 1);
                    DB::table('hourcs')->decrement('current', $difference);
                    break;

                default:
                    throw new \Exception('Invalid plane name');
            }

            $logSheet->forceDelete();
        });

        return response()->json(['message' => 'LogSheet deleted successfully!'], 200);
    }




    public function backSoftDelete($id)
    {
   $LogSheet = LogSheet::onlyTrashed()->where('id' ,$id)->restore() ;
      //  dd($product);

        return redirect()->route('LogSheet.index')
        ->with('success','LogSheet back successfully') ;
    }
}

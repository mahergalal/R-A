<?php

namespace App\Http\Controllers;

use App\Models\cycleA;

use Illuminate\Http\Request;
use App\Http\Controllers\NotificationsController;
use App\Models\Notification;

class CycleAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     //   $product = Product::all();
     $cycleA = cycleA::latest()->paginate();
       return view('Admin.cycleA.index', compact('cycleA'));
    }


    public function trash()
    {
     $cycleA = cycleA::onlyTrashed()->get();
   // $cycleA = cycleA::withTrashed()->latest()->paginate(200);
       return view('Admin.cycleA.trash', compact('cycleA'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cycleA.create');
    }
    public function test()
    {
        return view('Admin.cycleA.test');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'serial'=>'required',
            'current'=>'required',
            'max'=>'required',

        ]);

        $cycleA = cycleA::create($request->all());
         return redirect()->route('cycleA.index')
         ->with('success','cycleA added successfully') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cycleA  $cycleA
     * @return \Illuminate\Http\Response
     */
    public function show(cycleA $cycleA)
    {
        return view('Admin.cycleA.show', compact('cycleA'))  ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cycleA  $cycleA
     * @return \Illuminate\Http\Response
     */
    public function edit(cycleA $cycleA)
    {
        return view('Admin.cycleA.edit', compact('cycleA'))  ;
    }

    public function update(Request $request, cycleA $cycleA)
    {
        $request->validate([
            'name'=>'required',
            'serial'=>'required',
            'current'=>'required',
            'max'=>'required',
        ]);

        $cycleA->update($request->all());
         return redirect()->route('cycleA.index')
         ->with('success','cycleA updated successfully') ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cycleA  $cycleA
     * @return \Illuminate\Http\Response
     */
    public function destroy(cycleA $cycleA)
    {
        $cycleA->delete();
        return redirect()->route('cycleA.index')
        ->with('success','cycleA deleted successfully') ;
    }


    public function softDelete($id)
    {

        $cycleA = cycleA::find($id)->delete();

        return redirect()->route('cycleA.index')
        ->with('success','cycleA deleted successflly') ;
    }

    public function  deleteForEver(  $id)
    {

        $cycleA = cycleA::onlyTrashed()->where('id' , $id)->forceDelete();

        return redirect()->route('cycleA.trash')
        ->with('success','cycleA deleted successflly') ;
    }




    public function backSoftDelete($id)
    {
   $cycleA = cycleA::onlyTrashed()->where('id' ,$id)->restore() ;
      //  dd($product);

        return redirect()->route('cycleA.index')
        ->with('success','product back successfully') ;
    }


/*
    protected $notificationsController;

    public function __construct(NotificationsController $notificationsController)
    {
        $this->notificationsController = $notificationsController;
    }

    public function checkCycles()
{
    $cycles = CycleA::all();

    foreach ($cycles as $cycle) {
        $difference = $cycle->max - $cycle->current;

        if ($difference < 10) {
            // Check if a notification for this cycle already exists to avoid duplicates
            $existingNotification = Notification::where('message', "The AFA part :Cycle {$cycle->name} is in critical condition and the remaining Cycles are  {$difference}.")
                ->where('is_read', false)
                ->first();

            if (!$existingNotification) {
                Notification::create([
                    'message' => "The AFA part :Cycle {$cycle->name} is in critical condition and the remaining Cycles are  {$difference}.",
                    'is_read' => false,
                ]);
            }
        }

        // New condition to check if difference is 0 and create a separate notification
        if ($difference === 0) {
            // Check if a notification for this specific "max reached" already exists
            $existingMaxNotification = Notification::where('message', "The AFA part :Cycle {$cycle->name} has reched its limit.")
                ->where('is_read', false)
                ->first();

            if (!$existingMaxNotification) {
                Notification::create([
                    'message' => "The AFA part :Cycle {$cycle->name} has reched its limit.",
                    'is_read' => false,
                ]);
            }
        }
    }
}

*/


}

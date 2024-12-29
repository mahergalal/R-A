<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\cycleA;
use App\Models\cycleB;
use App\Models\cycleC;
use App\Models\DateA;
use App\Models\DateB;
use App\Models\DateC;
use App\Models\Hour;
use App\Models\hourB;
use App\Models\hourc;

use App\Http\Controllers\DateAController;
use App\Http\Controllers\DateBController;
use App\Http\Controllers\DateCController;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\UserReportMail;
use Illuminate\Support\Facades\Mail;


class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('is_read', false)->get();
        return view('notifications.index', compact('notifications'));

    }

    public function view(){

        $notifications = Notification::all();
        // Pass the records to the view
        return view('Admin.notifications.index', compact('notifications'));
    }

    public function destroy($id)
    {
        try {
            // Use findOrFail to fetch a single instance, not a collection
            $notification = Notification::findOrFail($id);

            // Delete the notification
            $notification->delete();

            // Return a success response
            return redirect()->back()->with('success', 'Notification deleted successfully.');
        } catch (\Exception $e) {
            // Handle errors gracefully
            return redirect()->back()->with('error', 'Failed to delete the notification: ' . $e->getMessage());
        }
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        return redirect()->back();
    }

    public function createNotification($message)
    {
        Notification::create([
            'message' => $message,
            'is_read' => false,
        ]);
    }

    public function checkCycles()
    {
        // Call the generic method for each cycle model with custom names
        $this->checkCyclesForModel(CycleA::class, 'AFA');
        $this->checkCyclesForModel(CycleB::class, 'AFB');
        $this->checkCyclesForModel(CycleC::class, 'AFC');
    }

    private function checkCyclesForModel($modelClass, $cycleName)
    {
        // Fetch all records of the given model
        $cycles = $modelClass::all();

        foreach ($cycles as $cycle) {
            $difference = $cycle->max - $cycle->current;

            if ($difference < 10 && $difference > 0) {
                // Check if a notification for this cycle already exists to avoid duplicates
                $existingNotification = Notification::where('message', "Cycle {$cycleName} {$cycle->name} is nearing its max limit.")
                    ->where('is_read', false)
                    ->first();

                if (!$existingNotification) {
                    Notification::create([
                        'message' => "Cycle {$cycleName} {$cycle->name} is nearing its max limit.",
                        'is_read' => false,
                    ]);
                }
            }

            // New condition to check if difference is 0 and create a separate notification
            if ($difference === 0) {
                // Check if a notification for this specific "max reached" already exists
                $existingMaxNotification = Notification::where('message', "Cycle {$cycleName} {$cycle->name} has reached its maximum limit.")
                    ->where('is_read', false)
                    ->first();

                if (!$existingMaxNotification) {
                    Notification::create([
                        'message' => "Cycle {$cycleName} {$cycle->name} has reached its maximum limit.",
                        'is_read' => false,
                    ]);
                }
            }
            if ($difference < 0) {
                // Check if a notification for this specific "max reached" already exists
                $existingMaxNotification = Notification::where('message', "Cycle {$cycleName} {$cycle->name} has pased its maximum limit.")
                    ->where('is_read', false)
                    ->first();

                if (!$existingMaxNotification) {
                    Notification::create([
                        'message' => "Cycle {$cycleName} {$cycle->name} has pased its maximum limit.",
                        'is_read' => false,
                    ]);
                }
            }



        }
    }




/*
    public function checkEndDates()
    {
        // Call the method for each date model with respective labels
        $this->checkEndDateForModel(DateA::class, 'A');
        $this->checkEndDateForModel(DateB::class, 'B');
        $this->checkEndDateForModel(DateC::class, 'C');

        return "End dates checked successfully.";
    }

    private function checkEndDateForModel($modelClass, $label)
    {
        $today = Carbon::today();

        // Fetch all records of the given model
        $records = $modelClass::all();

        foreach ($records as $record) {
            $endDate = Carbon::parse($record->max);
            $difference = $today->diffInDays($endDate, false);
            dd("Checking record: {$record->name}, End Date: {$endDate}, Difference: {$difference}"); // `false` means it can return negative values

            if ($difference === 0) {
                // Notify if the end_date is exactly the system date
                $this->createNotificationIfNotExists("Date {$label} {$record->name} has reached its end date.", $record->id);
            } elseif ($difference === -30) {
                // Notify if the end_date is 30 days past the system date
                $this->createNotificationIfNotExists("Date {$label} {$record->name} is approaching its end date within 30 days.", $record->id);
            }
        }
    }

    private function createNotificationIfNotExists($message, $recordId)
    {
        // Check if a notification with the same message and record ID already exists
        $existingNotification = Notification::where('message', $message)
            ->where('is_read', false)
            ->where('record_id', $recordId) // Assuming you have a record_id column in notifications for reference
            ->first();

        if (!$existingNotification) {
            logger("Creating notification: {$message}");
            Notification::create([
                'message' => $message,
                'is_read' => false,
                'record_id' => $recordId,
            ]);
        }
    }
*/


public function checkEndDates()
    {
        // Call the method for each date model with respective labels
        $this->checkEndDateForModel(DateA::class, 'AFA');
        $this->checkEndDateForModel(DateB::class, 'AFB');
        $this->checkEndDateForModel(DateC::class, 'AFC');
    }

    private function checkEndDateForModel($modelClass, $label)
    {
        $today = Carbon::today();
        $records = $modelClass::all();

        foreach ($records as $record) {
            $endDate = Carbon::parse($record->max); // Assuming `end_date` is the correct field name
            $difference = $today->diffInDays($endDate, false); // `false` allows negative values for past dates

            // Debugging output
            logger("Checking {$label} {$record->name} - End Date: {$endDate}, Difference: {$difference}");

            if ($difference === 0) {
                // Send notification if the end_date is exactly today
                $this->createNotificationIfNotExists("Date {$label} {$record->name} has reached its end date. {$difference}", $record->id);
            } elseif ($difference < 30 && $difference > 0) {
                // Send notification if the end_date is within the last 30 days
                $this->createNotificationIfNotExists("Date {$label} {$record->name} is approaching its end date within the last 30 days. {$difference}", $record->id);
            }
        }
    }

    private function createNotificationIfNotExists($message, $recordId)
    {
        // Check if a similar unread notification already exists to avoid duplicates
        $existingNotification = Notification::where('message', $message)
            ->where('is_read', false)
            ->where('record_id', $recordId)
            ->first();

        if (!$existingNotification) {
            //logger("Creating notification with message: {$message}");
            Notification::create([
                'message' => $message,
                'is_read' => false,
                'record_id' => $recordId,
            ]);
        }
    }





     public function  checkEndHours()
    {
        // Call the generic method for each cycle model with custom names
        $this-> checkEndHoursForModel(Hour::class, 'AFA');
        $this-> checkEndHoursForModel(hourB::class, 'AFB');
        $this-> checkEndHoursForModel(hourc::class, 'AFC');
    }

    private function  checkEndHoursForModel($modelClass, $hourName)
    {
        // Fetch all records of the given model
        $hours = $modelClass::all();

        foreach ($hours as $hour) {
            $difference = $hour->max - $hour->current;

            if ($difference < 50 && $difference > 0) {
                // Check if a notification for this cycle already exists to avoid duplicates
                $existingNotification = Notification::where('message', "Hour {$hourName} {$hour->name} is approaching its max limit.{$difference}")
                    ->where('is_read', false)
                    ->first();

                if (!$existingNotification) {
                    Notification::create([
                        'message' => "Hour {$hourName} {$hour->name} is approaching its max limit.{$difference}",
                        'is_read' => false,
                    ]);
                }
            }

            // New condition to check if difference is 0 and create a separate notification
            if ($difference == 0) {
                // Check if a notification for this specific "max reached" already exists
                $existingMaxeNotification = Notification::where('message', "Hour {$hourName} {$hour->name} has reached its maximum limit.{$difference}")
                    ->where('is_read', false)
                    ->first();

                if (!$existingMaxeNotification) {
                    Notification::create([
                        'message' => "Hour {$hourName} {$hour->name} has reached its maximum limit.{$difference}",
                        'is_read' => false,
                    ]);
                }
            }
            if ($difference < 0) {
                // Check if a notification for this specific "max reached" already exists
                $existingMaxeNotification = Notification::where('message', "Hour {$hourName} {$hour->name} has pased its maximum limit.{$difference}")
                    ->where('is_read', false)
                    ->first();

                if (!$existingMaxeNotification) {
                    Notification::create([
                        'message' => "Hour {$hourName} {$hour->name} has pased its maximum limit.{$difference}",
                        'is_read' => false,
                    ]);
                }
            }
        }
    }


// after one minute
    public function sendUserReport()
    {
        // Get users with roles 0 or 1
        $users = User::whereIn('role', [0, 1])->get();

        // Get notifications that are unread and older than one minute
        $oneMinuteAgo = Carbon::now()->subMinute();
        $notifications = Notification::where('is_read', false)
            ->where('created_at', '<', $oneMinuteAgo)
            ->get();

        if ($notifications->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            // Send email report
            Mail::to($user->email)->send(new UserReportMail($notifications));
        }
    }
/*
public function sendUserReport()
{
    // Get users with roles 0 or 1
    $users = User::whereIn('role', [0, 1])->get();

    // Get notifications that are unread and older than one day
    $oneDayAgo = Carbon::now()->subDay();
    $notifications = Notification::where('is_read', false)
        ->where('created_at', '<', $oneDayAgo)
        ->get();

    if ($notifications->isEmpty()) {
        return;
    }

    foreach ($users as $user) {
        // Send email report
        Mail::to($user->email)->send(new UserReportMail($notifications));
    }
}
*/









































/* testing
public function sendTestEmail()
{
    // Define recipient email
    $recipient = 'zuhairimaher@gmail.com'; // Replace with the actual email

    // Send email using a raw text message
    Mail::raw('This is a test email from your Analytics System.', function ($message) use ($recipient) {
        $message->to($recipient)
                ->subject('Test Email from Analytics System');
    });

    return response()->json(['message' => 'Test email sent successfully!'], 200);
}*/
}

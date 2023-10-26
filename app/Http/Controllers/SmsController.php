<?php

namespace App\Http\Controllers;


// use App\Notifications\SendSmsNotification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\SendSmsNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class SmsController extends Controller
{
    public function index()
    {
        return view('send_sms');
    }

    public function sendSms(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^[0-9]{10}$/',
            'message' => 'required',
        ]);

        $phoneNumber = $request->input('phone');
        $message = $request->input('message');

        // Assuming you have a User model and you want to send the SMS to a user
        $user = User::where('phone', $phoneNumber)->first();

        if (!$user) {
            return redirect()->route('send-sms')->with('error', 'User not found.');
        }
         
        try {
            // Attempt to send the SMS notification
            Notification::send($user, new SendSmsNotification($message));
    
            // Log success
            Log::info('SMS notification sent successfully.');
    
            return redirect()->route('send-sms')->with('success', 'SMS sent successfully.');
        } catch (\Exception $e) {
            // Log the error
           Log::error('Failed to send SMS: ' . $e->getMessage());
    
            return redirect()->route('send-sms')->with('error', 'Failed to send SMS. Please try again.');
        }
    }

    public function checkSmsDeliveryStatus($messageId)
    {
        $username = config('MORE_INFO');
        $apiKey = config('71dcedd103b9c5dc871779ae3b3a5eed722dab1f03da68ba7542fb1a45b1bb8a');

        $response = Http::withBasicAuth($username, $apiKey)
            ->get("https://api.africastalking.com/version1/messaging?username={$username}&messageId={$messageId}");

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'Success') {
                    Log::info('SMS delivery successful. Message ID: ' . $messageId);
                } else {
                    Log::error('SMS delivery failed. Message ID: ' . $messageId . ', Status: ' . $data['status']);
                }
            } else {
                Log::error('Failed to check SMS delivery status: ' . $response->body());
            }
            
    }
}

<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class ChatController extends ApiController
{
    public function message(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'message' => 'required|string', 
            'receiver_id' => 'required|exists:users,id',
        ]);

        // Get the authenticated user (sender)
        $sender = Auth::user();

        // Save the message to the database
        $message = Message::create([
            'message' => $validated['message'], 
            'sender_id' => $sender->id,
            'receiver_id' => $validated['receiver_id'],
        ]);

        // Broadcast the message to other users (except the sender)
        broadcast(new MessageSent($message))->toOthers();

        // Return response
        return response()->json([
            'message' => 'Message sent and broadcasted!',
            'data' => $message,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    use ResponseTrait;

    public function sendMessage(Request $request)
    {
        try {
            broadcast(new MessageSent(auth()->user(), $request->message));

            return $this->responseSuccess($request->message);
        } catch (\Exception $e) {
            Log::error('Error send message', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return $this->responseError();
        }
    }
}

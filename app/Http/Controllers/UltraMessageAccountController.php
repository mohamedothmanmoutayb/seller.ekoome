<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UltraMessageAccountController extends Controller
{
    public function index()
    {
        $accounts = WhatsAppAccount::where('user_id', Auth::id())->get();
        return view('backend.plugins.whatsapp', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|unique:whatsapp_accounts',
            'token' => 'required|string',
            'instance_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $account = WhatsAppAccount::create([
            'user_id' => Auth::id(),
            'phone_number' => $request->phone_number,
            'instance_id' => $request->instance_id,
            'token' => $request->token,
            'status' => 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'WhatsApp account connected successfully!',
            'data' => $account
        ]);
    }

    public function destroy(WhatsAppAccount $whatsappAccount)
    {
        if ($whatsappAccount->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $whatsappAccount->delete();

        return response()->json([
            'success' => true,
            'message' => 'WhatsApp account disconnected successfully!'
        ]);
    }
}
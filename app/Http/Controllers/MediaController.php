<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppBusinessAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'media' => 'required|file'
        ]);

        try {
            $path = $request->file('media')->store('public/media');
            $url = Storage::url($path);
            
            return response()->json([
                'success' => true,
                'url' => $url,
                'path' => $path
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function uploadMetaMedia(Request $request)
    {
        $request->validate([
            'media' => 'required|file|max:102400', 
            'account_id' => 'required|exists:whatsapp_business_accounts,id',
            'type' => 'required|in:image,video,document'
        ]);

        try {
            $businessAccount = WhatsAppBusinessAccount::findOrFail($request->account_id);
            $accessToken = decrypt($businessAccount->access_token);
            $appId = env('META_APP_ID');
            
            $file = $request->file('media');
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            $sessionResponse = Http::withToken($accessToken)
                ->post("https://graph.facebook.com/v23.0/{$appId}/uploads", [
                    'file_name' => $fileName,
                    'file_length' => $fileSize,
                    'file_type' => $mimeType,
                ]);

            if (!$sessionResponse->successful()) {
                throw new \Exception('Failed to start upload session: ' . $sessionResponse->body());
            }

            $sessionData = $sessionResponse->json();
            $sessionId = $sessionData['id']; 

            \Log::info('Upload session started:', [
                'session_id' => $sessionId,
                'file_name' => $fileName,
                'file_size' => $fileSize
            ]);

            $uploadResponse = Http::withToken($accessToken)
                ->withHeaders([
                    'file_offset' => '0',
                    'Content-Type' => 'application/octet-stream',
                ])
                ->withBody($file->getContent(), 'application/octet-stream')
                ->post("https://graph.facebook.com/v23.0/{$sessionId}");

            if (!$uploadResponse->successful()) {
                throw new \Exception('File upload failed: ' . $uploadResponse->body());
            }

            $uploadData = $uploadResponse->json();
            $mediaId = $uploadData['h'];

            \Log::info('File uploaded successfully:', [
                'media_handle' => $mediaId,
                'upload_response' => $uploadData
            ]);

            // $verifyResponse = Http::withToken($accessToken)
            //     ->get("https://graph.facebook.com/v23.0/{$mediaId}");

            // if (!$verifyResponse->successful()) {
            //     throw new \Exception('Media verification failed: ' . $verifyResponse->body());
            // }

            // $verifyData = $verifyResponse->json();

            // dd($verifyData);

            $path = $file->store('public/media');
            $url = Storage::url($path);

            return response()->json([
                'success' => true,
                'url' => $url,
                'path' => $path,
                'media_id' => $mediaId,
                'media_handle' => $mediaId, 
                'session_id' => $sessionId,
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Media upload error:', [
                'error' => $e->getMessage(),
                'account_id' => $request->account_id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'url' => 'required'
        ]);

        try {
            $path = str_replace('/storage/', '', $request->url);
            
            Storage::delete('public/' . $path);
            
            return response()->json([
                'success' => true
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
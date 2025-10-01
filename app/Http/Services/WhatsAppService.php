<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WhatsAppService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.ultramsg.com/',
            'timeout' => 15
        ]);
    }

    public function sendMessage($instanceId, $token, $to, $message, $media = null, $mimeType = null, $quotedMessageId = null)
    {
        $payload = [
            'token' => $token,
            'to' => $to,
        ];
    
        if ($media) {
            $mediaUrl = url( '/public' . Storage::url($media));
            $extension = pathinfo($media, PATHINFO_EXTENSION);
    
            if ($mimeType) {
                if (str_starts_with($mimeType, 'audio/')) {
                    $endpoint = "{$instanceId}/messages/audio";
                    $payload['audio'] = $mediaUrl;
                } 
                elseif (str_starts_with($mimeType, 'image/')) {
                    $endpoint = "{$instanceId}/messages/image";
                    $payload['image'] = $mediaUrl;
                    $payload['caption'] = $message;
                }
                elseif (str_starts_with($mimeType, 'video/')) {
                    $endpoint = "{$instanceId}/messages/video";
                    $payload['video'] = $mediaUrl;
                    $payload['caption'] = $message;
                }
                elseif ($mimeType === 'application/pdf') {
                    $endpoint = "{$instanceId}/messages/document";
                    $payload['document'] = $mediaUrl;
                    $payload['filename'] = basename($media);
                    $payload['caption'] = $message;
                }
                else {
                    $endpoint = "{$instanceId}/messages/document";
                    $payload['document'] = $mediaUrl;
                    $payload['filename'] = basename($media);
                    $payload['caption'] = $message;
                }
            }
            else {
                if (in_array(strtolower($extension), ['mp3', 'aac', 'ogg', 'm4a', 'wav'])) {
                    $endpoint = "{$instanceId}/messages/audio";
                    $payload['audio'] = $mediaUrl;
                }
                elseif (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {
                    $endpoint = "{$instanceId}/messages/image";
                    $payload['image'] = $mediaUrl;
                    $payload['caption'] = $message;
                }
                elseif (in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'mkv'])) {
                    $endpoint = "{$instanceId}/messages/video";
                    $payload['video'] = $mediaUrl;
                    $payload['caption'] = $message;
                }
                else {
                    $endpoint = "{$instanceId}/messages/document";
                    $payload['document'] = $mediaUrl;
                    $payload['filename'] = basename($media);
                    $payload['caption'] = $message;
                }
            }
        } else {
            $endpoint = "{$instanceId}/messages/chat";
            $payload['body'] = $message;
        }
        if ($quotedMessageId) {
            $payload['msgId'] = $quotedMessageId;
        }

        try {
            $response = $this->client->post($endpoint, [
                'form_params' => $payload
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error: ' . $e->getMessage());
            return [
                'error' => true,
                'message' => 'Failed to send message',
                'exception' => $e->getMessage()
            ];
        }
    }

    public function deleteMessage($instanceId, $token, $messageId)
    {
        try {
            $response = $this->client->post("{$instanceId}/messages/delete", [
                'form_params' => [
                    'token' => $token,
                    'msgId' => $messageId
                ]
            ]);
    
            $result = json_decode($response->getBody(), true);
            
            return [
                'status' => $result['status'] ?? 'failed',
                'message' => $result['message'] ?? ($result['error'] ?? 'Unknown response'),
                'original_response' => $result 
            ];
            
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Failed to delete message',
                'error' => $e->getMessage()
            ];
        }
    }

    public function downloadMedia($mediaId, $instanceId, $token)
    {
        try {
            $response = $this->client->get("{$instanceId}/media/{$mediaId}", [
                'query' => ['token' => $token]
            ]);

            $extension = $this->getExtensionFromMime(
                $response->getHeader('Content-Type')[0]
            );

            $filename = Str::uuid().'.'.$extension;
            $path = "whatsapp/media/{$filename}";
            
            Storage::put($path, $response->getBody());

            return [
                'path' => $path,
                'mime_type' => $response->getHeader('Content-Type')[0]
            ];

        } catch (\Exception $e) {
            throw new \Exception("Media download failed: ".$e->getMessage());
        }
    }   

    // public function downloadMedia($mediaId, $instanceId, $token)
    // {
    //     $response = $this->client->get("{$instanceId}/media/{$mediaId}", [
    //         'headers' => [
    //             'Authorization' => 'Bearer '.$token,
    //             'Accept' => 'application/json'
    //         ]
    //     ]);

    //     $path = 'whatsapp/media/'.Str::uuid().'.bin';
    //     Storage::put($path, $response->getBody());

    //     return [
    //         'path' => $path,
    //         'mime_type' => $response->getHeader('Content-Type')[0]
    //     ];
    // }

    private function getExtensionFromMime($mime)
    {
        $map = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'audio/ogg' => 'ogg',
            'video/mp4' => 'mp4',
        ];

        return $map[$mime] ?? 'bin';
    }

    public function processBackup($file, $user)
    {
        // Implement backup processing logic
        // This would vary based on backup format
        // Here's a basic example for JSON format
        
        $stats = [
            'messages' => 0,
            'media' => 0,
            'contacts' => 0
        ];

        $data = json_decode($file->get(), true);

        foreach ($data['messages'] as $message) {
            // Process each message
            $stats['messages']++;
            
            if (isset($message['media'])) {
                $stats['media']++;
            }
        }

        return $stats;
    }

    public function blockContact($instanceId, $token, $chatId)
    {
        $response = Http::post("https://api.ultramsg.com/{$instanceId}/contacts/block", [
            'token' => $token,
            'chatId' => $chatId
        ]);
    
        return $response->json();
    }

    public function unblockContact($instanceId, $token, $chatId)
    {
        $response = Http::post("https://api.ultramsg.com/{$instanceId}/contacts/unblock", [
            'token' => $token,
            'chatId' => $chatId
        ]);
    
        return $response->json();
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\WooCommerceIntegration;
use App\Models\WooCommerceWebhook;
use Automattic\WooCommerce\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WooCommerceIntegrationController extends Controller
{
    public function index()
    {
        $integrations = WooCommerceIntegration::with('user', 'webhook')->get();
        return view('backend.woocommerce.index', compact('integrations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'domain' => 'required|url',
            'consumer_key' => 'required|string',
            'consumer_secret' => 'required|string',
        ]);

        $integration = WooCommerceIntegration::create([
            'user_id' => auth()->id(), 
            'domain' => $request->domain,
            'consumer_key' => $request->consumer_key,
            'consumer_secret' => $request->consumer_secret,
        ]);

        $woocommerce = new Client(
            $integration->domain,
            $integration->consumer_key,
            $integration->consumer_secret,
            ['version' => 'wc/v3']
        );

        $webhookUrl = route('webhooks.woocommerce.order_created');
        $secret = bin2hex(random_bytes(16));

        try {
            $response = $woocommerce->post('webhooks', [
                'name' => 'Order Created Webhook',
                'topic' => 'order.created',
                'delivery_url' => $webhookUrl,
                'secret' => $secret,
                'status' => 'active'
            ]);

            WooCommerceWebhook::create([
                'integration_id' => $integration->id,
                'webhook_id' => $response->id,
                'topic' => 'order.created',
                'status' => 'active',
                'secret' => $secret,
            ]);

            return redirect()->back()->with('success', 'Integration and webhook created successfully!');
        } catch (\Exception $e) {
            $integration->delete();
            Log::error('Failed to create webhook: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create webhook: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $integration = WooCommerceIntegration::with('webhook')->findOrFail($id);

        if ($integration->webhook) {
            try {
                $woocommerce = new Client(
                    $integration->domain,
                    $integration->consumer_key,
                    $integration->consumer_secret,
                    ['version' => 'wc/v3']
                );

                $woocommerce->delete('webhooks/' . $integration->webhook->webhook_id);
            } catch (\Exception $e) {
                Log::error('Failed to delete webhook: ' . $e->getMessage());
            }
        }

        $integration->delete();

        return redirect()->back()->with('success', 'Integration deleted successfully!');
    }
}
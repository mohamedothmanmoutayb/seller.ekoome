<?php

if (!function_exists('replaceTemplateVariables')) {
    function replaceTemplateVariables($template, $lead) {
        $replacements = [
            'customer-name' => $lead->name ?? '',
            'customer-phone' => $lead->phone ?? '',
            'customer-email' => $lead->email ?? '',
            'customer-address' => $lead->address ?? '',
            'customer-city' => $lead->city->name ?? '',
            'order-id' => $lead->id ?? '',
            'order-date' => $lead->created_at->format('Y-m-d H:i') ?? '',
            'delivery-date' => $lead->delivery_date ?? '',
            'order-total' => $lead->lead_value ?? '',
            'order-status' => $lead->status ?? '',
            'payment-method' => $lead->payment_method ?? '',
            'product-name' => $lead->products->pluck('name')->implode(', ') ?? '',
            'product-quantity' => $lead->products->sum('pivot.quantity') ?? '',
            'product-price' => $lead->products->sum('pivot.price') ?? '',
        ];

        foreach ($replacements as $key => $value) {
            $template = str_replace("{{ $key }}", $value, $template);
            $template = str_replace("{{$key}}", $value, $template);
        }

        return $template;
    }
}
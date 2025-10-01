<?php

namespace App\Services;

class RuleBasedIntentDetector
{
    public function detect(string $message): string
    {
        $message = strtolower(trim($message));
        
        $intentPatterns = [
            'track_order' => [
                ['track order', 2],
                ['track', 1], ['order', 1],
                ['where is my', 1], ['order status', 2],
                ['order tracking', 2]
            ],
            'view_products' => [
                ['view products', 2],
                ['products', 1], ['items', 1],
                ['show products', 2], ['list products', 2],
                ['browse', 1], ['catalog', 1]
            ],
            'view_special_offers' => [
                ['special offers', 2],
                ['offers', 1], ['deals', 1],
                ['promotions', 1], ['discounts', 1],
                ['sale', 1], ['limited time', 1]
            ],
            'find_seller' => [
                ['find seller', 2],
                ['change seller', 2],
                ['switch seller', 2],
                ['seller', 1], ['find', 1],
                ['change', 1], ['switch', 1],
                ['different seller', 2]
            ],
            'back' => [
                ['back', 1],
                ['go back', 2],
                ['return', 1],
                ['previous', 1],
                ['go to previous', 2]
            ],
            'help' => [
                ['help', 1],
                ['support', 1],
                ['what can you do', 2],
                ['how does this work', 2],
                ['options', 1]
            ]
        ];

        
        $intentScores = [];
        
        foreach ($intentPatterns as $intent => $patterns) {
            $intentScores[$intent] = 0;
            
            foreach ($patterns as $pattern) {
                list($keyword, $score) = $pattern;
                
                if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/', $message)) {
                    $intentScores[$intent] += $score;
                }
            }
        }
        
        arsort($intentScores);
        $topIntent = key($intentScores);
        
        return ($intentScores[$topIntent] > 1) ? $topIntent : 'unknown';
    }
}
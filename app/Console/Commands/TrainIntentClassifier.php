<?php


namespace App\Console\Commands;


use Illuminate\Console\Command;

use App\Services\IntentDetectionService;


class TrainIntentClassifier extends Command

{

    protected $signature = 'intent:train';

    protected $description = 'Train the intent classification model';


    public function handle(IntentDetectionService $detector)

    {

        $trainingData = $this->getEnhancedTrainingData();

       

        $detector->train($trainingData['samples'], $trainingData['labels']);

       

        $this->info('Intent classifier trained successfully!');

    }


    protected function getEnhancedTrainingData(): array

    {

        return [

            'samples' => [

                // Track Order

                'how do I track my order', 'where is my package', 'order status please',

                'track order #123', 'where is my shipment', 'status of my order',

                'check my order status', 'order tracking', 'where is my purchase',

                'when will my order arrive', 'delivery status', 'package location',

                'order #456 status', 'track my purchase', 'where is my item',

                'order delivery update', 'check delivery status', 'has my order shipped',

                'tracking information', 'order shipment status', 'find my package',

                'order arrival time', 'when is delivery', 'where is my parcel',

                'order dispatch status', 'track my shipment', 'order progress',

                'check order #789', 'status update for order', 'locate my order',

                'where is my stuff', 'order not arrived', 'track my recent purchase',

                'find my order', 'order location', 'package tracking',

                'delivery ETA', 'when will it arrive', 'shipping status',

                'where is my recent order', 'track order number', 'check shipment',

                'order not delivered', 'track purchase', 'find my shipment',

                'order delivery date', 'track my recent order', 'check order status',

                'where is my online order', 'track my online purchase',

               

                // View Products

                'show me products', 'what items do you have', 'list your products',

                'show catalog', 'what do you sell', 'display your items',

                'show me your inventory', 'what products available', 'browse items',

                'show me your goods', 'what can I buy', 'display merchandise',

                'show me your collection', 'what products do you offer', 'list inventory',

                'show me your range', 'what is available', 'display product list',

                'show me your selection', 'what goods available', 'browse products',

                'show me your stock', 'what can you provide', 'display available items',

                'show me your wares', 'what merchandise available', 'list your goods',

                'show me your offerings', 'what is for sale', 'display your collection',

                'show me smartphones', 'what clothes available', 'list electronics',

                'show home appliances', 'display kitchen items', 'what books available',

                'show me laptops', 'what shoes do you have', 'list furniture',

                'show beauty products', 'display sports equipment', 'what toys available',

                'show me watches', 'what jewelry available', 'list baby products',

                'show me tools', 'display garden items', 'what pet supplies available',

               

                // Special Offers

                'any special offers', 'current promotions', 'do you have discounts',

                'show me deals', 'any sales going on', 'what offers available',

                'are there any discounts', 'show promotions', 'any current deals',

                'what specials available', 'show me bargains', 'any price reductions',

                'are there sales', 'show discounts', 'what promotions running',

                'any limited offers', 'show me special prices', 'any clearance sales',

                'what deals today', 'show me markdowns', 'any seasonal discounts',

                'what bargain offers', 'show me reduced items', 'any holiday sales',

                'what flash sales', 'show me discounted products', 'any price cuts',

                'what sale items', 'show me promotional offers', 'any exclusive deals',

                'show me today offers', 'what discounts now', 'any weekend deals',

                'show me best deals', 'what special prices', 'any member discounts',

                'show me clearance items', 'what seasonal offers', 'any holiday discounts',

                'show me limited offers', 'what exclusive promotions', 'any bundle deals',

                'show me combo offers', 'what package deals', 'any buy one get one',

                'show me gift offers', 'what loyalty discounts', 'any coupon codes',

               

                // Find Seller

                'I want to change seller', 'find me a seller', 'switch seller',

                'different seller please', 'need new seller', 'change to another seller',

                'I want another vendor', 'find different seller', 'change merchant',

                'look for new seller', 'I need different provider', 'change supplier',

                'find another retailer', 'switch to new seller', 'locate different vendor',

                'I want to try another seller', 'find alternate seller', 'change trader',

                'look for another merchant', 'need different distributor', 'change dealer',

                'find me another provider', 'switch to different seller', 'locate new vendor',

                'I want different supplier', 'find another retailer', 'change to new merchant',

                'look for alternate seller', 'need another trader', 'change to different provider',

                'find better seller', 'switch to better vendor', 'change to another provider',

                'find me a different seller', 'need another supplier', 'change to new vendor',

                'find me a new seller', 'switch to another merchant', 'change to different trader',

                'find alternative seller', 'need another dealer', 'change to another distributor',

                'find me another vendor', 'switch to different provider', 'change to new supplier',

                'find me a better seller', 'need to change seller', 'find different vendor',

               

                // Back Menu

                'go back to main menu', 'return to menu', 'back',

                'previous menu', 'go back', 'return',

                'take me back', 'back to start', 'main menu',

                'return to main screen', 'go to homepage', 'back to beginning',

                'start over', 'back to main', 'return to start',

                'go back to beginning', 'back to first menu', 'return to home',

                'take me to main menu', 'back to main page', 'return to main',

                'go back home', 'back to start menu', 'return to first screen',

                'take me to home', 'back to initial menu', 'return to base',

                'go back to start', 'back to home screen', 'return to root menu',

                'menu please', 'go to menu', 'show menu',

                'back to options', 'return to choices', 'main screen',

                'home please', 'start menu', 'initial screen',

                'back to dashboard', 'return to selection', 'main options',

                'go to main', 'back to list', 'return to home screen',

                'show main menu', 'back to categories', 'return to main options',

               

                // Negative examples

                'hello', 'hi there', 'good morning',

                'thanks', 'thank you', 'appreciate it',

                'goodbye', 'bye', 'see you later',

                'help', 'I need help', 'can you assist',

                'what time is it', 'what day is today', 'how are you',

                'who are you', 'what can you do', 'your name',

                'okay', 'yes', 'no',

                'maybe', 'later', 'not now',

                'cancel', 'stop', 'enough',

                'what', 'huh', 'repeat that',

                'who is this', 'are you human', 'what is this',

                'I dont understand', 'not sure', 'confused',

                'who made you', 'what is your purpose', 'how old are you',

                'where are you', 'what language', 'can you speak french',

                'good night', 'have a nice day', 'take care',

                'sorry', 'my bad', 'excuse me',

                'please', 'thanks again', 'much appreciated'

            ],



            'labels' => [

                ...array_fill(0, 49, 'track_order'),

                ...array_fill(0, 49, 'view_products'),

                ...array_fill(0, 49, 'view_special_offers'),

                ...array_fill(0, 49, 'find_seller'),

                ...array_fill(0, 49, 'back_menu'),

                ...array_fill(0, 48, 'unknown')

            ]


        ];

    }

}

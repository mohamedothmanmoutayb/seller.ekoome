<?php

return [
    /* Common Responses */
    'welcome' => "👋 *Welcome!* How can I assist you today?",
    'unknown_intent' => "🤔 I didn't understand. Please choose a valid option:",
    'invalid_selection' => "❌ Invalid selection. Please choose a valid option.",
    'choose_from_numbers' => "⚠️ Please choose from the numbers below.",
    'chatbot_disabled' => "🚫 The chatbot is currently unavailable. Please contact the seller directly.",
    'command_disabled' => "🚫 This feature is currently disabled.",
    'choose_option' => "Please enter the number of your choice.",

    /* Menu Options */
    'menu_view_products' => "📦 View Products",
    'menu_find_seller' => "🔍 Find Seller",
    'menu_track_order' => "📮 Track Order", 
    'menu_special_offers' => "🏷️ Special Offers",
    'menu_change_language' => "🌐 Change Language",

    /* Order Tracking */
    'order_details' => "📮 *Order Details:*\n\n📦 *Order ID:* #:order_id\n📝 *Status:* :status\n📅 *Date:* :date",
    'request_order_id' => "📮 Please provide your *Order ID* (numbers only).\nType 'back' to return to main menu.",
    'order_not_found' => "❌ Order #:order_id not found. Please check your order ID.",


    // Order Confirmation */
    'order_cancelled' => "❌ Your order has been cancelled. Let us know if you need assistance.",
    'confirm_now_button' => "1️⃣ Confirm Now",
    'schedule_button' => "2️⃣ Schedule Delivery",
    'cancel_button' => "❌ Cancel Order",
    'edit_button' => 'Edit Informations',
    'edit_lead_name_prompt' => '✏️ Please send your new name (current: :current):',
    'edit_lead_phone_prompt' => '📱 Please send your new phone number (current: :current):',
    'edit_lead_email_prompt' => '📧 Please send your new email (current: :current). Send "skip" to keep current:',
    'edit_lead_address_prompt' => '🏠 Please send your new address (current: :current). Send "skip" to keep current:',
    'field_skipped' => '✅ Kept the current value',
    'invalid_name' => '❌ Please enter a valid name',
    'invalid_phone' => '❌ Please enter a valid phone number',
    'invalid_email' => '❌ Please enter a valid email or "skip"',
    'edit_lead_confirmation' => 'Please confirm your changes:' . "\n\n" .
                               'Name: :name' . "\n" .
                               'Phone: :phone' . "\n" .
                               'Email: :email' . "\n" .
                               'Address: :address',
    'confirm_edit_prompt' => 'Reply "yes" to confirm or "no" to cancel.',
    'lead_updated_successfully' => 'Your information has been updated successfully!',
    'edit_cancelled' => 'Edit cancelled. Your information remains unchanged.',
    'edit_session_expired' => 'Edit session expired. Please start again if needed.',
    'invalid_name' => 'Please provide a valid name.',
    'invalid_phone' => 'Please provide a valid phone number.',
    'invalid_email' => 'Please provide a valid email address or "skip".',
    'not_provided' => 'Not provided',
    'order_confirmed_immediate' => "✅ Your order has been confirmed for immediate processing!",
    'order_confirmed_scheduled' => "✅ Your order has been confirmed for delivery on :date!",
    'request_delivery_date' => "📅 Please enter your preferred delivery date (YYYY-MM-DD):",
    'date_format_hint' => "Example: 2025-01-16 for January 16, 2025",
    'delivery_date_too_early' => "⚠️ The date must be at least :date. Please choose a later date.",
    'delivery_date_too_late' => "⚠️ We can't schedule deliveries beyond :date. Please choose an earlier date.",
    'invalid_confirmation_option' => "❌ Invalid option. Please choose 'Confirm Now', 'Schedule', or 'Cancel'.",
    'invalid_date_format' => "❌ Invalid date format. Please use YYYY-MM-DD format.",
    'customer_details_confirmation' => "🔍 Please confirm the following details as well:\n\n👤 Name: :name\n📞 Phone: :phone\n📧 Email: :email\n🏠 Address: :address\n\n",
    'confirm_details_prompt' => "Can you confirm the following details ❓",
    'lead_not_found' => "❌ Lead not found",
    'details_confirmed' => "✅ Details confirmed successfully",

    /* Seller Selection */
    'seller_list_header' => "🔍 *Available Sellers:*",
    'seller_list_footer' => "Reply with the seller number to select.",
    'no_sellers' => "⚠️ Currently no sellers available. Please try again later.",
    'seller_selected' => "✅ Seller selected! You can now view products or offers.",

    /* Product Management */
    'product_list_header' => "🛍️ *Products from :seller:*",
    'product_list_footer' => "Reply with the product number for details.",
    'product_details' => "🔍 *Product Details:*\n\n📦 *Name:* :name\n💰 *Price:* :price :currency\n📝 *Description:* :description\n📦 *Availability:* :quantity in stock",
    'product_not_found' => "❌ Product not found. Please try again.",
    'product_session_expired' => "⚠️ Product session expired. Please select again.",
    'back_to_products' => "Type 'back' to return to products list",

    /* Special Offers */
    'special_offers_header' => "🏷️ *Special Offers:*",
    'offer_item' => "📦 *:name* - :price :currency\n📝 *Details:* :description",
    'no_offers' => "🏷️ No special offers available currently.",
    'special_offer_item' => "🎁 Get :quantity of :product_name for :price :currency",

    /* Language Management */
    'language_menu' => "🌐 Please select your language:",
    'language_set' => "✅ Language changed to :language",
    'invalid_language' => "❌ Invalid language selection.",
    'select_language_prompt' => "Type the number of your preferred language:",

    /* Navigation */
    'back_to_menu' => "↩️ Back to main menu",
    'help_prompt' => "Type 'help' at any time for options.",

    /* Confirmation  */
    'order_item' => ":product × :quantity",
    'stock_alert_item' => "• :product (Available: :available, Needed: :needed)",
    'order_alert_stock' => "⚠️ *Order Alert - Stock Issue*\n\nHello Team,\n\nWe have a stock shortage for order #:order_id:\n\n:items\n\nCustomer: :customer_name\nPlease take immediate action to address this.\n\nThank you!",
    'order_confirmation' => "🛍️ *Order Confirmation #:order_id*\n\nDear :customer_name,\n\nThank you for your order! Here are the details:\n\n📦 *Order Items:*\n:items\n\n💵 *Total Amount:* :total :currency\n\nPlease reply with:\n✅ *:confirm* to confirm your order\n❌ *:cancel* to cancel\n\nWe appreciate your business!",
    'confirm_button' => "Confirm Informations",
    'cancel_button' => "Cancel",

    /* AI Assistant */
    'ai_no_response' => "🤖💬 Hmm, I didn't quite get a response from my AI assistant. Could you try asking your question again?",
    'ai_unavailable' => "⚠️🔧 Our AI assistant is taking a quick break. Please try again in a little while!",
    'ai_connection_error' => "🔌😕 Oops! I'm having trouble connecting to the AI assistant. You can try asking your question differently or come back later.",

];
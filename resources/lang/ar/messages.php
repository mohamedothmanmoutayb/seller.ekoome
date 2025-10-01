<?php

return [
    /* Common Responses */
    'welcome' => "👋 *مرحبًا بك!* كيف يمكنني مساعدتك اليوم؟",
    'unknown_intent' => "🤔 لم أفهم. الرجاء اختيار خيار صالح:",
    'invalid_selection' => "❌ اختيار غير صالح. الرجاء اختيار خيار صالح.",
    'choose_from_numbers' => "⚠️ الرجاء الاختيار من الأرقام أدناه.",
    'chatbot_disabled' => "🚫 روبوت المحادثة غير متاح حاليًا. الرجاء التواصل مع البائع مباشرة.",
    'command_disabled' => "🚫 هذه الميزة غير متاحة حاليًا.",
    'choose_option' => "الرجاء إدخال رقم خيارك.",

    /* Menu Options */
    'menu_view_products' => "📦 عرض المنتجات",
    'menu_find_seller' => "🔍 البحث عن بائع",
    'menu_track_order' => "📮 تتبع الطلب", 
    'menu_special_offers' => "🏷️ عروض خاصة",
    'menu_change_language' => "🌐 تغيير اللغة",

    /* Order Tracking */
    'order_details' => "📮 *تفاصيل الطلب:*\n\n📦 *رقم الطلب:* #:order_id\n📝 *الحالة:* :status\n📅 *التاريخ:* :date",
    'request_order_id' => "📮 الرجاء إدخال *رقم الطلب* (أرقام فقط).\nاكتب 'back' للعودة إلى القائمة الرئيسية.",
    'order_not_found' => "❌ الطلب #:order_id غير موجود. الرجاء التحقق من رقم الطلب.",

    /* Order Confirmation */
    'order_cancelled' => "❌ تم إلغاء طلبك. أخبرنا إذا كنت بحاجة إلى مساعدة.",
    'confirm_now_button' => "1️⃣ تأكيد الآن",
    'schedule_button' => "2️⃣ جدولة التسليم",
    'cancel_button' => "❌ إلغاء الطلب",
    'edit_button' => 'تعديل المعلومات',
    'edit_lead_name_prompt' => '✏️ الرجاء إرسال اسمك الجديد (الحالي: :current):',
    'edit_lead_phone_prompt' => '📱 الرجاء إرسال رقم هاتفك الجديد (الحالي: :current):',
    'edit_lead_email_prompt' => '📧 الرجاء إرسال بريدك الإلكتروني الجديد (الحالي: :current). اكتب "skip" للحفاظ على الحالي:',
    'edit_lead_address_prompt' => '🏠 الرجاء إرسال عنوانك الجديد (الحالي: :current). اكتب "skip" للحفاظ على الحالي:',
    'field_skipped' => '✅ تم الاحتفاظ بالقيمة الحالية',
    'invalid_name' => '❌ الرجاء إدخال اسم صالح',
    'invalid_phone' => '❌ الرجاء إدخال رقم هاتف صالح',
    'invalid_email' => '❌ الرجاء إدخال بريد إلكتروني صالح أو "skip"',
    'edit_lead_confirmation' => 'الرجاء تأكيد التغييرات:' . "\n\n" .
                               'الاسم: :name' . "\n" .
                               'الهاتف: :phone' . "\n" .
                               'البريد الإلكتروني: :email' . "\n" .
                               'العنوان: :address',
    'confirm_edit_prompt' => 'اكتب "yes" للتأكيد أو "no" للإلغاء.',
    'lead_updated_successfully' => 'تم تحديث معلوماتك بنجاح!',
    'edit_cancelled' => 'تم إلغاء التعديل. معلوماتك لم تتغير.',
    'edit_session_expired' => 'انتهت جلسة التعديل. الرجاء البدء مرة أخرى إذا لزم الأمر.',
    'not_provided' => 'غير متوفر',
    'order_confirmed_immediate' => "✅ تم تأكيد طلبك للمعالجة الفورية!",
    'order_confirmed_scheduled' => "✅ تم تأكيد طلبك للتسليم في :date!",
    'request_delivery_date' => "📅 الرجاء إدخال تاريخ التسليم المفضل (YYYY-MM-DD):",
    'date_format_hint' => "مثال: 2025-01-16 لـ 16 يناير 2025",
    'delivery_date_too_early' => "⚠️ يجب أن يكون التاريخ على الأقل :date. الرجاء اختيار تاريخ لاحق.",
    'delivery_date_too_late' => "⚠️ لا يمكننا جدولة التسليم بعد :date. الرجاء اختيار تاريخ أبكر.",
    'invalid_confirmation_option' => "❌ خيار غير صالح. الرجاء اختيار 'تأكيد الآن'، 'جدولة'، أو 'إلغاء'.",
    'invalid_date_format' => "❌ تنسيق تاريخ غير صالح. الرجاء استخدام تنسيق YYYY-MM-DD.",
    'customer_details_confirmation' => "🔍 الرجاء تأكيد التفاصيل التالية:\n\n👤 الاسم: :name\n📞 الهاتف: :phone\n📧 البريد الإلكتروني: :email\n🏠 العنوان: :address\n\n",
    'confirm_details_prompt' => "هل يمكنك تأكيد التفاصيل التالية ؟",
    'lead_not_found' => "❌ لم يتم العثور على العميل المحتمل",
    'details_confirmed' => "✅ تم تأكيد التفاصيل بنجاح",

    /* Seller Selection */
    'seller_list_header' => "🔍 *البائعون المتاحون:*",
    'seller_list_footer' => "رد برقم البائع للتحديد.",
    'no_sellers' => "⚠️ لا يوجد بائعون متاحون حالياً. الرجاء المحاولة لاحقاً.",
    'seller_selected' => "✅ تم اختيار البائع! يمكنك الآن عرض المنتجات أو العروض.",

    /* Product Management */
    'product_list_header' => "🛍️ *المنتجات من :seller:*",
    'product_list_footer' => "رد برقم المنتج للتفاصيل.",
    'product_details' => "🔍 *تفاصيل المنتج:*\n\n📦 *الاسم:* :name\n💰 *السعر:* :price :currency\n📝 *الوصف:* :description\n📦 *التوفر:* :quantity في المخزن",
    'product_not_found' => "❌ المنتج غير موجود. الرجاء المحاولة مرة أخرى.",
    'product_session_expired' => "⚠️ انتهت جلسة المنتج. الرجاء التحديد مرة أخرى.",
    'back_to_products' => "اكتب 'back' للعودة إلى قائمة المنتجات",

    /* Special Offers */
    'special_offers_header' => "🏷️ *عروض خاصة:*",
    'offer_item' => "📦 *:name* - :price :currency\n📝 *التفاصيل:* :description",
    'no_offers' => "🏷️ لا توجد عروض خاصة متاحة حالياً.",
    'special_offer_item' => "🎁 احصل على :quantity من :product_name مقابل :price :currency",

    /* Language Management */
    'language_menu' => "🌐 الرجاء اختيار لغتك:",
    'language_set' => "✅ تم تغيير اللغة إلى :language",
    'invalid_language' => "❌ اختيار لغة غير صالح.",
    'select_language_prompt' => "اكتب رقم لغتك المفضلة:",

    /* Navigation */
    'back_to_menu' => "↩️ العودة إلى القائمة الرئيسية",
    'help_prompt' => "اكتب 'help' في أي وقت للخيارات.",

    /* Confirmation */
    'order_item' => ":product × :quantity",
    'stock_alert_item' => "• :product (المتاح: :available, المطلوب: :needed)",
    'order_alert_stock' => "⚠️ *تنبيه الطلب - مشكلة في المخزون*\n\nمرحباً فريقنا,\n\nهناك نقص في المخزون للطلب #:order_id:\n\n:items\n\nالعميل: :customer_name\nالرجاء اتخاذ إجراء فوري لمعالجة هذا الأمر.\n\nشكراً لكم!",
    'order_confirmation' => "🛍️ *تأكيد الطلب #:order_id*\n\nعزيزي :customer_name,\n\nشكراً لطلبك! إليك التفاصيل:\n\n📦 *عناصر الطلب:*\n:items\n\n💵 *المبلغ الإجمالي:* :total :currency\n\nالرجاء الرد بـ:\n✅ *:confirm* لتأكيد طلبك\n❌ *:cancel* للإلغاء\n\nنقدر عملك معنا!",
    'confirm_button' => "تأكيد المعلومات",
    'cancel_button' => "إلغاء",

    /* AI Assistant */
    'ai_no_response' => "🤖💬 لم أحصل على رد من مساعدي الذكي. هل يمكنك إعادة طرح سؤالك؟",
    'ai_unavailable' => "⚠️🔧 مساعدنا الذكي يأخذ استراحة سريعة. الرجاء المحاولة لاحقاً!",
    'ai_connection_error' => "🔌😕 عذراً! أواجه مشكلة في الاتصال بالمساعد الذكي. يمكنك إعادة صياغة سؤالك أو المحاولة لاحقاً.",
];
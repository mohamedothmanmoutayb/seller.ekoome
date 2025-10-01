<?php

return [
    /* Common Responses */
    'welcome' => "👋 *¡Bienvenido!* ¿Cómo puedo ayudarte hoy?",
    'unknown_intent' => "🤔 No entendí. Por favor elige una opción válida:",
    'invalid_selection' => "❌ Selección inválida. Por favor elige una opción válida.",
    'choose_from_numbers' => "⚠️ Por favor elige entre los números a continuación.",
    'chatbot_disabled' => "🚫 El chatbot no está disponible actualmente. Por favor contacta al vendedor directamente.",
    'command_disabled' => "🚫 Esta función está actualmente deshabilitada.",
    'choose_option' => "Por favor ingresa el número de tu elección.",

    /* Menu Options */
    'menu_view_products' => "📦 Ver productos",
    'menu_find_seller' => "🔍 Encontrar vendedor",
    'menu_track_order' => "📮 Rastrear pedido", 
    'menu_special_offers' => "🏷️ Ofertas especiales",
    'menu_change_language' => "🌐 Cambiar idioma",

    /* Order Tracking */
    'order_details' => "📮 *Detalles del pedido:*\n\n📦 *Número de pedido:* #:order_id\n📝 *Estado:* :status\n📅 *Fecha:* :date",
    'request_order_id' => "📮 Por favor proporciona tu *Número de pedido* (solo números).\nEscribe 'back' para volver al menú principal.",
    'order_not_found' => "❌ Pedido #:order_id no encontrado. Por favor verifica tu número de pedido.",

    /* Order Confirmation */
    'order_cancelled' => "❌ Tu pedido ha sido cancelado. Háznoslo saber si necesitas ayuda.",
    'confirm_now_button' => "1️⃣ Confirmar ahora",
    'schedule_button' => "2️⃣ Programar entrega",
    'cancel_button' => "❌ Cancelar pedido",
    'edit_button' => 'Editar información',
    'edit_lead_name_prompt' => '✏️ Por favor envía tu nuevo nombre (actual: :current):',
    'edit_lead_phone_prompt' => '📱 Por favor envía tu nuevo número de teléfono (actual: :current):',
    'edit_lead_email_prompt' => '📧 Por favor envía tu nuevo correo (actual: :current). Envía "skip" para mantener el actual:',
    'edit_lead_address_prompt' => '🏠 Por favor envía tu nueva dirección (actual: :current). Envía "skip" para mantener la actual:',
    'field_skipped' => '✅ Se mantuvo el valor actual',
    'invalid_name' => '❌ Por favor ingresa un nombre válido',
    'invalid_phone' => '❌ Por favor ingresa un número de teléfono válido',
    'invalid_email' => '❌ Por favor ingresa un correo válido o "skip"',
    'edit_lead_confirmation' => 'Por favor confirma tus cambios:' . "\n\n" .
                               'Nombre: :name' . "\n" .
                               'Teléfono: :phone' . "\n" .
                               'Correo: :email' . "\n" .
                               'Dirección: :address',
    'confirm_edit_prompt' => 'Responde "yes" para confirmar o "no" para cancelar.',
    'lead_updated_successfully' => '¡Tu información ha sido actualizada con éxito!',
    'edit_cancelled' => 'Edición cancelada. Tu información permanece sin cambios.',
    'edit_session_expired' => 'Sesión de edición expirada. Por favor comienza de nuevo si es necesario.',
    'not_provided' => 'No proporcionado',
    'order_confirmed_immediate' => "✅ ¡Tu pedido ha sido confirmado para procesamiento inmediato!",
    'order_confirmed_scheduled' => "✅ ¡Tu pedido ha sido confirmado para entrega el :date!",
    'request_delivery_date' => "📅 Por favor ingresa tu fecha de entrega preferida (AAAA-MM-DD):",
    'date_format_hint' => "Ejemplo: 2025-01-16 para 16 de enero de 2025",
    'delivery_date_too_early' => "⚠️ La fecha debe ser al menos :date. Por favor elige una fecha posterior.",
    'delivery_date_too_late' => "⚠️ No podemos programar entregas después de :date. Por favor elige una fecha anterior.",
    'invalid_confirmation_option' => "❌ Opción inválida. Por favor elige 'Confirmar ahora', 'Programar' o 'Cancelar'.",
    'invalid_date_format' => "❌ Formato de fecha inválido. Por favor usa el formato AAAA-MM-DD.",
    'customer_details_confirmation' => "🔍 Por favor también confirma los siguientes detalles:\n\n👤 Nombre: :name\n📞 Teléfono: :phone\n📧 Correo: :email\n🏠 Dirección: :address\n\n",
    'confirm_details_prompt' => "¿Puedes confirmar los siguientes detalles ❓",
    'lead_not_found' => "❌ Prospecto no encontrado",
    'details_confirmed' => "✅ Detalles confirmados con éxito",

    /* Seller Selection */
    'seller_list_header' => "🔍 *Vendedores disponibles:*",
    'seller_list_footer' => "Responde con el número del vendedor para seleccionar.",
    'no_sellers' => "⚠️ Actualmente no hay vendedores disponibles. Por favor intenta más tarde.",
    'seller_selected' => "✅ ¡Vendedor seleccionado! Ahora puedes ver productos u ofertas.",

    /* Product Management */
    'product_list_header' => "🛍️ *Productos de :seller:*",
    'product_list_footer' => "Responde con el número del producto para detalles.",
    'product_details' => "🔍 *Detalles del producto:*\n\n📦 *Nombre:* :name\n💰 *Precio:* :price :currency\n📝 *Descripción:* :description\n📦 *Disponibilidad:* :quantity en stock",
    'product_not_found' => "❌ Producto no encontrado. Por favor intenta de nuevo.",
    'product_session_expired' => "⚠️ Sesión de producto expirada. Por favor selecciona de nuevo.",
    'back_to_products' => "Escribe 'back' para volver a la lista de productos",

    /* Special Offers */
    'special_offers_header' => "🏷️ *Ofertas especiales:*",
    'offer_item' => "📦 *:name* - :price :currency\n📝 *Detalles:* :description",
    'no_offers' => "🏷️ No hay ofertas especiales disponibles actualmente.",
    'special_offer_item' => "🎁 Obtén :quantity de :product_name por :price :currency",

    /* Language Management */
    'language_menu' => "🌐 Por favor selecciona tu idioma:",
    'language_set' => "✅ Idioma cambiado a :language",
    'invalid_language' => "❌ Selección de idioma inválida.",
    'select_language_prompt' => "Escribe el número de tu idioma preferido:",

    /* Navigation */
    'back_to_menu' => "↩️ Volver al menú principal",
    'help_prompt' => "Escribe 'help' en cualquier momento para ver opciones.",

    /* Confirmation */
    'order_item' => ":product × :quantity",
    'stock_alert_item' => "• :product (Disponible: :available, Necesario: :needed)",
    'order_alert_stock' => "⚠️ *Alerta de pedido - Problema de stock*\n\nHola equipo,\n\nTenemos escasez de stock para el pedido #:order_id:\n\n:items\n\nCliente: :customer_name\nPor favor tomen acción inmediata para resolver esto.\n\n¡Gracias!",
    'order_confirmation' => "🛍️ *Confirmación de pedido #:order_id*\n\nEstimado :customer_name,\n\n¡Gracias por tu pedido! Aquí están los detalles:\n\n📦 *Artículos del pedido:*\n:items\n\n💵 *Monto total:* :total :currency\n\nPor favor responde con:\n✅ *:confirm* para confirmar tu pedido\n❌ *:cancel* para cancelar\n\n¡Apreciamos tu negocio!",
    'confirm_button' => "Confirmar información",
    'cancel_button' => "Cancelar",

    /* AI Assistant */
    'ai_no_response' => "🤖💬 Hmm, no recibí respuesta de mi asistente de IA. ¿Podrías intentar reformular tu pregunta?",
    'ai_unavailable' => "⚠️🔧 Nuestro asistente de IA está tomando un descanso rápido. ¡Por favor intenta de nuevo en un rato!",
    'ai_connection_error' => "🔌😕 ¡Oops! Estoy teniendo problemas para conectarme al asistente de IA. Puedes intentar reformular tu pregunta o volver más tarde.",
];
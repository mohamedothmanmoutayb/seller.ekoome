<?php

return [
    /* Common Responses */
    'welcome' => "👋 *Bienvenue!* Comment puis-je vous aider aujourd'hui?",
    'unknown_intent' => "🤔 Je n'ai pas compris. Veuillez choisir une option valide:",
    'invalid_selection' => "❌ Sélection invalide. Veuillez choisir une option valide.",
    'choose_from_numbers' => "⚠️ Veuillez choisir parmi les numéros ci-dessous.",
    'chatbot_disabled' => "🚫 Le chatbot est actuellement indisponible. Veuillez contacter le vendeur directement.",
    'command_disabled' => "🚫 Cette fonctionnalité est actuellement désactivée.",
    'choose_option' => "Veuillez entrer le numéro de votre choix.",

    /* Menu Options */
    'menu_view_products' => "📦 Voir les produits",
    'menu_find_seller' => "🔍 Trouver un vendeur",
    'menu_track_order' => "📮 Suivi de commande", 
    'menu_special_offers' => "🏷️ Offres spéciales",
    'menu_change_language' => "🌐 Changer de langue",

    /* Order Tracking */
    'order_details' => "📮 *Détails de la commande:*\n\n📦 *Numéro de commande:* #:order_id\n📝 *Statut:* :status\n📅 *Date:* :date",
    'request_order_id' => "📮 Veuillez fournir votre *numéro de commande* (chiffres uniquement).\nTapez 'back' pour revenir au menu principal.",
    'order_not_found' => "❌ Commande #:order_id introuvable. Veuillez vérifier votre numéro de commande.",

    /* Order Confirmation */
    'order_cancelled' => "❌ Votre commande a été annulée. Faites-nous savoir si vous avez besoin d'aide.",
    'confirm_now_button' => "1️⃣ Confirmer maintenant",
    'schedule_button' => "2️⃣ Planifier la livraison",
    'cancel_button' => "❌ Annuler la commande",
    'edit_button' => 'Modifier les informations',
    'edit_lead_name_prompt' => '✏️ Veuillez envoyer votre nouveau nom (actuel: :current):',
    'edit_lead_phone_prompt' => '📱 Veuillez envoyer votre nouveau numéro de téléphone (actuel: :current):',
    'edit_lead_email_prompt' => '📧 Veuillez envoyer votre nouvel email (actuel: :current). Envoyez "skip" pour garder l\'actuel:',
    'edit_lead_address_prompt' => '🏠 Veuillez envoyer votre nouvelle adresse (actuel: :current). Envoyez "skip" pour garder l\'actuel:',
    'field_skipped' => '✅ Valeur actuelle conservée',
    'invalid_name' => '❌ Veuillez entrer un nom valide',
    'invalid_phone' => '❌ Veuillez entrer un numéro de téléphone valide',
    'invalid_email' => '❌ Veuillez entrer un email valide ou "skip"',
    'edit_lead_confirmation' => 'Veuillez confirmer vos modifications:' . "\n\n" .
                               'Nom: :name' . "\n" .
                               'Téléphone: :phone' . "\n" .
                               'Email: :email' . "\n" .
                               'Adresse: :address',
    'confirm_edit_prompt' => 'Répondez "yes" pour confirmer ou "no" pour annuler.',
    'lead_updated_successfully' => 'Vos informations ont été mises à jour avec succès!',
    'edit_cancelled' => 'Modification annulée. Vos informations restent inchangées.',
    'edit_session_expired' => 'Session de modification expirée. Veuillez recommencer si nécessaire.',
    'not_provided' => 'Non fourni',
    'order_confirmed_immediate' => "✅ Votre commande a été confirmée pour un traitement immédiat!",
    'order_confirmed_scheduled' => "✅ Votre commande a été confirmée pour une livraison le :date!",
    'request_delivery_date' => "📅 Veuillez entrer votre date de livraison préférée (AAAA-MM-JJ):",
    'date_format_hint' => "Exemple: 2025-01-16 pour le 16 janvier 2025",
    'delivery_date_too_early' => "⚠️ La date doit être au moins le :date. Veuillez choisir une date ultérieure.",
    'delivery_date_too_late' => "⚠️ Nous ne pouvons pas planifier de livraisons après le :date. Veuillez choisir une date antérieure.",
    'invalid_confirmation_option' => "❌ Option invalide. Veuillez choisir 'Confirmer maintenant', 'Planifier' ou 'Annuler'.",
    'invalid_date_format' => "❌ Format de date invalide. Veuillez utiliser le format AAAA-MM-JJ.",
    'customer_details_confirmation' => "🔍 Veuillez également confirmer les détails suivants:\n\n👤 Nom: :name\n📞 Téléphone: :phone\n📧 Email: :email\n🏠 Adresse: :address\n\n",
    'confirm_details_prompt' => "Pouvez-vous confirmer les détails suivants ❓",
    'lead_not_found' => "❌ Prospect introuvable",
    'details_confirmed' => "✅ Détails confirmés avec succès",

    /* Seller Selection */
    'seller_list_header' => "🔍 *Vendeurs disponibles:*",
    'seller_list_footer' => "Répondez avec le numéro du vendeur pour sélectionner.",
    'no_sellers' => "⚠️ Aucun vendeur disponible actuellement. Veuillez réessayer plus tard.",
    'seller_selected' => "✅ Vendeur sélectionné! Vous pouvez maintenant voir les produits ou les offres.",

    /* Product Management */
    'product_list_header' => "🛍️ *Produits de :seller:*",
    'product_list_footer' => "Répondez avec le numéro du produit pour les détails.",
    'product_details' => "🔍 *Détails du produit:*\n\n📦 *Nom:* :name\n💰 *Prix:* :price :currency\n📝 *Description:* :description\n📦 *Disponibilité:* :quantity en stock",
    'product_not_found' => "❌ Produit introuvable. Veuillez réessayer.",
    'product_session_expired' => "⚠️ Session produit expirée. Veuillez sélectionner à nouveau.",
    'back_to_products' => "Tapez 'back' pour retourner à la liste des produits",

    /* Special Offers */
    'special_offers_header' => "🏷️ *Offres spéciales:*",
    'offer_item' => "📦 *:name* - :price :currency\n📝 *Détails:* :description",
    'no_offers' => "🏷️ Aucune offre spéciale disponible actuellement.",
    'special_offer_item' => "🎁 Obtenez :quantity de :product_name pour :price :currency",

    /* Language Management */
    'language_menu' => "🌐 Veuillez sélectionner votre langue:",
    'language_set' => "✅ Langue changée en :language",
    'invalid_language' => "❌ Sélection de langue invalide.",
    'select_language_prompt' => "Tapez le numéro de votre langue préférée:",

    /* Navigation */
    'back_to_menu' => "↩️ Retour au menu principal",
    'help_prompt' => "Tapez 'help' à tout moment pour les options.",

    /* Confirmation */
    'order_item' => ":product × :quantity",
    'stock_alert_item' => "• :product (Disponible: :available, Nécessaire: :needed)",
    'order_alert_stock' => "⚠️ *Alerte de commande - Problème de stock*\n\nBonjour l'équipe,\n\nNous avons une pénurie de stock pour la commande #:order_id:\n\n:items\n\nClient: :customer_name\nVeuillez prendre des mesures immédiates pour résoudre ce problème.\n\nMerci!",
    'order_confirmation' => "🛍️ *Confirmation de commande #:order_id*\n\nCher :customer_name,\n\nMerci pour votre commande! Voici les détails:\n\n📦 *Articles commandés:*\n:items\n\n💵 *Montant total:* :total :currency\n\nVeuillez répondre avec:\n✅ *:confirm* pour confirmer votre commande\n❌ *:cancel* pour annuler\n\nNous apprécions votre confiance!",
    'confirm_button' => "Confirmer les informations",
    'cancel_button' => "Annuler",

    /* AI Assistant */
    'ai_no_response' => "🤖💬 Hmm, je n'ai pas reçu de réponse de mon assistant IA. Pourriez-vous reformuler votre question?",
    'ai_unavailable' => "⚠️🔧 Notre assistant IA prend une petite pause. Veuillez réessayer un peu plus tard!",
    'ai_connection_error' => "🔌😕 Oups! J'ai du mal à me connecter à l'assistant IA. Vous pouvez essayer de reformuler votre question ou revenir plus tard.",
];
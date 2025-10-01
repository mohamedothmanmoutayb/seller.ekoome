<?php

return [
    /* Common Responses */
    'welcome' => "👋 *Bem-vindo(a)!* Como posso ajudar hoje?",
    'unknown_intent' => "🤔 Não percebi. Por favor, selecione uma opção válida:",
    'invalid_selection' => "❌ Seleção inválida. Por favor, escolha uma opção válida.",
    'choose_from_numbers' => "⚠️ Por favor, escolha um dos números apresentados.",
    'chatbot_disabled' => "🚫 O assistente virtual está temporariamente indisponível. Contacte o vendedor diretamente.",
    'command_disabled' => "🚫 Esta funcionalidade encontra-se desativada.",
    'choose_option' => "Por favor, indique o número da opção desejada.",

    /* Menu Options */
    'menu_view_products' => "📦 Ver produtos",
    'menu_find_seller' => "🔍 Encontrar vendedor",
    'menu_track_order' => "📮 Acompanhar encomenda", 
    'menu_special_offers' => "🏷️ Ofertas especiais",
    'menu_change_language' => "🌐 Alterar idioma",

    /* Order Tracking */
    'order_details' => "📮 *Detalhes da encomenda:*\n\n📦 *Número:* #:order_id\n📝 *Estado:* :status\n📅 *Data:* :date",
    'request_order_id' => "📮 Por favor, indique o *Número da encomenda* (apenas dígitos).\nEscreva 'back' para voltar ao menu principal.",
    'order_not_found' => "❌ A encomenda #:order_id não foi encontrada. Por favor, verifique o número.",

    /* Order Confirmation */
    'order_cancelled' => "❌ A sua encomenda foi cancelada. Contacte-nos se necessitar de ajuda.",
    'confirm_now_button' => "1️⃣ Confirmar agora",
    'schedule_button' => "2️⃣ Agendar entrega",
    'cancel_button' => "❌ Cancelar encomenda",
    'edit_button' => 'Editar informações',
    'edit_lead_name_prompt' => '✏️ Por favor, indique o seu nome (atual: :current):',
    'edit_lead_phone_prompt' => '📱 Por favor, indique o seu contacto telefónico (atual: :current):',
    'edit_lead_email_prompt' => '📧 Por favor, indique o seu email (atual: :current). Escreva "skip" para manter:',
    'edit_lead_address_prompt' => '🏠 Por favor, indique o seu endereço (atual: :current). Escreva "skip" para manter:',
    'field_skipped' => '✅ Valor atual mantido',
    'invalid_name' => '❌ Por favor, insira um nome válido',
    'invalid_phone' => '❌ Por favor, insira um número de telefone válido',
    'invalid_email' => '❌ Por favor, insira um email válido ou "skip"',
    'edit_lead_confirmation' => 'Por favor, confirme as alterações:' . "\n\n" .
                               'Nome: :name' . "\n" .
                               'Telefone: :phone' . "\n" .
                               'Email: :email' . "\n" .
                               'Morada: :address',
    'confirm_edit_prompt' => 'Responda "yes" para confirmar ou "no" para cancelar.',
    'lead_updated_successfully' => 'As suas informações foram atualizadas com sucesso!',
    'edit_cancelled' => 'Edição cancelada. As informações mantêm-se inalteradas.',
    'edit_session_expired' => 'Tempo limite excedido. Por favor, recomece se necessário.',
    'not_provided' => 'Não fornecido',
    'order_confirmed_immediate' => "✅ A sua encomenda foi confirmada para processamento imediato!",
    'order_confirmed_scheduled' => "✅ A sua encomenda foi agendada para entrega no dia :date!",
    'request_delivery_date' => "📅 Por favor, indique a data pretendida para entrega (AAAA-MM-DD):",
    'date_format_hint' => "Exemplo: 2025-01-16 para 16 de janeiro de 2025",
    'delivery_date_too_early' => "⚠️ A data deve ser posterior a :date. Por favor, selecione outra data.",
    'delivery_date_too_late' => "⚠️ Não é possível agendar entregas após :date. Por favor, selecione uma data anterior.",
    'invalid_confirmation_option' => "❌ Opção inválida. Escolha 'Confirmar agora', 'Agendar' ou 'Cancelar'.",
    'invalid_date_format' => "❌ Formato de data inválido. Utilize o formato AAAA-MM-DD.",
    'customer_details_confirmation' => "🔍 Por favor, confirme os seguintes dados:\n\n👤 Nome: :name\n📞 Telefone: :phone\n📧 Email: :email\n🏠 Morada: :address\n\n",
    'confirm_details_prompt' => "Confirma os seguintes dados? ❓",
    'lead_not_found' => "❌ Cliente potencial não encontrado",
    'details_confirmed' => "✅ Dados confirmados com sucesso",

    /* Seller Selection */
    'seller_list_header' => "🔍 *Vendedores disponíveis:*",
    'seller_list_footer' => "Responda com o número correspondente ao vendedor.",
    'no_sellers' => "⚠️ De momento não existem vendedores disponíveis. Tente novamente mais tarde.",
    'seller_selected' => "✅ Vendedor selecionado! Pode agora visualizar produtos ou ofertas.",

    /* Product Management */
    'product_list_header' => "🛍️ *Produtos de :seller:*",
    'product_list_footer' => "Responda com o número do produto para mais detalhes.",
    'product_details' => "🔍 *Detalhes do produto:*\n\n📦 *Designação:* :name\n💰 *Preço:* :price :currency\n📝 *Descrição:* :description\n📦 *Disponibilidade:* :quantity unidades",
    'product_not_found' => "❌ Produto não encontrado. Por favor, tente novamente.",
    'product_session_expired' => "⚠️ Sessão expirada. Por favor, selecione novamente.",
    'back_to_products' => "Escreva 'back' para voltar à lista de produtos",

    /* Special Offers */
    'special_offers_header' => "🏷️ *Ofertas especiais:*",
    'offer_item' => "📦 *:name* - :price :currency\n📝 *Detalhes:* :description",
    'no_offers' => "🏷️ De momento não existem ofertas especiais disponíveis.",
    'special_offer_item' => "🎁 Leve :quantity unidades de :product_name por :price :currency",

    /* Language Management */
    'language_menu' => "🌐 Selecione o seu idioma:",
    'language_set' => "✅ Idioma alterado para :language",
    'invalid_language' => "❌ Seleção de idioma inválida.",
    'select_language_prompt' => "Indique o número correspondente ao idioma pretendido:",

    /* Navigation */
    'back_to_menu' => "↩️ Voltar ao menu principal",
    'help_prompt' => "Escreva 'help' a qualquer momento para ver opções.",

    /* Confirmation */
    'order_item' => ":product × :quantity",
    'stock_alert_item' => "• :product (Disponível: :available, Necessário: :needed)",
    'order_alert_stock' => "⚠️ *Alerta de Stock*\n\nCaro equipa,\n\nExiste uma divergência no stock para a encomenda #:order_id:\n\n:items\n\nCliente: :customer_name\nPor favor, tomem as medidas necessárias.\n\nObrigado!",
    'order_confirmation' => "🛍️ *Confirmação de Encomenda #:order_id*\n\nCaro(a) :customer_name,\n\nObrigado pela sua encomenda! Detalhes:\n\n📦 *Artigos:*\n:items\n\n💵 *Total:* :total :currency\n\nPor favor, responda com:\n✅ *:confirm* para confirmar\n❌ *:cancel* para cancelar\n\nAgradecemos a sua preferência!",
    'confirm_button' => "Confirmar informações",
    'cancel_button' => "Cancelar",

    /* AI Assistant */
    'ai_no_response' => "🤖💬 Não obtive resposta do assistente. Pode reformular a sua questão?",
    'ai_unavailable' => "⚠️🔧 O nosso assistente está temporariamente indisponível. Tente novamente brevemente!",
    'ai_connection_error' => "🔌😕 Ocorreu um erro de ligação. Pode reformular ou tentar mais tarde.",
];
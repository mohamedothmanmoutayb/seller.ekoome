@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Best Regards'),<br>
    <p style="font-size:11px">
        <strong>EUROPEAN FULFILLMENT CENTER S.L.</strong><br>
        Paseo del charcón 10, 18110 Las Gabias, Granada, España <a href="">info@Ecomfulfillment.eu</a>  || <a href="">ecomfulfillment.eu </a> 
    </p><br>
    <center><img src="https://seller.ecomfulfilment.eu/public/LOGOVFECOM.jpg" class="logo" alt="European Fullfilement Center"></center><br>
    <p style="font-size:10px">
        Aviso legal - Este correo electrónico, y en su caso, cualquier fichero anexo, contiene información de carácter 
        confidencial exclusivamente dirigida a su destinatario. Queda prohibida su divulgación, 
        copia o distribución a terceros sin la previa autorización escrita de la Entidad. 
        En caso de haber recibido este correo electrónico por error, 
        se ruega la notificación inmediata de esta circunstancia mediante reenvío a la dirección electrónica del remitente. 
        INFORMACIÓN BÁSICA DE PROTECCIÓN DE DATOS. Responsable Identidad: ECOMFULFILLMENT S.L.- Dir. postal: Paseo del charcón 10, 18110 Granada, España. 
    </p>

@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent

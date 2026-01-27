<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de Servicio #{{ $reparacion->ID_rep }}</title>
    <link rel="icon" href="/assets/images/SOLUXMOVIL.png" type="image/png">
    <style>
        /* CONFIGURACIÓN GENERAL */
        @page {
            margin: 0cm;
        }
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 2cm;
            color: #333;
            line-height: 1.5;
            font-size: 12px;
        }

        /* SALTO DE PÁGINA AUTOMÁTICO */
        .page-break {
            page-break-after: always;
        }

        /* ESTILOS DE ENCABEZADO */
        .header-table { width: 100%; border-bottom: 3px solid #0056b3; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-img { max-height: 90px; }

        .company-name { font-size: 20px; font-weight: bold; color: #0056b3; margin: 0; }
        .company-sub { font-size: 10px; color: #555; }

        .folio-box {
            border: 2px solid #d9534f;
            padding: 5px;
            text-align: center;
            width: 150px;
            float: right;
            border-radius: 5px;
        }
        .folio-label { font-size: 10px; text-transform: uppercase; color: #d9534f; font-weight: bold; }
        .folio-number { font-size: 24px; color: #d9534f; font-weight: bold; }

        /* TÍTULOS DE SECCIÓN */
        .section-title {
            background-color: #e9ecef;
            color: #333;
            padding: 8px;
            font-weight: bold;
            font-size: 11px;
            border-left: 5px solid #0056b3;
            margin-top: 20px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        /* TABLAS DE DATOS */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table td { padding: 8px; border-bottom: 1px solid #eee; vertical-align: top; }
        .label { font-weight: bold; color: #555; width: 130px; }

        /* CAJA DE DESCRIPCIÓN */
        .desc-box {
            border: 1px solid #ccc;
            padding: 15px;
            min-height: 100px;
            background-color: #fcfcfc;
            border-radius: 4px;
            text-align: justify;
        }

        /* FIRMAS */
        .signatures { width: 100%; margin-top: 60px; }
        .signatures td { width: 50%; text-align: center; vertical-align: bottom; }
        .sign-line {
            border-top: 1px solid #000;
            width: 80%;
            margin: 0 auto;
            padding-top: 5px;
            font-weight: bold;
        }

        /* PIE DE PÁGINA LEGAL */
        .terms {
            font-size: 9px;
            color: #777;
            text-align: justify;
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        /* ETIQUETA DE COPIA */
        .watermark {
            position: absolute;
            top: -1cm;
            right: 0;
            background: #333;
            color: #fff;
            padding: 5px 15px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 0 0 5px 5px;
        }
    </style>
</head>
<body>

{{-- ================================================================= --}}
{{-- PÁGINA 1: ORIGINAL CLIENTE --}}
{{-- ================================================================= --}}

<div class="watermark">ORIGINAL: CLIENTE</div>

<table class="header-table">
    <tr>
        <td valign="top">
            <img src="{{ public_path('assets/images/SOLUX.png') }}" class="logo-img" alt="Logo">
            <h1 class="company-name">SOLUXMOVIL</h1>
            <div class="company-sub">Servicio Técnico Especializado</div>
        </td>
        <td valign="top">
            <div class="folio-box">
                <div class="folio-label">Nota de Servicio</div>
                <div class="folio-number">#{{ str_pad($reparacion->ID_rep, 6, '0', STR_PAD_LEFT) }}</div>
            </div>
        </td>
    </tr>
</table>

<div class="section-title">Información del Cliente y Dispositivo</div>
<table class="data-table">
    <tr>
        <td class="label">Cliente:</td>
        <td>
            <strong>{{ $reparacion->dispositivo->cliente?->nombre }} {{ $reparacion->dispositivo->cliente?->apellido }}</strong>
        </td>
        <td class="label">Teléfono:</td>
        <td>{{ $reparacion->dispositivo->cliente?->telefono }}</td>
    </tr>
    <tr>
        <td class="label">Dirección:</td>
        <td colspan="3">
            {{ $reparacion->dispositivo->cliente?->direccion ?? '' }}
            {{ $reparacion->dispositivo->cliente?->num_ext ? '#'.$reparacion->dispositivo->cliente->num_ext : '' }}
        </td>
    </tr>
    <tr>
        <td class="label">Dispositivo:</td>
        <td>{{ $reparacion->dispositivo?->tipo }} - {{ $reparacion->dispositivo?->marca }}</td>
        <td class="label">Modelo:</td>
        <td>{{ $reparacion->dispositivo?->modelo }}</td>
    </tr>
    {{-- >>> NUEVO CAMPO: PRECIO PARA EL CLIENTE <<< --}}
    <tr>
        <td class="label" style="color: #d9534f; padding-top: 15px;">Costo Total:</td>
        <td colspan="3" style="font-size: 16px; font-weight: bold; color: #d9534f; padding-top: 15px;">
            ${{ number_format($reparacion->costo, 2) }} <small style="color: #555; font-weight: normal; font-size: 10px;">(MXN)</small>
        </td>
    </tr>
</table>

<div class="section-title">Detalle del Servicio / Falla Reportada</div>
<div class="desc-box">
    {{ $reparacion->descripcion }}
</div>

<table class="signatures">
    <tr>
        <td>
            <div class="sign-line">Firma del Cliente</div>
            <small>Acepto costo y términos</small>
        </td>
        <td>
            <div class="sign-line">Recibido por (Técnico)</div>
            <small>SoluxMovil</small>
        </td>
    </tr>
</table>

<div class="terms">
    <strong>TÉRMINOS Y CONDICIONES:</strong>
    <ol style="margin-top: 5px; padding-left: 15px;">
        <li>El diagnóstico inicial es preliminar y puede variar al realizar la revisión interna del equipo.</li>
        <li>SoluxMovil no se hace responsable por la pérdida de información (fotos, contactos, etc.). Se recomienda realizar un respaldo previo.</li>
        <li>La garantía cubre exclusivamente la mano de obra y refacciones utilizadas en la reparación por un periodo de 30 días (NO aplica en cambio de display).</li>
        <li>Todo equipo abandonado por más de 30 días causará honorarios por almacenamiento. Pasados 90 días, la empresa podrá disponer del equipo.</li>
        <li>No hay garantía en equipos mojados o previamente manipulados por terceros.</li>
    </ol>

    {{-- TEXTO AGREGADO DE SITIO WEB --}}
    <div style="margin-top: 15px; font-size: 11px; font-weight: bold; text-align: center; text-transform: uppercase;">
        Pueden consultar el estado de la reparación a través de la página web: <br>
        <span style="font-size: 12px; color: #0056b3;">www.soluxmovil.com</span>
    </div>
</div>

{{-- ================================================================= --}}
{{-- SALTO DE PÁGINA --}}
{{-- ================================================================= --}}
<div class="page-break"></div>

{{-- ================================================================= --}}
{{-- PÁGINA 2: COPIA TALLER --}}
{{-- ================================================================= --}}

<div class="watermark" style="background: #555;">COPIA: TALLER / TÉCNICO</div>

<table class="header-table">
    <tr>
        <td valign="top">
            <img src="{{ public_path('assets/images/SOLUX.png') }}" class="logo-img" alt="Logo">
            <h1 class="company-name">SOLUXMOVIL</h1>
            <div class="company-sub">Control Interno</div>
        </td>
        <td valign="top">
            <div class="folio-box" style="border-color: #555;">
                <div class="folio-label" style="color: #555;">Folio Interno</div>
                <div class="folio-number" style="color: #555;">#{{ str_pad($reparacion->ID_rep, 6, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div style="text-align: center; margin-top: 10px; font-size: 11px;">
                <strong>Ingreso:</strong> {{ \Carbon\Carbon::parse($reparacion->fec_inicio)->format('d/m/Y ') }}
            </div>
        </td>
    </tr>
</table>

<div class="section-title">Datos Técnicos</div>
<table class="data-table">
    <tr>
        <td class="label">Cliente:</td>
        <td>{{ $reparacion->dispositivo->cliente?->nombre }} {{ $reparacion->dispositivo->cliente?->apellido }}</td>
        <td class="label">Contacto:</td>
        <td>{{ $reparacion->dispositivo->cliente?->telefono }}</td>
    </tr>
    <tr>
        <td class="label">Equipo:</td>
        <td>{{ $reparacion->dispositivo?->marca }} {{ $reparacion->dispositivo?->modelo }} ({{ $reparacion->dispositivo?->tipo }})</td>
        <td class="label">ID Sistema:</td>
        <td>Dev: {{ $reparacion->dispositivo?->ID_tel }} | Rep: {{ $reparacion->ID_rep }}</td>
    </tr>
    {{-- >>> NUEVO CAMPO: PRECIO PARA EL TALLER <<< --}}
    <tr>
        <td class="label">Costo Autorizado:</td>
        <td colspan="3" style="font-weight: bold;">
            ${{ number_format($reparacion->costo, 2) }}
        </td>
    </tr>
</table>

<div class="section-title">Descripción de la Falla</div>
<div class="desc-box" style="min-height: 80px;">
    {{ $reparacion->descripcion }}
</div>

<div class="section-title">Checklist de Ingreso (Uso Interno)</div>
<table class="data-table" style="font-size: 11px;">
    <tr>
        <td width="50%">
            [ &nbsp; ] Enciende<br>
            [ &nbsp; ] Pantalla (Touch/Imagen)<br>
            [ &nbsp; ] Botones (Volumen/Power)<br>
            [ &nbsp; ] Centro de Carga
        </td>
        <td width="50%">
            [ &nbsp; ] Cámaras (Frontal/Trasera)<br>
            [ &nbsp; ] Bandeja SIM / SD<br>
            [ &nbsp; ] Golpes / Rayones Visibles<br>
            [ &nbsp; ] Mojado (Indicadores)
        </td>
    </tr>
</table>
<div style="margin-top: 10px; border: 1px dashed #999; padding: 10px; color: #555;">
    <strong>Contraseña / Patrón:</strong> ___________________________________
    <br><br>
    <strong>Notas Adicionales:</strong> _______________________________________________________
</div>

<table class="signatures">
    <tr>
        <td>
            <div class="sign-line">Firma del Cliente</div>
            <small>Autorizo la revisión y costo</small>
        </td>
        <td>
            <div class="sign-line">Técnico Asignado</div>
            <small>Responsable</small>
        </td>
    </tr>
</table>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de Entrega #{{ $reparacion->ID_rep }}</title>
    <style>
        @page { margin: 1cm; }
        body { 
            font-family: 'Helvetica', Arial, sans-serif; 
            color: #333; 
            line-height: 1.5; 
            margin: 0; 
            padding: 0;
            font-size: 12px;
        }
        /* Cabecera */
        .header-table { width: 100%; border-bottom: 2px solid #1e293b; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { width: 180px; }
        .company-info { text-align: right; color: #64748b; }
        .company-name { color: #0d6efd; font-size: 22px; font-weight: bold; margin-bottom: 5px; }
        
        /* Título y Folio */
        .title-section { text-align: center; margin-bottom: 30px; }
        .title-section h1 { margin: 0; font-size: 18px; color: #1e293b; text-transform: uppercase; letter-spacing: 1px; }
        .folio-badge { 
            display: inline-block; 
            background: #f1f5f9; 
            padding: 5px 15px; 
            border-radius: 4px; 
            border: 1px solid #e2e8f0;
            margin-top: 10px;
        }

        /* Bloques de información */
        .info-container { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-box { width: 50%; vertical-align: top; padding: 10px; border: 1px solid #e2e8f0; background: #f8fafc; }
        .info-title { font-weight: bold; color: #0d6efd; text-transform: uppercase; font-size: 10px; margin-bottom: 8px; display: block; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; }

        /* Tabla de Detalles */
        .details-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .details-table th { background: #1e293b; color: white; padding: 10px; text-align: left; text-transform: uppercase; font-size: 10px; }
        .details-table td { padding: 12px 10px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        
        /* Totales */
        .total-section { margin-top: 20px; text-align: right; }
        .total-box { 
            display: inline-block; 
            width: 200px; 
            background: #1e293b; 
            color: white; 
            padding: 15px; 
            border-radius: 4px; 
            text-align: center;
        }
        .total-amount { font-size: 20px; font-weight: bold; display: block; }

        /* Garantía */
        .warranty-box { 
            margin-top: 30px; 
            padding: 15px; 
            border: 1px dashed #cbd5e1; 
            border-radius: 8px; 
            font-size: 11px; 
            color: #475569;
            background: #fdfdfd;
        }

        /* Firmas */
        .signature-section { margin-top: 60px; width: 100%; }
        .signature-box { width: 45%; text-align: center; vertical-align: bottom; }
        .signature-line { border-top: 1px solid #334155; margin-top: 40px; padding-top: 8px; font-weight: bold; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #94a3b8; padding: 10px 0; border-top: 1px solid #f1f5f9; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                {{-- Nota: public_path es la forma correcta para DomPDF --}}
                <img src="{{ public_path('assets/images/SOLUX.png') }}" class="logo" alt="Logo">
            </td>
            <td class="company-info">
                <div class="company-name">SOLUXMOVIL</div>
                <div>Av. Benito Juarez #11, San Baltazar Temaxcalac</div>
                <div>Tel: (248) 266-0871</div>
                <div>soluxmovil@gmail.com</div>
            </td>
        </tr>
    </table>

    <div class="title-section">
        <h1>Nota de Entrega de Servicio</h1>
        <div class="folio-badge">
            FOLIO: <strong>#{{ str_pad($reparacion->ID_rep, 6, '0', STR_PAD_LEFT) }}</strong>
        </div>
    </div>

    <table class="info-container">
        <tr>
            <td class="info-box" style="border-right: 5px solid white;">
                <span class="info-title">Datos del Cliente</span>
                <strong>{{ $reparacion->dispositivo->cliente->nombre }} {{ $reparacion->dispositivo->cliente->apellido }}</strong><br>
                Tel: {{ $reparacion->dispositivo->cliente->telefono }}<br>
                Email: {{ optional($reparacion->dispositivo->cliente->usuario)->emai ?? 'N/A' }}
            </td>
            <td class="info-box">
                <span class="info-title">Información del Servicio</span>
                Fecha de Entrega: <strong>{{ date('d/m/Y') }}</strong><br>
                Estado: Finalizado 
            </td>
        </tr>
    </table>

    <table class="details-table">
        <thead>
            <tr>
                <th width="30%">Dispositivo</th>
                <th width="70%">Descripción de la Reparación / Servicio</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $reparacion->dispositivo->marca }}</strong><br>
                    Modelo: {{ $reparacion->dispositivo->modelo }}<br>
                    Tipo: {{ $reparacion->dispositivo->tipo }}
                </td>
                <td>
                    {{ $reparacion->descripcion }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-box">
            <small>TOTAL PAGADO</small>
            <span class="total-amount">${{ number_format($reparacion->costo, 2) }}</span>
        </div>
    </div>

    <div class="warranty-box">
        <strong>TÉRMINOS DE GARANTÍA Y CONFORMIDAD:</strong><br>
        1. Se otorga una garantía limitada de <strong>30 días naturales</strong> a partir de la fecha de entrega sobre la mano de obra y refacciones descritas.<br>
        2. La garantía quedará invalidada si el equipo presenta rastros de humedad, golpes, sellos de garantía rotos o intervención de terceros.<br>
        3. En cambios de Display/Pantalla, la garantía solo cubre defectos de fábrica (no manchas, líneas verdes/rosas o roturas posteriores).<br>
        4. El cliente manifiesta recibir su equipo en óptimas condiciones y haber verificado su funcionamiento.
    </div>

    <table class="signature-section">
        <tr>
            <td class="signature-box">
                <div class="signature-line">Firma del Técnico</div>
            </td>
            <td width="10%"></td>
            <td class="signature-box">
                <div class="signature-line">Firma de Conformidad Cliente</div>
                <small>{{ $reparacion->dispositivo->cliente->nombre }} {{ $reparacion->dispositivo->cliente->apellido }}</small>
            </td>
        </tr>
    </table>

    <div class="footer">
        Este documento es un comprobante de servicio técnico y garantía. Gracias por confiar en SoluxMovil.<br>
        <strong>www.soluxmovil.com</strong>
    </div>

</body>
</html>
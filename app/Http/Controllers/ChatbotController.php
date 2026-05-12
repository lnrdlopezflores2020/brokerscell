<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    /**
     * Muestra la vista del chatbot al cliente
     */
    public function index()
    {
        return view('cpanel/chatbot/Chatbot'); 
    }

    /**
     * Procesa los mensajes enviados por el cliente
     */
    public function procesarMensaje(Request $request)
    {
        // 1. Recibir y estandarizar el mensaje
        $mensajeOriginal = $request->input('mensaje');
        $mensaje = strtolower($mensajeOriginal);
        $mensaje = str_replace(
            ['á','é','í','ó','ú','¿','?'], 
            ['a','e','i','o','u','',''], 
            $mensaje
        );

        $cliente = Auth::user()->name ?? 'Cliente';

        // 2. DETECCIÓN DE INTENCIONES Y ENTIDADES
        $intencionCosto = Str::contains($mensaje, ['costo', 'precio', 'cuanto', 'cuesta', 'cobran', 'sale', 'cotizacion', 'cotizar']);

        // Componentes para costos
        $diccionarioComponentes = [
            'pantalla' => ['pantalla', 'display', 'cristal', 'touch', 'vidrio', 'roto'],
            'bateria' => ['bateria', 'pila'],
            'carga' => ['pin de carga', 'centro de carga', 'conector'],
            'software' => ['software', 'flasheo', 'cuenta', 'google', 'desbloqueo', 'patron', 'contraseña'],
            'mantenimiento' => ['mojado', 'agua', 'limpieza', 'mantenimiento', 'polvo']
        ];

        // Marcas / Modelos
        $diccionarioMarcas = [
            'apple' => ['iphone', 'apple', 'ipad', 'mac'],
            'samsung' => ['samsung', 'galaxy', 'serie a', 'serie s'],
            'huawei' => ['huawei', 'y9', 'p30', 'mate'],
            'oppo' => ['oppo', 'reno'],
            'motorola' => ['motorola', 'moto', 'moto g', 'moto e'],
            'xiaomi' => ['xiaomi', 'redmi', 'poco'],
            'realme' => ['realme', 'gt', 'realme 7', 'realme 8']
        ];

        // =========================================================
        // LÓGICA DE RESPUESTAS PARA COSTOS ESPECÍFICOS
        // =========================================================
        if ($intencionCosto) {
            $tipoServicio = null;
            $marcaDetectada = 'general'; 
            
            // Buscar componente
            foreach ($diccionarioComponentes as $servicio => $palabrasClave) {
                if (Str::contains($mensaje, $palabrasClave)) {
                    $tipoServicio = $servicio;
                    break;
                }
            }

            // Buscar marca
            foreach ($diccionarioMarcas as $marca => $palabrasClave) {
                if (Str::contains($mensaje, $palabrasClave)) {
                    $marcaDetectada = $marca;
                    break;
                }
            }

            if ($tipoServicio === 'pantalla') {
                $respuestasPantalla = [
                    'apple' => "📱 <b>Pantallas para iPhone:</b><br>Aquí tienes los estimados para modelos comunes (Calidad Original/OLED):<br>
                        • iPhone 11: <b>$1,200 MXN</b><br>
                        • iPhone 12 / 12 Pro: <b>$1,800 MXN</b><br>
                        • iPhone 13: <b>$2,500 MXN</b><br>
                        • iPhone 14 Pro / 15: <b>$4,500+ MXN</b><br><br>
                        💡 <i>Incluye instalación y 30 días de garantía. Contamos con opciones genéricas más económicas, ¡pregunta en sucursal!</i>",
                        
                    'samsung' => "📱 <b>Pantallas para Samsung:</b><br>Los costos varían bastante si es pantalla LCD o AMOLED. Algunos ejemplos:<br>
                        • Galaxy A12 / A13 / A14: <b>$750 - $900 MXN</b><br>
                        • Galaxy A32 / A52: <b>$1,200 - $1,600 MXN</b><br>
                        • Galaxy A54: <b>$1,800 MXN</b><br>
                        • Serie S (S21, S22, S23): <b>$3,000 a $5,000+ MXN</b><br><br>
                        💡 <i>Si tu modelo no está en la lista, tráelo a revisión.</i>",
                        
                    'huawei' => "📱 <b>Pantallas para Huawei:</b><br>Estimados para los modelos más comerciales:<br>
                        • Huawei Y9 (2019/Prime): <b>$800 - $950 MXN</b><br>
                        • Huawei P30 Lite / P40 Lite: <b>$900 - $1,100 MXN</b><br>
                        • Mate 20 Lite: <b>$950 MXN</b><br>
                        • Modelos de gama alta: <b>Cotización sobre pedido.</b><br>
                        <br><br>💡 <i>Si tu modelo no está en la lista, tráelo a revisión.</i>",
                        
                    'oppo' => "📱 <b>Pantallas para Oppo:</b><br>Estimados comunes con mano de obra incluida:<br>
                        • Oppo A15 / A17 / A54: <b>$800 - $950 MXN</b><br>
                        • Oppo Reno 5 Lite / Reno 6: <b>$1,200 - $1,600 MXN</b><br>
                        • Oppo Reno 7: <b>$1,800 MXN</b><br>
                        • Modelos de gama alta: <b>Cotización sobre pedido.</b><br>
                        <br><br>💡 <i>Si tu modelo no está en la lista, tráelo a revisión.</i>",
                        
                    'motorola' => "📱 <b>Pantallas para Motorola:</b><br>Lista de precios estimados para Moto:<br>
                        • Moto E20 / E40: <b>$750 MXN</b><br>
                        • Moto G20 / G30 / G50: <b>$850 - $950 MXN</b><br>
                        • Moto G60 / G60s: <b>$1,100 MXN</b><br>
                        • Serie Edge: <b>$2,000+ MXN</b><br>
                        <br><br>💡 <i>Si tu modelo no está en la lista, tráelo a revisión.</i>",
                        
                    'xiaomi' => "📱 <b>Pantallas para Xiaomi / Poco:</b><br>Estimados para esta marca:<br>
                        • Redmi Note 9 / Note 10: <b>$850 - $1,100 MXN</b><br>
                        • Redmi Note 11 / 12: <b>$1,200 - $1,500 MXN</b><br>
                        • Poco X3 Pro / NFC: <b>$1,100 MXN</b><br>
                        • Poco X5 / F5: <b>$1,600+ MXN</b><br>
                        <br><br>💡 <i>Si tu modelo no está en la lista, tráelo a revisión.</i>",

                    'realme' => "📱 <b>Pantallas para Realme:</b><br>Estimados para esta marca:<br>
                        • Realme 7 / 7 Pro: <b>$800 - $1,000 MXN</b><br>
                        • Realme 8 / 8 Pro: <b>$900 - $1,200 MXN</b><br>
                        • Realme GT Neo: <b>$1,200 - $1,500 MXN</b><br>
                        • Realme GT Master: <b>$1,600+ MXN</b><br>
                        <br><br>💡 <i>Si tu modelo no está en la lista, tráelo a revisión.</i>",
                        
                    'general' => "📱 <b>Cambio de Pantalla / Display:</b><br>El costo varía mucho según el modelo exacto. Normalmente oscilan entre <b>$500 y $3,000+ MXN</b>.<br><br>
                        Tengo listas de precios para las siguientes marcas:<br>
                        🔸 Apple (iPhone)<br>
                        🔸 Samsung<br>
                        🔸 Motorola<br>
                        🔸 Xiaomi<br>
                        🔸 Huawei<br>
                        🔸 Oppo<br><br>
                        <b>¿De qué marca es tu celular?</b> Escríbelo para darte la lista de modelos."
                ];
                return response()->json(['respuesta' => $respuestasPantalla[$marcaDetectada]]);
            }

            if ($tipoServicio === 'bateria') {
                $respuestasBateria = [
                    'apple' => "🔋 <b>Batería para iPhone:</b><br>El reemplazo de batería (al 100% de condición) cuesta entre <b>$500 y $1,200 MXN</b> según el modelo.",
                    'general' => "🔋 <b>Cambio de Batería:</b><br>Una batería nueva ya instalada tiene un costo estimado de <b>$300 a $800 MXN</b> para la mayoría de marcas Android."
                ];
                $texto = $marcaDetectada === 'apple' ? $respuestasBateria['apple'] : $respuestasBateria['general'];
                return response()->json(['respuesta' => $texto]);
            }

            if ($tipoServicio === 'carga') {
                return response()->json(['respuesta' => "⚡ <b>Centro de Carga:</b><br>Para casi todas las marcas, la reparación o cambio de la tablilla de carga está entre <b>$250 y $450 MXN</b>."]);
            }

            if ($tipoServicio === 'software') {
                $respuestasSoftware = [
                    'apple' => "💻 <b>Software Apple:</b><br>Para restauraciones de sistema o problemas de arranque en iOS, el costo inicia en <b>$300 MXN</b>.",
                    'samsung' => "💻 <b>Software Samsung:</b><br>Flasheos y eliminación de cuentas Google (FRP) en Samsung van desde <b>$250 hasta $600 MXN</b>.",
                    'general' => "💻 <b>Desbloqueos y Software:</b><br>Flasheos, remoción de cuenta Google o eliminación de patrón en Android van desde <b>$200 hasta $500 MXN</b>."
                ];
                $texto = isset($respuestasSoftware[$marcaDetectada]) ? $respuestasSoftware[$marcaDetectada] : $respuestasSoftware['general'];
                return response()->json(['respuesta' => $texto]);
            }

            if ($tipoServicio === 'mantenimiento') {
                return response()->json(['respuesta' => "💧 <b>Equipo Mojado / Mantenimiento:</b><br>El baño químico ultrasónico para equipos mojados tiene un costo base de <b>$200 MXN</b> para cualquier marca.<br><i>Nota: Las piezas dañadas (como pantalla o centro de carga) se cotizan aparte.</i>"]);
            }
        }

        // =========================================================
        // SÍNTOMAS Y DIAGNÓSTICO DE FALLAS COMUNES
        // =========================================================

        if (Str::contains($mensaje, ['no prende', 'no enciende', 'pantalla negra', 'muerto', 'no da imagen'])) {
            return response()->json(['respuesta' => "🔌 <b>¿El equipo no enciende?</b><br>Esto puede deberse a la batería totalmente agotada, el centro de carga dañado o un corto en la tarjeta lógica. Te recomendamos traerlo a la sucursal para realizarle un diagnóstico preciso con nuestra fuente de poder."]);
        }

        if (Str::contains($mensaje, ['descarga rapido', 'baja rapido', 'no dura', 'dura poco', 'se apaga'])) {
            return response()->json(['respuesta' => "🔋 <b>¿Se descarga muy rápido?</b><br>Generalmente es por el desgaste natural de la batería (cumplió su ciclo de vida). En menor medida, puede ser un corto interno que consume energía de más. Casi siempre se soluciona con un reemplazo de batería nueva."]);
        }

        if (Str::contains($mensaje, ['no carga', 'falso contacto', 'carga lento', 'no sube'])) {
            return response()->json(['respuesta' => "⚡ <b>¿Problemas de carga?</b><br>Primero revisaremos que el puerto no esté sucio o dañado físicamente. Si el puerto está bien, el problema podría estar en la batería o en el circuito de carga de la tarjeta. Puedes traerlo para una limpieza y revisión."]);
        }

        if (Str::contains($mensaje, ['queda en el logo', 'no pasa del logo', 'reinicia solo', 'bootloop', 'manzanita'])) {
            return response()->json(['respuesta' => "🔄 <b>¿Se queda en el logo o se reinicia?</b><br>Suele ser una falla de software (el sistema operativo colapsó) o saturación de memoria. A veces también lo provoca una batería dañada. Podemos intentar cargarle el sistema nuevamente."]);
        }

        if (Str::contains($mensaje, ['sin servicio', 'no hay señal', 'no levanta señal', 'no lee el chip', 'no agarra el chip', 'llamadas de emergencia'])) {
            return response()->json(['respuesta' => "📶 <b>¿Problemas de señal o chip?</b><br>Puede ser que el lector del chip esté dañado, un problema en la antena interna, o un bloqueo/reporte de red por parte de la compañía telefónica (IMEI). Necesitamos revisarlo físicamente para confirmarlo."]);
        }

        if (Str::contains($mensaje, ['huella', 'sensor', 'proximidad', 'face id', 'no se apaga la pantalla', 'microfono', 'no me escuchan'])) {
            return response()->json(['respuesta' => "🛠️ <b>¿Falla en algún sensor o micrófono?</b><br>Las fallas en Face ID, huellas digitales, micrófonos o sensores de proximidad ocurren frecuentemente por caídas, humedad o tras un cambio de pantalla previo. Son reparaciones delicadas que requieren un diagnóstico detallado."]);
        }

        // =========================================================
        // DUDAS SOBRE EL SISTEMA Y SEGUIMIENTO
        // =========================================================

        if (Str::contains($mensaje, ['seguimiento', 'rastrear', 'estatus', 'status', 'como se el estado', 'como checar', 'donde veo mi', 'avance', 'como va mi'])) {
            return response()->json(['respuesta' => "🔍 <b>¿Quieres saber cómo va tu reparación?</b><br><br>Para ver el avance en tiempo real, solo debes:<br>1️⃣ Ir a la sección de <b>'Seguimiento'</b> o <b>'Consultar Reparación'</b> en el menú de este panel.<br>2️⃣ Identificar tu equipo usando el <b>Número de Folio</b> que viene en tu nota de ingreso.<br><br>Ahí te indicaremos si tu celular está en <i>Revisión</i>, <i>En Reparación</i> o si ya está <i>Terminado</i> y listo para entregar."]);
        }

        // =========================================================
        // OTRAS INTENCIONES (Saludos, Dirección, Horarios)
        // =========================================================
        
        if (Str::contains($mensaje, ['horario', 'hora', 'abren', 'cierran', 'abierto', 'dias', 'atienden'])) {
            return response()->json(['respuesta' => "🕒 <b>Nuestro Horario de Atención:</b><br><br>🔸 Lunes a Viernes: 10:00 AM - 7:00 PM<br>🔸 Sábados: 10:00 AM - 4:00 PM<br>🔸 Domingos: Cerrado<br><br>¡Te esperamos en sucursal para revisar tu equipo!"]);
        }

        if (Str::contains($mensaje, ['hola', 'buenos dias', 'buenas tardes'])) {
            return response()->json(['respuesta' => "¡Hola, $cliente! 👋 Soy el asistente de Brokerscell.<br><br>Puedes describirme la falla de tu equipo (Ej: <i>Mi teléfono no carga</i>), preguntarme por <b>costos de reparación</b>, o consultar cómo darle <b>seguimiento</b> a tus equipos."]);
        }

        if (Str::contains($mensaje, ['ubicacion', 'direccion', 'donde estan', 'como llegar'])) {
            return response()->json(['respuesta' => "📍 <b>Nuestra Ubicación:</b><br>Estamos ubicados en Av. Benito Juárez #11, San Baltazar Temaxcalac."]);
        }

        // RESPUESTA POR DEFECTO
        return response()->json(['respuesta' => "Disculpa, no logré entender tu consulta. 🤖<br><br>Puedes intentar preguntarme sobre:<br>🔸 <b>Costos:</b> <i>'Precio de pantalla para Samsung'</i><br>🔸 <b>Fallas:</b> <i>'Mi celular no pasa del logo'</i><br>🔸 <b>Sistema:</b> <i>'¿Dónde checo el estado de mi equipo?'</i>"]);
    }
}
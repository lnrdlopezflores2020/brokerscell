<?php

namespace App\Exports;

use App\Models\Cliente; // <--- Importamos tu modelo Cliente
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    // 1. Traemos los datos
    public function collection()
    {
        return Cliente::all(); // Trae todos los registros de la tabla 'cliente'
    }

    // 2. Definimos los encabezados del Excel (Primera fila)
    public function headings(): array
    {
        return [
            'ID Cliente',
            'Nombre',
            'Apellido',
            'Teléfono',
            'Dirección',
            'Num. Ext',
            'Num. Int',
            'ID Usuario Sistema' // La FK
        ];
    }

    // 3. Acomodamos los datos fila por fila
    public function map($cliente): array
    {
        return [
            $cliente->ID_client,
            $cliente->nombre,
            $cliente->apellido,
            $cliente->telefono,
            $cliente->direccion,
            $cliente->num_ext,
            $cliente->num_int ?? 'S/N', // Si es nulo, ponemos S/N
            $cliente->usuario_fk,
        ];
    }

    // 4. (Opcional) Estilo: Poner negritas a los encabezados
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

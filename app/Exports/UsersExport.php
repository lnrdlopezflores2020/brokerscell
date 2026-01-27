<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // 1. Importa esto para los títulos
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        // Seleccionamos solo las columnas que queremos mostrar en el reporte
        return User::select('ID_usuario', 'emai', 'rol_usuario')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Email',
            'Rol'
        ];
    }
}

<?php

namespace App\Exports;

use App\NotasPropuesta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class NotasPropuestasExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        return NotasPropuesta::where('docente_id', $this->id)
                            ->where('anio_vigente', date('Y'))
                            ->get();                
    }

    public function map($notapropuesta): array
    {
        /**
        * @var Invoice $invoice
        */
        return [
            $notapropuesta->id,
            $notapropuesta->asignatura->sigla,
            $notapropuesta->asignatura->nombre,
            $notapropuesta->nota_asistencia,
            $notapropuesta->nota_practicas,
            $notapropuesta->nota_primer_parcial,
            $notapropuesta->nota_examen_final,
            $notapropuesta->nota_puntos_ganados,
        ];
    }

    public function headings() : array
    {
        return [
            '# Id',
            'Codigo',
            'Nombre',
            'Asistencia',
            'Practicas',
            'Primer Parcial',
            'Examen Final',
            'Extras',
        ];
    }

    public function registerEvents(): array
    {
        $styleArray = [
            'font' => [
                'bold' => true,
                'color' => array('rgb' => 'FF0000'),
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            
        ];
        return [
            AfterSheet::class => function(AfterSheet $event) use ($styleArray) {
                $event->sheet->getStyle('A1:H1')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->freezePane('B1');
            },
        ];
    }
}

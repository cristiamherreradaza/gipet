<?php

namespace App\Exports;

use App\Asignatura;
use App\Inscripcione;
use App\Turno;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DataExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    protected $carrera;
    protected $turno;
    protected $paralelo;
    protected $anio_vigente;

    public function __construct($carrera, $turno, $paralelo, $anio_vigente)
    {
        $this->carrera      = $carrera;
        $this->turno        = $turno;
        $this->paralelo     = $paralelo;
        $this->anio_vigente = $anio_vigente;
    }

    public function collection()
    {
        return Asignatura::where('carrera_id', $this->carrera)
                        ->where('anio_vigente', $this->anio_vigente)
                        ->get();
    }

    public function map($asignatura): array
    {
        /**
        * @var Invoice $invoice
        */
        $turno = Turno::find($this->turno);
        return [
            '',
            $asignatura->carrera->nombre,
            $asignatura->sigla,
            $asignatura->nombre,
            $asignatura->ciclo,
            $turno->descripcion,
            $this->paralelo,
            $this->anio_vigente,
        ];
    }

    public function headings() : array
    {
        //$notapropuesta = NotasPropuesta::find($this->asignatura_id);
        return [
            [
                'Cedula de Identidad',
                'Carrera',
                'Sigla',
                'Nombre',
                'Ciclo',
                'Turno',
                'Paralelo',
                'Año Vigente',
                'Bimestre 1',
                '',
                '',
                '',
                '',
                'Bimestre 2',
                '',
                '',
                '',
                '',
                'Bimestre 3',
                '',
                '',
                '',
                '',
                'Bimestre 4',
            ],
            [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'Nota Asistencia',
                'Nota Practicas',
                'Nota Primer Parcial',
                'Nota Examen Final',
                'Nota Puntos',
                'Nota Asistencia',
                'Nota Practicas',
                'Nota Primer Parcial',
                'Nota Examen Final',
                'Nota Puntos',
                'Nota Asistencia',
                'Nota Practicas',
                'Nota Primer Parcial',
                'Nota Examen Final',
                'Nota Puntos',
                'Nota Asistencia',
                'Nota Practicas',
                'Nota Primer Parcial',
                'Nota Examen Final',
                'Nota Puntos',
            ]
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
                $event->sheet->getStyle('A1:AB1')->applyFromArray($styleArray);
                $event->sheet->getStyle('A2:AB2')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->freezePane('E1');
                $event->sheet->mergeCells('A1:A2');
                $event->sheet->mergeCells('B1:B2');
                $event->sheet->mergeCells('C1:C2');
                $event->sheet->mergeCells('D1:D2');
                $event->sheet->mergeCells('E1:E2');
                $event->sheet->mergeCells('F1:F2');
                $event->sheet->mergeCells('G1:G2');
                $event->sheet->mergeCells('H1:H2');

                $event->sheet->mergeCells('I1:M1');
                $event->sheet->mergeCells('N1:R1');
                $event->sheet->mergeCells('S1:W1');
                $event->sheet->mergeCells('X1:AB1');
            },
        ];
    }
}

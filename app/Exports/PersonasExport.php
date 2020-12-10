<?php

namespace App\Exports;

use App\CarrerasPersona;
use App\Persona;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class PersonasExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    protected $carrera_id;
    protected $curso_id;
    protected $turno_id;
    protected $paralelo;
    protected $gestion;
    protected $estado;
    
    public function __construct($carrera_id, $curso_id, $turno_id, $paralelo, $gestion, $estado)
    {
        $this->carrera  = $carrera_id;
        $this->turno    = $turno_id;
        $this->curso    = $curso_id;
        $this->paralelo = $paralelo;
        $this->gestion  = $gestion;
        $this->estado   = $estado;
    }

    public function collection()
    {
        $listado    = CarrerasPersona::where('carrera_id', $this->carrera)
                                    ->where('gestion', $this->curso)
                                    ->where('turno_id', $this->turno)
                                    ->where('paralelo', $this->paralelo)
                                    ->where('anio_vigente', $this->gestion)
                                    ->where('vigencia', $this->estado)
                                    ->get();
        $array_personas = array();
        foreach($listado as $registro)
        {
            array_push($array_personas, $registro->persona_id);
        }
        return Persona::whereIn('id', $array_personas)
                    ->orderBy('apellido_paterno')
                    ->orderBy('apellido_materno')
                    ->orderBy('nombres')
                    ->get();
    }

    public function map($listado): array
    {
        return [
            $listado->cedula,
            $listado->apellido_paterno,
            $listado->apellido_materno,
            $listado->nombres,
            $listado->numero_celular,
            strtoupper($this->estado)
        ];
    }

    public function headings() : array
    {
        return[
            [
                'Cedula de Identidad',
                'Apellido Paterno',
                'Apellido Materno',
                'Nombres',
                'Celular',
                'Estado'
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
                $event->sheet->getStyle('A1:F1')->applyFromArray($styleArray);
                //$event->sheet->getStyle('A2:AB2')->applyFromArray($styleArray);
                // $event->sheet->getDelegate()->freezePane('E1');
                // $event->sheet->mergeCells('A1:A2');
                // $event->sheet->mergeCells('B1:B2');
                // $event->sheet->mergeCells('C1:C2');
                // $event->sheet->mergeCells('D1:D2');
                // $event->sheet->mergeCells('E1:E2');
                // $event->sheet->mergeCells('F1:F2');
                // $event->sheet->mergeCells('G1:G2');
                // $event->sheet->mergeCells('H1:H2');

                // $event->sheet->mergeCells('I1:M1');
                // $event->sheet->mergeCells('N1:R1');
                // $event->sheet->mergeCells('S1:W1');
                // $event->sheet->mergeCells('X1:AB1');
            },
        ];
    }

}

<?php

namespace App\Exports;

use App\Inscripcione;
use App\Asignatura;
use App\Nota;
use App\Turno;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class NotasEstudiantesExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $array_inscripciones;

    public function __construct($array_inscripciones)
    {
        $this->array_inscripciones    = $array_inscripciones;
    }

    public function collection()
    {
        return Inscripcione::whereIn('id', $this->array_inscripciones)
                            ->orderBy('persona_id')
                            ->orderBy('carrera_id')
                            ->orderBy('anio_vigente')
                            ->get();
    }

    public function map($inscripcion): array
    {
        /**
        * @var Invoice $invoice
        */
        //$turno = Turno::find($this->turno);
        $notaUno    = Nota::where('inscripcion_id', $inscripcion->id)->where('trimestre', 1)->first();
        if(!$notaUno){
            $notaUno    = new Nota();
        }
        $notaDos    = Nota::where('inscripcion_id', $inscripcion->id)->where('trimestre', 2)->first();
        if(!$notaDos){
            $notaDos    = new Nota();
        }
        $notaTres   = Nota::where('inscripcion_id', $inscripcion->id)->where('trimestre', 3)->first();
        if(!$notaTres){
            $notaTres   = new Nota();
        }
        $notaCuatro = Nota::where('inscripcion_id', $inscripcion->id)->where('trimestre', 4)->first();
        if(!$notaCuatro){
            $notaCuatro = new Nota();
        }
        ($inscripcion->convalidado == 'Si' ? $convalidado = 'Si' : $convalidado = 'No');
        ($inscripcion->gestion ? $inscripcionGestion = $inscripcion->gestion : $inscripcionGestion = $inscripcion->asignatura->gestion);
        // APLICAR VALIDACIONES
        return [
            $inscripcion->id,
            $inscripcion->persona->cedula,
            $inscripcion->carrera->nombre,
            $inscripcion->asignatura->sigla,
            $inscripcion->asignatura->nombre,
            $inscripcionGestion,
            $inscripcion->asignatura->ciclo,
            $inscripcion->turno->descripcion,
            $inscripcion->paralelo,
            $inscripcion->anio_vigente,
            $notaUno->nota_asistencia,
            $notaUno->nota_practicas,
            $notaUno->nota_primer_parcial,
            $notaUno->nota_examen_final,
            $notaUno->nota_puntos_ganados,
            $notaDos->nota_asistencia,
            $notaDos->nota_practicas,
            $notaDos->nota_primer_parcial,
            $notaDos->nota_examen_final,
            $notaDos->nota_puntos_ganados,
            $notaTres->nota_asistencia,
            $notaTres->nota_practicas,
            $notaTres->nota_primer_parcial,
            $notaTres->nota_examen_final,
            $notaTres->nota_puntos_ganados,
            $notaCuatro->nota_asistencia,
            $notaCuatro->nota_practicas,
            $notaCuatro->nota_primer_parcial,
            $notaCuatro->nota_examen_final,
            $notaCuatro->nota_puntos_ganados,
            $convalidado,
            $inscripcion->nota_reprobacion,
            $inscripcion->nota,
            //$this->anio_vigente,
        ];
    }

    public function headings() : array
    {
        //$notapropuesta = NotasPropuesta::find($this->asignatura_id);
        return [
            [
                'Id',
                'Cedula de Identidad',
                'Carrera',
                'Sigla',
                'Nombre',
                'Gestion',
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
                '',
                '',
                '',
                '',
                '(REFERENCIAL NO LLENAR)',
                '',
                '',
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
                'Convalidado',
                'Nota Reprobacion',
                'Total',
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
                $event->sheet->getStyle('A1:AG1')->applyFromArray($styleArray);
                $event->sheet->getStyle('A2:AG2')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->freezePane('F1');
                $event->sheet->mergeCells('A1:A2');
                $event->sheet->mergeCells('B1:B2');
                $event->sheet->mergeCells('C1:C2');
                $event->sheet->mergeCells('D1:D2');
                $event->sheet->mergeCells('E1:E2');
                $event->sheet->mergeCells('F1:F2');
                $event->sheet->mergeCells('G1:G2');
                $event->sheet->mergeCells('H1:H2');
                $event->sheet->mergeCells('I1:I2');
                $event->sheet->mergeCells('J1:J2');

                $event->sheet->mergeCells('K1:O1');
                $event->sheet->mergeCells('P1:T1');
                $event->sheet->mergeCells('U1:Y1');
                $event->sheet->mergeCells('Z1:AD1');
                $event->sheet->mergeCells('AE1:AG1');
            },
        ];
    }
}

<?php

namespace App\Exports;

use App\Inscripcione;
use App\Nota;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AsignaturaNotasExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    protected $docente_id;
    protected $asignatura_id;
    protected $anio_vigente;

    public function __construct($docente_id, $asignatura_id, $anio_vigente)
    {
        $this->docente_id       = $docente_id;
        $this->asignatura_id    = $asignatura_id;
        $this->anio_vigente     = $anio_vigente;
    }

    public function collection()
    {
        return Inscripcione::where('inscripciones.asignatura_id', $this->asignatura_id)
                            ->where('inscripciones.anio_vigente', $this->anio_vigente)
                            // ->where('inscripciones.docente_id', $this->docente_id)
                            ->join('personas', 'personas.id', '=', 'inscripciones.persona_id')
                            ->orderBy('turno_id')
                            ->orderBy('paralelo')
                            ->orderBy('personas.apellido_paterno')
                            ->select('inscripciones.*')
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
        $inscripcionGestion = ($inscripcion->gestion ? $inscripcion->gestion : $inscripcion->asignatura->gestion);
        // APLICAR VALIDACIONES
        return [
            $inscripcion->id,
            $inscripcion->persona->cedula,
            $inscripcion->persona->apellido_paterno . ' ' . $inscripcion->persona->apellido_materno . ' ' . $inscripcion->persona->nombres,
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
                'Apellidos y Nombres',
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
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],  
        ];
        return [
            AfterSheet::class => function(AfterSheet $event) use ($styleArray) {
                $event->sheet->getStyle('A1:AH1')->applyFromArray($styleArray);
                $event->sheet->getStyle('A2:AH2')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->freezePane('D1');
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
                $event->sheet->mergeCells('K1:K2');

                $event->sheet->mergeCells('L1:P1');
                $event->sheet->mergeCells('Q1:U1');
                $event->sheet->mergeCells('V1:Z1');
                $event->sheet->mergeCells('AA1:AE1');
                $event->sheet->mergeCells('AF1:AH1');
            },
        ];
    }
}

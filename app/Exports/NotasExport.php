<?php

namespace App\Exports;

use App\Nota;
use App\NotasPropuesta;
use App\Inscripcione;
//use Illuminate\Contracts\View\View;
//use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
//use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class NotasExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $asignatura_id;
    protected $bimestre;

    public function __construct($asignatura_id, $bimestre)
    {
        $this->asignatura_id    = $asignatura_id;
        $this->bimestre         = $bimestre;
    }
    
    public function collection()
    {
        $notapropuesta  = NotasPropuesta::find($this->asignatura_id);
        $bimestre       = $this->bimestre;
        return Nota::where('asignatura_id', $notapropuesta->asignatura_id)
                    ->where('turno_id', $notapropuesta->turno_id)
                    ->where('paralelo', $notapropuesta->paralelo)
                    //->where('docente_id', $notapropuesta->docente_id)
                    ->where('anio_vigente', $notapropuesta->anio_vigente)
                    ->where('trimestre', $bimestre)
                    ->get();
        // if($notapropuesta->asignatura->ciclo == 'Semestral')
        // {
        //     return Nota::where('asignatura_id', $notapropuesta->asignatura_id)
        //                 ->where('turno_id', $notapropuesta->turno_id)
        //                 ->where('user_id', $notapropuesta->user_id)
        //                 ->where('paralelo', $notapropuesta->paralelo)
        //                 ->where('anio_vigente', $notapropuesta->anio_vigente)
        //                 ->where(function ($query) {
        //                     $query->where('trimestre', 1)
        //                         ->orWhere('trimestre', 2);
        //                 })
        //                 ->get();
        // }
        // else
        // {
        //     return Nota::where('asignatura_id', $notapropuesta->asignatura_id)
        //                 ->where('turno_id', $notapropuesta->turno_id)
        //                 ->where('user_id', $notapropuesta->user_id)
        //                 ->where('paralelo', $notapropuesta->paralelo)
        //                 ->where('anio_vigente', $notapropuesta->anio_vigente)
        //                 ->get();
        // }
    }

    public function map($nota): array
    {
        /**
        * @var Invoice $invoice
        */
        $registro   = Inscripcione::where('id', $nota->inscripcion_id)
                                ->first();
        if($registro){
            if($registro->convalidacion_externa && $registro->convalidacion_externa == 'Si'){
                $observacion    = 'No Calificar';
            }else{
                $observacion    = '';
            }
        }else{
            $observacion    = '';
        }
        return [
            $nota->id,
            $nota->persona->apellido_materno. ' ' .$nota->persona->apellido_paterno. ' ' .$nota->persona->nombres,
            $nota->persona->cedula,
            $nota->trimestre,
            $nota->nota_asistencia,
            $nota->nota_practicas,
            $nota->nota_primer_parcial,
            $nota->nota_examen_final,
            $nota->nota_puntos_ganados,
        ];
    }

    public function headings() : array
    {
        $notapropuesta = NotasPropuesta::find($this->asignatura_id);
        return [
            '# Id',
            'Nombres y Apellidos',
            'CI',
            'Bimestre',
            'Asistencia (Max: '.round($notapropuesta->nota_asistencia).')',
            'Practicas (Max: '.round($notapropuesta->nota_practicas).')',
            'Primer Parcial (Max: '.round($notapropuesta->nota_primer_parcial).')',
            'Examen Final (Max: '.round($notapropuesta->nota_examen_final).')',
            'Extras (Max: '.round($notapropuesta->nota_puntos_ganados).')',
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
                $event->sheet->getStyle('A1:J1')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->freezePane('E1');
            },
        ];
    }
}

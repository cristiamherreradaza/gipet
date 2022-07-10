<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Carrera;
use App\CarrerasPersona;
use App\Inscripcione;
use App\Persona;
use App\User;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cantidadEstudiantes    = Persona::count();
        $cantidadUsuarios       = User::count();
        $cantidadCarreras       = Carrera::count();
        $sumaPuntaje            = Inscripcione::where('anio_vigente', date('Y'))
                                            ->where('aprobo', 'Si')
                                            ->whereNull('oyente')
                                            ->sum('nota');
        $cantidadAprobados      = Inscripcione::where('anio_vigente', date('Y'))
                                            ->where('aprobo', 'Si')
                                            ->whereNull('oyente')
                                            ->count();
        $mediaPuntajeAnual  = ($cantidadAprobados == 0 ? $cantidadAprobados : (round($sumaPuntaje/$cantidadAprobados)));
        // Hallaremos la cantidad de alumnos por carrera
        $cantidadEstudiantesCarrera = CarrerasPersona::select('carrera_id', DB::raw('count(distinct persona_id) as total'))
                                                ->groupBy('carrera_id')
                                                ->orderBy('total', 'desc')
                                                ->get();
                                                
        $anio = date('Y');

        $number = cal_days_in_month(CAL_GREGORIAN, 1, $anio);
        $fechaInicoEnero = $anio.'-01-01';
        $fechaFinEnero = $anio.'-01-'.$number;
        // MENSUALIDADES
        $mensualidadEnero = DB::table('pagos')
                            ->select(DB::raw('sum(importe) as total'))
                            ->where('servicio_id',2)
                            ->whereBetween('fecha',[$fechaInicoEnero,$fechaFinEnero])
                            ->first();

        // $number = cal_days_in_month(CAL_GREGORIAN, 2, $anio);
        // $fechaInicoFebrero = $anio.'-02-01';
        // $fechaFinFebrero = $anio.'-02-'.$number;
        // // dd($fechaInicoFebrero . "<---->".$fechaFinFebrero);
        // // MENSUALIDADES
        // $mensualidadFebrero = DB::table('pagos')
        //                     ->select(DB::raw('sum(importe) as total'))
        //                     ->where('servicio_id',2)
        //                     ->whereBetween('fecha',[$fechaInicoFebrero,$fechaFinFebrero])
        //                     ->first();

        // $number = cal_days_in_month(CAL_GREGORIAN, 3, $anio);
        // $fechaInicoMarzo = $anio.'-03-01';
        // $fechaFinMarzo = $anio.'-03-'.$number;
        // // MENSUALIDADES
        // $mensualidadMarzo = DB::table('pagos')
        //                     ->select(DB::raw('sum(importe) as total'))
        //                     ->where('servicio_id',2)
        //                     ->whereBetween('fecha',[$fechaInicoMarzo,$fechaFinMarzo])
        //                     ->first();

        // $number = cal_days_in_month(CAL_GREGORIAN, 4, $anio);
        // $fechaInicoAbril = $anio.'-04-01';
        // $fechaFinAbril = $anio.'-04-'.$number;
        // // MENSUALIDADES
        // $mensualidadAbril = DB::table('pagos')
        //                     ->select(DB::raw('sum(importe) as total'))
        //                     ->where('servicio_id',2)
        //                     ->whereBetween('fecha',[$fechaInicoAbril,$fechaFinAbril])
        //                     ->first();

        // $number = cal_days_in_month(CAL_GREGORIAN, 5, $anio);
        // $fechaInicoMayo = $anio.'-05-01';
        // $fechaFinMayo = $anio.'-05-'.$number;
        // // MENSUALIDADES
        // $mensualidadMayo = DB::table('pagos')
        //                     ->select(DB::raw('sum(importe) as total'))
        //                     ->where('servicio_id',2)
        //                     ->whereBetween('fecha',[$fechaInicoMayo,$fechaFinMayo])
        //                     ->first();


        // $number = cal_days_in_month(CAL_GREGORIAN, 6, $anio);
        // $fechaInicoJunio = $anio.'-06-01';
        // $fechaFinJunio = $anio.'-06-'.$number;
        // // MENSUALIDADES
        // $mensualidadJunio = DB::table('pagos')
        //                     ->select(DB::raw('sum(importe) as total'))
        //                     ->where('servicio_id',2)
        //                     ->whereBetween('fecha',[$fechaInicoJunio,$fechaFinJunio])
        //                     ->first();

        // $number = cal_days_in_month(CAL_GREGORIAN, 7, $anio);
        // $fechaInicoJulio = $anio.'-07-01';
        // $fechaFinJulio = $anio.'-07-'.$number;
        // // MENSUALIDADES
        // $mensualidadJulio = DB::table('pagos')
        //                     ->select(DB::raw('sum(importe) as total'))
        //                     ->where('servicio_id',2)
        //                     ->whereBetween('fecha',[$fechaInicoJulio,$fechaFinJulio])
        //                     ->first();

        // $number = cal_days_in_month(CAL_GREGORIAN, 8, $anio);
        // $fechaInicoAgosto = $anio.'-08-01';
        // $fechaFinAgosto = $anio.'-08-'.$number;
        // // MENSUALIDADES
        // $mensualidadAgosto = DB::table('pagos')
        //                     ->select(DB::raw('sum(importe) as total'))
        //                     ->where('servicio_id',2)
        //                     ->whereBetween('fecha',[$fechaInicoAgosto,$fechaFinAgosto])
        //                     ->first();

        // $number = cal_days_in_month(CAL_GREGORIAN, 9, $anio);
        // $fechaInicoSeptiembre = $anio.'-09-01';
        // $fechaFinSeptiembre = $anio.'-09-'.$number;
        // // MENSUALIDADES
        // $mensualidadSeptiembre = DB::table('pagos')
        //                     ->select(DB::raw('sum(importe) as total'))
        //                     ->where('servicio_id',2)
        //                     ->whereBetween('fecha',[$fechaInicoSeptiembre,$fechaFinSeptiembre])
        //                     ->first();


        // $number = cal_days_in_month(CAL_GREGORIAN, 10, $anio);
        // $fechaInicoOctubre = $anio.'-10-01';
        // $fechaFinOctubre = $anio.'-10-'.$number;
        // // MENSUALIDADES
        // $mensualidadOctubre = DB::table('pagos')
        //                     ->select(DB::raw('sum(importe) as total'))
        //                     ->where('servicio_id',2)
        //                     ->whereBetween('fecha',[$fechaInicoOctubre,$fechaFinOctubre])
        //                     ->first();


        // $number = cal_days_in_month(CAL_GREGORIAN, 11, $anio);
        // $fechaInicoNoviembre = $anio.'-11-01';
        // $fechaFinNoviembre = $anio.'-11-'.$number;
        // // MENSUALIDADES
        // $mensualidadNoviembre = DB::table('pagos')
        //                     ->select(DB::raw('sum(importe) as total'))
        //                     ->where('servicio_id',2)
        //                     ->whereBetween('fecha',[$fechaInicoNoviembre,$fechaFinNoviembre])
        //                     ->first();

        // $number = cal_days_in_month(CAL_GREGORIAN, 12, $anio);
        // $fechaInicoDiciembre = $anio.'-12-01';
        // $fechaFinDiciembre = $anio.'-12-'.$number;
        // // MENSUALIDADES
        // $mensualidadDiciembre = DB::table('pagos')
        //                     ->select(DB::raw('sum(importe) as total'))
        //                     ->where('servicio_id',2)
        //                     ->whereBetween('fecha',[$fechaInicoDiciembre,$fechaFinDiciembre])
        //                     ->first();

        // POP ERRROR DE SERVER SE CAMBIO A NULL
        // $mensualidadEnero = null;
        $mensualidadFebrero = null;
        $mensualidadMarzo = null;
        $mensualidadAbril = null;
        $mensualidadMayo = null;
        $mensualidadJunio = null;
        $mensualidadJulio = null;
        $mensualidadAgosto = null;
        $mensualidadSeptiembre = null;
        $mensualidadOctubre = null;
        $mensualidadNoviembre = null;
        $mensualidadDiciembre = null;
                                                
        
        return view('home')->with(compact('cantidadEstudiantes', 'cantidadUsuarios', 'cantidadCarreras', 'mediaPuntajeAnual', 'cantidadEstudiantesCarrera','mensualidadEnero', 'mensualidadFebrero', 'mensualidadMarzo', 'mensualidadAbril','mensualidadMayo','mensualidadJunio', 'mensualidadJulio', 'mensualidadAgosto','mensualidadSeptiembre','mensualidadOctubre','mensualidadNoviembre','mensualidadDiciembre'));
    }
}

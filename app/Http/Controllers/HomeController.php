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
        return view('home')->with(compact('cantidadEstudiantes', 'cantidadUsuarios', 'cantidadCarreras', 'mediaPuntajeAnual', 'cantidadEstudiantesCarrera'));
    }
}

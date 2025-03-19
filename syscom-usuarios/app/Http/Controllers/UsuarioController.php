<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PDF;
use Carbon\Carbon;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::whereNull('fecha_eliminacion')->get();
        $roles = Role::all();
        
        // Calcular días trabajados para cada usuario
        foreach ($usuarios as $usuario) {
            $usuario->dias_trabajados = $this->calcularDiasHabiles($usuario->fecha_ingreso);
        }
        
        return view('usuarios.index', compact('usuarios', 'roles'));
    }
    
    public function create()
    {
        $roles = Role::all();
        return view('usuarios.create', compact('roles'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo_electronico' => 'required|email|unique:usuarios',
            'id_rol' => 'required|exists:roles,id',
            'fecha_ingreso' => 'required|date',
            'firma' => 'required|string'
        ]);
        
        // Crear usuario
        $usuario = new Usuario($validated);
        $usuario->save();
        
        // Generar contrato PDF
        $contrato = $this->generarContrato($usuario);
        $usuario->contrato = $contrato;
        $usuario->save();
        
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }
    
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }
    
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo_electronico' => 'required|email|unique:usuarios,correo_electronico,'.$id,
            'id_rol' => 'required|exists:roles,id',
            'fecha_ingreso' => 'required|date',
            'firma' => 'sometimes|string'
        ]);
        
        $usuario->update($validated);
        
        // Si se actualizó la firma, regenerar el contrato
        if ($request->has('firma') && $request->firma != $usuario->firma) {
            $contrato = $this->generarContrato($usuario);
            $usuario->contrato = $contrato;
            $usuario->save();
        }
        
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }
    
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->fecha_eliminacion = now();
        $usuario->save();
        
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
    
    public function verContrato($id)
    {
        $usuario = Usuario::findOrFail($id);
        if (!$usuario->contrato || !Storage::exists($usuario->contrato)) {
            return redirect()->route('usuarios.index')->with('error', 'El contrato no existe');
        }
        
        return response()->file(storage_path('app/'.$usuario->contrato));
    }
    
    private function calcularDiasHabiles($fechaIngreso)
    {
        $hoy = Carbon::now();
        $fechaInicio = Carbon::parse($fechaIngreso);
        $diasTotales = 0;
        
        // Obtener festivos de Colombia
        $anioActual = date('Y');
        $response = Http::get("https://api-colombia.com/api/v1/holiday/year/{$anioActual}");
        $festivos = [];
        
        if ($response->successful()) {
            foreach ($response->json() as $festivo) {
                $festivos[] = $festivo['date'];
            }
        }
        
        // Calcular días hábiles
        for ($fecha = $fechaInicio; $fecha->lte($hoy); $fecha->addDay()) {
            $esFestivo = in_array($fecha->format('Y-m-d'), $festivos);
            $esFinDeSemana = $fecha->isWeekend();
            
            if (!$esFestivo && !$esFinDeSemana) {
                $diasTotales++;
            }
        }
        
        return $diasTotales;
    }
    
    private function generarContrato($usuario)
    {
        // Asegurarse de que la carpeta existe
        $path = 'contratos';
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }
        
        // Generar PDF
        $pdf = \PDF::loadView('contratos.template', compact('usuario'));
        $filename = $path . '/' . time() . '_contrato_' . $usuario->id . '.pdf';
        
        Storage::put($filename, $pdf->output());
        
        return $filename;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    
    protected $table = 'usuarios';
    
    protected $fillable = [
        'nombre',
        'correo_electronico',
        'id_rol',
        'fecha_ingreso',
        'firma',
        'contrato',
        'fecha_eliminacion'
    ];
    
    protected $dates = [
        'fecha_ingreso',
        'fecha_eliminacion'
    ];
    
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_rol');
    }
}
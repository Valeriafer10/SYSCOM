<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Trabajo - {{ $usuario->nombre }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 15px;
        }
        .signature {
            margin-top: 50px;
            text-align: center;
        }
        .signature img {
            max-width: 200px;
            max-height: 100px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">CONTRATO DE TRABAJO</div>
        <div class="subtitle">SYSCOM COLOMBIA</div>
    </div>
    
    <div class="content">
        <div class="section">
            <p>Entre la empresa SYSCOM COLOMBIA, representada legalmente por su Gerente General, y {{ $usuario->nombre }}, identificado como aparece al pie de su firma, se ha celebrado el siguiente contrato de trabajo.</p>
        </div>
        
        <div class="section">
            <h3>DATOS DEL EMPLEADO</h3>
            <table>
                <tr>
                    <th>Nombre completo:</th>
                    <td>{{ $usuario->nombre }}</td>
                </tr>
                <tr>
                    <th>Correo electrónico:</th>
                    <td>{{ $usuario->correo_electronico }}</td>
                </tr>
                <tr>
                    <th>Cargo:</th>
                    <td>{{ $usuario->role->nombre_cargo }}</td>
                </tr>
                <tr>
                    <th>Fecha de ingreso:</th>
                    <td>{{ \Carbon\Carbon::parse($usuario->fecha_ingreso)->format('d/m/Y') }}</td>
                </tr>
            </table>
        </div>
        
        <div class="section">
            <h3>CLÁUSULAS</h3>
            <p><strong>PRIMERA - OBJETO:</strong> El EMPLEADOR contrata los servicios personales del TRABAJADOR para desempeñarse como {{ $usuario->role->nombre_cargo }} y realizar las funciones propias de este cargo y las demás que le sean asignadas por el empleador o sus representantes.</p>
            
            <p><strong>SEGUNDA - DURACIÓN:</strong> El presente contrato tiene una duración indefinida, mientras subsistan las causas que le dieron origen y la materia del trabajo.</p>
            
            <p><strong>TERCERA - LUGAR:</strong> El trabajador desarrollará sus funciones en las instalaciones de la empresa ubicadas en Bogotá, Colombia, o en los lugares que la empresa designe según las necesidades del servicio.</p>
            
            <p><strong>CUARTA - JORNADA DE TRABAJO:</strong> El trabajador se obliga a laborar la jornada ordinaria de 48 horas semanales, en los turnos y dentro de las horas señaladas por el empleador.</p>
            
            <p><strong>QUINTA - CONFIDENCIALIDAD:</strong> El TRABAJADOR se compromete a guardar absoluta confidencialidad sobre los procesos, métodos, datos técnicos, información de clientes y cualquier información de la empresa a la que tenga acceso.</p>
        </div>
    </div>
    
    <div class="signature">
        <p>Firmado en Bogotá, el día {{ date('d/m/Y') }}</p>
        <p><strong>El trabajador:</strong></p>
        <img src="{{ $usuario->firma }}" alt="Firma del empleado">
        <p>{{ $usuario->nombre }}<br>{{ $usuario->correo_electronico }}</p>
    </div>
    
    <div class="footer">
        <p>SYSCOM COLOMBIA - Todos los derechos reservados {{ date('Y') }}</p>
    </div>
</body>
</html>
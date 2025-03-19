<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Usuarios - SYSCOM Colombia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/icono.jfif') }}" type="image/x-icon">
    <style>
        :root {
            --primary-color: #0e3ba3;
            --secondary-color: #f8fafc;
        }
        
        body {
            background-image: url('{{ asset('images/fondo.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand img {
            height: 50px;
            margin-right: 10px;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: #1e40af;
        }
        
        .nav-link.active {
            background-color: var(--primary-color);
            color: white !important;
            border-radius: 5px;
        }
        
        .titulo {
            color:rgb(242, 244, 250);
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
        
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table th {
            background-color: #f8fafc;
            color: #334155;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .table td {
            white-space: nowrap;
            vertical-align: middle;
            font-size: 0.9rem;
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
        }
        
        .form-label {
            font-weight: 500;
            color: #4b5563;
        }
        
        .input-group-text {
            background-color: #f3f4f6;
            border-right: none;
        }
        
        #searchInput {
            border-left: none;
        }
        
        .btn-outline-primary, .btn-outline-warning, .btn-outline-danger {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-success {
            background-color: #10b981;
            border-color: #10b981;
        }
        
        .btn-success:hover {
            background-color: #059669;
            border-color: #059669;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="SYSCOM Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="titulo"><center>Gestión de Usuarios</center></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Listado de Usuarios</span>
                        <a href="{{ route('usuarios.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Nuevo Usuario
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="cargoFilter" class="form-select">
                                    <option value="">Todos los cargos</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->nombre_cargo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="date" id="fechaFilter" class="form-control">
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Correo Electrónico</th>
                                        <th>Cargo</th>
                                        <th>Fecha de Ingreso</th>
                                        <th>Días Trabajados</th>
                                        <th>Contrato</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($usuarios as $usuario)
                                        <tr>
                                            <td>{{ $usuario->id }}</td>
                                            <td>{{ $usuario->nombre }}</td>
                                            <td>{{ $usuario->correo_electronico }}</td>
                                            <td>{{ $usuario->role->nombre_cargo }}</td>
                                            <td>{{ \Carbon\Carbon::parse($usuario->fecha_ingreso)->format('d/m/Y') }}</td>
                                            <td>{{ $usuario->dias_trabajados }}</td>
                                            <td>
                                                @if($usuario->contrato)
                                                    <a href="{{ route('usuarios.contrato', $usuario->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                                        <i class="fas fa-file-pdf"></i> Ver
                                                    </a>
                                                @else
                                                    <span class="badge bg-secondary">No disponible</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-outline-warning btn-sm">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este usuario?')">
                                                            <i class="fas fa-trash"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No hay usuarios registrados</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Esta función se ejecuta cuando el documento HTML ha sido completamente cargado
    console.log('Sistema de Gestión de Usuarios inicializado');
    
    // Manejadores de eventos para los filtros
    document.getElementById('searchInput').addEventListener('keyup', function() {
        filtrarTabla();
    });
    
    document.getElementById('cargoFilter').addEventListener('change', function() {
        filtrarTabla();
    });
    
    document.getElementById('fechaFilter').addEventListener('change', function() {
        filtrarTabla();
    });
    
    function filtrarTabla() {
        const busqueda = document.getElementById('searchInput').value.toLowerCase();
        const cargoSeleccionado = document.getElementById('cargoFilter').value;
        const fechaSeleccionada = document.getElementById('fechaFilter').value;
        
        const filas = document.querySelectorAll('tbody tr');
        
        filas.forEach(function(fila) {
            // Si la fila no tiene suficientes celdas (como en el caso de "No hay usuarios registrados"), la saltamos
            if(fila.cells.length < 4) return;
            
            let mostrar = true;
            
            // Filtro por búsqueda (nombre o correo)
            const nombre = fila.cells[1].textContent.toLowerCase();
            const email = fila.cells[2].textContent.toLowerCase();
            
            if (busqueda && !nombre.includes(busqueda) && !email.includes(busqueda)) {
                mostrar = false;
            }
            
            // Filtro por cargo
            if (cargoSeleccionado && mostrar) {
                // Obtener el texto del cargo desde la opción seleccionada
                const cargoTexto = fila.cells[3].textContent.trim();
                const cargoDropdownText = document.querySelector(`#cargoFilter option[value="${cargoSeleccionado}"]`).textContent.trim();
                
                if (cargoTexto !== cargoDropdownText) {
                    mostrar = false;
                }
            }
            
            // Filtro por fecha
            if (fechaSeleccionada && mostrar) {
                // Convertir fecha de dd/mm/yyyy a yyyy-mm-dd para comparar
                const fechaTabla = fila.cells[4].textContent.trim();
                const partesFecha = fechaTabla.split('/');
                if (partesFecha.length === 3) {
                    const fechaFormateada = `${partesFecha[2]}-${partesFecha[1]}-${partesFecha[0]}`;
                    if (fechaFormateada !== fechaSeleccionada) {
                        mostrar = false;
                    }
                }
            }
            
            fila.style.display = mostrar ? '' : 'none';
        });
    }
});
    </script>
</body>
</html>
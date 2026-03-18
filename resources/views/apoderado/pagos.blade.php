@extends('layouts.apoderado.app')
@section('title','Historial de Pagos')
@push('styles')
    <style>
        /* --- TUS ESTILOS CSS (SIMPLIFICADOS) --- */
        :root {
            --primary-color: #1E8449; --secondary-color: #2ECC71; --light-green: #D5F5E3;
            --dark-gray: #34495E; --light-gray: #ECF0F1; --white: #ffffff;
            --info: #3498DB;
        }
        /* ... (tus estilos base de body, sidebar, top-nav, etc. se mantienen) ... */
        .content { padding: 2rem; }
        .main-panel { background: var(--white); border-radius: 8px; padding: 1.5rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); }
        .main-panel h3 { margin-top: 0; border-bottom: 2px solid var(--primary-color); padding-bottom: 0.5rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        
        .payments-table-container { overflow-x: auto; }
        .payments-table { width: 100%; border-collapse: collapse; }
        .payments-table th, .payments-table td { padding: 0.8rem 1rem; text-align: left; border-bottom: 1px solid var(--light-gray); vertical-align: middle; }
        .payments-table th { font-weight: 600; color: var(--dark-gray); font-size: 0.9rem; white-space: nowrap; }
        .payments-table tbody tr:hover { background-color: #f9f9ff; }
        
        .btn { padding: 0.6rem 1.2rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; font-size: 0.9rem; font-weight: bold; }
        .btn-primary { background-color: var(--primary-color); color: var(--white); }
        .btn-receipt { background-color: transparent; color: var(--info); border: 1px solid var(--info); padding: 0.4rem 0.8rem; }

        @media (max-width: 768px) {
            .content { padding: 1.5rem 1rem; }
            .payments-table th, .payments-table td { font-size: 0.85rem; padding: 0.6rem 0.5rem; }
            .main-panel h3 { flex-direction: column; align-items: flex-start; gap: 1rem; }
        }
    </style>
@endpush

@section('content')
    <div class="content">
        <h1>Historial de Pagos</h1>

        <div class="main-panel">
            <h3>
                <span>Pagos Realizados</span>
                <a href="{{ route('index') }}" class="btn btn-primary" style="font-size: 0.9rem;">
                    <i class="fa-solid fa-plus"></i> Inscribir a Nuevo Taller
                    
                </a>
            </h3>
            <div class="payments-table-container">
                <table class="payments-table">
                    <thead>
                        <tr>
                            @if(Auth::user()->role->value == 'PADRE')
                                <th>Alumno</th>
                            @endif
                            <th>Taller / Sección</th>
                            <th>Periodo</th>
                            <th>Fecha de Pago</th>
                            <th>Monto Pagado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pagos as $pago)
                            <tr>
                                @if(Auth::user()->role->value === 'PADRE')
                                    <td><strong>{{ $pago->cronogramaPago->matricula->alumnos->user->nombres }}</strong></td>
                                @endif
                                <td>{{ $pago->cronogramaPago->matricula->seccion->talleres->disciplina->nombre }} - {{ $pago->cronogramaPago->matricula->seccion->nombre }}</td>
                                <td>{{ $pago->cronogramaPago->matricula->seccion->periodo->anio }} - {{ $pago->cronogramaPago->matricula->seccion->periodo->ciclo }}</td>
                                <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                <td><strong>S/ {{ number_format($pago->monto_pagado, 2) }}</strong></td>
                                <td>
                                    @php $idCifrado = Crypt::encryptString($pago->id); @endphp
                                    <a href="{{ route('pagos.comprobante', $idCifrado) }}" class="btn btn-receipt" target="_blank">
                                        <i class="fa-solid fa-file-pdf"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role->value === 'PADRE' ? '6' : '5' }}" style="text-align: center; padding: 2rem;">
                                    Aún no has realizado ninguna inscripción.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Paginación si es necesaria --}}
            <div style="margin-top: 1.5rem;">
                {{ $pagos->links() }}
            </div>
        </div>
    </div>
@endsection


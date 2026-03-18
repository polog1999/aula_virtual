@extends('layouts.alumno.app')
{{-- O como se llame tu layout base del portal --}}

@section('title', 'Mis Pagos')

@push('styles')
    <style>
        :root {
            --primary-color: #1E8449;
            --secondary-color: #2ECC71;
            --light-green: #D5F5E3;
            --dark-gray: #34495E;
            --light-gray: #ECF0F1;
            --white: #ffffff;
            --warning: #F39C12;
            --danger: #E74C3C;
            --info: #3498DB;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            background-color: var(--light-gray);
            color: var(--dark-gray);
        }

        .container-fluid {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--dark-gray);
            color: var(--white);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 1.2rem;
        }

        .sidebar-nav {
            flex-grow: 1;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav a {
            display: block;
            padding: 1rem 1.5rem;
            color: var(--light-gray);
            text-decoration: none;
            transition: background-color 0.2s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background-color: var(--primary-color);
            color: var(--white);
            border-left-color: var(--secondary-color);
        }

        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .top-nav {
            background: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .user-profile {
            font-weight: bold;
        }

        .content {
            padding: 2rem;
        }

        .main-panel,
        .side-panel {
            background: var(--white);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .main-panel h3,
        .side-panel h3 {
            margin-top: 0;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }

        /* --- ESTILOS ESPECÍFICOS PARA LA TABLA DE PAGOS --- */
        .payments-table-container {
            overflow-x: auto;
        }

        .payments-table {
            width: 100%;
            border-collapse: collapse;
        }

        .payments-table th,
        .payments-table td {
            padding: 0.8rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
            vertical-align: middle;
        }

        .payments-table th {
            font-weight: 600;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }

        .payments-table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: bold;
            color: var(--white);
            display: inline-block;
            text-align: center;
            min-width: 80px;
        }

        .status-pagado {
            background-color: var(--secondary-color);
            color: var(--dark-gray);
        }

        .status-pendiente {
            background-color: var(--warning);
        }

        .status-vencido {
            background-color: var(--danger);
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .btn-pay {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .btn-receipt {
            background-color: transparent;
            color: var(--info);
            border: 1px solid var(--info);
            padding: 0.4rem 0.8rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            font-size: 1rem;
            padding: 0.5rem 0;
        }

        .summary-item .value {
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100%;
                transform: translateX(-100%);
                z-index: 1000;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .menu-toggle {
                display: block;
            }

            .content {
                padding: 1.5rem 1rem;
            }

            .payments-table th,
            .payments-table td {
                font-size: 0.85rem;
                padding: 0.6rem 0.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="content">
        <h1>Mis Pagos</h1>
        {{-- <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">


            <div class="main-panel">
                <h3>Pagos Pendientes y Vencidos</h3>
                <div class="payments-table-container">
                    <table class="payments-table">
                        <thead>
                            <tr>
                                <th>Alumno</th>
                                <th>Concepto</th>
                                <th>Vencimiento</th>
                                <th>Monto</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @forelse ($cuotasPendientes as $cuota)
                                <tr>
                                    <td>
                                        {{ $cuota->matricula->alumnos->user->nombres }}
                                        @if ($cuota->matricula->alumno_id == Auth::id())
                                            (Tú)
                                        @endif
                                    </td>
                                    <td>{{ $cuota->concepto }}
                                        ({{ $cuota->matricula->seccion->talleres->disciplina->nombre }})</td>
                                    <td>{{ $cuota->fecha_vencimiento->format('d/m/Y') }}</td>
                                    <td>S/ {{ number_format($cuota->monto, 2) }}</td>
                                    <td><span
                                            class="status-badge status-{{ strtolower($cuota->estado) }}">{{ $cuota->estado }}</span>
                                    </td>
                                    <td>
                                        <a href="/ruta-para-pagar/{{ $cuota->id }}" class="btn btn-pay">Pagar Ahora</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 2rem;">¡Felicidades! No tienes
                                        pagos pendientes.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="side-panel">
                <h3>Resumen Financiero</h3>
                <div class="summary-item">
                    <span>Total Pendiente:</span>
                    <span class="value" style="color: var(--danger);">S/ {{ number_format($totalPendiente, 2) }}</span>
                </div>
                <div class="summary-item">
                    <span>Próximo Vencimiento:</span>
                    <span
                        class="value">{{ $proximoVencimiento ? $proximoVencimiento->format('d/m/Y') . ' (' . $proximoVencimiento->diffForHumans() . ')' : 'N/A' }}</span>
                </div>
                <br>
                <a href="#" class="btn btn-pay" style="width: 100%;">Pagar Todo lo Pendiente</a>
            </div>
        </div> --}}

        {{-- Panel Secundario con Historial de Pagos --}}
        <div class="main-panel" style="margin-top: 2rem;">
            <h3>Historial de Pagos Realizados</h3>
            <div class="payments-table-container">
                <table class="payments-table">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Concepto</th>
                            <th>Fecha de Pago</th>
                            <th>Monto</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($historialPagos as $pago)
                            @php
                                $idCifrado = Crypt::encryptString($pago->id);
                            @endphp
                            <tr>
                                <td>{{ $pago->cronogramaPago->matricula->alumnos->user->nombres }}</td>
                                <td>{{ $pago->cronogramaPago->concepto }}</td>
                                <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                <td>S/ {{ number_format($pago->monto_pagado, 2) }}</td>
                                <td>
                                    <a href="{{ route('pagos.comprobante', $idCifrado) }}" class="btn btn-receipt"
                                        target="_blank">Ver Comprobante</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 2rem;">Aún no has realizado ningún
                                    pago.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

{{-- @push('styles')
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>
@endpush --}}

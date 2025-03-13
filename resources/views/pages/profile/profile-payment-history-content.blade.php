<div id="container-payments">
    <div class="table-responsive">
        <table class="table table-hover align-middle ">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>ID</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($payment_history as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <div><strong>{{ $item['paquete']['titulo'] }}</strong></div>
                                    <small>ID: {{ $item['uuid'] ? $item['uuid'] : '--' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($item['created_at'])->format('d/m/y') }}</div>
                            <small>{{ \Carbon\Carbon::parse($item['created_at'])->format('H:i') }}</small>
                        </td>
                        <td>
                            {{ $item['uuid'] ? $item['uuid'] : '--' }}
                        </td>
                        <td>
                            {{ isset($item['importe']) ? \App\Helpers\Helpers::formatear_presupuesto($item['importe']) . ' €' : '--' }}
                        </td>
                        <td>
                            <span
                                class="badge bg-{{ $item['estado'] ? 'success' : 'danger' }}">{{ $item['estado'] ? 'Éxito' : 'Fallida' }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay transacciones</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

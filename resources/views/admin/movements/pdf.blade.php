<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalle de Movimiento</title>
    <style>
        /* Base */
        :root {
            --text: #111827;
            --muted: #6b7280;
            --line: #e5e7eb;
            --head: #f3f4f6;
            --zebra: #fbfbfd;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue",
                Arial, "Noto Sans", "Liberation Sans", "DejaVu Sans", sans-serif;
            font-size: 12px;
            line-height: 1.45;
            color: var(--text);
            margin: 10px;
        }

        /* Título */
        .title {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: .2px;
            margin: 0 0 8px 0;
        }

        /* Secciones */
        .section {
            margin-top: 12px;
        }

        /* Línea de metadatos (tu mismo <div>) */
        body>div:nth-of-type(2) {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 6px 16px;
            padding: 10px 12px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fafafa;
        }

        body>div:nth-of-type(2) strong {
            color: var(--muted);
            font-weight: 600;
            margin-right: 4px;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid var(--line);
            border-radius: 8px;
            overflow: hidden;
            /* para que se vea el borde redondeado en thead */
            font-variant-numeric: tabular-nums;
        }

        thead th {
            background: var(--head);
            color: #374151;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-size: 11px;
            padding: 8px 10px;
            text-align: left;
            border-bottom: 1px solid var(--line);
        }

        tbody td {
            padding: 8px 10px;
            border-top: 1px solid var(--line);
            vertical-align: top;
        }

        tbody tr:nth-child(even) {
            background: var(--zebra);
        }

        /* Alineaciones por columna (sin cambiar tu HTML) */
        /* 1a col: índice -> centrado y angosta */
        thead th:nth-child(1),
        tbody td:nth-child(1) {
            width: 44px;
            text-align: center;
        }

        /* Cantidad, Precio, Subtotal -> derecha */
        thead th:nth-child(3),
        thead th:nth-child(4),
        thead th:nth-child(5),
        tbody td:nth-child(3),
        tbody td:nth-child(4),
        tbody td:nth-child(5) {
            text-align: right;
            white-space: nowrap;
        }

        /* Total final */
        .section[style*="text-align: right"] {
            margin-top: 10px;
            padding: 8px 12px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fafafa;
            font-weight: 700;
        }

        /* Impresión */
        @media print {
            body {
                margin: 0;
            }

            a,
            a:visited {
                color: inherit;
                text-decoration: none;
            }
        }
    </style>
</head>

<body>

    <div class="title">
        Detalle de Movimiento ${{ $model->serie }} - {{ str_pad($model->correlative, 4, '0', STR_PAD_LEFT) }}
    </div>
    <div>
        <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($model->created_at)->format('d/m/Y') }}
        <strong>Tipo de movimiento:</strong> {{ $model->type == 1 ? 'Ingreso' : 'Salida' }}
        <strong>Almacén:</strong> {{ $model->warehouse->name ?? '_' }}
        <strong>Motivo:</strong> {{ $model->reason->name ?? '_' }}
        <strong>Observación:</strong> {{ $model->observation ?? '_' }}
    </div>
    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($model->products as $i => $product)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>COP {{ number_format($product->pivot->price, 2) }}</td>
                        <td>COP {{ number_format($product->pivot->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section" style="text-align: right;">
        <strong>Total:</strong> COP {{ number_format($model->total, 2) }}
    </div>
</body>

</html>

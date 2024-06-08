<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Карточки товаров</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .description {
            margin-bottom: 10px;
            padding: 15px;
            background-color: #3493d2;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 4, 0.1);
            font-size: 16px;
            color: #fff;
        }
        .description p {
            font-size: 16px;
            color: #fff;
        }
        .status-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 2, 0.3);
            margin-bottom: 10px;
            overflow: hidden;
        }
        .status-title {
            font-size: 18px;
            margin: 0;
            padding: 15px 20px;
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .status-title::after {
            font-size: 18px;
            margin-left: 10px;
        }
        .container {
            display: none; /* Initially hidden */
            padding: 20px;
        }
        .status-container:not(.collapsed) .container {
            display: flex; /* Show when not collapsed */
            flex-wrap: wrap;
            gap: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-radius: 10px;
            overflow: hidden; /* Это необходимо, чтобы закругление углов было видно */
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }
        .card h2 {
            margin: 0 0 10px;
            flex-shrink: 0;
        }
        .card p {
            margin: 0 0 10px;
            flex-grow: 1;
        }
        .status {
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            color: #fff;
            margin-top: auto;
        }
        .status.ready-for-shipment { background-color: #3498db; }
        .status.delivered { background-color: #2ecc71; }
        .status.under-review { background-color: #f1c40f; }
        .status.shipped { background-color: #8e44ad; }
        .status.preparing-warehouse { background-color: #34495e; }
        .status.reserve { background-color: #95a5a6; }
        .status.assembly-warehouse { background-color: #16a085; }
        .status.in-transit { background-color: #2980b9; }

        .icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 10px;
            vertical-align: middle;
        }
        .icon.ready-for-shipment {
            background: url('https://img.icons8.com/color/48/000000/box--v1.png') no-repeat center center;
            background-size: cover;
        }
        .icon.delivered {
            background: url('https://img.icons8.com/color/48/000000/delivery--v2.png') no-repeat center center;
            background-size: cover;
        }
        .icon.under-review {
            background: url('https://img.icons8.com/color/48/000000/search--v1.png') no-repeat center center;
            background-size: cover;
        }
        .icon.shipped {
            background: url('https://img.icons8.com/color/48/000000/shipped.png') no-repeat center center;
            background-size: cover;
        }
        .icon.preparing-warehouse {
            background: url('https://img.icons8.com/color/48/000000/warehouse.png') no-repeat center center;
            background-size: cover;
        }
        .icon.reserve {
            background: url('https://img.icons8.com/color/48/000000/save-close.png') no-repeat center center;
            background-size: cover;
        }
        .icon.assembly-warehouse {
            background: url('https://img.icons8.com/color/48/000000/toolbox.png') no-repeat center center;
            background-size: cover;
        }
        .icon.in-transit {
            background: url('https://img.icons8.com/color/48/000000/in-transit.png') no-repeat center center;
            background-size: cover;
        }
        .call {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 10px;
        }
        .call div {
            position: relative;
            display: flex;
            align-items: center;
        }
        .call button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .call .driver button {
            background-color: #3498db;
        }
        .call .manager button {
            background-color: #e74c3c;
        }
        .call .icon-driver {
            background: url('https://img.icons8.com/ios-filled/50/000000/driver.png') no-repeat center center;
            background-size: cover;
            width: 24px;
            height: 24px;
        }
        .call .icon-manager {
            background: url('https://img.icons8.com/ios-filled/50/000000/manager.png') no-repeat center center;
            background-size: cover;
            width: 24px;
            height: 24px;
        }
        @media (max-width: 768px) {
            .status-container .container {
                display: block;
            }
            .status-title {
                font-size: 16px;
                padding: 10px;
            }
            table {
                display: none; /* Hide table on mobile */
            }
        }
        /* Desktop styles */
        @media (min-width: 769px) {
            .tabs {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }
            .status-container {
                flex: 1 1 calc(25% - 10px); /* Adjust width as necessary */
                display: flex;
                flex-direction: column;
            }
            .status-container .container {
                display: none;
            }
            .active .container {
                display: block;
                width: 100%;
            }
            .content-container {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
<div class="content-container">
    @php
        $firstItem = $order->first();
    @endphp

    @if ($firstItem)
        <div class="description">
            <h2>Статус вашего заказа</h2>
            <hr/>
            <p><b>Номер заказа: </b> {{ $firstItem->number_order }}</p>
            <p><b>Адрес доставки: </b> г.Алматы, Абылай хана 135</p>
            <p><b>Дата заказа:</b> {{ $firstItem->date_events }}</p>
            <p><b>Дата доставки товара (в пути):</b> {{ $firstItem->date_events }}</p>
        </div>
    @endif

    @php
        $statuses = [
            'Готов к отгрузке' => 'ready-for-shipment',
            'Доставлен' => 'delivered',
            'На рассмотрении' => 'under-review',
            'Отгружен' => 'shipped',
            'Подготовка на складе' => 'preparing-warehouse',
            'Резерв' => 'reserve',
            'Сборка на складе' => 'assembly-warehouse',
            'Товар в пути' => 'in-transit'
        ];
    @endphp

    @foreach ($statuses as $status_name => $status_class)
        @php
            $filtered_items = $order->filter(function ($item) use ($status_name) {
                return $item->state == $status_name;
            });
        @endphp

        @if ($filtered_items->isNotEmpty())
            <div class="status-container collapsed">
                <div class="status-title" onclick="toggleContainer(this, '{{ $status_name }}')">
                    {{ $status_name }} ({{ $filtered_items->count() }})
                </div>
                <div class="container">
                    <table>
                        <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Количество</th>
                            <th>Период</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($filtered_items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->count }}</td>
                                <td><span class="icon {{ $status_class }}"></span>{{ $item->period }}</td>
                                <td><div class="status {{ $status_class }}">{{ $status_name }}</div></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="status-container collapsed">
                <div class="status-title">
                    {{ $status_name }} (0)
                </div>
            </div>
        @endif
    @endforeach

    <div class="call">
        <div class="driver">
            <button type="button" onclick="call(87778441757)">
                <span class="icon-driver"></span>
                Связаться с Водителем
            </button>
        </div>
        <div class="manager">
            <button type="button" onclick="call(87778441757)">
                <span class="icon-manager"></span>
                Связаться с Менеджером
            </button>
        </div>
    </div>
</div>

<script>
    function toggleContainer(element, statusName) {
        const container = element.parentElement;
        container.classList.toggle('collapsed');
        const isMobile = window.innerWidth <= 768;

        if (isMobile) {
            const rows = container.querySelectorAll('table tbody tr');
            let alertContent = statusName + ':\n\n';

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                alertContent += `Товар: ${cells[0].innerText}\nКоличество: ${cells[1].innerText}\nПериод: ${cells[2].innerText}\nСтатус: ${cells[3].innerText}\n\n`;
            });

            alert(alertContent);
        }
    }

    function call(PhoneNumber) {
        window.location.href = 'tel://' + PhoneNumber;
    }
</script>
</body>
</html>

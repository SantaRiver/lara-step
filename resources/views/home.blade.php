@extends('layouts.app')

@section('content')
    <div class="container">
        {{--<div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>--}}

        <div class="row d-flex justify-content-between pb-5">
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-header">{{ __('Продано') }}</div>
                    <div class="card-body">
                        @foreach($countByType as $type)
                            <p>{{ Str::upper($type->ticket_type) . ': ' . $type->count }} </p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-header">{{ __('Кол-во билетов:') }}</div>
                    <div class="card-body">
                        <p>{{ 'Оформлено: ' . $total }}</p>
                        <p>{{ 'Куплено: ' . $totalPaid }}</p>
                        <p>{{ 'Не оплачено: ' . $total - $totalPaid }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-header">{{ __('Продано на сумму') }}</div>
                    <div class="card-body">
                        <p>{{ $totalCost . '₽'}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-header">{{ __('Место для информации') }}</div>
                    <div class="card-body">
                        {{ __('Например, статистика на сегодня') }}
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="row">
            <div class="col">
                <p>Фильтры</p>
            </div>
        </div>--}}
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col" class="sort-param" data-field="id">
                            #
                            @if ($sortBy == 'id')
                                {{ ($sortDir == 'asc') ? ' ▲ ' : ' ▼ ' }}
                            @endif
                        </th>
                        <th scope="col" class="sort-param" data-field="ticket_type">
                            Тип билета
                            @if ($sortBy == 'ticket_type')
                                {{ ($sortDir == 'asc') ? ' ▲ ' : ' ▼ ' }}
                            @endif
                        </th>
                        <th scope="col">Цена</th>
                        <th scope="col">Email</th>
                        <th scope="col">Номер телефона</th>
                        <th scope="col" class="sort-param" data-field="isPaid">
                            Оплачено
                            @if ($sortBy == 'isPaid')
                                {{ ($sortDir == 'asc') ? ' ▲ ' : ' ▼ ' }}
                            @endif
                        </th>
                        <th scope="col" class="sort-param" data-field="created_at">
                            Дата
                            @if ($sortBy == 'created_at')
                                {{ ($sortDir == 'asc') ? ' ▲ ' : ' ▼ ' }}
                            @endif
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <th scope="row">{{ $order->id }}</th>
                            <td>{{ Str::upper($order->ticket_type) }}</td>
                            <td>{{ $ticketDict[$order->ticket_type]['price'] . '₽' }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ ($order->isPaid) ? 'Да' : 'Нет' }}</td>
                            <td>{{ $order->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row justify-content-end">
            {{ $orders->links('vendor.pagination.bootstrap-5', ['items' => $items]) }}
        </div>
    </div>
    <script>

        let sortParams = document.getElementsByClassName('sort-param');
        for (let i = 0; i < sortParams.length; i++) {
            let sortParam = sortParams[i];
            sortParam.onclick = function () {
                let searchParams = new URLSearchParams(window.location.search);
                let sortDir = searchParams.get("sortDir")
                let sortBy = searchParams.get("sortBy")
                searchParams.set("sortDir", (sortDir === 'desc' || sortBy !== this.dataset.field) ? 'asc' : 'desc')
                searchParams.set("sortBy", this.dataset.field)
                window.location.search = searchParams.toString();
            }
        }
    </script>
    <style>
        .sort-param {
            cursor: pointer;
        }
    </style>
@endsection

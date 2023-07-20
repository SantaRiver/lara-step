<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(Request $request): Renderable
    {
        $items = $request->items ?? 10;
        $sortBy = $request->sortBy ?? 'id';
        $sortDir = $request->sortDir ?? 'desc';

        $ticketDict = [
            'flex' => ['rus' => 'Флекс', 'price' => 3000],
            'basik' => ['rus' => 'Басик', 'price' => 3000],
            'double-kill' => ['rus' => 'Дабл-килл', 'price' => 5500],
            'rampage' => ['rus' => 'Рампейдж', 'price' => 10000],
        ];

        $orders = Order::query()->orderBy($sortBy, $sortDir)->paginate($items);

        $totalCost = 0;
        Order::query()->where('isPaid', '=', true)->each(function (Order $order) use (&$totalCost, $ticketDict) {
            $totalCost += $ticketDict[$order->ticket_type]['price'];
        });

        $total = Order::query()->count();
        $totalPaid = Order::query()->where('isPaid', '=', 'true')->count();
        $countByType = Order::query()
            ->select(DB::raw("ticket_type, count(*)"))
            ->groupBy('ticket_type')
            ->get();

        return view('home', [
            'orders' => $orders,
            'total' => $total,
            'totalPaid' => $totalPaid,
            'countByType' => $countByType,
            'ticketDict' => $ticketDict,
            'totalCost' => $totalCost,
            'items' => $items,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $currentMonth = $request->get('month', now()->format('Y-m'));
        $startDate = Carbon::parse($currentMonth)->startOfMonth();
        $endDate = Carbon::parse($currentMonth)->endOfMonth();

        // Overview Statistics
        $stats = [
            'total_clients' => Client::count(),
            'active_clients' => Client::where('status', 'Active')->count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'Active')->count(),
            'new_clients_this_month' => Client::whereBetween('created_at', [$startDate, $endDate])->count(),
            'new_products_this_month' => Product::whereBetween('created_at', [$startDate, $endDate])->count(),
        ];

        // New clients in selected month
        $newClients = Client::whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->limit(10)
            ->get();

        // Products created in selected month (new services)
        $newProducts = Product::with('client')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->limit(10)
            ->get();

        // Products with next_due_date in selected month (renewals)
        $renewalProducts = Product::with('client')
            ->where('status', 'Active')
            ->whereBetween('next_due_date', [$startDate, $endDate])
            ->orderBy('next_due_date')
            ->limit(10)
            ->get();

        // Cancelled/Terminated products in selected month
        $cancelledProducts = Product::with('client')
            ->whereIn('status', ['Cancelled', 'Terminated'])
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->latest('updated_at')
            ->limit(10)
            ->get();

        // Revenue statistics
        $revenueStats = [
            'total_invoices' => Invoice::whereBetween('created_at', [$startDate, $endDate])->count(),
            'paid_invoices' => Invoice::where('status', 'Paid')->whereBetween('date', [$startDate, $endDate])->count(),
            'unpaid_invoices' => Invoice::where('status', 'Unpaid')->whereBetween('duedate', [$startDate, $endDate])->count(),
            'total_revenue' => Invoice::where('status', 'Paid')->whereBetween('updated_at', [$startDate, $endDate])->sum('total'),
        ];

        // Product status distribution
        $productStatusStats = Product::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Product type distribution
        $productTypeStats = Product::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        // Monthly trend (last 6 months)
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $monthlyTrend[] = [
                'month' => $month->format('M Y'),
                'new_clients' => Client::whereBetween('created_at', [$monthStart, $monthEnd])->count(),
                'new_products' => Product::whereBetween('created_at', [$monthStart, $monthEnd])->count(),
                'active_products' => Product::where('status', 'Active')->whereBetween('created_at', [$monthStart, $monthEnd])->count(),
            ];
        }

        return view('reports.index', compact(
            'stats',
            'newClients',
            'newProducts',
            'renewalProducts',
            'cancelledProducts',
            'revenueStats',
            'productStatusStats',
            'productTypeStats',
            'monthlyTrend',
            'currentMonth'
        ));
    }
}

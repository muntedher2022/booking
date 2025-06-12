<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\Report;
use App\Models\Incomingbooks\Incomingbooks;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('content.reports.index');
    }

    public function generateReport(Request $request)
    {
        $source = $request->source;
        $filters = $request->filters;
        $columns = $request->columns;

        switch($source) {
            case 'incomingbooks':
                $query = Incomingbooks::query();

                // تطبيق الفلاتر
                if (!empty($filters['book_type'])) {
                    $query->where('book_type', $filters['book_type']);
                }
                if (!empty($filters['date_from'])) {
                    $query->where('book_date', '>=', $filters['date_from']);
                }
                if (!empty($filters['date_to'])) {
                    $query->where('book_date', '<=', $filters['date_to']);
                }
                // ... المزيد من الفلاتر

                // تحديد الأعمدة المطلوبة
                $data = $query->get($columns);
                break;

            // يمكن إضافة المزيد من المصادر هنا
        }

        return response()->json($data);
    }
}

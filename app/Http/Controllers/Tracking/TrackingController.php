<?php
namespace App\Http\Controllers\Tracking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class TrackingController extends Controller
{
    public function index()
    {
        return view('content.Tracking.index');
    }

    public function TrackinShow($id)
    {
        return view('content.Tracking.show', [
            'id' => $id
        ]);
    }
}

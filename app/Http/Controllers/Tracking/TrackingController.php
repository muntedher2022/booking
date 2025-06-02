<?php
namespace App\Http\Controllers\Tracking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class TrackingController extends Controller
{
    public function index()
    {
        Return View('content.Tracking.index'); 
    }

    public function TrackinShow($id)
    {
        Return View('content.Tracking.show', [
            'id' => $id
        ]);
    }
}

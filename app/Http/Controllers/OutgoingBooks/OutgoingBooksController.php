<?php
namespace App\Http\Controllers\Outgoingbooks;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class OutgoingbooksController extends Controller
{
    public function index()
    {
        Return View('content.Outgoingbooks.index'); 
    }
}

<?php
namespace App\Http\Controllers\Incomingbooks;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class IncomingbooksController extends Controller
{
    public function index()
    {
        Return View('content.Incomingbooks.index'); 
    }
}

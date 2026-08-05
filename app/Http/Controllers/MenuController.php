<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Canteen $canteen)
    {
        $menus = $canteen->menus()->where('status', 'available')->get();
        return view('customer.menus.index', compact('canteen', 'menus'));
    }
}

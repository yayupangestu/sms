<?php
namespace App\Http\Controllers;
use App\Models\StrStokAtk;
use App\Models\StrStokRtk;
use App\Models\StrStokConsum;
use App\Models\StrStokCuptip;
use App\Models\StrStokGas;
use App\Models\StrStokTi;
use App\Models\Departement;
use App\Models\StrBarang;
use App\Models\StrOut5;
use App\Models\StrCategory;
use App\Models\StrUom;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\ItemsOut3Export;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class UserStrLineBecakController extends Controller
{
    public function index()
    {
        $title          = 'Item Out Store Room';
        $departements   = Departement::all();
        $users          = User::all();
        $str_uoms       = StrUom::all();
    
        // 🔍 Menampilkan hanya barang dengan category bernilai 12
        $str_barangs = DB::table('str_barangs as a')
            ->select('a.id', 'a.name', 'b.name as category', 'a.item_code')
            ->leftJoin('str_categories as b', 'b.id', '=', 'a.category')
            ->where('a.category', '=', 12)
            ->get();
    
        Alert::info('NOTE:', 'Penukaran Barang Harap Membawa Bekasnya');
    
        return view('userspbstr.linebecak', compact('title', 'departements', 'str_uoms', 'str_barangs', 'users'));
    }
}

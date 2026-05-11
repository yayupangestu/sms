<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Str2StokAtk;
use App\Models\Str2StokRtk;
use App\Models\Str2StokConsum;
use App\Models\Str2StokCuptip;
use App\Models\Str2StokGas;
use App\Models\Str2StokTi;
use App\Models\Departement;
use App\Models\StrBarang;
use App\Models\Str2Out2;
use App\Models\StrCategory;
use App\Models\StrUom;
use App\Models\User;
use App\Exports\ItemsOut2ExportStr2;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class UserStr2LineCController extends Controller
{
    public function index()
    {
        $title = 'Item Out Store Room ';
        $departements = Departement::all();
        $users = User::all();
        $str_uoms = StrUom::all();
    
        // Menampilkan hanya barang dengan item_code yang mengandung "STMP"
        $str_barangs = DB::table('str_barangs as a')
            ->select('a.id', 'a.name', 'b.name as category', 'a.item_code')
            ->join('str_categories as b', 'b.id', '=', 'a.category', 'left')
            ->where('a.item_code', 'like', 'STMP%') // Filter berdasarkan item_code "STMP"
            ->get();
    
        Alert::info('NOTE:', 'Penukaran Barang Harap Membawa Bekasnya',);
    
        return view('userspbstr2.linec', compact('title', 'departements', 'str_uoms', 'str_barangs', 'users'));
    }
}

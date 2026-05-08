<?php

namespace App\Http\Controllers;
use App\Models\StrCategory;
use Illuminate\Http\Request;
use DataTables;

class StrCategoryController extends Controller
{
    public function index()
    {
        $title = 'List Item Category';
        return view('store.category', compact('title'));
    }

    public function list()
    {
        $query = StrCategory::all();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $category = new StrCategory;
        $category->name = $request->nama;
        $category->description = $request->description;
        $category->createdby = auth()->user()->id;
        $query = $category->save();
        if ($query) {
            return response()->json([
                'success' => true,
                'msg' => 'Insert success.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Insert failed.'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $cek = StrCategory::where('id', $request->id)->count();
        if ($cek > 0) {
            $row = StrCategory::where('id', $request->id)->first();
            return response()->json([
                'success' => true,
                'id' => $row->id,
                'name' => $row->name,
                'description' => $row->description
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Data Not found.'
            ]);
        }
    }

    public function update(Request $request)
    {
        $data['name'] = $request->nama;
        $data['description'] = $request->description;
        $data['updateby'] = auth()->user()->id;
        $query = StrCategory::where('id', $request->id)->update($data);
        if ($query) {
            return response()->json([
                'success' => true,
                'msg' => 'Update success.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Update failed.'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $query = StrCategory::where('id', $request->id)->delete();
        if ($query) {
            return response()->json([
                'success' => true,
                'msg' => 'Delete success.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Delete failed.'
            ]);
        }
    }
}

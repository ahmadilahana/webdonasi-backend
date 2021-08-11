<?php

namespace App\Http\Controllers;

use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonaturController extends Controller
{
    public function index()
    {
        $donatur = Donatur::all();

        if ($donatur->isEmpty()) {
            return $this->sendResponse('error', 'Data Tidak Ada', null, 404);
        }

        return $this->sendResponse('success', 'Data Berhasil Diambil', $donatur, 200);
    }

    public function get($id)
    {
        $donatur = Donatur::find($id);

        if (!$donatur) {
            return $this->sendResponse('error', 'Data Tidak Ada', null, 404);
        }

        return $this->sendResponse('success', 'Data Berhasil Diambil', $donatur, 200);
    }

    public function store(Request $request, Donatur $donatur)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string',
            'date'            => 'required|integer',
            'nominal'      => 'required|integer',
            'address'       => 'required|string',
        ]);

        if ($validator->fails()) {
            return response($validator->errors());
        }

        $donatur->name = $request->name;
        $donatur->date = $request->date;
        $donatur->nominal = $request->nominal;
        $donatur->address = $request->address;

        try {
            $donatur->save();

            return $this->sendResponse('success', 'Donatur Berhasil dibuat',  compact('donatur'), 200);
        } catch (\Throwable $th) {
            return $this->sendResponse('error', 'Donatur gagal dibuat', $th->getMessage(), 500);
        }
    }
    public function update(Request $request, Donatur $id)
    {
        if(!$id){
            return $this->sendRerspone('error', 'Data tidak ada', null, 404);
        };

        $validator = Validator::make($request->all(),[
            'name'       => 'string',
            'date'         => 'integer',
            'nominal'   => 'integer',
            'address'    => 'string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $data = $request->all();
        $result = array_filter($data);

        try {

            $donatur=tap($id)->update($data)->first();

            return $this->sendResponse('success', 'data berhasil diupdate', compact('donatur'), 200);
        } catch (\Throwable $th) {
            return $this->sendResponse('error', 'data gagal diupdate', $th->getMessage(), null, 404);
        }
    }
    public function destroy(donatur $donatur, $id)
    {
        $donatur = Donatur::where('id', $id)->first();

        if (!$donatur) {
            return $this->sendResponse('error', 'Data Tidak Ada', null, 404);
        }

        try {
           $donatur->delete();

            return $this->sendResponse('success', 'Data Donatur Berhasil dihapus', compact('donatur'), 200);
        } catch (\Throwable $th) {
           return $this->sendResponse('error', 'Data Donatur Gagal dihapus', $th->getMessage(), null, 404404);
        }
    }
}

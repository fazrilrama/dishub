<?php

namespace App\Http\Controllers\tables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PersonModel;
use App\Models\logSended;

class Basic extends Controller
{
  public function index()
  {
    $person = PersonModel::get();
    return view('content.tables.tables-basic', compact('person'));
  }

  public function delete(Request $request) {
    $person = PersonModel::where('id', $request->id)->first();
    $person->delete();
    return response()->json([
      'status' => true,
      'message' => 'SUCCESS_DELETE',
      'data' => $person
    ]);
  }

  public function store(Request $request) {
    $data = $request->all();
    $personAdd = PersonModel::create($data);

    return response()->json([
      'status' => true,
      'message' => 'SUCCESS_CREATED',
      'data' => $personAdd
    ]);
  }

  public function editStatus(Request $request) {
    $data = $request->all();

    $person = PersonModel::where('id', $data['id'])->first();
    $person->status = $data['status'];
    $person->save();

    return response()->json([
      'status' => true,
      'message' => 'SUCCESS_EDITED',
      'data' => $person
    ]);
  }

  public function log_message(Request $request) {
    $data = $request->all();
    $log = logSended::where('person_id', $data['id'])->get();

    return response()->json([
      'status' => true,
      'message' => 'SUCCESS_GET',
      'data' => $log
    ]);
  }
}

<?php
namespace App\Http\Controllers;
use App\Models\usermodel;
use Illuminate\Http\Request;
class usercontroller extends Controller
{
  public function insert(Request $request)
  { 
    $data = usermodel::create([
        'name' => $request->name, 
        'email' => $request->email
    ]);
   return response()->json(true);
  }
  public function delete($id)
  {
    $data = usermodel::where('id',$id)->delete();
    return response()->json(['success' => true]);
  }   
  function display()
  {
     $user = usermodel::all();
    return response()->json($user); 
  }
  function edit($id)
  {
    $user = usermodel::findOrFail($id);
    return response()->json($user);
  }
  public function update(Request $request,$id)
  {
    $data = usermodel::where('id',$id)->update([
        'name' => $request ->name, 
        'email' => $request->email
    ]);
   return response()->json(true);
  } 
}

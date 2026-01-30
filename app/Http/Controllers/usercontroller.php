<?php
namespace App\Http\Controllers;
use App\Models\usermodel;
use Illuminate\Http\Request;
class usercontroller extends Controller
{
  public function index() {
    $data = usermodel::select("id","name","email")->get();
    return response()->json([
      "data" => $data
    ]);
  }
  public function insert(Request $request)
  { 
    $request->validate([
     'name' => 'required',
     'email' => 'required|email'
    ]);
    $user = usermodel::where('email',$request->email)->exists();
    if($user)
    { 
      return response()->json(['message' => 'record already exist']);
    }
    else
    {
    if($request->hasFile('image'));
    {
      $path = $request->file('image')->store('uploads','public'); 
    }
    $data = usermodel::create([
        'name' => $request->name, 
        'email' => $request->email,
        'image' => $path
    ]);
   return response()->json(true);
   }
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
    $request->validate([
      'edit_name' => "required",
      'edit_email' => "required|email"
    ]);
    $user =usermodel::where('email',$request->edit_email)->exists();
    if($user)
      {
        return response()->json(['success' => "1"]);
      }
      else
     {  
        $path = $request->file('edit_image')->store('uploads','public');
        $data = usermodel::where('id',$id)->update([
        'name' => $request ->edit_name, 
        'email' => $request->edit_email,
        'image' => $path
    ]);
   return response()->json(true);
   }
  } 
  function sagar(){
    return view('insert2');
  }
}

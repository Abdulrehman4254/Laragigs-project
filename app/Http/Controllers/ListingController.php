<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //Multiple listing
    public function index(){
    
        return view('Listings.index',[
            'listingsmain'=> Listing::latest()->filter(request(['tag','search']))->simplePaginate(2)
        ]);

    }

    //Single listing
    public function show(Listing $listingsmain){
        
        return view ('Listings.show',[
            'listingsmain'=> $listingsmain
        ]);
    }

    //create form
     public function create(){
       return view('Listings.create');
     }

     //store data

     public function store(Request $request){
     
       $formFields = $request->validate([
         'title' => 'required',
         'company' => ['required', Rule::Unique('listings','company')],
         'location' => 'required',
         'website' => 'required',
         'email' => ['required','email'],
         'tags' => 'required',
         'description' => 'required'
       ]);

       if($request->hasFile('logo')){
           $formFields['logo'] = $request->file('logo')->store('logos','public');
       }
       $formFields['user_id']=auth()->id();
       Listing::create($formFields);
    //    Session::flash('message','Listing created successfully');
       return redirect('/')->with('message','Listing created successfully');
    }


    //edit 

    public function edit(Listing $listingsmain){


        return view('Listings.edit',[
            'listingsmain'=> $listingsmain
        ]);
    }

    public function update(Request $request, Listing $listingsmain){
     

        //Make sure that the logged in user is the owner of the listing
        if($listingsmain->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }

        $formFields = $request->validate([
          'title' => 'required',
          'company' => ['required'],
          'location' => 'required',
          'website' => 'required',
          'email' => ['required','email'],
          'tags' => 'required',
          'description' => 'required'
        ]);
 
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

       
         
        $listingsmain->update($formFields);
     //    Session::flash('message','Listing created successfully');
        return back()->with('message','Listing updated successfully');
     }


     public function destroy(Listing $listingsmain){

         //Make sure that the logged in user is the owner of the listing
         if($listingsmain->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }
        
         $listingsmain->delete();
         return redirect('/')->with('message','Listing deleted successfully');
     }

   public function manage(){

    return view('Listings.manage',['listingsmain'=>auth()->user()->get()]);
       
   }

      
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use Auth;

class SectionController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:اضافة قسم', ['only' => ['create','store']]);
         $this->middleware('permission:تعديل قسم', ['only' => ['edit','update']]);
         $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        return view('sections.sections' , compact('sections'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sections = new Section;
            $sections->section_name = $request->section_name ;
            $sections->description = $request->description;
            $sections->created_by = (Auth::user()->name);
            $sections->save();

            session()->flash('add');
            return redirect('sections');
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $sections = Section::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description
        ]);

        $sections->save();
        session()->flash('update');

        return redirect('sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id ;
        $sections = Section::find($id)->delete();

        session()->flash('delete');

        return redirect('sections');
    }


}

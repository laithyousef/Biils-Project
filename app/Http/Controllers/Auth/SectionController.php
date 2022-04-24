<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use Auth;

class SectionController extends Controller
{

    // function __construct()
    // {
    //      $this->middleware('permission:اضافة قسم', ['only' => ['create','store']]);
    //      $this->middleware('permission:تعديل قسم', ['only' => ['edit','update']]);
    //      $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    // }

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
        $request->validate([
            'section_name' => "required|max:255|unique:sections",
            'description' => 'required|max:2000'
        ], [
            'section_name.unique' => 'هذا الاسم موجود مسبقا',
            'section_name.required' => 'يرجى إدخال اسم القسم',
            'description.required' => 'يرجى إدخال البيانات'
        ]);
            $sections->section_name = $request->section_name ;
            $sections->description = $request->description;
            $sections->created_by = (Auth::user()->name);
            $sections->save();

            return redirect()->route('sections.index')->with('Add' , 'تم إضافة القسم بنجاح');
           
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

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

        $request->validate([
            'section_name' => "required|max:255|unique:sections,section_name,$id",
            'description' => 'required|max:2000'
        ], [
                'section_name.unique' => 'هذا الاسم موجود مسبقا',
                'section_name.required' => 'يرجى إدخال اسم القسم',
                'description.required' => 'يرجى إدخال البيانات'

        ]);
        $sections = Section::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description
        ]);

        $sections->save();

        return redirect('sections')->with('edit' , 'تم التعديل بنجاح');
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

        return redirect('sections.sections')->with('delete' , 'تم حئف القسم بنجاح');
    }


}

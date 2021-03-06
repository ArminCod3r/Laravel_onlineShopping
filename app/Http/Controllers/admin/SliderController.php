<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Slider;
use App\Http\Requests\SliderRequest;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('id', 'desc')->paginate(4);
        return view('admin/slider/index')->with('sliders', $sliders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/slider/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        $slider = new Slider;

        if($request->hasFile('img'))
        {
            $fileName = time().'.'.$request->file('img')->getClientOriginalExtension();

            if($request->file('img')->move('upload', $fileName))
                $slider->img = $fileName;

        }

        $slider->title = $request->input('title');
        $slider->url = $request->input('url');

        $slider->save();

        return redirect('admin/slider');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('admin/slider/edit')->with('slider',$slider);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::find($id);

        if($request->hasFile('img'))
        {
            $fileName = time().'.'.$request->file('img')->getClientOriginalExtension();

            $path = 'upload/'.$slider->img;
            if(file_exists($path))
                unlink($path);
            
            if($request->file('img')->move('upload', $fileName))
                $slider->img = $fileName;

        }

        $slider->title = $request->input('title');
        $slider->url = $request->input('url');

        $slider->save();

        return redirect('admin/slider');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);

        $slider->delete();
        
        $path = 'upload/'.$slider->img;
        if(file_exists($path))
        {
            unlink($path);
        }

        return redirect()->back();;
    }
}

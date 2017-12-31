<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\File;

class DirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $walk = $request->get('o');
        $dir    = 'G:\My Drive'.$walk;
        $files = scandir($dir);

        echo $dir.'<br>';
        echo 'Size: '.sizeof($files).' files.';
    
        return view('dirs.index', ['files' => $files, 'walk' => $walk, 'dir' => $dir]);

        //print_r($files2);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data  = $request->all();
        $dir   = $data['dir'];
        $files = scandir($dir);
        $dept  = sizeof(explode("\\", $dir))-1;
        $prefix = $data['prefix'].'_';

        foreach ($files as $key => $val) {
            if($val != '.' && $val != '..') {
                
                $file = File::where(
                    ['name_raw' => $val],
                    ['dept'     => $dept],
                    ['dir'      => $dir])->first();
                if($file == null) {
                    $insert_result = File::create([
                        'name_raw' => $val,
                        'name_enc' => uniqid($prefix),
                        'dept'     => $dept,
                        'dir'      => $dir]);
                }

                echo $val.'<br>';
            }      
        }

        dd($data);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

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
    public function walk(Request $request)
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
                $type = filetype($dir.'\\'.$val);
                if($type != 'dir') {
                    $type = $this->mime_content_type($dir.'\\'.$val);
                }
                $file = File::where(
                    ['name_raw' => $val],
                    ['dept'     => $dept],
                    ['dir'      => $dir])->first();
                if($file == null) {
                    $insert_result = File::create([
                        'name_raw' => $val,
                        'name_enc' => uniqid($prefix),
                        'type'     => $type,
                        'dept'     => $dept,
                        'dir'      => $dir]);
                }

                echo $val.'<br>';
            }      
        }

        dd($data);
    }

    function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg3',
            'mp4' => 'video/mpeg4',
            'qt'  => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai'  => 'application/postscript',
            'eps' => 'application/postscript',
            'ps'  => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',

            'ds_store' => 'os/ds_store',
        );
        $filename_ref = array_slice(explode('.', $filename), -1)[0];
        $ext = strtolower($filename_ref);
        return $ext;;
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        } else {
            return 'unknown/'.$ext;
        }
    }

    public function encrypt(Request $request) {
        $files = File::where('encrypted', 0)->orderBy('dept', 'asc')->get();
        foreach ($files as $key => $val) {
            if($val->type == 'dir') {
                rename($val->dir.'\\'.$val->name_raw, $val->dir.'\\'.$val->name_enc);
            } else {
                rename($val->dir.'\\'.$val->name_raw, $val->dir.'\\'.$val->name_enc.'.'.$val->type);    
            }
            
            $file_result = File::where('id', $val->id)->update(['encrypted' => 1]);
            echo $val;
            echo '<br>';
        }
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\File;
use App\Directory;

class IndexController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = auth()->id();
        $directory = "/";
//        if(request('directory'))
//        {
//            $directory = request('directory');
//        }

        $dirId = Directory::where('name',$directory)->first()->id;
//        return $dirId;
        $files = Directory::where('id',$dirId)->first()->files;
        $subDirs = Directory::where('id',$dirId)->first()->directories;
        return view('welcome',compact(['directory','dirId','files','subDirs']));
    }

    public function changeDir($dir)
    {
        $id = auth()->id();
        $directory = $dir;
        $dirId = Directory::whereName($dir)->first()->id;
        $files = Directory::where('id',$dirId)->first()->files;
        $subDirs = Directory::where('id',$dirId)->first()->directories;
        return view('welcome',compact(['directory','dirId','files','subDirs']));
    }

    public function storeRoot()
    {
        $id = auth()->id();
        $path = 'public/'.$id.'/';
        $file = new File;
        $name = request()->file('fileName')->getClientOriginalName();
        $finalPath = request()->file('fileName')->store($path);
        $file->path = $finalPath;
        $file->user_id = $id;
        $file->directory_id = 1;
        $file->client_name = $name;
        $file->name = $finalPath;
        $file->save();
        return back();
    }

    public function store($directory)
    {
        $dirId = Directory::whereName($directory)->first()->id;
        $path = Directory::whereName($directory)->first()->path;
        $id = auth()->id();
//        $path = 'public/'.$id.'/'.$directory;
        $file = new File;
        $name = request()->file('fileName')->getClientOriginalName();
        $finalPath = request()->file('fileName')->store($path);
        $file->path = $finalPath;
        $file->user_id = $id;
        $file->directory_id = $dirId;
        $file->client_name = $name;
        $file->name = $finalPath;
        $file->save();
        return back();
    }

    public function createDir()
    {
        $parentId = request('parentDir');
        $name = request('dirName');
        $id = auth()->id();
        if($parentId == 1)
        {
            Storage::makeDirectory('public/'.$id.'/'.$name);
            $directory = new Directory;
            $directory->user_id = $id;
            $directory->parent = 1;
            $directory->name = $name;
            $directory->path = 'public/'.$id.'/'.$name;
            $directory->save();
            return back();
        }
        else
        {
            $parentPath = Directory::where('id',$parentId)->first()->path;
    //        return $parentPath;
            $directory = new Directory;
            $directory->user_id = $id;
            $directory->parent = $parentId;
            $directory->path = $parentPath.'/'.$name;
            $directory->name = $name;
            $directory->save();
            Storage::makeDirectory($parentPath.'/'.$name);
            return back();
        }
    }

    public function download($id)
    {
        $path = File::where('id',$id)->first()->path;
        return Storage::download($path);
    }

    public function delete()
    {
        $id = request('id');
        $path = File::whereId($id)->first()->path;
        // verifica id user logat cu id proprietar
        Storage::delete($path);
        File::whereId($id)->delete();
        return back();
    }


    public function deleteDir($dir)
    {
        $id = auth()->id();
        $directory = Directory::whereName($dir)->get()->where('user_id',$id)->first();
        Storage::deleteDirectory($directory->path);
        File::where('directory_id',$directory->id)->delete();
        $directory->delete();
        return redirect('/');
    }
}

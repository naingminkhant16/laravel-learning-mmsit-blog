<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //reading image
        $img = Image::make('https://kpopping.com/documents/9f/5/220324-JYP-Fans-Happy-Mina-Day-documents-3.jpeg?v=9834a');

        //resize
        $img->resize(500, null, fn ($constraint) => $constraint->aspectRatio());

        // $img->fit(600, 360); //fit

        // $img->brightness(35); //brightness

        // $img->rotate(-25); //rotate

        // $img->blur(30); //blur

        Storage::makeDirectory('public/500'); //make diretory in storage/app/public

        $img->save('storage/500/mn.png'); //save imgage to public/storage

        // return $img->response('png'); //response image

        return view('home');
    }

    public function test()
    {
        return view('test');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Textbook;
use App\Hashlink;
use Illuminate\Support\Facades\Redirect;

class TextbookController extends Controller
{
    //
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $textbook_types = Textbook::distinct('type')->orderBy('type', 'asc')->pluck('type');
        $textbooks = Textbook::orderBy('title', 'asc')->get();
        
        return view('textbook.index', compact('textbook_types', 'textbooks'));
    }


    public function textbooklink($hashlink)
    {
        $link = Hashlink::where('hashlink', $hashlink)->first();
        $link->click_time = $link->click_time + 1;
        $link->save();

        return Redirect::away($link->orilink);
    }
}

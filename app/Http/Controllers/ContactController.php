<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(Request $request){

        $contacts = Contact::select('contacts.*','conditions.name AS condition_name','designs.name AS design_name')
            ->where('contacts.status', 1)
            ->leftJoin('conditions', 'contacts.condition_id','=','conditions.id')
            ->leftJoin('designs', 'contacts.design_id','=','designs.id')
            ->orderBy('contacts.created_at', 'DESC')
            ->get();

        return view('index', compact('contacts'));
    }
}

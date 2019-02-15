<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use Validator;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $clients = Client::all();
        return View('clients.index', array('clients' => $clients));
    }
    
    public function show($id){
        $client = Client::find($id);
        return View('clients.show', array('client' => $client));
    }
    
    public function insertView(){
        return View('clients.create');
    }
    
    public function insert()
    {
        $v = Validator::make(request()->all(), [
            'nom_client'            => 'required',
            'email_client'          => 'required',
            'telefon_client'        => 'required',
            'direccio_client'       => 'required',
            'codi_postal_client'    => 'required',
            'ciutat_client'         => 'required',
            'pais_client'           => 'required',

        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            $client = new Client(request()->all());               

            try {
                $client->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el client.'));
            }

            return redirect()->route('indexClient')->with('success', 'Client creat correctament.');
        }
    }
    
    public function updateView($id) {
        $client = Client::find($id);

        return view('clients.create', array('client' => $client));
    }
    
    public function update($id) {
        $client = Client::find($id);
        if ($client) {
            $v = Validator::make(request()->all(), [
                'nom_client'            => 'required',
                'email_client'          => 'required',
                'telefon_client'        => 'required',
                'direccio_client'       => 'required',
                'codi_postal_client'    => 'required',
                'ciutat_client'         => 'required',
                'pais_client'           => 'required',
            ]);
    
            if ($v->fails()) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar les dades.'));
            } else {
                $client->fill(request()->all());
    
                try {
                    $client->save(); 
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar el client.'));
                }
    
                return redirect()->route('indexClient')->with('success', 'Client modificat correctament.');
            }
        }
    }
    
    public function delete(Request $request) {
        Client::where('id_client', $request["id"])->delete();
        return redirect()->route('indexClient');
    }
}

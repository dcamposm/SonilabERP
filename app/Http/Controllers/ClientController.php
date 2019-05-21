<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Http\Requests\ClientCreateRequest;

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
    
    public function insert(ClientCreateRequest $request)
    {
        $client = new Client(request()->all());               

        try {
            $client->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el client.'));
        }

        return redirect()->route('indexClient')->with('success', 'Client creat correctament.');
    }
    
    public function updateView($id) {
        $client = Client::find($id);

        return view('clients.create', array('client' => $client));
    }
    
    public function update(ClientCreateRequest $request, $id) {
        $client = Client::find($id);
        
        if ($client) {
            $client->fill(request()->all());

            try {
                $client->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar el client.'));
            }

            return redirect()->route('indexClient')->with('success', 'Client modificat correctament.');
        }
    }
    
    public function delete(Request $request) {
        Client::where('id_client', $request["id"])->delete();
        return redirect()->route('indexClient');
    }
}

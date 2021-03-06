<?php

namespace App\Http\Controllers;

use App\{Carrec,CarrecEmpleat,EmpleatExtern,Idioma,Tarifa,RegistreEntrada,ActorEstadillo,Calendar, CalendarCarrec};
use Illuminate\Http\Request;
use App\Http\Responsables\EmpleatExtern\{EmpleatExternIndex,EmpleatExternShow,EmpleatExternCreate,EmpleatExternUpdate};
use App\Http\Requests\EmpleatExternCreateRequest;

class EmpleatExternController extends Controller
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
    /*
        *funcio que retorna tots els empleats externs
    */
    public function index()
    {
        $empleats = EmpleatExtern::with(['carrec' => function($query){
                                        $query->orderBy('id_carrec');
                                    }])->get();
        
        return new EmpleatExternIndex($empleats);
    }
    /*
        *funcio que busca empleats externs per una opcio insertada
    */
    public function find()
    {
        if (request()->input("searchBy") == 'carrec'){  
            $empleats = EmpleatExtern::select('slb_empleats_externs.id_empleat', 
                                            'nom_empleat', 'cognom1_empleat', 
                                            'cognom2_empleat',
                                            'telefon_empleat', 
                                            'email_empleat')
                                        ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', 'slb_empleats_externs.id_empleat')
                                        ->distinct()->where('slb_carrecs_empleats.id_carrec', request()->input("search_term"))->get();
        } else {
            //Amb el whereRaw ens dona la posibilitat de poder fer consultes amb més opcions
            $empleats = EmpleatExtern::whereRaw('LOWER('. request()->input("searchBy").') like "%'. strtolower(request()->input("search_term")).'%"')
                        ->with('carrec')->get();     
        }

        return new EmpleatExternIndex($empleats);
    }
    
    public function show($id)
    {
        $empleat = EmpleatExtern::find($id);
        
        return new EmpleatExternShow($empleat);
    }

    public function insertView()
    {
        return new EmpleatExternCreate();
    }

    public function updateView($id)
    {
        // TODO: Controlar si l'empleat existeix o no per mostrar una página o un altre
        $empleat = EmpleatExtern::find($id);
        
        try {
            return new EmpleatExternUpdate($empleat);
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut mostrar la pàgina.'));
        } 
    }

    public function insert(EmpleatExternCreateRequest $request)
    {
        $empleat = new EmpleatExtern(request()->all());

        if ($_FILES["imatge_empleat"]["tmp_name"]!=""){
            $empleat['imatge_empleat'] = base64_encode(file_get_contents($_FILES["imatge_empleat"]["tmp_name"]));
        } else {
            $empleat['imatge_empleat'] = "iVBORw0KGgoAAAANSUhEUgAAAK0AAAC4CAYAAACRtGxrAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAAEnQAABJ0Ad5mH3gAACQ6SURBVHhe7d1ntyxHdcZxv1Ti6l5llHPOCYFQToiMjQkGG9tgewEmR7FAgEEkSQibJAQSCiCEJGSSP994/0Zni6JXzUzPnJ45p8+pF886c2e6u6p2/eupXdU9c//mwIEDk6amMalB2zQ6NWibRqcGbdPo1KBtGp0atE2jU4O2aXRq0DaNTg3aptGpQds0OjVom0anBm3T6NSgbRqdGrRNo1ODtml0atA2jU4N2qbRqUHbNDo1aJtGpwZt0+jUoG0anRq0TaNTg7ZpdGrQNo1ODdqm0alB2zQ6NWibRqcGbdPo1KBtGp0atCvo4MGDk2OOOWZy4oknTk455ZTJ6aefPjn77LMn55133uT888+fXHjhhZOLLrror+S9Cy64YHLuuedOjz3jjDOm57rGscceO73m0UcfXS2v6a/VoJ2jhPO4446bwnXyySdPTj311ClwCSkYL7nkkslll102ueKKKyZXXnnl5KqrrppcffXVU11zzTVTee19xzjWOWAGeULs2spQljKVDeQG81+rQTtDQOGAJ5100uTMM8+cwgm46667bvK6171ucvPNN09uvfXWqW677bapbr/99ld0xx13vKI777zzldflMc5x/k033TS95rXXXjstgyMrU9nANXhqddyvatBuCaSHDh2anHDCCdNpm/NxUo7IIV/zmtdMXv/6109Bu+uuuyZveMMbeuvee+99Rd33vL7nnnumYLu2MpSlTGWrA4A58PHHH/+K+9basF/UoA2BgJuZls8666zp9H3DDTdM3ZQ7gvTuu++eCmAJ3nbUhdh1SRnKAzE3vuWWWybXX3/9tE7gVUeDaz+Du6+hTWeVS55zzjlTZ5N/mqprjppQAdm0Duobb7xx8trXvnbqjuCSPpjmKfPZ/LfPHONY53BV11AWSJVXDoosT1nqJC9WR3VVZ867HwHet9DqaIsd7sXFwFe6aglPAuQzx8hByylcDgokKcVpp502TS9M569+9aun8tp7PstFnAXYpZdeOgUxXZ2zzio7AXYM4NXZ9YDboN3jSncFj8UVaBLYBCbF/UzP5SIJpIBLSHPFb9HkuiAyGCzi5J/+kvd85pjciQCdQWMbDPiurQxlKZPD5iBKgL3mzOm8diDUwzX3y7bZvoJWhwLHvqqtKe4GTIB2nQ0cPjedg6m7mh8KDtdJuTb4lKVMZQM361irpzpqC/fO/d5aOXtJ+wZaDsfZOBMnM8WDoXSxdFZT/+WXX/7K1pOp3fkJxVDAduXawFWWMi0K1UFdAKxuZd7rb6Yr2nTxxRdPB2QOrFoZe0F7HtoEwRQqhzStZhqQHe/fgOVaOh8oclGQrgvQPlK2dAbAUhJ1A24Oti686q+NUg/pyE7WfZ3a09DqNFO6/NMUarVuIaOTE9Z0qswPOWsCuxvcShvURZ3UTR3tSGhLmTbkItGgtECULnBs0NeuO2btWWh1lvwVsDqZC2UHZycD2CIsOxngu7WT03XlvBZu5SDMxVrZLp+DfC8u0PYktDqIM5nmAZtTagksiO2b2kGQ63IlacRu7lx1y8Wa3FXdtS8Xa8Clsn3uqDl+LznunoNW5wCQG+XiJWGlzP10duauzlkG1oOhQ6HjQieGTgmdHjrrwKsmZx/9qsm5Rx+YnFPR2aEz4rjTQq8OnRA6JuR6R4dqZdWU8Ko7KMFZLiy101+OK+0x2+QsspsHZV/tKWh1iM4Bo0VLd7uIA0kH7IVKBzjQsu4KMLCeHDo3AL0y9PrQPaF3HDxq8q7QP2zpvVt6T+jdB181eWfoTaHb49jrQxeHTg+QwWsQrAKu9koD7DAYjAZl2V6DFtQG8V5x3D0DbTosVwGsDtRpOWVyHW4EWFtJju0DK5AS0nMCsstDrw3dFfCB9B9DHw599uCRk/sPHTn5RujboW9t6YEtfePQUZOvhb4Y+kQc+8E4B+D3xnVujutdHbooxIm5d1/3la/aKdAmublB2U0VDN7cy9XusW+H7QlowZeLLh1Xbgul8tanrS+d3KfjQMMBz4hpn6NyyX8P0L4cEH7/mCMnPw09EXrqmCMmvw49F3p+hn67pWdDvwr9MvRY6Idx/jfjep8MceRbohwOfHyUqexavUppu7Zov7tz2qj9HDfbLhaZEmX7l5lddptGD63g6wQLEy7adZp0WNOnDuM0teuUOjbEWS8MeG4IveXooyb/GkDdF2A9EnoyYPtd6I+h/+voz6E/hXzWlfd9nsf69+9DgP9JiEt/IsqRUtwRZV4VZcuT+zgvcKULUgWuautLHHK28dpug31csdrpPejtaPTQSgtsvtu/zL3LBLbMYXWmTl3ksMCwsLosgHlbwPO5mM4fDpieCXHK/z3m8Mkf4m8CmALl7w8dMXkp9GK8TndNp30h3v9dCKQlwAm49533XDjvo6HvRHkGyi0B7/lRl1yw1eqcyhlHPLS5u6tgAIsHN5YLjzVNGDW0gs45LbwsNjxIkh2UuwTSBfneibEIqV2DgAqIhPXuEGC+EuAA6NlQCdlLod+EHo/3fxTHPBSSt341ctUvhYD+mfj3p7b06dDntz77WryW83LsR0NPB8igLgcCF5dCPBiffyrO+fuoy40Br4Wf/HoevGLCRaVKdg7MMum2/oqRXRULs7GCO1pouQrnlMfJ1fL514S2XDUvclgQSAkAC5CvBHScNVOAdEZ/Oemv4rMfh74a+kgc+57Idd8YuiV0/cEDsVg7MLkkZGFFl4RM9VKN2+MYDv7PIYu378U1fhF6PsRtlZPyb0D/ID77ZBzLdW2XqWutHSmxMUgNVjEo0wTKwWxhJja1a+xmjRZaaQFgpQVl/uavaZCbcGBT5azcjcNyLrsCt4aA9F8BiAUSN01YXwg9HeKOX45jPhJ6L1DjnJtCVv4XB6T2Z88InRKyD3vSlrw+Nd47M2SqNzheE7oj9I64zr/E9T4d4tbcV47LeZXvL9f9nxgsXPftAa5FoVlBylBrF4GRk4qP53WlCuJDmSbIb+31jg3cUUILQlOgh0jy8b2yQziJvI3bzNuXtDq34HpdQPCZgObRAEPO+ufQH7f0h5DdAbsF/xGuemdAdlHAZ3HE8RYtkGbJOXmD4qy43rVRB/u490U9pBwvHjp8Whd1+NNWPZ6N+n03PntHgMu97e/Wrp3SdosujznmAjXj5LXYyfX7bv/tFo0SWs7gSSaLDYDKX7Mz5HA59c1aIQPm+NB50fGm9Y8HjJzMdtTvAw76Xejn8R7346xvi+PAfUEAli63KrCpBNcA4MIclPu+L8r7bOiRKP83W3UB7YuhJ+K9r0ed/ik+vy6OdSdu1taYtgMSmPLb3ApLaIGcuypjym1HB62O4KCg9Nxr6RxkKsxFxiz3AJxNfFP7FwLYxwNWYHA1wD4feibeA4c7W6ZyYM2bjodQ5tYXBsC3hj4Wdftx1ENdXtqqG9llsKPxrhhIcmWOO2vwJLiZJmTuT/kNCM8wMIJZ8dptGh20HIEzcIic8khaYMuL+8pjZ7lsAvuGmGJt6P8wAMitLOBytofDzT4asL4lxP3O3Dpv3qp9CAFPGXJgzyq4U2bP1i7GY1Gn57agVdcn49/uuHHcK+I47l8DVwwAKU2Qw4oRtxUzf6VWYim3FbPu+btRo4I2O8ACi2vknS/K3QJ5rpsNtfMBcWpI/vjxWNT8bArsyyBwsl+FfhQw/Gd8dmMcY2Fl6t1OCrAdgZfrut1rp+JnUbcXoo6gpRci730g3jO4LO64dK2uBrr9W7sJ8lgOm+CSuC3aFtxNGhW0+XxB3qrM4BPX9XUTjxnWFl8606IHjPZgH4zO5qoWPPRsvP5evGcHwa1Ui6N50+4mxN2By0nfFPX6QoBrsfhc1PelkJmBA98f8hyEh2+0sXsdg11MzEA5Q4ldQitFEFNuPIYUYVTQcgtQWlQkrNICHcBBuIVjaosKCy+3RE23VuCm12lKEJ3/TOi/498fDYeVv+r8VVMBnT5LteMXKQfbeVGnd0bdvxx1fCzq+/wWtGaKJ+O17TALM1tuteuQ2JRf20m3tZi1PrAWELtV67opjQpaOwa5zZXQAlae5n47J+EotaDr9Ftj4fL5ANYW1m91eshfOwf/FkDYq7WKB8kqDqtcna4O0piUf28HBgPIQlAK8Nao51ejvo9v1d0sAWCzhBnEDYxZdVcXg94WmJgZ8BlD4FqsOaY26HeTRgVtPhRjOktoOQaIrYClDt1zdLi81HaVxwEtsuSvgP1NyHT7hXCp2+Jzi59ldghACEg5tLItZgwcYKirBaO/5EaIz+WNHC/h6AuydkhXgPuBaIdclsPKa7XlF/Fv23NuPkgpanfNlKeebvHmDQfgpnJvW9265+4mjQJaHUuCDVB7sRnofILLXmRt9avzdOI7ozM9I/BEdPCLhw6bdvYTB4+Y3BfAuivlia5lHFZ9dG4+hG1xqNPtEZt+LW5MuerrtZTGgJN3m4bBPSuVmaVcSEph7BpIaZ6dgnvYdABKeT4c7fHMr9u93fNzkBlEbn2LHZcVRwag7n2fhNtJjQZawQaGRQR3FWgBz31GqYNjuufq5Msjl3WD4KnoVJ1rOpXHPhQdbB/2mnBYYHfPrUldDA6w6mB1AiMwPbMLBPXjYurnL5l+1R3IAAavQVjC69q1MksZhLbszAxmiJ9EO7TJIKT74723xgC9ND6vDUBlcHwDTH3TbUGbuy8+7563mzQKaHMK1tG5ayDQAg4CNxp8XnOtiwPYN0cnfiU6E6zEnX4cAH/+0FHTr8q4lTvrrlIpHc5dTfVg5VY5iLJOpYDQfS9BBre6g8cCclb9uwKiFMaD4rbC7OE+vdUu0MrPPxdt9XANZ66By0nBqf5pACRlUB/t656zmzQKaIEi1xLQhMNf7mUqNt0Bu3QqnUW+GvOR6MSHIhXQqTr3qZCvxng6y4MuffZiAaUO3NXgUa7FjHpkfr2MtAEwQOHUUoacLfo4rulf2z4U4P50K03Qtsfj9fejrW+b5rYv7912zzVApDTKFcOE1gA0C2hjnzrslEYBrSCbRgU5AwwW0MjDfNYNMgjB6M7Xd6Ij7Wdabdvj9PqD4bIeI/T0VXleTemwHDG/FZCDZwgBB7zSnL55Lhhtzb0xoH0wILUo0zbwekb3AzFQPVvhKbPuudoiZgZfd32QM5c271Zwdx20ApXpAGfjPrnQkXNlgE2xOjofr+tex6KKG70roLVDwF11qs61g/D26Gy7BfZvu+d2ZTrlPpwesOWUOoRy1jBd+0q4Ni8CxtSvjW6WfDZmjVyUJbgfC2g58Zmh7rniK7ZSBO4qluqgXf4NZlDL21fZ6Vi3dhW0CaxACRpn4z52B0zHAiq4GWDvgVkHdK8lT7049KGA9tfhRDozt7ikBjdHasCtdH733K6kHwlsTu1ZjyHkeq4LXE63zCa/Bdf7YtbwcM+vtqClL8W/7el6CL17jmtbTHJUA18s1QO8OXjs2Voo2r4TX+A2aAsJIjezANBhRrpUQPB0Yvmr2QKbwZUaCCzIu9f0kIu9WY7z7MEANqRTpQqei70mPpu1UEnpKPUycHSuMhO0rMcQymuCRzsNUrDU2tWV2cIzvh7+MZtwWW19IAaqh8s9BdY9J83BDCa+ZVyJOXifKUiHzGZc2WzDfXca4B2HVuOlAtwMrBlE7pP3xkt3y8DKv7ifQDq/e90LorP8poDvZv364GEB7mGTp0P3RWdKDezLds/pKtMCi5Nu+euSMuzt5hRdq1epkwPayyI3d8PBDQYDU3sfCXB9nUeKUDtP3MU8973L8sU7Y6/dBhPjYCRMgvP2XTCuQzsGbY52+Rt3NaK5WQZQ8AQsYekCw5E4AEeq3VRw5+jd0ZH2LacdGfplyBNcNwXMHojpntMV5zcw1Ktb/jrF6eTvpu9FcEyfqYi2eC7BE2raqL0/CnmQxtbXrN0Rscttu7L8buy9x0iAawBLHQAv7jsB7o5BmymBacc0JCg1R50l0KYbma661786oPU8wQMBqRsJ9IsQR7o0nIlDdc9J6Qj14yp5w6BWh3WJs4mHtMQsAtxaPQmQbu+aVXx7184IaH8W+na8vivaa8FWy90NSilWLi5rdSH9kSCn63p+wQK4Fvt1a0egBYXcCBSCBsBu0Px7nriDTp0VOL+VJZ/9XqQDz8RUKd97NORXXDwne+IcaEECFou8zKVrdVi3uDywaulPKrf2/D6Yr6e7aaK9BuhD8fqN9mujrbVnKhJaENbKT3X7xSA2EzANbt130TiUNg6txoGsu+fZB9QUiJwHqlwYdMvxtNOnA9qHA9qnoxOfCP0wOvJvA9rTohO5T/eclGnPYOAmOwUs5UKztjvSla0vt3Uf2Rqkj4e8dkvXXnTtJgNo9QFol2mnvgKutCn3lufNBkNr49CWQHBLwUpgve6rhHaW04L2M1vQPhULk8eiE+3PvjmmUc8ZzHuaSyfI2azis6NqdViXskxpU84mtXqW0l4/bGdm0V7Q/iAGqTtj9qtrg7QLbR9l3TImBhYD6jOwhtLGoc20QIdw2DIAy6gvtG7fPhmd+Gj89fD3vfG+HNCU2j0npQMsgnToKnUbQsq1spci9NlFkA55wuvbCW0Am9D6xm4NWtfNBXCtDrOUfcZsnKuOBrlZdBNpwkah1SB7g2UeVQtKHy2C1uN70oPpLc5wHffn/T6W35GdtTBJGVjuTFkp18relAABKnljrZ6lfO/NLzpaeGqvnPaRHtDaxloW2pT+kyboCwtq/SC/7ZYztDYGrcZolMYBNhc4q0igXGMRtL6CAtpfRif+JKD1G1p3z1lNp0CrnjsNrTaqQ19o7ZZ8cwvanwew318CWjGt1aGPwMttbV/Wth+H1sagBZZpNxc3grQdLYI2F2IvQ3tYrKoPn37lui+0rg2YWtmbkjbaRzX11upZKqH9xlZ7E1oLsb7QrqIEV6zMTmLXLWdobQzavLskSNnQWhD6ahlonwBtuI+vqNwdnXjcgZdv4XbPSY0dWu315ce+0LoLWSu/r/Sla+Tt53XntRuD1tThTooFWK3hy2oRtJkeWE0/Hp34o4D2W/H6nujERb+yvZugXTY9AK32Phb6S3rwch7fPQe0QNsutJTPK2ziscaNQSvwQ4xqkg/3gdbPY37XoiQ68Afx92vRoX5he5n0QFm1OmxCy0DrwRjfG7s/2qi97og9/IrTLoZ2u+10PnClCPLadS7INgatXYP8HpUGbleLofUfchwx+Y5FSXTiQ/H3iwHxzfH+rHvxqS60OyW5Zl9oPWvh6zceCOKyPw1gH1oS2u0o4TWbWrvU+mQorR1a04RRl89uGo21Ri8r1+rjtF+PTvSbAG7per7UT2Ry2b0GrS872qt9+be/7EkfPnkQtPFvP+CxCWj99RDTolvP29Xaoc2tLtPGUMCSDrUtNQ9ad4i46xcPHTn9n2n853N+9KJ7bFcJbT4XsVPSRnXoA20+OHNDtPP9h17+T02AC1o/QFL7hsaQ0JL+dT0GZeHdLW8orR1a96Q1AAQ2obNx25VAz4PWd//fHx3o5zDvCflJ+b4/1wla1wZMrexNaRmnzQdnDMxro71/F7B62N1P6i9yWnfeauWvIjdDGNQ6b+uuHVpJee4cgLbW0FWU0AKsBq2fQbr7YEyZIV8APD7UPWaWElodUCt7U1oG2pTU55ho6xXR7rtCV8Rrv/1Qe2BmaGj1r/r2fV5iVa0dWrmNoLupYPGkYUOohLb2hJFvofrV7unUGOpucUlbnOdvd3umhLZW9qakjbPSA3Wu1Z/jAteTXedvATtrt6SEtlb+KrKv7JHFUUPriSk3FSToQ0Obd2Bq0GbndRdcuTBUL1NYbXtmt0ALplnPHmTaRdowKwap7me0LmgZlNm1VuYQWju0gurRNfemh4RWoOelB1TrLJ0LVl/xMY0JrvNLtxqD05rBbCN6Ys5fzlabNeYpobUVWSt/Fe0ZaK0mBWcd0M5aiHWlQx0nmPnYofzLLMCpxgatuKqjGYwhGITq3W3LPIHWubl/XqvDMnKNPQVtOu1QWhZa6YDOl29lJ7mlvAjabrmb1Lz0QFylRz7PBZuZwx5pX8ftQjuE9hy0gltr6CrqC610IPPqBDY3wkFrap0FrdvOtbI3pT7Q5rac4/ObDmDU5kXwltAO0TeusedyWo0aSgKt02ZBq7MIgPI+AJrCyu0ZAZ7ntM6plb0paWNfp9UmAxHo6p2DsbvILAUs/QL2btmriuOPfvcgoZV7ydFqDV1Fi6D1XgmssjlsAssZuFTt+/vOc+3dAq0pv2wbcVJ5rLWCtmlT3rhxrngDV/xnue06oFXf0e/TCq7gDQ2tQM+DNsEDZnZmwup8dUkXc/5uhVYdZkGbaRd3dby2Jbz+nQtNKVIN3HVAq75iJ4bd8obSRqAVOHnOUNC6ziJodYgyHacTdWaemzC4tSy43dyvhHbIgbas5jmtNstJ1dMxjlVX4OYABTOwZ6UJJbRDtNM1XK/v195X1caglecIooYNoUXQ6mjQZYekdC73da5O16Hdc0GbOW157qaV0NZyWoMswXWLXJvK+ILIvwGkD2o3HxJauX1Z7qpSXpmWdMsbSmuHNm/jCuwmodWZ8j0dolwCgU5yHqjVreZACW3eLaqVvwnNg5aAC0ifyyO1NR03z18ELcgyRmXZq8g1mJN1gjK75Q2ltUPLyQAkqIKYAG1XAr0IWh0ir3O8shN0UNbOSXWh3Smp7zxoCbiABEp3kDp/GWi3KzHOveJRP08LDvkNWIaG1up5GWi9tpOxaCtot0Fby2lLAVd75fCZJuT5m4ZW3BaZwna1dmjBARILAkEcClwALgOtsnOLSydT95zUboJWXr0IWhIHLgfyPB+M4r5JaA0SLlsrbyitHVpwAFdyDqAEd7taBlrHrwptt9xNCkzLQut454KoL7QZo+1KjM1kypoX3+1q7dCSBoCFCwhkrcHLahG02SFAdfyy0Epnxgxtnr8paLvx7ZY1pDYCLXE+K0vgauB2tQy0jteBy0Kbe5g7pVWhdS6QloG2W/ayElvX6lPX7Wpj0AIBZEOBIEgN2r+oCy2BcRG0uXgry11FZqX8dnS3nKG1MWgFDjD5KzPbVR9oyw4ZI7SgGwu0riOfXeedsNTGoAVWbn0BiGqN7yPnSjOsVBdBm+nIWKHlYKtCq72bgFZsuazrrXN/NrUxaO0ggMtoFFiBSnhX0TLQlucsA630oixz00porQdq9SyV0Do+z18G2rLcZaWe+mLR/vdQ2hi0BBSu0Q3uKkpoAdYHWoEdG7Rg4va7GVoxFSdxBey8uA6ljUJLHqTIB2iAtKqWgbY8Z1loyzI3rVWhdS6gFkHrnG6MlpEyxCjXFt3rr0sbhxZgclvACfCqAVsFWp1owCxyBPXTEc4vy9y01L0vtNprkduFVjoG2tq0vR1oXdt5cln120Qum9o4tGARwHwyKYO8rJaFVif6686c4+flXjmodgO0nKwvtGYv6wXnltDOepptO9Bm3Vx/U7lsauPQEnClCaZqI5WbCIIg1wJUk85ZBG12Ynld0+WsTkypG7jzOdWy3E3KgDaw+0y9wAZgQktiqh2zoCqh7dtOxzlebMXSNVx73sw1tHYEWtJQwQSujgGugPTVImgFM53c8Rl054CyluOlTKc5oLrlblKAkltrY62eKcBY4JaDn8RIOjRrZkloc2D3kesrp08c16UdgzbTBA0XcEFIeAVRcMoOKIPmLxidI/A1aHW0h15MYeV1vMeVDJjuOSnXc115bVnuppRligenNIhq9SRxBI5BlvDldcRIGjbLCUtoa+WnvOcYsTSQpQQZ9006bGrHoE1l0EHGFXSU4Ah4F958TYugzbw0n3dI9QFBJ0shdE557qbFZaU58wZYzljqKkZmE+eKHQMwQGeBJXaZQnXLLmFNYA14g2PWwm5T2nFoSVCBx3V1ksDIlzidkS2wglbKe+ADZ22KEtgcBGVnOHfRlKs+OoVLOd4AKa+xbiUouYiaNwXPmhXUWU4unrXzSAzEl9uWsSXvOR+oBr9Yupa4qs9OOGxqV0CbSlgSYC4hWAAGmgCSQPu3tGLWoor7ON9xXSB0iA5YFHgwKEsnltdYtwCnTO1Tx3n1LAdnCa3zxWre4BRjA0OMtJMyxt7zGQMRh0WL101qV0FLCa7RDDydIrgcVQek/DtdqNap3nce4NO5SKeCQmcsysmUzW11YnmNdQpwZhHupp3z6keOUb9yYLkOiEEnBrXzKGPUjS15z2diLE76ZFFdNqVdB+1QSsfmQiAlnZk5H5hnpRYpn+k0aQgocpG4LmU9TfVmAmXX6kU5uM0m6ta9VjkT1c4fs/YstDqVdGrmxIBIN5Kv9VmZAwNAnC/vOK1L6sghcxZQdq1e5DN11waQmkH8zWuly84blGPVnoU2ZarjXAmcjgWt1wCRrwFg3tTHrcAPXPkwx004hpDrAVZOmYvLWj1KSZ2kLs7JXLa8FvABO69dY9Weh5YbmSZNlwlJOpPX0gfHLHI1zpfgdh0XKKvK+QYC+NSljzsC0WA06JyfeWx5rT4LzbFqz0MLNiCYLjlQpgmg1dk6mGNxrnmd7DNwA1c+DJh03VWkHs43AMwEnJHDLnL9TAsyV5ejl2lBurU2187fC9rz0AKAcwETIAlapgng9T7nmue2lI4LLtfj3pkvJ4glmLOUwALMYOKKBs2i8slxgFXnvDUNVtf110ygfupZO38vaM9DS8AFJUA4ZMIDXE9D+auz5beL8kCfpXtLO1yTU9p2cm0wARmUpbznM6CCnVuXe6DzyiSfA5bTK0edc7YAqzK8bzCpX58BMFbtC2gpHRKcnI50to7PKRZMi/JbAhABHHAGBFgSYGAmwOQ1qJXNJTmrchKuRcCSspynjursu1kJrAGoDOWrS5/rjVn7Blpw5Ipbx4Mp3RYEHNe/OWAfx03ldTkvYIDFgZVTikO6roED9L7Xd4zjXRf4IC3Tgkw1cqZQl9p19pL2DbQEAHCBKO8i6XCdn98sBTCogbLMFOvafVU7f5bUIYE1sPzurDoaYOov7cjFZN+BMHbtK2gp81HTNBB0ejou9wIGiIHLMTkXGGrXWpeAB1auLO8FZdav67Dq6Rht2g/A0r6DlgBhKs2Fmc4vHTd/BVAKweVyobQpKDLlyNvH6pQOm7AabOrumGVnhbFrX0ILPlDIQXV613FzoZPTsMWVnDQXaeuA1zVzFuCc6qRszk9ZlwQ2HVYb9ktakNqX0KZ0dum4YEh4TcN+kt1/MuJ15o2gypRhOwA7j1zDtVxTXaQtwOT0+bPw6bDqlttmBlufnY69qH0NLWjSccGSuwoAAa4tpXQ64sLAsVIHsPPKrauEOJVllCohNQASVM4KVmUaJJzeX2Wqi3INLK6vbPnufnPY1L6GNqXzE1zwpOuCCMCAlVPm/0EGLHCD1xQt73U+CEEsxyRg5mvvE9gcK93glgZK5q1cNf8rpUwH0l3VKctLh92PwFKDNqTzM58EU6YLYAENeDLXBTDAyGtuCGLHgNx5QCSumK9N6eniFnzp4nktymuVuwPOcT7Ac1G4Xx021aAtxL24IzjcZEjYEmAggRdsXDH/h8R04PzJeHCDL5Ww+6Fj5znWeXnuLGdVNvDNAHnjYD/DmmrQFgIEcLuuC9503UwZAJaOCTgu2XXO/Fn3lM8dRwl25qyu6/qUbp2wSgf2u7uWatBWlPCairmuPJLzcj05b+m+IEuIAQjEBLMGKdAdW07/6apAVYaBokz5by7yavXcr2rQzhFYypV+Lp6AVYKbSqcsXbP271SeZyCUD9MoC6zNXetq0PYQcABkmjZdu70LMI7IgQl06cRgTvcsX6eTkuOdZxBwVQPCrkIutGr1aHpZDdollGlDum9uYXHHBBmM3LOE1r/Lad+x4HcuSNNVXVsZzV3nq0G7otJ9AZf7sCAEbk77pdNy1ATVsaDPfLVBupwatAMo3ZG4bg1a75dOSrVrNS1Wg3ZggTMXWV1oG6jDqEE7sEpoy0VZg3Y4NWgHVgmt3YIG7fBq0A4scAIWqKDNFKFBO5watAPLDkGDdr1q0A4s0IIUrAkteb9BO4watAPLXS0LMMo7ZATa2vFNy6tBO7A8N+DOlztjKbdr3VSoHd+0vBq0A8tdLm7rVq27YHnL1h2w2vFNy6tBO7Dc9QIux7X4yie2vF87vml5NWjXIAsukLaHYNajBm3T6NSgbRqdGrRNo1ODtml0atA2jU4N2qbRqUHbNDo1aJtGpwZt0+jUoG0anRq0TaNTg7ZpdGrQNo1ODdqm0alB2zQ6NWibRqcGbdPo1KBtGp0atE2jU4O2aXRq0DaNTg3aptGpQds0OjVom0anBm3T6NSgbRqdGrRNo1ODtmlkOjD5f8E7g8Uk7cWqAAAAAElFTkSuQmCC";
        }    

        try {
            $empleat->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. El email, dni o nss ja existeixen'));
        }

        if ($empleat) {

            $camposCargos = Carrec::all(); //["director","tecnic_sala","actor","traductor"];
            $idiomas = Idioma::all(); //["Català", 'Castellà', "Anglès"];
            $tarifas = Tarifa::all();

            $datos = [];

            foreach ($camposCargos as $key => $carrec) {
                $id_carrec = $carrec->id_carrec;
                $nomCarrec = $carrec->input_name;

                if (($nomCarrec == "director" || $nomCarrec == "tecnic_sala") && request()->has($nomCarrec)) {
                    foreach ($tarifas as $key => $tarifa) {
                        $nombre_corto = $tarifa->nombre_corto;
                        $id_tarifa = $tarifa->id_tarifa;

                        if(!empty(request()->input("preu_$nomCarrec"."_$nombre_corto"))){
                            $datos["id_empleat"] = $empleat->id_empleat;
                            $datos["id_carrec"] = $id_carrec;
                            $datos["id_idioma"] = 0;
                            $datos["empleat_homologat"] = 0;
                            $datos["rotllo"] = 0;
                            $datos["contracta"] = request()->input('contracta_'.$nomCarrec);
                            $datos["preu_carrec"] = request()->input("preu_$nomCarrec"."_$nombre_corto");//coge el valor mandado del input
                            $datos["id_tarifa"] = $tarifa->id;

                            $carrecEmpleat = new CarrecEmpleat($datos);
                            // TODO: Validar "carrecEmpleat"
                            $carrecEmpleat->save();
                        }
                    }
                } else if (request()->has($nomCarrec)) {
                    foreach ($idiomas as $key => $idioma) {
                        foreach ($tarifas as $key => $tarifa) {
                            $nombre_corto = $tarifa->nombre_corto;
                            $id_tarifa = $tarifa->id_tarifa;
                            $id_idioma = $idioma->id_idioma;
                            $nom_idioma = $idioma->idioma;

                            if (request()->has("idioma_$nomCarrec" . "_$nom_idioma") && !empty(request()->input("preu_$nomCarrec" . "_$nom_idioma" . "_$nombre_corto"))) {
                                $datos["id_empleat"] = $empleat->id_empleat;
                                $datos["id_carrec"] = $id_carrec;
                                $datos["id_idioma"] = $id_idioma;
                                $datos["empleat_homologat"] = (request()->has("homologat_$nomCarrec" . "_$nom_idioma")) ? request()->input("homologat_$nomCarrec" . "_$nom_idioma") : 0;
                                $datos["rotllo"] = (request()->has("rotllo_$nomCarrec" . "_$nom_idioma")) ? request()->input("rotllo_$nomCarrec" . "_$nom_idioma") : 0;
                                $datos["contracta"] = request()->input('contracta_'.$nomCarrec);
                                $datos["preu_carrec"] = request()->input("preu_$nomCarrec" . "_$nom_idioma" . "_$nombre_corto");
                                $datos["id_tarifa"] = $tarifa->id;
                                //(Tarifa::select('id')->where('id_carrec',$id_carrec)->first())->id;

                                $carrecEmpleat = new CarrecEmpleat($datos);
                                // TODO: Validar "carrecEmpleat"
                                $carrecEmpleat->save();

                            }   
                        }
                    }   
                }
            }
        }

        return redirect()->back()->with('success', 'S\'ha creat el personal correctament');
    }

    public function update(EmpleatExternCreateRequest $request, $id)
    {
        $empleat = EmpleatExtern::find($id);

        if (!$empleat) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar el personal, hi ha hagut un error amb el Servidor.'));
        }
        // Modifica datos personales del empleado
        $data = request()->all();
        
        $empleat->fill($data);
        
        if ($_FILES["imatge_empleat"]["tmp_name"]!=""){
            $empleat['imatge_empleat'] = base64_encode(file_get_contents($_FILES["imatge_empleat"]["tmp_name"]));
        }

        try {
            $empleat->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. El email, dni o nss ja existeixen'));
        }

        // Modifica cargos del empleado

        // TODO: Hacer la parte de modificar los cargos

        $camposCargos = Carrec::all(); //["director","tecnic_sala","ajustador","actor","traductor","linguista"];
        $idiomas = Idioma::all(); //["Català", 'Castellà', "Anglès"];
        $tarifas = Tarifa::all();

        $datos = [];

        foreach ($camposCargos as $key => $carrec) {
            $id_carrec = $carrec->id_carrec;
            $nomCarrec = $carrec->input_name;

            if (($nomCarrec == "director" || $nomCarrec == "tecnic_sala") && request()->has($nomCarrec)) {
                foreach ($tarifas as $key => $tarifa) {
                    $nombre_corto = $tarifa->nombre_corto;
                    $id_tarifa = $tarifa->id_tarifa;

                    if(!empty(request()->input("preu_$nomCarrec"."_$nombre_corto"))){

                        $datos["id_empleat"] = $empleat->id_empleat;
                        $datos["id_carrec"] = $id_carrec;
                        $datos["id_idioma"] = 0;
                        $datos["empleat_homologat"] = 0;
                        $datos["rotllo"] = 0;
                        $datos["contracta"] =(int) request()->input("contracta_$nomCarrec");
                        $datos["preu_carrec"] = request()->input("preu_$nomCarrec"."_$nombre_corto");//coge el valor mandado del input
                        $datos["id_tarifa"] = $tarifa->id;

                        $carrecAntic = CarrecEmpleat::where([
                            ['id_empleat', $id],
                            ['id_carrec', $id_carrec],
                            ['id_idioma', '0'],
                            ['id_tarifa', $tarifa->id],
                        ])->first();

                        if (empty($carrecAntic)) {
                            $carrecEmpleat = new CarrecEmpleat($datos);

                            $carrecEmpleat->save();
                        } else {
                            $carrecAntic->fill($datos);

                            $carrecAntic->save();
                        }
                    }
                }
            } else if (request()->has($nomCarrec)) {
                foreach ($idiomas as $key => $idioma) {
                    foreach ($tarifas as $key => $tarifa) {
                        $nombre_corto = $tarifa->nombre_corto;
                        $id_tarifa = $tarifa->id_tarifa;
                        $id_idioma = $idioma->id_idioma;
                        $nom_idioma = $idioma->idioma;
                        
                        if (request()->has("idioma_$nomCarrec" . "_$nom_idioma") && !empty(request()->input("preu_$nomCarrec" . "_$nom_idioma" . "_$nombre_corto")) && !empty(request()->input("preu_$nomCarrec" . "_$nom_idioma" . "_$nombre_corto"))) {
                            $datos["id_empleat"] = $empleat->id_empleat;
                            $datos["id_carrec"] = $id_carrec;
                            $datos["id_idioma"] = $id_idioma;
                            $datos["empleat_homologat"] = (request()->has("homologat_$nomCarrec" . "_$nom_idioma")) ? request()->input("homologat_$nomCarrec" . "_$nom_idioma") : 0;
                            $datos["rotllo"] = (request()->has("rotllo_$nomCarrec" . "_$nom_idioma")) ? request()->input("rotllo_$nomCarrec" . "_$nom_idioma") : 0;
                            $datos["contracta"] =(int) request()->input('contracta_'.$nomCarrec);
                            $datos["preu_carrec"] = request()->input("preu_$nomCarrec" . "_$nom_idioma" . "_$nombre_corto");
                            $datos["id_tarifa"] = $tarifa->id;
                            //(Tarifa::select('id')->where('id_carrec',$id_carrec)->first())->id;

                            $carrecAntic = CarrecEmpleat::where([
                                ['id_empleat', $id],
                                ['id_carrec', $id_carrec],
                                ['id_idioma', $id_idioma],
                                ['id_tarifa', $tarifa->id],
                            ])->first();

                            if (empty($carrecAntic)) {
                                $carrecEmpleat = new CarrecEmpleat($datos);
                                $carrecEmpleat->save();
                            } else {
                                $carrecAntic->fill($datos);
                                $carrecAntic->save();
                            }
                        } else if (!empty(request()->input("preu_$nomCarrec" . "_$nom_idioma" . "_$nombre_corto"))){
                            $carrecAntic = CarrecEmpleat::where([
                                ['id_empleat', $id],
                                ['id_carrec', $id_carrec],
                                ['id_idioma', $id_idioma],
                                ['id_tarifa', $tarifa->id],
                            ])->first();
                            if (!empty($carrecAntic)){
                                $carrecAntic->delete();
                            }
                        } else {
                            $carrecAntic = CarrecEmpleat::where([
                                ['id_empleat', $id],
                                ['id_carrec', $id_carrec],
                                ['id_idioma', $id_idioma],
                                ['id_tarifa', $tarifa->id],
                            ])->first();
                            if (!empty($carrecAntic)){
                                $carrecAntic->delete();
                            }
                        }  
                    }
                }   
            }else if(!request()->has($nomCarrec)){
                $carrecAntic = CarrecEmpleat::where([
                    ['id_empleat', $id],
                    ['id_carrec', $id_carrec]
                ])->delete();
            }
        }
        return redirect()->route('empleatIndex')->with('success', 'S\'ha modificat el personal correctament');        
    }

    public function delete(Request $request)
    {
        ActorEstadillo::whereIdActor($request["id"])->delete();
        
        Calendar::whereIdActor($request["id"])->delete();
        Calendar::whereIdDirector($request["id"])
                ->update(["id_director" => 0]);
        
        CalendarCarrec::whereIdEmpleat($request["id"])
                ->update(["id_empleat" => null]);
        
        CarrecEmpleat::whereIdEmpleat($request["id"])->delete();
        
        EmpleatExtern::whereIdEmpleat($request["id"])->delete();
        
        return redirect()->route('empleatIndex');
    }
//Funcio per fer consultes dels Empleat, s'utilitza per els inputs EasyAutocomplete d'alguns formularis
    public function search(Request $request)
    {
        if ($request->search != 'director' && $request->search != 'tecnic_mix' && $request->search != 'Actor'){
            $empleats = EmpleatExtern::select('slb_empleats_externs.id_empleat', 'nom_empleat', 'cognom1_empleat', 'cognom2_empleat')
                                    ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', 'slb_empleats_externs.id_empleat')
                                    ->join('slb_tarifas', 'slb_tarifas.id', 'slb_carrecs_empleats.id_tarifa')
                                    ->distinct()
                                    ->where('slb_tarifas.nombre_corto', $request->search)
                                    ->where('slb_carrecs_empleats.id_idioma', $request->idioma)
                                    ->get();
        } else {
            if ($request->search == 'director'){
                $empleats = EmpleatExtern::select('slb_empleats_externs.id_empleat', 'nom_empleat', 'cognom1_empleat', 'cognom2_empleat')
                                        ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', 'slb_empleats_externs.id_empleat')
                                        ->join('slb_carrecs', 'slb_carrecs.id_carrec', 'slb_carrecs_empleats.id_carrec')
                                        ->distinct()->where('slb_carrecs.nom_carrec', 'Director')
                                        ->get();
            } elseif ($request->search == 'Actor') {
                $empleats = EmpleatExtern::select('slb_empleats_externs.id_empleat', 'nom_empleat', 'cognom1_empleat', 'cognom2_empleat')
                                        ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', 'slb_empleats_externs.id_empleat')
                                        ->join('slb_carrecs', 'slb_carrecs.id_carrec', 'slb_carrecs_empleats.id_carrec')
                                        ->distinct()->where('slb_carrecs.nom_carrec', $request->search)
                                        ->get();
            } else {
                $empleats = EmpleatExtern::select('slb_empleats_externs.id_empleat', 'nom_empleat', 'cognom1_empleat', 'cognom2_empleat')
                                        ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', 'slb_empleats_externs.id_empleat')
                                        ->join('slb_carrecs', 'slb_carrecs.id_carrec', 'slb_carrecs_empleats.id_carrec')
                                        ->distinct()->where('slb_carrecs.nom_carrec', 'Tècnic de sala')
                                        ->get();
            }
                
        }
        
                            
        return response()->json($empleats);
    }
    
    public function check(Request $request)
    {
        if (EmpleatExtern::where($request['camp'], $request['value'])->first()){
            return response()->json(true);
        }

        return response()->json(false);
    }
}

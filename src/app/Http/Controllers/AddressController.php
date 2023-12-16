<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\AddressStoreRequest;
use App\Http\Requests\Address\MarkAsMainRequest;
use App\Models\Address;
use Illuminate\Http\Request;
use Throwable;

class AddressController extends Controller
{
    public array $ufs;

    public function __construct()
    {
        $this->ufs = [
            'AC',
            'AL',
            'AP',
            'AM',
            'BA',
            'CE',
            'DF',
            'ES',
            'GO',
            'MA',
            'MT',
            'MS',
            'MG',
            'PA',
            'PB',
            'PR',
            'PE',
            'PI',
            'RJ',
            'RN',
            'RS',
            'RO',
            'RR',
            'SC',
            'SP',
            'SE',
            'TO',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\Address\AddressStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressStoreRequest $request)
    {
        try
        {
            $address = new Address([
                'cep' => $request->input('cep'),
                'logradouro' => $request->input('logradouro'),
                'numero' => $request->input('numero'),
                'complemento' => $request->input('complemento'),
                'bairro' => $request->input('bairro'),
                'cidade' => $request->input('cidade'),
                'estado' => $request->input('uf'),

                'partner_id' => $request->input('partner_id')
            ]);

            $save = $address->save();

            if (! $save) {
                return back()->with('address_created', false);
            }

            return back()->with('address_created', true);
        }
        catch (Throwable $throwable)
        {
            return back()->withInput()->with('address_created', false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $address = Address::find($request->id);

        if (! $address) {
            return back()->withErrors('Endereço não encontrado');
        }

        if (! $address->delete()) {
            return back()->withErrors('Erro ao deletar o endereço selecionado');
        }

        return back();
    }

    /**
     * Define um endereço de um sócio como endereço principal
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function markAsMain(MarkAsMainRequest $request)
    {
        $partnerAddresses = Address::where('partner_id', $request->partner_id);

        if (! $partnerAddresses->count()) {
            return back()->withErrors('Nenhum endereço do sócio para atualizar.');
        }

        $partnerAddresses->update(['principal' => false]);
        $partnerAddresses->where('id', $request->address_id)->update(['principal' => true]);

        return back()->with('address_updated', true);
    }
}

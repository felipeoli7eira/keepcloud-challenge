<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartnerRequest;
use App\Models\Partner;
use Illuminate\Http\Request;
use Throwable;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::all();
        return view('pages.dashboard.partners.read', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForm()
    {
        return view('pages.dashboard.partners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartnerRequest $request)
    {
        try
        {
            $payload = $request->safe()->only(['name', 'type']);
            $partner = Partner::create($payload);
            return redirect()->route('dashboard.partner.list');
        }
        catch (Throwable $throwable)
        {
            dd($throwable->getMessage());
            return back()->withInput()->with('error', $throwable->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $partner = Partner::find($request->id);

        if (! $partner->exists()) {
            return route('dashboard.partner.list');
        }

        $ufs = (new AddressController())->ufs;

        return view('pages.dashboard.partners.update', compact('partner', 'ufs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        $partnerInstance = $partner->where('id', request('id'));

        if (!$partnerInstance->exists()) {
            return back()->withInput()->withErrors(['notFound' => 'Sócio não encontrado']);
        }

        $partnerInstance->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()->route('dashboard.partner.show', ['id' => request('id')])->with('updated', true);

        // $partner =
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $partner = Partner::find($request->id);
        dd($partner->name);
    }
}

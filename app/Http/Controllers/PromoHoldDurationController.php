<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePromoHoldDurationRequest;
use App\Http\Requests\UpdatePromoHoldDurationRequest;
use App\Repositories\PromoHoldDurationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\PromoHoldDuration;
use Flash;
use Response;

class PromoHoldDurationController extends AppBaseController
{
    /** @var  PromoHoldDurationRepository */
    private $promoHoldDurationRepository;

    public function __construct(PromoHoldDurationRepository $promoHoldDurationRepo)
    {
        $this->promoHoldDurationRepository = $promoHoldDurationRepo;
    }

    /**
     * Display a listing of the PromoHoldDuration.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $promoHoldDurations = $this->promoHoldDurationRepository->all();

        return view('promo_hold_durations.index')
            ->with('promoHoldDurations', $promoHoldDurations);
    }

    /**
     * Show the form for creating a new PromoHoldDuration.
     *
     * @return Response
     */
    public function create()
    {
        return view('promo_hold_durations.create');
    }

    /**
     * Store a newly created PromoHoldDuration in storage.
     *
     * @param CreatePromoHoldDurationRequest $request
     *
     * @return Response
     */
    public function store(CreatePromoHoldDurationRequest $request)
    {
        $input = $request->all();

        $input['created_by'] = \Auth::user()->id;

        $cekData = PromoHoldDuration::where('packet_type', $input['packet_type'])->get()->first();

        if ($cekData != null) {
            Flash::error('Durasi '.$input['packet_type'].' Sudah dibuat.');

            return redirect(route('promoHoldDurations.create'))->withInput();
        }

        $promoHoldDuration = $this->promoHoldDurationRepository->create($input);

        Flash::success('Promo Hold Duration saved successfully.');

        return redirect(route('promoHoldDurations.index'));
    }

    /**
     * Display the specified PromoHoldDuration.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $promoHoldDuration = $this->promoHoldDurationRepository->find($id);

        if (empty($promoHoldDuration)) {
            Flash::error('Promo Hold Duration not found');

            return redirect(route('promoHoldDurations.index'));
        }

        return view('promo_hold_durations.show')->with('promoHoldDuration', $promoHoldDuration);
    }

    /**
     * Show the form for editing the specified PromoHoldDuration.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $promoHoldDuration = $this->promoHoldDurationRepository->find($id);

        if (empty($promoHoldDuration)) {
            Flash::error('Promo Hold Duration not found');

            return redirect(route('promoHoldDurations.index'));
        }

        return view('promo_hold_durations.edit')->with('promoHoldDuration', $promoHoldDuration);
    }

    /**
     * Update the specified PromoHoldDuration in storage.
     *
     * @param int $id
     * @param UpdatePromoHoldDurationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePromoHoldDurationRequest $request)
    {
        $promoHoldDuration = $this->promoHoldDurationRepository->find($id);

        if (empty($promoHoldDuration)) {
            Flash::error('Promo Hold Duration not found');

            return redirect(route('promoHoldDurations.index'));
        }

        $promoHoldDuration = $this->promoHoldDurationRepository->update($request->all(), $id);

        Flash::success('Promo Hold Duration updated successfully.');

        return redirect(route('promoHoldDurations.index'));
    }

    /**
     * Remove the specified PromoHoldDuration from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $promoHoldDuration = $this->promoHoldDurationRepository->find($id);

        if (empty($promoHoldDuration)) {
            Flash::error('Promo Hold Duration not found');

            return redirect(route('promoHoldDurations.index'));
        }

        $this->promoHoldDurationRepository->delete($id);

        Flash::success('Promo Hold Duration deleted successfully.');

        return redirect(route('promoHoldDurations.index'));
    }

    public function getDataByCode($code)
    {
        if ($code == 'G') {
            $value = 'BUNDLING GIMMICK';
        } else if ($code == 'P') {
            $value = 'BUNDLING PRODUCT';
        } else if ($code == 'C') {
            $value = 'BUNDLING DISCOUNT';
        } else {
            $value = 'REGULAR';
        }

        $findData = PromoHoldDuration::where('packet_type', $value)->get()->first();

        if ($findData != null) {
            return 1;
        } else {
            return 0;
        }
    }
}

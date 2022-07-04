<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDsRuleRequest;
use App\Http\Requests\UpdateDsRuleRequest;
use App\Repositories\DsRuleRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\DsRule;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Flash;
use Response;

class DsRuleController extends AppBaseController
{
    /** @var  DsRuleRepository */
    private $dsRuleRepository;

    public function __construct(DsRuleRepository $dsRuleRepo)
    {
        $this->dsRuleRepository = $dsRuleRepo;
    }

    /**
     * Display a listing of the DsRule.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (!\Auth::user()->can('setting direct selling rules')) {
            abort(403);
        }

        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereIn('BAccountID', $createdCustomer)->whereNotIn('AcctCD', ['MAIN'])->get();

        $dsRule = $this->dsRuleRepository->find(1);

        return view('ds_rules.index', compact('dsRule', 'customers'));
    }

    /**
     * Show the form for creating a new DsRule.
     *
     * @return Response
     */
    public function create()
    {
        return view('ds_rules.create');
    }

    /**
     * Store a newly created DsRule in storage.
     *
     * @param CreateDsRuleRequest $request
     *
     * @return Response
     */
    public function store(CreateDsRuleRequest $request)
    {
        $input = $request->all();

        $dsRule = $this->dsRuleRepository->create($input);

        Flash::success('Ds Rule saved successfully.');

        return redirect(route('dsRules.index'));
    }

    /**
     * Display the specified DsRule.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $dsRule = $this->dsRuleRepository->find($id);

        if (empty($dsRule)) {
            Flash::error('Ds Rule not found');

            return redirect(route('dsRules.index'));
        }

        return view('ds_rules.show')->with('dsRule', $dsRule);
    }

    /**
     * Show the form for editing the specified DsRule.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $dsRule = $this->dsRuleRepository->find($id);

        if (empty($dsRule)) {
            Flash::error('Ds Rule not found');

            return redirect(route('dsRules.index'));
        }

        return view('ds_rules.edit')->with('dsRule', $dsRule);
    }

    /**
     * Update the specified DsRule in storage.
     *
     * @param int $id
     * @param UpdateDsRuleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDsRuleRequest $request)
    {
        $dsRule = $this->dsRuleRepository->find($id);

        if (empty($dsRule)) {
            Flash::error('Ds Rule not found');

            return redirect(route('dsRules.index'));
        }

        $dsRule = $this->dsRuleRepository->update($request->all(), $id);

        Flash::success('Ds Rule updated successfully.');

        return redirect(route('dsRules.index'));
    }

    /**
     * Remove the specified DsRule from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $dsRule = $this->dsRuleRepository->find($id);

        if (empty($dsRule)) {
            Flash::error('Ds Rule not found');

            return redirect(route('dsRules.index'));
        }

        $this->dsRuleRepository->delete($id);

        Flash::success('Ds Rule deleted successfully.');

        return redirect(route('dsRules.index'));
    }

    public function updateStatus($code)
    {
        $dsPercentage = DsRule::get()->first();
        $dsPercentage['status'] = $code;
        $dsPercentage->save();

        return response()->json(['success'=>'Rule Updated successfully.']);
    }
}

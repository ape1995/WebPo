<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMailSettingRequest;
use App\Http\Requests\UpdateMailSettingRequest;
use App\Repositories\MailSettingRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\MailSetting;
use Flash;
use Response;

class MailSettingController extends AppBaseController
{
    /** @var  MailSettingRepository */
    private $mailSettingRepository;

    public function __construct(MailSettingRepository $mailSettingRepo)
    {
        $this->mailSettingRepository = $mailSettingRepo;
    }

    /**
     * Display a listing of the MailSetting.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $mailSettings = MailSetting::orderBy('email', 'ASC')->latest()->get();

        return view('mail_settings.index')
            ->with('mailSettings', $mailSettings);
    }

    /**
     * Show the form for creating a new MailSetting.
     *
     * @return Response
     */
    public function create()
    {
        return view('mail_settings.create');
    }

    /**
     * Store a newly created MailSetting in storage.
     *
     * @param CreateMailSettingRequest $request
     *
     * @return Response
     */
    public function store(CreateMailSettingRequest $request)
    {
        $input = $request->all();

        $cekMail = MailSetting::where('email', $input['email'])->where('name', $input['name'])->get();

        if($cekMail->count('id') >= 1){

            return redirect()->back()->with('error', 'Email already exist');

        } else {

            if($input['type'] == 'Sender'){
                
                $cekMail2 = MailSetting::where('status', 1)->where('type', 'Sender')->get();

                if($cekMail2->count('id') >= 1){

                    return redirect()->back()->with('error', 'There is a must, only 1 (one) sender active');
                
                } else {
                    
                    $mailSetting = $this->mailSettingRepository->create($input);
        
                    return redirect(route('mailSettings.index'))->with('success', 'Email saved successfully.');
                
                }

            } else {

                $mailSetting = $this->mailSettingRepository->create($input);
        
                return redirect(route('mailSettings.index'))->with('success', 'Email saved successfully.');

            }

            
        }

        
    }

    /**
     * Display the specified MailSetting.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $mailSetting = $this->mailSettingRepository->find($id);

        if (empty($mailSetting)) {

            return redirect(route('mailSettings.index'))->with('error', 'Email not found.');
        }

        return view('mail_settings.show')->with('mailSetting', $mailSetting);
    }

    /**
     * Show the form for editing the specified MailSetting.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $mailSetting = $this->mailSettingRepository->find($id);

        if (empty($mailSetting)) {

            return redirect(route('mailSettings.index'))->with('error', 'Email not found.');
        }

        return view('mail_settings.edit')->with('mailSetting', $mailSetting);
    }

    /**
     * Update the specified MailSetting in storage.
     *
     * @param int $id
     * @param UpdateMailSettingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMailSettingRequest $request)
    {
        $mailSetting = $this->mailSettingRepository->find($id);

        if (empty($mailSetting)) {

            return redirect(route('mailSettings.index'))->with('error', 'Email not found.');
        }

        $mailSetting = $this->mailSettingRepository->update($request->all(), $id);

        return redirect(route('mailSettings.index'))->with('success', 'Email updated successfully.');
    }

    /**
     * Remove the specified MailSetting from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $mailSetting = $this->mailSettingRepository->find($id);

        if (empty($mailSetting)) {
            Flash::error('Mail Setting not found');

            return redirect(route('mailSettings.index'));
        }

        $mailSetting = MailSetting::find($id);
        $mailSetting['status'] = 0;
        $mailSetting->save();

        Flash::success('Email inactived successfully.');

        return redirect(route('mailSettings.index'));
    }

    public function active($id)
    {
        if (!\Auth::user()->can('active mail setting')) {
            abort(403);
        }

        $mail = MailSetting::find($id);

        if (empty($mail)) {
            return redirect(route('mailSettings.index'))->with('error', 'Mail not found');
        }

        // $user->removeRole($user->role);
        $mail = MailSetting::find($id);
        $mail['status'] = 1;
        $mail->save();

        return redirect(route('mailSettings.index'))->with('success', 'Mail actived successfully.');
    }
}

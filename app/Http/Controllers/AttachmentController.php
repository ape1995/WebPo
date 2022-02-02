<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttachmentRequest;
use App\Http\Requests\UpdateAttachmentRequest;
use App\Repositories\AttachmentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class AttachmentController extends AppBaseController
{
    /** @var  AttachmentRepository */
    private $attachmentRepository;

    public function __construct(AttachmentRepository $attachmentRepo)
    {
        $this->attachmentRepository = $attachmentRepo;
    }

    /**
     * Display a listing of the Attachment.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $attachments = $this->attachmentRepository->all();

        return view('attachments.index')
            ->with('attachments', $attachments);
    }

    /**
     * Show the form for creating a new Attachment.
     *
     * @return Response
     */
    public function create()
    {
        return view('attachments.create');
    }

    /**
     * Store a newly created Attachment in storage.
     *
     * @param CreateAttachmentRequest $request
     *
     * @return Response
     */
    public function store(CreateAttachmentRequest $request)
    {
        $input = $request->all();

        $attachment = $this->attachmentRepository->create($input);

        Flash::success('Attachment saved successfully.');

        return redirect(route('attachments.index'));
    }

    /**
     * Display the specified Attachment.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attachment = $this->attachmentRepository->find($id);

        if (empty($attachment)) {
            Flash::error('Attachment not found');

            return redirect(route('attachments.index'));
        }

        return view('attachments.show')->with('attachment', $attachment);
    }

    /**
     * Show the form for editing the specified Attachment.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attachment = $this->attachmentRepository->find($id);

        if (empty($attachment)) {
            Flash::error('Attachment not found');

            return redirect(route('attachments.index'));
        }

        return view('attachments.edit')->with('attachment', $attachment);
    }

    /**
     * Update the specified Attachment in storage.
     *
     * @param int $id
     * @param UpdateAttachmentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttachmentRequest $request)
    {
        $attachment = $this->attachmentRepository->find($id);

        if (empty($attachment)) {
            Flash::error('Attachment not found');

            return redirect(route('attachments.index'));
        }

        $attachment = $this->attachmentRepository->update($request->all(), $id);

        Flash::success('Attachment updated successfully.');

        return redirect(route('attachments.index'));
    }

    /**
     * Remove the specified Attachment from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attachment = $this->attachmentRepository->find($id);

        
        if (empty($attachment)) {
            Flash::error('Attachment not found');
            
            return redirect(route('attachments.index'));
        }

        $salesOrderId = $attachment->sales_order_id;

        $this->attachmentRepository->delete($id);

        Flash::success('Attachment deleted successfully.');

        return redirect(route('salesOrders.show', $salesOrderId));
    }
}

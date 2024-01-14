<?php

namespace App\Http\Controllers;

use App\Http\Requests\Mail\CustomMailRequest;
use App\Services\MailService;

class MailController extends Controller
{
    public function __construct(protected MailService $mailService)
    {
    }

    public function sendCustomEmail(CustomMailRequest $request)
    {
        return $this->mailService->sendCustomEmail($request->validated());
    }
}

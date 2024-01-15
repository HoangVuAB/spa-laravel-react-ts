<?php

namespace App\Services;

use App\Mail\CustomMail;
use App\Repositories\User\UserRepository;
use Mail;

class MailService
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function sendCustomEmail(array $data)
    {
        $reciever = $this->userRepository->findByField('email', $data['to']);

        Mail::to($reciever->email)->send(new CustomMail(auth()->user(), $reciever, $data));

        return redirect()->back();
    }
}

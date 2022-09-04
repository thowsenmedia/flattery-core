<?php

namespace ThowsenMedia\Flattery\Mail;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;

class Mailer
{

    protected Transport $transport;
    protected SymfonyMailer $mailer;

    public function __construct(string $dsn)
    {
        $this->transport = Transport::fromDsn($dsn);
        $this->mailer = new SymfonyMailer($this->transport);
    }

    public function send(Email $email)
    {
        return $this->mailer->send($email);
    }

}
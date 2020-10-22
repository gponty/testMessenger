<?php

namespace App\Message;

use App\Entity\Traitement;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

class TraitementService implements MessageHandlerInterface
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(Traitement $traitement)
    {
        sleep($traitement->getDuree());

        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('Traitement terminé!')
            ->text('Vous pouvez recuperer votre traitement !');

        $this->mailer->send($email);

    }
}
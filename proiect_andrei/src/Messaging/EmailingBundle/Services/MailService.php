<?php
/**
 * Created by PhpStorm.
 * User: Andrei Gache
 * Date: 10/04/2019
 * Time: 22:30
 */

namespace Messaging\EmailingBundle\Services;


use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\HttpFoundation\Request;

class MailService
{
    /**
     * @var Request $request
     */
    private $request;

    /**
     * @var TwigEngine $templating
     */
    private $templating;

    /**
     * @var string $view_mail
     */
    private $view_mail;

    public function __construct(TwigEngine $templating)
    {
        $this->templating = $templating;
    }

    public function sendMail(Request $request){
        $this->request = $request->request->all();
        $this->createMessage();
        return $this->flushMail();
    }

    private function createMessage()
    {
        $this->view_mail =  $this->templating->render('@MessagingEmailing/Email/mail.html.twig', [
            'name' => trim($this->request['name']),
            'phone'=> trim($this->request['phone']),
            'email'=> trim($this->request["email"]),
            'message'=>trim($this->request["message"])
        ]);
    }

    private function flushMail()
    {
        return mail('miron.bsm@gmail.com', 'Mesaj Website serrurieremetallerie.fr', $this->view_mail);
    }
}
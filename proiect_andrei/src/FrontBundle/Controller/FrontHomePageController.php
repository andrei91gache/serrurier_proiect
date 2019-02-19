<?php
/**
 * Created by PhpStorm.
 * Filename: FrontHomePageController.php.
 * User: Andrei Gache.
 * Website: https://andrei-gache.com
 * Date: 25/01/19
 * Time: 11:39
 */

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class FrontHomePageController extends Controller
{
    public function renderHomepageAction()
    {
        return $this->render('@Front/Homepage/homepage.html.twig');
    }

    public function sendFormAction(Request $request)
    {
        $response = new Response();
        if($request->isXmlHttpRequest()){
            //Get Service GoogleHangoutChat
            $hangoutChat = $this->get('hangout_messaging');
            //Send message
            $success = $hangoutChat->sendMessage($request);
            if ($success)
                $response->setStatusCode(Response::HTTP_ACCEPTED);
            else
                $response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);

        }
        return $response;
    }
}
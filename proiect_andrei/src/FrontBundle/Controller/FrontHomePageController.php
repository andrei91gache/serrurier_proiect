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

putenv('GOOGLE_APPLICATION_CREDENTIALS='. __DIR__ .'/Resources/config/HangoutMessaging-3cf961a474c0.json');

class FrontHomePageController extends Controller
{
    public function renderHomepageAction()
    {
        return $this->render('@Front/Homepage/homepage.html.twig');
    }

    public function sendFormAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $client = new \Google_Client();
            $client->useApplicationDefaultCredentials();
            $client->setApplicationName('Matu Fab\'Metal');
            $service = new \Google_Service_HangoutsChat($client);
            $s = $service->spaces->listSpaces();
            var_dump($s);
            die();
            return new Response('OK');
        }
    }
}
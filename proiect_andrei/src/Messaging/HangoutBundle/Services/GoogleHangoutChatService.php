<?php
/**
 * Created by PhpStorm.
 * Filename: GoogleHangoutChatService.php
 * User: Andrei Gache
 * Email: andrei.gache.99@gmail.com
 * Website: http://www.andrei-gache.com/
 * Date: 14/02/19
 * Time: 11:31
 */

namespace Messaging\HangoutBundle\Services;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class GoogleHangoutChatService
{
    /**
     * @var \Google_Client $googleClient
     */
    private $googleClient;

    /**
     * @var \Google_Service_HangoutsChat $googleService
     */
    private $googleService;

    /**
     * @var \Google_Service_HangoutsChat_Message $message
     */
    private $message;

    /**
     * @var array $request
     */
    private $request;

    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    /**
     * GoogleHangoutChatService constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function sendMessage(Request $request)
    {
        $this->request = $request->request->all();

        $this->initializeGoogleClient();
        $this->initializeGoogleHangoutChatService();
        $this->createMessage();
        $success = $this->flushMessageOnSpaces();
        return $success;
    }


    private function initializeGoogleClient()
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=/home/andrei/.google_credentials/HangoutMessaging-3cf961a474c0.json');
        $this->googleClient = new \Google_Client();
        $this->googleClient->useApplicationDefaultCredentials();
        $this->googleClient->setApplicationName('Matu Fab\'Metal');
        $this->googleClient->setScopes(
            [
                'https://www.googleapis.com/auth/chat.bot'
            ]
        );
    }

    private function initializeGoogleHangoutChatService()
    {
        $this->googleService = new \Google_Service_HangoutsChat($this->googleClient);
    }


    private function createMessage()
    {
        $this->message = new \Google_Service_HangoutsChat_Message();
        $card = $this->initializeCard();
        $this->message->setCards($card);
    }

    /**
     * @return \Google_Service_HangoutsChat_Card
     */
    private function initializeCard()
    {
        $card = new \Google_Service_HangoutsChat_Card();
        $card = $this->initializeHeader($card);
        $card = $this->initializeBody($card);
        return $card;
    }

    /**
     * @param \Google_Service_HangoutsChat_Card $card
     * @return \Google_Service_HangoutsChat_Card
     */
    private function initializeHeader(\Google_Service_HangoutsChat_Card $card)
    {
        //@ToDo Find a better way
        $title = trim($this->request['name']);
        $phone = trim($this->request['phone']);
        $email = trim($this->request["email"]);

        $card_header  = new \Google_Service_HangoutsChat_CardHeader();
        $card_header->setTitle($title);
        $card_header->setSubtitle("Telephone: ".$phone);
        $card->setHeader($card_header);
        return $card;
    }

    /**
     * @param \Google_Service_HangoutsChat_Card $card
     * @return \Google_Service_HangoutsChat_Card
     */
    private function initializeBody(\Google_Service_HangoutsChat_Card $card)
    {
        $text = trim($this->request['message']);

        $card_section = new \Google_Service_HangoutsChat_Section();
        $card_section->setHeader("Messagé");
        $widgets = new \Google_Service_HangoutsChat_WidgetMarkup();
        $textParagraph = new \Google_Service_HangoutsChat_TextParagraph();
        $textParagraph->setText($text);
        $widgets->setTextParagraph($textParagraph);
        $card_section->setWidgets($widgets);
        $card->setSections($card_section);
        return $card;
    }

    private function getSpacesChatRoom()
    {
        return $this->googleService->spaces->listSpaces()->getSpaces();
    }

    private function flushMessageOnSpaces()
    {
        $success = false;
        $spaces = $this->getSpacesChatRoom();

        foreach ($spaces as $space){
            try{
                $success = (bool)$this->googleService->spaces_messages->create($space->name, $this->message);
            }catch (\Exception $exception){
                $this->logger->critical($exception->getMessage());
            }
        }
        return $success;
    }
}
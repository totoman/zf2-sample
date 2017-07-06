<?php
namespace Member\Model\Mail;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplateMapResolver;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class MailService
{
    const MAIL = [
        'encoding' => 'UTF-8',
        'from'     => 'zf2-sample@example.com',
        'subject'  => '会員登録の確認',
    ];

    private $view;
    private $message;
    private $transport;
    private $options;
    private $renderer;
    private $resolver;

    public function __construct()
    {
        $this->view = new ViewModel();
        $this->message = new Message();
        $this->transport = new SmtpTransport();
        $this->options = new SmtpOptions([
            'host'              => 'zf2kawano_mailcatcher_1',
            'port'              => '1025',
        ]);
        $this->renderer = new PhpRenderer();
        $this->resolver = new TemplateMapResolver();
    }

    public function sendMail($userdata)
    {
        $this->resolver->setMap(array(
                'mailTemplate' => __DIR__ . '/../../../../view/member/mail/body.phtml'
        ));
        $this->renderer->setResolver($this->resolver);

        $this->view->setVariables(['userdata' => $userdata]);
        $this->view->setTemplate('mailTemplate');

        $html = new MimePart($this->renderer->render($this->view));
        $html->type = "text/html";

        $messageBody = new MimeMessage();
        $messageBody->addPart($html);

        $this->message->setEncoding(self::MAIL['encoding'])
                      ->addFrom(self::MAIL['from'])
                      ->addTo($userdata['mail_address'])
                      ->setSubject(self::MAIL['subject'])
                      ->setBody($messageBody);
        $this->send($this->message);
    }

    private function send($message)
    {
        $transport = new SmtpTransport();
        $options   = new SmtpOptions(array(
            'host'              => 'zf2kawano_mailcatcher_1',
            'port'              => '1025',
        ));
        $transport->setOptions($options);
        $transport->send($message);
    }
}
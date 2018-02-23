<?php

/*
 * This file is part of the Eulogix\Cool package.
 *
 * (c) Eulogix <http://www.eulogix.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace Eulogix\Cool\Bundle\CommunicationsBundle\Tests;

use Eulogix\AppModules\Communications\Communication;
use Eulogix\Cool\Bundle\CommunicationsBundle\Lib\Imp\EmailCommunication;
use Eulogix\Cool\Bundle\CoreBundle\Tests\Cases\baseTestCase;
use Eulogix\Cool\Lib\Cool;
use Eulogix\Lib\Crypto\CryptoUtils;
use Eulogix\Lib\Email\EmailFetcher;
use Eulogix\Lib\Email\EmailUtils;
use Eulogix\Lib\Email\Event\EmailProcessedEvent;
use Eulogix\Lib\File\Proxy\FileProxyInterface;
use Eulogix\Lib\File\Proxy\SimpleFileProxy;

/**
 * @author Pietro Baricco <pietro@eulogix.com>
 */

class EmailsTest extends baseTestCase
{
    const SYSTEM_SENDER = "fake@sender.org";
    const RECEIVER_1 = "receiver@domain.org";
    const RECEIVER_2 = "receiver2@domain.org";

    public function setUp() {
        parent::setUp();
        Cool::getInstance()->getSchema('communications')->query("TRUNCATE TABLE communication CASCADE");
    }

    /**
     * @throws \Exception
     * @throws \PropelException
     */
    public function testSend() {

        $email = new EmailCommunication();

        //1 system sends an email
        $email->setSubject("a test subject")
              ->setBody("A test body")
              ->addRecipient(self::RECEIVER_1)
              ->addRecipient(self::RECEIVER_2, "Somename")
              ->saveAndAddHiddenTrackingCode()
              ->addAttachment($this->getFakeAttachment())
              ->addAttachment($this->getFakeAttachment());

        $numSent = $email->send($this->getMailer(), self::SYSTEM_SENDER, "john.luri@gmail.com", "John Luri");

        $this->assertEquals(2, $numSent);

        $replyAttachment = $this->getFakeAttachment();
        //2 one receiver sends an answer to the sender
        $reply = $this->getReplyMessage($email)
                      ->setFrom([self::RECEIVER_1])
                      ->setTo(self::SYSTEM_SENDER)
                      ->attach(\Swift_Attachment::newInstance($replyAttachment->getContent(), $replyAttachment->getName()));

        $this->getMailer()->send($reply);

        $this->checkSentEmail();
        $this->fetchReplies();

    }

    protected function checkSentEmail() {
        $fetcher = EmailFetcher::getIMAPFetcher('127.0.0.1', 3143, "INBOX", self::RECEIVER_1, self::RECEIVER_1);

        $this->assertEquals(1, $fetcher->getMessagesNumber());

        $fetcher->getDispatcher()->addListener(EmailFetcher::EVENT_EMAIL_PROCESSED, function(EmailProcessedEvent $e){
          //  echo $e->getParser()->getHeadersRaw();
        });
        $fetcher->processMessages()->commit();
    }

    protected function fetchReplies() {

        $fetcher = EmailFetcher::getIMAPFetcher('127.0.0.1', 3143, "INBOX", self::SYSTEM_SENDER, self::SYSTEM_SENDER);

        $this->assertEquals(1, $fetcher->getMessagesNumber());

        $fetcher->getDispatcher()->addListener(EmailFetcher::EVENT_EMAIL_PROCESSED, function(EmailProcessedEvent $e){
            $body = $e->getParser()->getMessageBody('text');
            $subject = $e->getParser()->getHeader('subject');

            $hiddenCodes = CryptoUtils::decodeAllEncryptedStringsFromText($body);
            $e->getFetcher()->removeMessage($e->getMessageId());

            foreach($hiddenCodes as $hiddenCode => $jsonData) {
                $data = json_decode($jsonData, true);
                if(($schemaName = @$data['schema']) && ($pk = @$data['pk'])) {
                    //we have found a reply to an existing communication
                    $replyEmail = new EmailCommunication();
                    $replyEmail->setBody($body)
                               ->setSubject($subject)
                               ->setSender($e->getParser()->getHeader('from'));

                    $toEmails = EmailUtils::extractAllValidEmailAddressesFrom($e->getParser()->getHeader('to'));
                    foreach($toEmails as $toEmail)
                        $replyEmail->addRecipient($toEmail);

                    $schema = $replyEmail->getCommunication()->getCoolDatabase();
                    $schema->setCurrentSchema($schemaName);

                    $replyCommunication = $replyEmail->getCommunication();
                    $replyCommunication
                        ->setThreadCommunicationId($pk)
                        ->setInboundFlag(true)
                        ->setCommunicationDate(new \DateTime())
                        ->save();

                    foreach($e->getParser()->getAttachments(false) as $attachment) {
                        $f = new SimpleFileProxy();
                        $f->setName($attachment->getFilename())
                          ->setContent($attachment->getContent());
                        $replyEmail->addAttachment($f);
                    }
                }
            }

        });

        $fetcher->processMessages()->commit();

        $this->assertEquals(0, $fetcher->getMessagesNumber());
    }

    /**
     * @return \Swift_Mailer
     */
    protected function getMailer() {
        $transport = new \Swift_SmtpTransport('127.0.0.1', 3025);
        return new \Swift_Mailer($transport);
    }

    /**
     * @param EmailCommunication $email
     * @return \Swift_Message
     */
    protected function getReplyMessage(EmailCommunication $email) {

        $replyMessage = (new \Swift_Message("Re: ".$email->getSubject()))
            ->setBody("Some answer here \r\nold message:\n\n".$email->getBody())
        ;

        return $replyMessage;
    }

    /**
     * @return SimpleFileProxy
     */
    protected function getFakeAttachment() {
        $f = new SimpleFileProxy();
        $f->setName("file".rand(0,1000).".txt")
          ->setContent("lorem ipsum");
        return $f;
    }

}

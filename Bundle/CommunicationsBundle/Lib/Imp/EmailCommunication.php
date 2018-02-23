<?php

/*
 * This file is part of the Eulogix\Cool package.
 *
 * (c) Eulogix <http://www.eulogix.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace Eulogix\Cool\Bundle\CommunicationsBundle\Lib\Imp;

use Eulogix\AppModules\Communications\Communication;
use Eulogix\AppModules\Communications\CommunicationActor;
use Eulogix\Lib\Crypto\CryptoUtils;
use Eulogix\Lib\File\Proxy\FileProxyInterface;

/**
 * @author Pietro Baricco <pietro@eulogix.com>
 */

class EmailCommunication extends BaseCommunicationImp
{
    /**
     * @param $subject
     * @return $this
     */
    public function setSubject($subject) {
        $this->getCommunication()->setSubject($subject);
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject() {
        return $this->getCommunication()->getSubject();
    }

    /**
     * @param $body
     * @return $this
     */
    public function setBody($body) {
        $this->getCommunication()->setBody( $body);
        return $this;
    }

    /**
     * @return string
     */
    public function getBody() {
        return $this->getCommunication()->getBody();
    }

    /**
     * @param string $email
     * @param string|null $name
     * @return $this
     */
    public function addRecipient($email, $name = null) {
        $actor = new CommunicationActor();

        $actor->setEmail($email)
              ->setName($name)
              ->setRole(CommunicationActor::ROLE_RECIPIENT);

        $this->getCommunication()->addCommunicationActor($actor);
        return $this;
    }

    /**
     * @param string $email
     * @param string|null $name
     * @return $this
     */
    public function setSender($email, $name = null) {
        $actor = new CommunicationActor();

        $actor->setEmail($email)
              ->setName($name)
              ->setRole(CommunicationActor::ROLE_SENDER);

        $this->getCommunication()->addCommunicationActor($actor);
        return $this;
    }

    /**
     * @return \Swift_Message
     */
    public function getSwiftMessage() {
        $message = (new \Swift_Message($this->getSubject()))
            ->setTo($this->getSwiftMessageRecipients())
            ->setBody($this->getBody(), 'text/html')
        ;
        return $message;
    }

    /**
     * @return array
     */
    protected function getSwiftMessageRecipients() {
        $ret = [];
        foreach($this->getCommunication()->getCommunicationActors() as $actor)
            if($email = $actor->getEmail()) {
                if($name = $actor->getName())
                    $ret[$email] = $name;
                else $ret[] = $email;
            }
        return $ret;
    }

    /**
     * @param \Swift_Mailer $mailer
     * @param string $sender
     * @param string|null $from
     * @param string $fromName
     * @return int
     * @throws \Exception
     * @throws \PropelException
     */
    public function send(\Swift_Mailer $mailer, $sender, $from = null, $fromName = null)
    {
        $message = $this->getSwiftMessage();
        $message->setFrom($from ?? $sender, $fromName);
        $message->setSender($sender);
        $message->setReplyTo($sender);

        $docs = $this->getCommunication()->getFileRepository()->getChildrenOf('cat_ATTACHMENT', false);
        foreach($docs->getIterator() as $f) {
            /** @var $f FileProxyInterface */
            $message->attach(\Swift_Attachment::newInstance($f->getContent(), $f->getName()));
        }

        $numSent = $mailer->send($message);
        if($numSent > 0) {
            $this->setSender($sender, $fromName)
                ->getCommunication()
                    ->setInboundFlag(false)
                    ->setCommunicationDate(new \DateTime())
                    ->save();
        }
        return $numSent;
    }

    /**
     * @return $this
     */
    public function saveAndAddHiddenTrackingCode() {
        if($this->getCommunication()->isNew())
            $this->getCommunication()->save();

        $trackingInfo = [
            'schema' => $this->getCommunication()->getCoolDatabase()->getCurrentSchema(),
            'pk' => $this->getCommunication()->getPrimaryKey()
        ];

        $cleanBody = CryptoUtils::removeAllEncryptedStringsFromText( $this->getBody() );
        $uuid = CryptoUtils::getEncryptedString( json_encode($trackingInfo) );
        $this->setBody( "{$cleanBody}\r\n<!--{$uuid}-->" );

        $this->getCommunication()->save();
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Communication::CATEGORY_EMAIL;
    }

    /**
     * @param FileProxyInterface $file
     * @return $this
     */
    public function addAttachment($file)
    {
        $this->getCommunication()->getFileRepository()->storeFileAt($file, 'cat_ATTACHMENT');
        return $this;
    }
}
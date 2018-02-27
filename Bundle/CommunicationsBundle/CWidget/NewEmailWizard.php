<?php

/*
 * This file is part of the Eulogix\Cool package.
 *
 * (c) Eulogix <http://www.eulogix.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace Eulogix\Cool\Bundle\CommunicationsBundle\CWidget;

use Eulogix\Cool\Bundle\CommunicationsBundle\Lib\Imp\EmailCommunication;
use Eulogix\Cool\Lib\Cool;
use Eulogix\Cool\Lib\DataSource\ValueMapInterface;
use Eulogix\Cool\Lib\Form\Form;
use Eulogix\Lib\Email\EmailUtils;

/**
 * @author Pietro Baricco <pietro@eulogix.com>
 */

class NewEmailWizard extends Form  {

    public function __construct($parameters = [])
    {
        parent::__construct($parameters);

        if($schema = $this->getSchemaName())
            Cool::getInstance()->getSchema('communications')->setCurrentSchema($schema);
    }

    /**
     * @inheritdoc
     */
    public function build() {
        parent::build();

        $user = Cool::getInstance()->getLoggedUser();

        //TODO make this a quick selector that reverts to empty, used only to pick some recipients from a list
        if($recipientsVm = $this->getRecipientsValueMap()) {
            $recipients = $this->addFieldMultiSelect("recipients")->setUseChosen(true);
            $recipients->setValueMap($recipientsVm);
        }

        $this->addFieldTextBox("to_emails");

        $this->addFieldTextBox("sender")->setValue($user->getFirstName().' '.$user->getLastName());
        $this->addFieldTextBox("subject")->setNotNull();
        $this->addFieldHTMLEditor("body")->setNotNull();
        if($sig = $user->getEmailSignature())
            $this->getField("body")->setValue( "<br><br>--<br>{$sig}");

        $this->addFieldFile("attachments")->setMultiple(true);

        $this->addFieldButton("send")->setOnClick("widget.callAction('send');");

        $parameters = $this->parameters->all();
        $this->rawFill( $parameters );

        return $this;
    }


    protected function hide() {
        $this->addCommandJs("widget.dialog.hide();", 2000);
    }

    public function getLayout() {

        return "<FIELDS>
                    sender:200
                    to_emails:100%
                    subject:100%
                    body:100%:300px
                    attachments:100%
                </FIELDS>
                <FIELDS>
                    send|align=center
                </FIELDS>";
    }

    public function onSend() {

        $parameters = $this->request->all();
        $this->rawFill( $parameters );

        if($this->validate( array_keys($parameters) ) ) {

            $email = new EmailCommunication();

            $email->setSubject( $parameters['subject'] )
                ->setBody( $parameters['body'] );

            if($recipients = $this->getField('recipients')) {
                foreach($recipients->getValue() as $customRecipient)
                    $this->addCustomRecipientToEmail($email, $customRecipient);
            }

            $toEmails = EmailUtils::extractAllValidEmailAddressesFrom( $parameters['to_emails'] );
            foreach($toEmails as $recipientEmail) {
                $email->addRecipient($recipientEmail);
            }

            if($email->getCommunication()->countCommunicationActors() > 0) {

                $email->saveAndAddHiddenTrackingCode();

                if($f =  $this->getField('attachments')->getUploadedFiles()) {
                    foreach($f as $file)
                        $email->addAttachment($file);
                }

                if( $email->send( Cool::getInstance()->getFactory()->getMailer(), $this->getSender() ) > 0) {
                    $this->addMessageInfo("Message sent.");
                } else $this->addMessageError("Could not send message.");


                $this->setReadOnly(true);
                $this->removeField("send");
                $this->hide();

            } else $this->addMessageError("Provide at least one recipient.");

        } else {
            $this->addMessageError("NOT VALIDATED");
        }
    }

    /**
     * @return string
     */
    protected function getSender()
    {
        return Cool::getInstance()->getFactory()->getEmailFactory()->getMailerFrom();
    }

    /**
     * @return string
     */
    protected function getSchemaName() {
        return $this->getParameters()->get('schema');
    }

    /**
     * override to provide a default selectable list of recipients
     * @return ValueMapInterface|null
     */
    public function getRecipientsValueMap() {}

    /**
     * implement this to add custom recipients
     * @param EmailCommunication $email
     * @param string $customRecipient
     */
    protected function addCustomRecipientToEmail(EmailCommunication $email, $customRecipient) {}

}
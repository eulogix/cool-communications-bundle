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

/**
 * @author Pietro Baricco <pietro@eulogix.com>
 */

use Eulogix\AppModules\Communications\Communication;
use Eulogix\AppModules\Communications\CommunicationQuery;
use Eulogix\Cool\Bundle\CommunicationsBundle\Lib\Imp\EmailCommunication;
use Eulogix\Cool\Lib\Cool;
use Eulogix\Cool\Lib\DataSource\CoolCrudDataSource;
use Eulogix\Cool\Lib\DataSource\CoolValueMap;
use Eulogix\Cool\Lib\Form\DSCRUDForm;
use Eulogix\Cool\Lib\Form\Field\FieldInterface;
use Eulogix\Lib\Email\EmailUtils;

class EmailEditorForm extends DSCRUDForm  {

    public function __construct($parameters = [])
    {
        parent::__construct($parameters);

        if($schema = $this->getSchemaName())
            Cool::getInstance()->getSchema('communications')->setCurrentSchema($schema);

        $ds = CoolCrudDataSource::fromSchemaAndTable('communications','communication');
        $this->setDataSource($ds->build());
    }

    /**
     * @inheritdoc
     */
    public function build() {
        parent::build();

        $loggedUser = Cool::getInstance()->getLoggedUser();

        $this->removeField('save');

        foreach($this->getFields() as $field) {
            /** @var FieldInterface $field */
            $field->setReadOnly(true);
        }

        $lastMessage = $this->getCommunication()->getLastCommunicationInThread();

        $this->addFieldTextBox("to_emails");

        $this->addFieldTextBox('reply_subject')->setValue( $lastMessage->getSubject() );
        $this->addFieldHTMLEditor('reply_body')->setNotNull();
        $this->addFieldFile("attachments")->setMultiple(true);

        $this->addFieldButton('reply')->setOnClick("widget.callAction('reply')");
        $this->addFieldButton('cancel')->setOnClick("widget.containerWindow.onClose()");

        $this->getServerAttributes()->set("authorUser", $loggedUser->getAccount());
        $this->getServerAttributes()->set("lastMessage", $lastMessage );
        $this->getServerAttributes()->set("actualSchema", $this->getSchemaName() );

        $this->getServerAttributes()->set("randomId", $rid = rand(9999,999999) );

        $this->addCommandJs("widget.scrollToMe(500, dojo.byId('$rid'));", 1000);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return "COOL_COMMUNICATIONS_EMAIL_EDITOR";
    }


    public function onReply() {
        $parameters = $this->request->all();
        $this->rawFill( $parameters );

        if( $this->validate()) {

            $connection = Cool::getInstance()->getSchema('communications')->getConnection();
            $connection->beginTransaction();

            try {

                $lastMessage = $this->getCommunication()->getLastCommunicationInThread();

                $email = new EmailCommunication();

                $email->setSubject( $parameters['reply_subject'] )
                      ->setBody( $parameters['reply_body'] )
                      ->getCommunication()->setThreadCommunicationId($lastMessage->getThreadCommunicationId());


                $email->addRecipient($lastMessage->getSender()->getEmail());

                $toEmails = EmailUtils::extractAllValidEmailAddressesFrom( $parameters['to_emails'] );
                foreach($toEmails as $recipientEmail) {
                    $email->addRecipient($recipientEmail);
                }

                if($email->getCommunication()->countCommunicationActors() > 0) {

                    $email->saveAndAddHiddenTrackingCode();

                    if( $email->send( Cool::getInstance()->getFactory()->getMailer(), $this->getSender() ) > 0) {
                        $this->addMessageInfo("Message sent.");
                    } else $this->addMessageError("Could not send message.");

                    if($f =  $this->getField('attachments')->getUploadedFiles()) {
                        foreach ($f as $file)
                            $email->addAttachment($file);
                    }
                } else $this->addMessageError("Provide at least one recipient.");

                $this->build()->configure();

                $this->addCommandJs("widget.openerLister.reloadRows(true)");

            } catch(\Exception $e) {

                $this->addMessageError($e->getMessage());
                $connection->rollBack();
            }

        $connection->commit();

        } else {
            $this->addMessageError("NOT VALIDATED");
        }

    }

    /**
     * @return Communication
     */
    private function getCommunication()
    {
        return CommunicationQuery::create()->findPk($this->getDSRecord()->get('communication_id'));
    }

    public function getLayout() {

        return "{% include '@CoolCommunicationsWidgets/templates/displayThread.html.twig' with {'lastMessage':serverAttributes.lastMessage} %}
                {% include '@CoolCommunicationsWidgets/templates/replyMessage.html.twig' %}";
    }

    /**
     * @return string
     */
    protected function getSchemaName() {
        return $this->getParameters()->get('schema');
    }

    /**
     * @return string
     */
    protected function getSender()
    {
        return Cool::getInstance()->getFactory()->getEmailFactory()->getMailerFrom();
    }
}
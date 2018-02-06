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

use Eulogix\Cool\Bundle\CommunicationsBundle\Lib\DataSource\CommunicationsDataSource;
use Eulogix\Cool\Lib\Cool;
use Eulogix\Cool\Lib\Form\DSCRUDForm;
use Eulogix\Cool\Lib\Widget\WidgetSlot;

/**
 * @author Pietro Baricco <pietro@eulogix.com>
 */

class CommunicationEditorForm extends DSCRUDForm  {

    public function __construct($parameters = [])
    {
        parent::__construct($parameters);

        if($schema = @$parameters['schema'])
            Cool::getInstance()->getSchema('communications')->setCurrentSchema($schema);

        $this->setUpDs();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return "COOL_COMMUNICATION_EDITOR";
    }

    public function setUpDs() {
        $ds = new CommunicationsDataSource();
        $this->setDataSource( $ds->build() );
    }

    /**
     * @inheritdoc
     */
    public function build() {
        parent::build();

        $schema =  Cool::getInstance()->getSchema('communications')->getName();
        $actualSchema = Cool::getInstance()->getSchema('communications')->getCurrentSchema();
        $dsRecord = $this->getDSRecord();

        if(!$dsRecord->isNew()) {

            $pk = $dsRecord->get('communication_id');
            $filter = json_encode([ 'communication_id' => $pk ]);

            $this->setSlot("Actors", new WidgetSlot("EulogixCoolCommunications/CommunicationActorsLister", [
                'schema'=> $actualSchema,
                '_filter'=>$filter]), "Actors");

            $this->setSlot("Files", new WidgetSlot("Eulogix/Cool/Lib/File/FileRepositoryBrowser", [
                'repositoryId'=>'schema',
                'schema'=>$schema,
                'actualSchema'=>$actualSchema,
                'table'=>'communication',
                'pk'=>$pk
            ],[
                'cssHeight'=>'100%',
                'treePaneVisible'=>false,
                'defaultView'=>'list'
            ]), "Files");

        }

        return $this;
    }
}
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

use Eulogix\Cool\Bundle\CommunicationsBundle\Lib\DataSource\CommunicationActorsDataSource;
use Eulogix\Cool\Lib\Cool;
use Eulogix\Cool\Lib\Lister\Lister;

class CommunicationActorsLister extends Lister {

    public function __construct($parameters = [])
    {
        parent::__construct($parameters);

        if($schema = @$parameters['schema'])
            Cool::getInstance()->getSchema('communications')->setCurrentSchema($schema);

        $this->setUpDs();
    }

    public function getDefaultEditorServerId() {
        return 'EulogixCoolCommunications/CommunicationActorEditorForm';
    }

    public function build() {
        parent::build();
        $this->addAction('newItem')->setOnClick("widget.openNewRecordEditor();");
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return "COOL_COMMUNICATION_ACTORS_LISTER";
    }

    public function setUpDs() {
        $ds = new CommunicationActorsDataSource();
        $this->setDataSource( $ds->build() );
    }
}
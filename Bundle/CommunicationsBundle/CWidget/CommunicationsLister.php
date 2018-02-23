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
use Eulogix\Cool\Bundle\CommunicationsBundle\Lib\DataSource\CommunicationsDataSource;
use Eulogix\Cool\Lib\Cool;
use Eulogix\Cool\Lib\Lister\Lister;

class CommunicationsLister extends Lister {

    public function __construct($parameters = [])
    {
        parent::__construct($parameters);

        if($schema = $this->getSchemaName())
            Cool::getInstance()->getSchema('communications')->setCurrentSchema($schema);

        $this->setUpDs();
    }

    public function getDefaultEditorServerId() {
        return 'EulogixCoolCommunications/CommunicationEditorForm';
    }

    public function build() {
        $this->setHasVariableEditorServerId(true);
        parent::build();

        $this->setInitialSort([
            'communication_date' => self::SORT_DESC,
            'communication_id' => self::SORT_DESC
        ]);

        $this->addAction('new Email')->setOnClick("var d = COOL.getDialogManager().openWidgetDialog('EulogixCoolCommunications/NewEmailWizard', 'new Email', { schema:'{$this->getSchemaName()}' }, function() { widget.reloadRows(); } ); d.set('dimensions', [400, 200]); d.resize();");

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return "COOL_COMMUNICATIONS_LISTER";
    }

    public function setUpDs() {
        $ds = new CommunicationsDataSource();
        $this->setDataSource( $ds->build() );
    }

    public function getEditorServerId($editorWidgetParameters=null, $rowData=null) {
        switch(@$rowData['category']) {
            case Communication::CATEGORY_EMAIL : return 'EulogixCoolCommunications/EmailEditorForm';
        }
        return $this->getDefaultEditorServerId();
    }

    /**
     * @return string
     */
    protected function getSchemaName() {
        return $this->getParameters()->get('schema');
    }
}
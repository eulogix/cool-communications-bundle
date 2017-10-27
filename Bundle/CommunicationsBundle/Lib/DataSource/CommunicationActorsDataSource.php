<?php

/*
 * This file is part of the Eulogix\Cool package.
 *
 * (c) Eulogix <http://www.eulogix.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace Eulogix\Cool\Bundle\CommunicationsBundle\Lib\DataSource;

use Eulogix\Cool\Lib\DataSource\CoolCrudDataSource as CD;
use Eulogix\Cool\Lib\DataSource\CoolCrudTableRelation as Rel;

/**
 * @author Pietro Baricco <pietro@eulogix.com>
 */

class CommunicationActorsDataSource extends CD {

    public function __construct()
    {
        return parent::__construct('communications', [
            CD::PARAM_TABLE_RELATIONS=>[

                Rel::build()
                    ->setTable('communication_actor')
                    ->setDeleteFlag(true)
            ]
        ]);
    }

}

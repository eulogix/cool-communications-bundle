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

/**
 * @author Pietro Baricco <pietro@eulogix.com>
 */

abstract class BaseCommunicationImp
{

    /**
     * @var Communication
     */
    protected $communication;

    /**
     * BaseCommunicationImp constructor.
     * @param Communication|null $communication
     */
    public function __construct(Communication $communication = null)
    {
        $this->communication = $communication;
    }

    /**
     * @return Communication
     */
    public function getCommunication()
    {
        $c = $this->communication ?? $this->communication = new Communication();
        $c->setCategory( $this->getCategory() );
        return $c;
    }

    /**
     * @return string
     */
    public abstract function getCategory();

}
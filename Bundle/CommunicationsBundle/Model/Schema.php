<?php

namespace Eulogix\Cool\Bundle\CommunicationsBundle\Model;

class Schema extends \Eulogix\Cool\Lib\Database\Schema {

    /**
     * this function is overridden with a fixed value as if done otherwise, there is the possibility that with only one
     * project (eg in test env) the dictionary and views would be generated badly (as if the schema was not multi tenant)
     * @return bool
     */
    public function isMultiTenant()
    {
        return true;
    }

}

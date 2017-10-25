<?php

namespace Eulogix\Cool\Bundle\CommunicationsBundle\Model;

class BaseDictionary extends \Eulogix\Cool\Lib\Dictionary\Dictionary {

    /*
    Don't modify this class, use the overridable descendant instead    
    */

    public function getSettings() {
        return array (
  'tables' => 
  array (
    'communication' => 
    array (
      'attributes' => 
      array (
        'propelModelNamespace' => 'Eulogix\\Cool\\Bundle\\CommunicationsBundle\\Model\\Communication',
        'propelPeerNamespace' => 'Eulogix\\Cool\\Bundle\\CommunicationsBundle\\Model\\CommunicationPeer',
        'propelQueryNamespace' => 'Eulogix\\Cool\\Bundle\\CommunicationsBundle\\Model\\CommunicationQuery',
        'schema' => NULL,
        'rawname' => 'communication',
        'editable' => true,
      ),
      'columns' => 
      array (
        'communication_id' => 
        array (
          'attributes' => 
          array (
          ),
        ),
        'category' => 
        array (
          'attributes' => 
          array (
          ),
          'control' => 
          array (
            'type' => 'select',
          ),
          'lookup' => 
          array (
            'type' => 'enum',
            'validValues' => 'EMAIL,LETTER,SMS,FAX,OTHER',
          ),
        ),
        'type' => 
        array (
          'attributes' => 
          array (
          ),
          'control' => 
          array (
            'type' => 'select',
          ),
          'lookup' => 
          array (
            'type' => 'table',
            'domainName' => 'COMMUNICATION_TYPE',
          ),
        ),
        'subject' => 
        array (
          'attributes' => 
          array (
            'fts' => true,
          ),
        ),
        'body' => 
        array (
          'attributes' => 
          array (
            'fts' => true,
          ),
          'control' => 
          array (
            'type' => 'textarea',
          ),
        ),
        'sent_date' => 
        array (
          'attributes' => 
          array (
          ),
        ),
        'received_date' => 
        array (
          'attributes' => 
          array (
          ),
        ),
        'transmission_method' => 
        array (
          'attributes' => 
          array (
          ),
          'control' => 
          array (
            'type' => 'select',
          ),
          'lookup' => 
          array (
            'type' => 'table',
            'domainName' => 'TRANSMISSION_METHOD',
          ),
        ),
        'target' => 
        array (
          'attributes' => 
          array (
            'fts' => true,
          ),
        ),
        'inbound_flag' => 
        array (
          'attributes' => 
          array (
          ),
        ),
      ),
    ),
  ),
  'views' => 
  array (
  ),
);
    }
    
    /** returns the schema name **/
    public function getSchemaName() {
        return  'communications';
    }
    
    public function getProjectDir() {
        return  '@EulogixCoolCommunicationsBundle/Resources/databases/communications';
    }
       
}
<?php

namespace Eulogix\Cool\Bundle\CommunicationsBundle\Model\map;

use \RelationMap;


/**
 * This class defines the structure of the 'communication' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.vendor.eulogix.cool-communications-bundle.Bundle.CommunicationsBundle.Model.map
 */
class CommunicationTableMap extends \Eulogix\Cool\Lib\Database\Propel\CoolTableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'vendor.eulogix.cool-communications-bundle.Bundle.CommunicationsBundle.Model.map.CommunicationTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('communication');
        $this->setPhpName('Communication');
        $this->setClassname('Eulogix\\Cool\\Bundle\\CommunicationsBundle\\Model\\Communication');
        $this->setPackage('vendor.eulogix.cool-communications-bundle.Bundle.CommunicationsBundle.Model');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('communication_communication_id_seq');
        // columns
        $this->addPrimaryKey('communication_id', 'CommunicationId', 'INTEGER', true, null, null);
        $this->addColumn('category', 'Category', 'LONGVARCHAR', false, null, null);
        $this->addColumn('type', 'Type', 'LONGVARCHAR', false, null, null);
        $this->addColumn('subject', 'Subject', 'LONGVARCHAR', false, null, null);
        $this->addColumn('body', 'Body', 'LONGVARCHAR', false, null, null);
        $this->addColumn('sent_date', 'SentDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('received_date', 'ReceivedDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('transmission_method', 'TransmissionMethod', 'LONGVARCHAR', false, null, null);
        $this->addColumn('target', 'Target', 'LONGVARCHAR', false, null, null);
        $this->addColumn('inbound_flag', 'InboundFlag', 'BOOLEAN', true, null, false);
        $this->addColumn('ext', 'Ext', 'LONGVARCHAR', false, null, null);
        $this->addColumn('creation_date', 'CreationDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('update_date', 'UpdateDate', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('creation_user_id', 'CreationUserId', 'INTEGER', 'core.account', 'account_id', false, null, null);
        $this->addForeignKey('update_user_id', 'UpdateUserId', 'INTEGER', 'core.account', 'account_id', false, null, null);
        $this->addColumn('record_version', 'RecordVersion', 'INTEGER', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AccountRelatedByCreationUserId', 'Eulogix\\Cool\\Bundle\\CoreBundle\\Model\\Core\\Account', RelationMap::MANY_TO_ONE, array('creation_user_id' => 'account_id', ), 'RESTRICT', null);
        $this->addRelation('AccountRelatedByUpdateUserId', 'Eulogix\\Cool\\Bundle\\CoreBundle\\Model\\Core\\Account', RelationMap::MANY_TO_ONE, array('update_user_id' => 'account_id', ), 'RESTRICT', null);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'extendable' =>  array (
  'container_column' => 'ext',
),
            'auditable' =>  array (
  'create_column' => 'creation_date',
  'created_by_column' => 'creation_user_id',
  'update_column' => 'update_date',
  'updated_by_column' => 'update_user_id',
  'version_column' => 'record_version',
  'target' => 'EulogixCoolCommunicationsBundle/communications',
),
            'notifier' =>  array (
  'channel' => NULL,
  'per_row' => false,
  'schema' => 'communications',
  'target' => 'EulogixCoolCommunicationsBundle/communications',
),
        );
    } // getBehaviors()

} // CommunicationTableMap

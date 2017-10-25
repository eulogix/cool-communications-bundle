<?php

namespace Eulogix\Cool\Bundle\CommunicationsBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Eulogix\Cool\Bundle\CommunicationsBundle\Model\Communication;
use Eulogix\Cool\Bundle\CommunicationsBundle\Model\CommunicationPeer;
use Eulogix\Cool\Bundle\CommunicationsBundle\Model\CommunicationQuery;
use Eulogix\Cool\Bundle\CoreBundle\Model\Core\Account;

/**
 * @method CommunicationQuery orderByCommunicationId($order = Criteria::ASC) Order by the communication_id column
 * @method CommunicationQuery orderByCategory($order = Criteria::ASC) Order by the category column
 * @method CommunicationQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method CommunicationQuery orderBySubject($order = Criteria::ASC) Order by the subject column
 * @method CommunicationQuery orderByBody($order = Criteria::ASC) Order by the body column
 * @method CommunicationQuery orderBySentDate($order = Criteria::ASC) Order by the sent_date column
 * @method CommunicationQuery orderByReceivedDate($order = Criteria::ASC) Order by the received_date column
 * @method CommunicationQuery orderByTransmissionMethod($order = Criteria::ASC) Order by the transmission_method column
 * @method CommunicationQuery orderByTarget($order = Criteria::ASC) Order by the target column
 * @method CommunicationQuery orderByInboundFlag($order = Criteria::ASC) Order by the inbound_flag column
 * @method CommunicationQuery orderByExt($order = Criteria::ASC) Order by the ext column
 * @method CommunicationQuery orderByCreationDate($order = Criteria::ASC) Order by the creation_date column
 * @method CommunicationQuery orderByUpdateDate($order = Criteria::ASC) Order by the update_date column
 * @method CommunicationQuery orderByCreationUserId($order = Criteria::ASC) Order by the creation_user_id column
 * @method CommunicationQuery orderByUpdateUserId($order = Criteria::ASC) Order by the update_user_id column
 * @method CommunicationQuery orderByRecordVersion($order = Criteria::ASC) Order by the record_version column
 *
 * @method CommunicationQuery groupByCommunicationId() Group by the communication_id column
 * @method CommunicationQuery groupByCategory() Group by the category column
 * @method CommunicationQuery groupByType() Group by the type column
 * @method CommunicationQuery groupBySubject() Group by the subject column
 * @method CommunicationQuery groupByBody() Group by the body column
 * @method CommunicationQuery groupBySentDate() Group by the sent_date column
 * @method CommunicationQuery groupByReceivedDate() Group by the received_date column
 * @method CommunicationQuery groupByTransmissionMethod() Group by the transmission_method column
 * @method CommunicationQuery groupByTarget() Group by the target column
 * @method CommunicationQuery groupByInboundFlag() Group by the inbound_flag column
 * @method CommunicationQuery groupByExt() Group by the ext column
 * @method CommunicationQuery groupByCreationDate() Group by the creation_date column
 * @method CommunicationQuery groupByUpdateDate() Group by the update_date column
 * @method CommunicationQuery groupByCreationUserId() Group by the creation_user_id column
 * @method CommunicationQuery groupByUpdateUserId() Group by the update_user_id column
 * @method CommunicationQuery groupByRecordVersion() Group by the record_version column
 *
 * @method CommunicationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CommunicationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CommunicationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CommunicationQuery leftJoinAccountRelatedByCreationUserId($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccountRelatedByCreationUserId relation
 * @method CommunicationQuery rightJoinAccountRelatedByCreationUserId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccountRelatedByCreationUserId relation
 * @method CommunicationQuery innerJoinAccountRelatedByCreationUserId($relationAlias = null) Adds a INNER JOIN clause to the query using the AccountRelatedByCreationUserId relation
 *
 * @method CommunicationQuery leftJoinAccountRelatedByUpdateUserId($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccountRelatedByUpdateUserId relation
 * @method CommunicationQuery rightJoinAccountRelatedByUpdateUserId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccountRelatedByUpdateUserId relation
 * @method CommunicationQuery innerJoinAccountRelatedByUpdateUserId($relationAlias = null) Adds a INNER JOIN clause to the query using the AccountRelatedByUpdateUserId relation
 *
 * @method Communication findOne(PropelPDO $con = null) Return the first Communication matching the query
 * @method Communication findOneOrCreate(PropelPDO $con = null) Return the first Communication matching the query, or a new Communication object populated from the query conditions when no match is found
 *
 * @method Communication findOneByCategory(string $category) Return the first Communication filtered by the category column
 * @method Communication findOneByType(string $type) Return the first Communication filtered by the type column
 * @method Communication findOneBySubject(string $subject) Return the first Communication filtered by the subject column
 * @method Communication findOneByBody(string $body) Return the first Communication filtered by the body column
 * @method Communication findOneBySentDate(string $sent_date) Return the first Communication filtered by the sent_date column
 * @method Communication findOneByReceivedDate(string $received_date) Return the first Communication filtered by the received_date column
 * @method Communication findOneByTransmissionMethod(string $transmission_method) Return the first Communication filtered by the transmission_method column
 * @method Communication findOneByTarget(string $target) Return the first Communication filtered by the target column
 * @method Communication findOneByInboundFlag(boolean $inbound_flag) Return the first Communication filtered by the inbound_flag column
 * @method Communication findOneByExt(string $ext) Return the first Communication filtered by the ext column
 * @method Communication findOneByCreationDate(string $creation_date) Return the first Communication filtered by the creation_date column
 * @method Communication findOneByUpdateDate(string $update_date) Return the first Communication filtered by the update_date column
 * @method Communication findOneByCreationUserId(int $creation_user_id) Return the first Communication filtered by the creation_user_id column
 * @method Communication findOneByUpdateUserId(int $update_user_id) Return the first Communication filtered by the update_user_id column
 * @method Communication findOneByRecordVersion(int $record_version) Return the first Communication filtered by the record_version column
 *
 * @method array findByCommunicationId(int $communication_id) Return Communication objects filtered by the communication_id column
 * @method array findByCategory(string $category) Return Communication objects filtered by the category column
 * @method array findByType(string $type) Return Communication objects filtered by the type column
 * @method array findBySubject(string $subject) Return Communication objects filtered by the subject column
 * @method array findByBody(string $body) Return Communication objects filtered by the body column
 * @method array findBySentDate(string $sent_date) Return Communication objects filtered by the sent_date column
 * @method array findByReceivedDate(string $received_date) Return Communication objects filtered by the received_date column
 * @method array findByTransmissionMethod(string $transmission_method) Return Communication objects filtered by the transmission_method column
 * @method array findByTarget(string $target) Return Communication objects filtered by the target column
 * @method array findByInboundFlag(boolean $inbound_flag) Return Communication objects filtered by the inbound_flag column
 * @method array findByExt(string $ext) Return Communication objects filtered by the ext column
 * @method array findByCreationDate(string $creation_date) Return Communication objects filtered by the creation_date column
 * @method array findByUpdateDate(string $update_date) Return Communication objects filtered by the update_date column
 * @method array findByCreationUserId(int $creation_user_id) Return Communication objects filtered by the creation_user_id column
 * @method array findByUpdateUserId(int $update_user_id) Return Communication objects filtered by the update_user_id column
 * @method array findByRecordVersion(int $record_version) Return Communication objects filtered by the record_version column
 */
abstract class BaseCommunicationQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCommunicationQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'cool_db';
        }
        if (null === $modelName) {
            $modelName = 'Eulogix\\Cool\\Bundle\\CommunicationsBundle\\Model\\Communication';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CommunicationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CommunicationQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CommunicationQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CommunicationQuery) {
            return $criteria;
        }
        $query = new CommunicationQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Communication|Communication[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CommunicationPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CommunicationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Communication A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByCommunicationId($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Communication A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT communication_id, category, type, subject, body, sent_date, received_date, transmission_method, target, inbound_flag, ext, creation_date, update_date, creation_user_id, update_user_id, record_version FROM communication WHERE communication_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Communication();
            $obj->hydrate($row);
            CommunicationPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Communication|Communication[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Communication[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Find objects by primary key while maintaining the original sort order of the keys
     * <code>
     * $objs = $c->findPksKeepingKeyOrder(array(12, 56, 832), $con); STUOCAZZO
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return Communication[]
     */
    public function findPksKeepingKeyOrder($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $ret = array();

        foreach($keys as $key)
            $ret[ $key ] = $this->findPk($key, $con);

        return $ret;
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CommunicationPeer::COMMUNICATION_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CommunicationPeer::COMMUNICATION_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the communication_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCommunicationId(1234); // WHERE communication_id = 1234
     * $query->filterByCommunicationId(array(12, 34)); // WHERE communication_id IN (12, 34)
     * $query->filterByCommunicationId(array('min' => 12)); // WHERE communication_id >= 12
     * $query->filterByCommunicationId(array('max' => 12)); // WHERE communication_id <= 12
     * </code>
     *
     * @param     mixed $communicationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByCommunicationId($communicationId = null, $comparison = null)
    {
        if (is_array($communicationId)) {
            $useMinMax = false;
            if (isset($communicationId['min'])) {
                $this->addUsingAlias(CommunicationPeer::COMMUNICATION_ID, $communicationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($communicationId['max'])) {
                $this->addUsingAlias(CommunicationPeer::COMMUNICATION_ID, $communicationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::COMMUNICATION_ID, $communicationId, $comparison);
    }

    /**
     * Filter the query on the category column
     *
     * Example usage:
     * <code>
     * $query->filterByCategory('fooValue');   // WHERE category = 'fooValue'
     * $query->filterByCategory('%fooValue%'); // WHERE category LIKE '%fooValue%'
     * </code>
     *
     * @param     string $category The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByCategory($category = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($category)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $category)) {
                $category = str_replace('*', '%', $category);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::CATEGORY, $category, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%'); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type)) {
                $type = str_replace('*', '%', $type);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the subject column
     *
     * Example usage:
     * <code>
     * $query->filterBySubject('fooValue');   // WHERE subject = 'fooValue'
     * $query->filterBySubject('%fooValue%'); // WHERE subject LIKE '%fooValue%'
     * </code>
     *
     * @param     string $subject The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterBySubject($subject = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subject)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $subject)) {
                $subject = str_replace('*', '%', $subject);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::SUBJECT, $subject, $comparison);
    }

    /**
     * Filter the query on the body column
     *
     * Example usage:
     * <code>
     * $query->filterByBody('fooValue');   // WHERE body = 'fooValue'
     * $query->filterByBody('%fooValue%'); // WHERE body LIKE '%fooValue%'
     * </code>
     *
     * @param     string $body The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByBody($body = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($body)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $body)) {
                $body = str_replace('*', '%', $body);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::BODY, $body, $comparison);
    }

    /**
     * Filter the query on the sent_date column
     *
     * Example usage:
     * <code>
     * $query->filterBySentDate('2011-03-14'); // WHERE sent_date = '2011-03-14'
     * $query->filterBySentDate('now'); // WHERE sent_date = '2011-03-14'
     * $query->filterBySentDate(array('max' => 'yesterday')); // WHERE sent_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $sentDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterBySentDate($sentDate = null, $comparison = null)
    {
        if (is_array($sentDate)) {
            $useMinMax = false;
            if (isset($sentDate['min'])) {
                $this->addUsingAlias(CommunicationPeer::SENT_DATE, $sentDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sentDate['max'])) {
                $this->addUsingAlias(CommunicationPeer::SENT_DATE, $sentDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::SENT_DATE, $sentDate, $comparison);
    }

    /**
     * Filter the query on the received_date column
     *
     * Example usage:
     * <code>
     * $query->filterByReceivedDate('2011-03-14'); // WHERE received_date = '2011-03-14'
     * $query->filterByReceivedDate('now'); // WHERE received_date = '2011-03-14'
     * $query->filterByReceivedDate(array('max' => 'yesterday')); // WHERE received_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $receivedDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByReceivedDate($receivedDate = null, $comparison = null)
    {
        if (is_array($receivedDate)) {
            $useMinMax = false;
            if (isset($receivedDate['min'])) {
                $this->addUsingAlias(CommunicationPeer::RECEIVED_DATE, $receivedDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($receivedDate['max'])) {
                $this->addUsingAlias(CommunicationPeer::RECEIVED_DATE, $receivedDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::RECEIVED_DATE, $receivedDate, $comparison);
    }

    /**
     * Filter the query on the transmission_method column
     *
     * Example usage:
     * <code>
     * $query->filterByTransmissionMethod('fooValue');   // WHERE transmission_method = 'fooValue'
     * $query->filterByTransmissionMethod('%fooValue%'); // WHERE transmission_method LIKE '%fooValue%'
     * </code>
     *
     * @param     string $transmissionMethod The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByTransmissionMethod($transmissionMethod = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($transmissionMethod)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $transmissionMethod)) {
                $transmissionMethod = str_replace('*', '%', $transmissionMethod);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::TRANSMISSION_METHOD, $transmissionMethod, $comparison);
    }

    /**
     * Filter the query on the target column
     *
     * Example usage:
     * <code>
     * $query->filterByTarget('fooValue');   // WHERE target = 'fooValue'
     * $query->filterByTarget('%fooValue%'); // WHERE target LIKE '%fooValue%'
     * </code>
     *
     * @param     string $target The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByTarget($target = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($target)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $target)) {
                $target = str_replace('*', '%', $target);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::TARGET, $target, $comparison);
    }

    /**
     * Filter the query on the inbound_flag column
     *
     * Example usage:
     * <code>
     * $query->filterByInboundFlag(true); // WHERE inbound_flag = true
     * $query->filterByInboundFlag('yes'); // WHERE inbound_flag = true
     * </code>
     *
     * @param     boolean|string $inboundFlag The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByInboundFlag($inboundFlag = null, $comparison = null)
    {
        if (is_string($inboundFlag)) {
            $inboundFlag = in_array(strtolower($inboundFlag), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CommunicationPeer::INBOUND_FLAG, $inboundFlag, $comparison);
    }

    /**
     * Filter the query on the ext column
     *
     * Example usage:
     * <code>
     * $query->filterByExt('fooValue');   // WHERE ext = 'fooValue'
     * $query->filterByExt('%fooValue%'); // WHERE ext LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ext The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByExt($ext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ext)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ext)) {
                $ext = str_replace('*', '%', $ext);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::EXT, $ext, $comparison);
    }

    /**
     * Filter the query on the creation_date column
     *
     * Example usage:
     * <code>
     * $query->filterByCreationDate('2011-03-14'); // WHERE creation_date = '2011-03-14'
     * $query->filterByCreationDate('now'); // WHERE creation_date = '2011-03-14'
     * $query->filterByCreationDate(array('max' => 'yesterday')); // WHERE creation_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $creationDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByCreationDate($creationDate = null, $comparison = null)
    {
        if (is_array($creationDate)) {
            $useMinMax = false;
            if (isset($creationDate['min'])) {
                $this->addUsingAlias(CommunicationPeer::CREATION_DATE, $creationDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($creationDate['max'])) {
                $this->addUsingAlias(CommunicationPeer::CREATION_DATE, $creationDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::CREATION_DATE, $creationDate, $comparison);
    }

    /**
     * Filter the query on the update_date column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateDate('2011-03-14'); // WHERE update_date = '2011-03-14'
     * $query->filterByUpdateDate('now'); // WHERE update_date = '2011-03-14'
     * $query->filterByUpdateDate(array('max' => 'yesterday')); // WHERE update_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $updateDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByUpdateDate($updateDate = null, $comparison = null)
    {
        if (is_array($updateDate)) {
            $useMinMax = false;
            if (isset($updateDate['min'])) {
                $this->addUsingAlias(CommunicationPeer::UPDATE_DATE, $updateDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updateDate['max'])) {
                $this->addUsingAlias(CommunicationPeer::UPDATE_DATE, $updateDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::UPDATE_DATE, $updateDate, $comparison);
    }

    /**
     * Filter the query on the creation_user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCreationUserId(1234); // WHERE creation_user_id = 1234
     * $query->filterByCreationUserId(array(12, 34)); // WHERE creation_user_id IN (12, 34)
     * $query->filterByCreationUserId(array('min' => 12)); // WHERE creation_user_id >= 12
     * $query->filterByCreationUserId(array('max' => 12)); // WHERE creation_user_id <= 12
     * </code>
     *
     * @see       filterByAccountRelatedByCreationUserId()
     *
     * @param     mixed $creationUserId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByCreationUserId($creationUserId = null, $comparison = null)
    {
        if (is_array($creationUserId)) {
            $useMinMax = false;
            if (isset($creationUserId['min'])) {
                $this->addUsingAlias(CommunicationPeer::CREATION_USER_ID, $creationUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($creationUserId['max'])) {
                $this->addUsingAlias(CommunicationPeer::CREATION_USER_ID, $creationUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::CREATION_USER_ID, $creationUserId, $comparison);
    }

    /**
     * Filter the query on the update_user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateUserId(1234); // WHERE update_user_id = 1234
     * $query->filterByUpdateUserId(array(12, 34)); // WHERE update_user_id IN (12, 34)
     * $query->filterByUpdateUserId(array('min' => 12)); // WHERE update_user_id >= 12
     * $query->filterByUpdateUserId(array('max' => 12)); // WHERE update_user_id <= 12
     * </code>
     *
     * @see       filterByAccountRelatedByUpdateUserId()
     *
     * @param     mixed $updateUserId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByUpdateUserId($updateUserId = null, $comparison = null)
    {
        if (is_array($updateUserId)) {
            $useMinMax = false;
            if (isset($updateUserId['min'])) {
                $this->addUsingAlias(CommunicationPeer::UPDATE_USER_ID, $updateUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updateUserId['max'])) {
                $this->addUsingAlias(CommunicationPeer::UPDATE_USER_ID, $updateUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::UPDATE_USER_ID, $updateUserId, $comparison);
    }

    /**
     * Filter the query on the record_version column
     *
     * Example usage:
     * <code>
     * $query->filterByRecordVersion(1234); // WHERE record_version = 1234
     * $query->filterByRecordVersion(array(12, 34)); // WHERE record_version IN (12, 34)
     * $query->filterByRecordVersion(array('min' => 12)); // WHERE record_version >= 12
     * $query->filterByRecordVersion(array('max' => 12)); // WHERE record_version <= 12
     * </code>
     *
     * @param     mixed $recordVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function filterByRecordVersion($recordVersion = null, $comparison = null)
    {
        if (is_array($recordVersion)) {
            $useMinMax = false;
            if (isset($recordVersion['min'])) {
                $this->addUsingAlias(CommunicationPeer::RECORD_VERSION, $recordVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($recordVersion['max'])) {
                $this->addUsingAlias(CommunicationPeer::RECORD_VERSION, $recordVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommunicationPeer::RECORD_VERSION, $recordVersion, $comparison);
    }

    /**
     * Filter the query by a related Account object
     *
     * @param   Account|PropelObjectCollection $account The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CommunicationQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAccountRelatedByCreationUserId($account, $comparison = null)
    {
        if ($account instanceof Account) {
            return $this
                ->addUsingAlias(CommunicationPeer::CREATION_USER_ID, $account->getAccountId(), $comparison);
        } elseif ($account instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommunicationPeer::CREATION_USER_ID, $account->toKeyValue('PrimaryKey', 'AccountId'), $comparison);
        } else {
            throw new PropelException('filterByAccountRelatedByCreationUserId() only accepts arguments of type Account or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AccountRelatedByCreationUserId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function joinAccountRelatedByCreationUserId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AccountRelatedByCreationUserId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'AccountRelatedByCreationUserId');
        }

        return $this;
    }

    /**
     * Use the AccountRelatedByCreationUserId relation Account object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Eulogix\Cool\Bundle\CoreBundle\Model\Core\AccountQuery A secondary query class using the current class as primary query
     */
    public function useAccountRelatedByCreationUserIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAccountRelatedByCreationUserId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccountRelatedByCreationUserId', '\Eulogix\Cool\Bundle\CoreBundle\Model\Core\AccountQuery');
    }

    /**
     * Filter the query by a related Account object
     *
     * @param   Account|PropelObjectCollection $account The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CommunicationQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAccountRelatedByUpdateUserId($account, $comparison = null)
    {
        if ($account instanceof Account) {
            return $this
                ->addUsingAlias(CommunicationPeer::UPDATE_USER_ID, $account->getAccountId(), $comparison);
        } elseif ($account instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommunicationPeer::UPDATE_USER_ID, $account->toKeyValue('PrimaryKey', 'AccountId'), $comparison);
        } else {
            throw new PropelException('filterByAccountRelatedByUpdateUserId() only accepts arguments of type Account or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AccountRelatedByUpdateUserId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function joinAccountRelatedByUpdateUserId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AccountRelatedByUpdateUserId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'AccountRelatedByUpdateUserId');
        }

        return $this;
    }

    /**
     * Use the AccountRelatedByUpdateUserId relation Account object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Eulogix\Cool\Bundle\CoreBundle\Model\Core\AccountQuery A secondary query class using the current class as primary query
     */
    public function useAccountRelatedByUpdateUserIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAccountRelatedByUpdateUserId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccountRelatedByUpdateUserId', '\Eulogix\Cool\Bundle\CoreBundle\Model\Core\AccountQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Communication $communication Object to remove from the list of results
     *
     * @return CommunicationQuery The current query, for fluid interface
     */
    public function prune($communication = null)
    {
        if ($communication) {
            $this->addUsingAlias(CommunicationPeer::COMMUNICATION_ID, $communication->getCommunicationId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // auditable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     CommunicationQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(CommunicationPeer::UPDATE_DATE, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     CommunicationQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(CommunicationPeer::UPDATE_DATE);
    }

    /**
     * Order by update date asc
     *
     * @return     CommunicationQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(CommunicationPeer::UPDATE_DATE);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     CommunicationQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(CommunicationPeer::CREATION_DATE, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     CommunicationQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(CommunicationPeer::CREATION_DATE);
    }

    /**
     * Order by create date asc
     *
     * @return     CommunicationQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(CommunicationPeer::CREATION_DATE);
    }
}

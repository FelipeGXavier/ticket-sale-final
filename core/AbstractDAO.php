<?php

namespace Core;

use Core\DatasourceConnection;

abstract class AbstractDAO
{

	protected $connection;
	protected $current;

	public function __construct(DatasourceConnection $datasource)
	{
		$this->connection = $datasource->getConnection();
	}

	public function raw($sql, $bind = [])
	{
		$this->current = $this->connection->prepare($sql);
		if (!empty($bind)) {
			$this->current->execute($bind);
		} else {
			$this->current->execute();
		}
		return $this;
	}

	public function fetch()
	{
		return $this->current->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getAffectedRows()
	{
		if ($this->current) {
			return $this->current->rowCount() ?? 0;
		}
		return null;
	}

	public function getInsertId()
	{
		return $this->connection->lastInsertId();
	}

	public function startTransaction()
	{
		$this->connection->beginTransaction();
	}

	public function rollback()
	{
		$this->connection->rollBack();
	}

	public function commit()
	{
		$this->connection->commit();
	}

	public function get()
	{
		return $this->current;
	}
}

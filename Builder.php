<?php

interface SqlBuilder {

    public function select(string $table, array $fields): SqlBuilder;

    public function where(string $field, string $value, string $operator = '='): SqlBuilder;

    public function limit(int $start, int $offset): SqlBuilder;

    public function getSql(): string;
}

class MysqlBuilder implements SqlBuilder {

    protected $query;

    public function reset(): void {

        $this->query = new \StdClass;
    }

    public function select(string $table, array $fields): SqlBuilder {

        $this->reset();

        $this->query->basic = "SELECT " . implode(', ', $fields) . " FROM " . $table;
        $this->query->type = 'select';

        return $this;
    }

    public function where(string $field, string $value, string $operator = '='): SqlBuilder {

        if (!in_array($this->query->type, ['select', 'update'])) {
            throw new Exception('Method WHERE can be used only after SELECT or UPDATE');
        }

        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    public function limit(int $start, int $offset): SqlBuilder {

        if (!in_array($this->query->type, ['select'])) {
            throw new Exception('Method LIMIT can be used only with SELECT');
        }

        $this->query->limit = " LIMIT " . $start . ", " . $offset;

        return $this;
    }

    public function getSql(): string {

        $query = $this->query;

        $sql = $query->basic;

        if (!empty($query->where)) {
            $sql .= ' WHERE ' . implode(' AND ', $query->where);
        }

        if (isset($query->limit)) {
            $sql .= $query->limit;
        }

        return $sql;
    }
}

class PgsqlBuilder extends MysqlBuilder {

	public function limit(int $start, int $offset): SqlBuilder {
		parent::limit($start, $offset);

		$this->query->limit = " LIMIT " . $start . " OFFSET " . $offset;

		return $this;
	}

}

function clientFunction(SqlBuilder $builder) {

    $result = $builder->select('user', ['name', 'phone', 'age'])
                      ->where('age', '25', '>')
                      ->where('name', 'John')
                      ->limit(40, 20)
                      ->getSql();
    echo '<p>' . $result . '</p>';
}

clientFunction(new MysqlBuilder);
clientFunction(new PgsqlBuilder);
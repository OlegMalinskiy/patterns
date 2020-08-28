<?php

class Original
{
    private string $info;

    public function __construct(string $data)
    {
        $this->info = $data;
        echo "<p>Original:Initialize object with property '{$this->info}'</p>";
    }

    public function changeInfo(string $data): void
    {
        $this->info = $data;
        echo "<p>Original:Change object property to '{$this->info}'</p>";
    }

    public function save(): Snapshot
    {
        return new SimpleSnapshot($this->info);
    }

    public function back(Snapshot $snapshot): void
    {
        $this->info = $snapshot->getInfo();
    }

}

interface Snapshot
{
    public function getName(): string;
    public function getDate(): string;
}

class SimpleSnapshot implements Snapshot
{
    private string $info;
    private DateTimeImmutable $date;

    public function __construct(string $data)
    {
        $this->info = $data;
        $this->date = new DateTimeImmutable();
    }

    public function getInfo(): string
    {
        return $this->info;
    }

    public function getName(): string
    {
        return sprintf("<: %s / %s :>", $this->info, $this->date->format('Y-m-d H:i:s'));
    }

    public function getDate(): string
    {
        return $this->date;
    }

}

class TakeCare
{
    private array $snapshots = [];
    private Original $original;

    public function __construct(Original $original)
    {
        $this->original = $original;
    }

    public function backup(): void
    {
        echo "<p>TakeCare: Create backup for Original:object...</p>";
        $this->snapshots[] = $this->original->save();
    }

    public function rollback(): void
    {
        if (empty($this->snapshots)) return;

        $snapshot = array_pop($this->snapshots);

        echo "<p>TakeCare: Rollback Original:object to state - {$snapshot->getName()}</p>";

        $this->original->back($snapshot);
    }

    public function showHistory(): void
    {
        echo "<p>TakeCare: All list of snapshots</p>";
        foreach ($this->snapshots as $snapshot) {
            echo "<p>" . $snapshot->getName() . "</p>";
        }
    }
}

$original = new Original("first state of Original");
$takecare = new TakeCare($original);

$takecare->backup();

$original->changeInfo("second state of Original");

$takecare->backup();

$original->changeInfo("third state of Original");

print_r($original);

echo "<p>I want to rollback state of object!</p>";

$takecare->rollback();

echo "<p>And one more time!</p>";

$takecare->rollback();

print_r($original);

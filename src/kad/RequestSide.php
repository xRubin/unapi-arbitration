<?php

namespace unapi\arbitration\kad;

class RequestSide implements RequestSideInterface
{
    /** @var string */
    private $name;
    /** @var int */
    private $type;
    /** @var bool */
    private $exactMatch;

    /**
     * RequestSide constructor.
     * @param string $name
     * @param int $type
     * @param bool $exactMatch
     s*/
    public function __construct(string $name, $type = self::TYPE_ANY, $exactMatch = false)
    {
        $this->name = $name;
        $this->type = $type;
        $this->exactMatch = $exactMatch;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isExactMatch(): bool
    {
        return $this->exactMatch;
    }
}
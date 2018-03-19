<?php

namespace unapi\arbitration\kad;

class RequestJudge implements RequestJudgeInterface
{
    /** @var string */
    private $id;

    /**
     * Judge constructor.
     * @param string $id
     */
    public function __construct(string $id = '*')
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
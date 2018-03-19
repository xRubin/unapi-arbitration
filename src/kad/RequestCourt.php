<?php

namespace unapi\arbitration\kad;

class RequestCourt implements RequestCourtInterface
{
    /** @var string */
    private $code;

    /**
     * RequestCourt constructor.
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}
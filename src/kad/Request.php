<?php

namespace unapi\arbitration\kad;

use DateTimeInterface;

class Request implements RequestInterface
{
    /** @var RequestSideInterface[] */
    private $sides = [];
    /** @var RequestJudgeInterface[] */
    private $judges = [];
    /** @var RequestCourtInterface[] */
    private $courts = [];
    /** @var string[] */
    private $caseNumbers = [];
    /** @var DateTimeInterface */
    private $dateFrom;
    /** @var DateTimeInterface */
    private $dateTo;

    /**
     * Request constructor.
     * @param DateTimeInterface $dateFrom
     * @param DateTimeInterface $dateTo
     */
    public function __construct(DateTimeInterface $dateFrom = null, DateTimeInterface $dateTo = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    /**
     * @return RequestSideInterface[]
     */
    public function getSides(): array
    {
        return $this->sides;
    }

    /**
     * @return RequestJudgeInterface[]
     */
    public function getJudges(): array
    {
        return $this->judges;
    }

    /**
     * @return RequestCourtInterface[]
     */
    public function getCourts(): array
    {
        return $this->courts;
    }

    /**
     * @return string[]
     */
    public function getCaseNumbers(): array
    {
        return $this->caseNumbers;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDateFrom(): ?DateTimeInterface
    {
        return $this->dateFrom;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDateTo(): ?DateTimeInterface
    {
        return $this->dateTo;
    }

    /**
     * @param RequestSideInterface $side
     * @return RequestInterface
     */
    public function addSide(RequestSideInterface $side): RequestInterface
    {
        $this->sides[] = $side;
        return $this;
    }

    /**
     * @param RequestJudgeInterface $judge
     * @return RequestInterface
     */
    public function addJudge(RequestJudgeInterface $judge): RequestInterface
    {
        $this->judges[] = $judge;
        return $this;
    }

    /**
     * @param RequestCourtInterface $court
     * @return RequestInterface
     */
    public function addCourt(RequestCourtInterface $court): RequestInterface
    {
        $this->courts[] = $court;
        return $this;
    }

    /**
     * @param string $caseNumber
     * @return RequestInterface
     */
    public function addCaseNumber(string $caseNumber): RequestInterface
    {
        $this->caseNumbers[] = $caseNumber;
        return $this;
    }
}
<?php

namespace unapi\arbitration\kad;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\RejectedPromise;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use unapi\interfaces\ServiceInterface;
use Psr\Log\NullLogger;

class Service implements ServiceInterface, LoggerAwareInterface
{
    /** @var ClientInterface */
    private $client;
    /** @var LoggerInterface */
    private $logger;

    const URL_SEARCH = '/Kad/SearchInstances';

    /**
     * @param array $config Service configuration settings.
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['client'])) {
            $this->client = new Client();
        } elseif ($config['client'] instanceof ClientInterface) {
            $this->client = $config['client'];
        } else {
            throw new \InvalidArgumentException('Client must be instance of ClientInterface');
        }

        if (!isset($config['logger'])) {
            $this->logger = new NullLogger();
        } elseif ($config['logger'] instanceof LoggerInterface) {
            $this->setLogger($config['logger']);
        } else {
            throw new \InvalidArgumentException('Logger must be instance of LoggerInterface');
        }
    }

    /**
     * @inheritdoc
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * @param RequestInterface $request
     * @return PromiseInterface
     */
    public function findCases(RequestInterface $request): PromiseInterface
    {
        return $this->sendSearchRequest($request)->then(function (ResponseInterface $response) {
            if ($response->getStatusCode() !== 200)
                return new RejectedPromise($response->getStatusCode());

            return $this->parseResult($response->getBody()->getContents());
        });
    }

    /**
     * @param RequestInterface $request
     * @return PromiseInterface
     */
    protected function sendSearchRequest(RequestInterface $request): PromiseInterface
    {
        return $this->getClient()->requestAsync('POST', self::URL_SEARCH, [
            'json' => [
                'Page' => 1,
                'Count' => 25,
                'Courts' => array_map(function (RequestCourtInterface $court) {
                    return $court->getCode();
                }, $request->getCourts()),
                'DateFrom' => $request->getDateFrom() ? $request->getDateFrom()->format('Y-m-d\TH:i:s') : null,
                'DateTo' => $request->getDateTo() ? $request->getDateTo()->format('Y-m-d\TH:i:s') : null,
                'Sides' => array_map(function (RequestSideInterface $side) {
                    return [
                        'Name' => $side->getName(),
                        'Type' => $side->getType(),
                        'ExactMatch' => $side->isExactMatch(),
                    ];
                }, $request->getSides()),
                'Judges' => array_map(function (RequestJudgeInterface $judge) {
                    return [
                        'JudgeId' => $judge->getId(),
                        'Type' => -1,
                    ];
                }, $request->getJudges()),
                'CaseNumbers' => $request->getCaseNumbers(),
                'WithVKSInstances' => false,
            ]
        ]);
    }

    /**
     * @param string $html
     * @return ResponseCase[]
     */
    protected function parseResult(string $html): array
    {
        $result = [];
        $dom = new \DOMDocument;
        $searchPage = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8");
        $dom->loadHTML($searchPage);
        /** @var \DOMElement $case */
        foreach ($dom->getElementsByTagName('tr') as $case) {
            $responseCase = new ResponseCase();
            $cases_list = $case->getElementsByTagName('td');
            /** @var \DOMElement $case_info_container */
            if ($case_info_container = $cases_list->item(0)) {
                /** @var \DOMElement $date_object */
                if ($date_object = $case_info_container->getElementsByTagName('span')->item(0)) {
                    $responseCase->setDate(\DateTime::createFromFormat('d.m.Y', trim($date_object->textContent)));
                }

                /** @var \DOMElement $link_object */
                if ($link_object = $case_info_container->getElementsByTagName('a')->item(0)) {
                    $href = $link_object->getAttribute('href');
                    $responseCase->setId(trim(substr($href, strrpos($href, "/") + 1)));
                    $responseCase->setNumber(trim($link_object->textContent));
                }

                /** @var \DOMElement $case_div_container */
                if ($case_div_container = $case_info_container->getElementsByTagName('div')->item(0)) {
                    /** @var \DOMElement $case_info_div */
                    $case_info_div = $case_div_container->getElementsByTagName('div')->item(0);
                    if ($div_class = $case_info_div->getAttribute('class')) {
                        $div_class = str_replace("_simple","",$div_class);
                        switch ($div_class) {
                            case "administrative" :
                                $responseCase->setType(ResponseCase::TYPE_ADMINISTRATIVE);
                                break;
                            case "bankruptcy" :
                                $responseCase->setType(ResponseCase::TYPE_BANKRUPTCY);
                                break;
                            case "civil" :
                                $responseCase->setType(ResponseCase::TYPE_CIVIL);
                                break;
                        }
                    }
                }
            }

            /** @var \DOMElement $court_info_container */
            if ($court_info_container = $cases_list->item(1)) {
                /** @var \DOMElement $main_court_object */
                if ($main_court_object = $court_info_container->getElementsByTagName('div')->item(0)) {
                    foreach ($main_court_object->getElementsByTagName('div') as $single_court_object) {
                        /** @var \DOMElement $single_court_object */
                        if (!$single_court_object->hasAttribute('class')) {
                            $responseCase->setCourtName(trim($single_court_object->textContent));
                            break;
                        }
                    }
                }
            }
            $result[] = $responseCase;
        }
        return $result;
    }
}
<?php

namespace Omnipay\ZaloPay\Support;

use JsonException;
use Symfony\Component\HttpFoundation\ParameterBag;

trait InputParameterBag {
    protected function getAllRequestData(): ParameterBag {
        $bag = new ParameterBag();

        $bag->add($this->httpRequest->attributes->all());
        $bag->add($this->httpRequest->request->all());
        $bag->add($this->httpRequest->query->all());

        //In case json body
        $jsonBody = $this->requestToArray($this->httpRequest);
        $bag->add($jsonBody);

        return $bag;
    }

    /**
     * Gets the request body decoded as array, typically from a JSON payload.
     *
     * @throws JsonException When the body cannot be decoded to an array
     */
    private function requestToArray($request): array
    {
        if ('' === $content = $request->getContent()) {
            throw new JsonException('Request body is empty.');
        }

        try {
            $content = json_decode($content, true, 512, \JSON_BIGINT_AS_STRING | \JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new JsonException('Could not decode request body.', $e->getCode(), $e);
        }

        if (!\is_array($content)) {
            throw new JsonException(sprintf('JSON content was expected to decode to an array, "%s" returned.', get_debug_type($content)));
        }

        return $content;
    }
}

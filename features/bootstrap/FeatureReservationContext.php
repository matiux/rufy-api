<?php

class FeatureReservationContext extends RestContext
{
    public function __construct($guzzleClient, $baseUrl)
    {
        parent::__construct($guzzleClient, $baseUrl);
    }
}

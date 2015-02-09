<?php namespace Rufy\RestApiBundle\Security\Authorization\Voter;


interface RufyVoterInterface {

    const VIEW      = 'VIEW';
    const EDIT      = 'EDIT';
    const CREATE    = 'CREATE';
    const DELETE    = 'DELETE';
    const LISTING   = 'LISTING';
}

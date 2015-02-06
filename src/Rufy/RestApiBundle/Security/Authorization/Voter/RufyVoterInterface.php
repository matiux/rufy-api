<?php namespace Rufy\RestApiBundle\Security\Authorization\Voter;


interface RufyVoterInterface {

    const VIEW      = 'view';
    const EDIT      = 'edit';
    const CREATE    = 'create';
    const DELETE    = 'delete';
    const LISTING   = 'listing';
}

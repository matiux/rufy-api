<?php namespace Rufy\RestApiBundle\Security\Authorization\Voter;

trait RufyVoterTrait {

    /**
     * Return an array of supported attributes. This will be called by supportsAttribute
     *
     * @return array an array of supported attributes, i.e. array('CREATE', 'READ')
     */
    protected function getSupportedAttributes()
    {
        return [
            self::CREATE,
            self::DELETE,
            self::EDIT,
            self::LISTING,
            self::VIEW,
        ];
    }
}

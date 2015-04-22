<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\CategorySetting;

class LoadCategorySetting extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $cat            = new CategorySetting();
        $cat->setName('Ristorante');
        $this->setReference('cat_set_ristorante', $cat);

        $cat            = new CategorySetting();
        $cat->setName('Servizi');
        $this->setReference('cat_set_servizi', $cat);

        $cat            = new CategorySetting();
        $cat->setName('Prenotazioni');
        $this->setReference('cat_set_prenotazioni', $cat);

        $cat            = new CategorySetting();
        $cat->setName('Sale');
        $this->setReference('cat_set_sale', $cat);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 80;
    }
}

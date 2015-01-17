<?php namespace Rufy\RestApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\Setting;

class LoadSetting extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $setting =      new Setting();
        $setting->setCategorySetting($this->getReference('cat_set_sale'));
        $setting->setRestaurant($this->getReference('restaurant'));
        $setting->setName('animali.ammessi');
        $setting->setLabel('Animali ammessi');
        $setting->setValue(1);
        $this->setReference('set_animali.ammessi', $setting);

        $setting =      new Setting();
        $setting->setCategorySetting($this->getReference('cat_set_ristorante'));
        $setting->setRestaurant($this->getReference('restaurant'));
        $setting->setName('telefono.obbligatorio');
        $setting->setLabel('Telefono obbligatorio');
        $setting->setValue(1);
        $this->setReference('set_telefono.obbligatorio', $setting);

        $manager->persist($setting);

        $setting =      new Setting();
        $setting->setCategorySetting($this->getReference('cat_set_prenotazioni'));
        $setting->setRestaurant($this->getReference('restaurant'));
        $setting->setName('nome.cognome.separati');
        $setting->setLabel('Nome e cognome separati');
        $setting->setValue(0);
        $this->setReference('set_nome.cognome.separati', $setting);

        $manager->persist($setting);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 90;
    }
}

<?php

namespace Jazzyweb\AulasMentor\NotasFrontendBundle\Fixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\Etiqueta;

class LoadEtiquetaData extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        $etiqueta = new Etiqueta();
        $etiqueta->setTexto('Notas');
        $etiqueta->setUsuario($this->getReference('alberto'));

        $manager->persist($etiqueta);
        $this->addReference('etiqueta1_alberto', $etiqueta);

        $etiqueta = new Etiqueta();
        $etiqueta->setTexto('Recordatorios');
        $etiqueta->setUsuario($this->getReference('alberto'));

        $manager->persist($etiqueta);
        $this->addReference('etiqueta2_alberto', $etiqueta);

        $etiqueta = new Etiqueta();
        $etiqueta->setTexto('Cumpleaños');
        $etiqueta->setUsuario($this->getReference('alberto'));

        $manager->persist($etiqueta);
        $this->addReference('etiqueta3_alberto', $etiqueta);

        $etiqueta = new Etiqueta();
        $etiqueta->setTexto('Cumpleaños');
        $etiqueta->setUsuario($this->getReference('isaac'));

        $manager->persist($etiqueta);
        $this->addReference('etiqueta1_isaac', $etiqueta);

        $etiqueta = new Etiqueta();
        $etiqueta->setTexto('Mis Cosas');
        $etiqueta->setUsuario($this->getReference('isaac'));

        $manager->persist($etiqueta);
        $this->addReference('etiqueta2_isaac', $etiqueta);

        $etiqueta = new Etiqueta();
        $etiqueta->setTexto('Top Secret');
        $etiqueta->setUsuario($this->getReference('isaac'));

        $manager->persist($etiqueta);
        $this->addReference('etiqueta3_isaac', $etiqueta);


        $etiqueta = new Etiqueta();
        $etiqueta->setTexto('Cumpleaños');
        $etiqueta->setUsuario($this->getReference('maria'));

        $manager->persist($etiqueta);
        $this->addReference('etiqueta1_maria', $etiqueta);

        $etiqueta = new Etiqueta();
        $etiqueta->setTexto('Mis Cosas');
        $etiqueta->setUsuario($this->getReference('maria'));

        $manager->persist($etiqueta);
        $this->addReference('etiqueta2_maria', $etiqueta);

        $etiqueta = new Etiqueta();
        $etiqueta->setTexto('Top Secret');
        $etiqueta->setUsuario($this->getReference('maria'));

        $manager->persist($etiqueta);
        $this->addReference('etiqueta3_maria', $etiqueta);


        $etiqueta = new Etiqueta();
        $etiqueta->setTexto('Cumpleaños');
        $etiqueta->setUsuario($this->getReference('maximo'));

        $manager->persist($etiqueta);
        $this->addReference('etiqueta1_maximo', $etiqueta);

        $etiqueta = new Etiqueta();
        $etiqueta->setTexto('Mis Cosas');
        $etiqueta->setUsuario($this->getReference('maximo'));

        $manager->persist($etiqueta);
        $this->addReference('etiqueta2_maximo', $etiqueta);

        $etiqueta = new Etiqueta();
        $etiqueta->setTexto('Top Secret');
        $etiqueta->setUsuario($this->getReference('maximo'));

        $manager->persist($etiqueta);
        $this->addReference('etiqueta3_maximo', $etiqueta);



        $manager->flush();
    }

    public function getOrder() {
        return 3;
    }

}
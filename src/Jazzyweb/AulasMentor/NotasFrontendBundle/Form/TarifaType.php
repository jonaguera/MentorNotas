<?php

namespace Jazzyweb\AulasMentor\NotasFrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TarifaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('periodo')
            ->add('precio')
            ->add('validoDesde')
            ->add('validoHasta')
        ;
    }

    public function getName()
    {
        return 'jazzyweb_aulasmentor_notasfrontendbundle_tarifatype';
    }
}

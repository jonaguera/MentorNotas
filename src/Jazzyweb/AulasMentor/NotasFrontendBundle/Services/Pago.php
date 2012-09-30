<?php

namespace Jazzyweb\AulasMentor\NotasFrontendBundle\Services;

class Pago {

    public function __construct($doctrine, $mailer, $templating,
     $factory_encoder) {
       $this->doctrine = $doctrine;
       $this->mailer = $mailer;
       $this->templating = $templating;
       $this->factory_encoder = $factory_encoder;
   }

   public function pagar($usuario,$tarifa) {

     $em = $this->doctrine->getEntityManager();

     $grupo = $em->getRepository('JAMNotasFrontendBundle:Grupo')
             ->findOneByRol('ROLE_PREMIUM');

     $usuario->addGrupo($grupo);

     $contrato = new \Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\Contrato;
     $contrato->setFecha(new \DateTime("now"));
     $contrato->setUsuario($usuario);
     $contrato->setTarifa($tarifa);

     $em->persist($usuario);
     $em->persist($contrato);
     $em->flush();
     
     $message = \Swift_Message::newInstance()
             ->setSubject('Bienvenido a la versión premium de Mentor Notas')
             ->setFrom('jonaguera@gmail.com')
             ->setTo($usuario->getEmail())
             ->setBody($this
               ->templating
               ->render(
                 'JAMNotasFrontendBundle:Contratos:email_premium.html.twig',
                 array('usuario' => $usuario)
                 )
               )
     ;
   }
}
<?php

namespace Jazzyweb\AulasMentor\NotasBackendBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class UsuarioAdminController extends Controller
{

 public function createAction()
 {
     if (false === $this->admin->isGranted('CREATE')) {
         throw new AccessDeniedException();
     }

     $object = $this->admin->getNewInstance();

     $this->admin->setSubject($object);

     $form = $this->admin->getForm();
     $form->setData($object);

     if ($this->get('request')->getMethod() == 'POST') {
         $form->bindRequest($this->get('request'));

         if ($form->isValid()) {

             $serviceRegistro = $this->get('jam_notas_frontend.registro');
             $serviceRegistro-> registra($object, $form->get('password')->getData());
             $object->setIsActive(true);

             $this->admin->create($object);

             if ($this->isXmlHttpRequest()) {
                 return $this->renderJson(array(
                             'result' => 'ok',
                             'objectId' => $this->admin->getNormalizedIdentifier($object)
                         ));
             }

             $this->get('session')->setFlash('sonata_flash_success', 'flash_create_success');
             // redirect to edit mode
             return $this->redirectTo($object);
         }

         $this->get('session')->setFlash('sonata_flash_error', 'flash_create_error');
     }

     $view = $form->createView();

     // set the theme for the current Admin Form
     $this->get('twig')->getExtension('form')->setTheme($view, $this->admin->getFormTheme());

     return $this->render($this->admin->getEditTemplate(), array(
                 'action' => 'create',
                 'form' => $view,
                 'object' => $object,
             ));
 }

}
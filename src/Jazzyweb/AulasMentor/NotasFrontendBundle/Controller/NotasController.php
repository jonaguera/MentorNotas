<?php

namespace Jazzyweb\AulasMentor\NotasFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jazzyweb\AulasMentor\NotasFrontendBundle\Form\Type\NotaType;
use Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\Nota;
use Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\Etiqueta;
use Symfony\Component\HttpFoundation\RedirectResponse;

class NotasController extends Controller {

    public function indexAction() {
        $request = $this->getRequest(); // equivalente a $this->get('request');
        $session = $this->get('session');

        $ruta = $request->get('_route');

        switch ($ruta) {
            case 'jamn_homepage':
                break;

            case 'jamn_conetiqueta':
                $session->set('busqueda.tipo', 'por_etiqueta');
                $session->set('busqueda.valor', $request->get('etiqueta'));
                $session->set('nota.seleccionada.id', '');

                break;

            case 'jamn_buscar':
                $session->set('busqueda.tipo', 'por_termino');
                $session->set('busqueda.valor', $request->get('termino'));
                $session->set('nota.seleccionada.id', '');

                break;
            case 'jamn_nota':
                $session->set('nota.seleccionada.id', $request->get('id'));
                break;
        }

        list($etiquetas, $notas, $notaSeleccionada) = $this->dameEtiquetasYNotas();
        // creamos un formulario para borrar la nota
        if ($notaSeleccionada instanceof Nota) {
            $deleteForm = $this
                    ->createDeleteForm($notaSeleccionada->getId())
                    ->createView();
        } else {
            $deleteForm = null;
        }

        return $this->render('JAMNotasFrontendBundle:Notas:index.html.twig', array(
                    'etiquetas' => $etiquetas,
                    'notas' => $notas,
                    'nota_seleccionada' => $notaSeleccionada,
                    'delete_form' => $deleteForm,
                ));
    }

    public function nuevaAction() {
        $request = $this->getRequest();

        list($etiquetas, $notas, $nota_seleccionada) = $this->dameEtiquetasYNotas();

        $em = $this->getDoctrine()->getEntityManager();

        $nota = new Nota();
        $newForm = $this->createForm(new NotaType(), $nota);

        if ($request->getMethod() == 'POST') {
            $newForm->bindRequest($request);

            if ($newForm->isValid()) {
                $usuario = $this->get('security.context')->getToken()->getUser();

                $item = $request->get('item');
                $this->actualizaEtiquetas($nota, $item['tags'], $usuario);

                $nota->setUsuario($usuario);
                $nota->setFecha(new \DateTime());

                if ($newForm['file']->getData() != '')
                    $nota->upload($usuario->getUsername());
// TODO: Le he tenido que definir una ruta vacía para evitar caer en un error 
                $nota->setPath("");
                $em->persist($nota);
                $em->flush();

                return $this->redirect($this->generateUrl('jamn_homepage'));
            }
        }


        return $this
                        ->render(
                                'JAMNotasFrontendBundle:Notas:crearOEditar.html.twig', array(
                            'etiquetas' => $etiquetas,
                            'notas' => $notas,
                            'nota_seleccionada' => $nota_seleccionada,
                            'new_form' => $newForm->createView(),
                            'edita' => false,
                                )
        );
    }

    public function nuevanotaAction() {
        $request = $this->getRequest();
        $nota = new Nota();

        $form = $this->createForm(new NotaType(), $nota);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                // Se procesa el formulario

                $em = $this->getDoctrine()->getEntityManager();

                $nota->upload();

                $em->persist($nota);
                $em->flush();

                $this->get('session')->setFlash('mensaje', 'Nota subida');
                return $this->redirect($this->generateUrl('jamn_homepage'));
            }
        }

        return $this->render(
                        'JAMNotasFrontendBundle:Notas:nuevanota.html.twig', array(
                    'form' => $form->createView(),
                ));
    }

    public function editarAction() {
        $request = $this->getRequest();
        $session = $this->get('session');
        $id = $request->get('id');


        list($etiquetas, $notas, $nota_seleccionada) = $this->dameEtiquetasYNotas();
        $em = $this->getDoctrine()->getEntityManager();

        $nota = $em->getRepository('JAMNotasFrontendBundle:Nota')->find($id);

        if (!$nota) {
            throw $this
                    ->createNotFoundException('No se ha podido encontrar esa nota');
        }
        $editForm = $this->createForm(new NotaType(), $nota);
        $deleteForm = $this->createDeleteForm($id);


        if ($request->getMethod() == 'POST') {
            $editForm->bindRequest($request);

            if ($editForm->isValid()) {
                $usuario = $this->get('security.context')->getToken()->getUser();

                $item = $request->get('item');
                $this->actualizaEtiquetas($nota, $item['tags'], $usuario);

                $nota->setFecha(new \DateTime());

                if ($editForm['file']->getData() != '')
                    $nota->upload($usuario->getUsername());

                $em->persist($nota);

                $em->flush();

                return $this->redirect($this->generateUrl('jamn_homepage'));
            }
        }



        return $this
                        ->render(
                                'JAMNotasFrontendBundle:Notas:crearOEditar.html.twig', array(
                            'etiquetas' => $etiquetas,
                            'notas' => $notas,
                            'nota_seleccionada' => $nota_seleccionada,
                            'edit_form' => $editForm->createView(),
                            'delete_form' => $deleteForm->createView(),
                            'edita' => true,
                                )
        );
    }

    public function borrarAction() {
        $request = $this->getRequest();
        $session = $this->get('session');

        $form = $this->createDeleteForm($request->get('id'));

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em
                    ->getRepository('JAMNotasFrontendBundle:Nota')
                    ->find($request->get('id'));

            if (!$entity) {
                throw $this->createNotFoundException('Esa nota no existe.');
            }

            $em->remove($entity);
            $em->flush();

            $session->set('nota.seleccionada.id', '');
        }




        return $this->redirect($this->generateUrl('jamn_homepage'));
    }

    public function miEspacioAction() {
        $params = 'Los datos de la página de inicio del espacio premium';
        return $this->render('JAMNotasFrontendBundle:Notas:index', array('params' => $params));
    }

    public function rssAction() {
        
    }

    public function compartirAction() {
        $request = $this->getRequest();

        // Acciones para rellenar el campo ruta en la tabla Nota
        $em = $this->getDoctrine()->getEntityManager();

        $nota_seleccionada = $em
                ->getRepository('JAMNotasFrontendBundle:Nota')
                ->findOneById($request->get("id"));

        if ($nota_seleccionada->getPublicUrl() == null)
            $nota_seleccionada->setPublicUrl(substr(md5(uniqid(rand(), true)), 0, 32));

        $em->persist($nota_seleccionada);
        $em->flush();


        // Redirigir a la nota
        return $this->redirect($this->generateUrl('jamn_nota', array("id" => $request->get("id"))));
    }

    public function descompartirAction() {
        $request = $this->getRequest();

        // Acciones para vaciar el campo ruta en la tabla Nota
        $em = $this->getDoctrine()->getEntityManager();

        $nota_seleccionada = $em
                ->getRepository('JAMNotasFrontendBundle:Nota')
                ->findOneById($request->get("id"));

        $nota_seleccionada->setPublicUrl(null);

        $em->persist($nota_seleccionada);
        $em->flush();

        // Redirigir a la nota
        return $this->redirect($this->generateUrl('jamn_nota', array("id" => $request->get("id"))));
    }

    public function publicAction() {
        $request = $this->getRequest();

        // Acciones para vaciar el campo ruta en la tabla Nota
        $em = $this->getDoctrine()->getEntityManager();

        $nota_seleccionada = $em
                ->getRepository('JAMNotasFrontendBundle:Nota')
                ->findOneByPublicUrl($request->get("publicUrl"));

        if (!$nota_seleccionada) {
            throw $this
                    ->createNotFoundException('No se ha podido encontrar esa nota');
        }

        // Redirigir a la nota pública
        return $this
                        ->render(
                                'JAMNotasFrontendBundle:Notas:vistapublica.html.twig', array(
                            'nota_seleccionada' => $nota_seleccionada,
                                )
        );
    }

    protected function dameEtiquetasYNotas() {
        $session = $this->get('session');
        $em = $this->getDoctrine()->getEntityManager();

        $usuario = $this->get('security.context')->getToken()->getUser();


        $busqueda_tipo = $session->get('busqueda.tipo');

        $busqueda_valor = $session->get('busqueda.valor');

        // Etiquetas. Se pillan todas
        $etiquetas = $em->getRepository('JAMNotasFrontendBundle:Etiqueta')->
                findByUsuarioOrderedByTexto($usuario);

        // Notas. Se pillan según el filtro almacenado en la sesión
        if ($busqueda_tipo == 'por_etiqueta' && $busqueda_valor != 'todas') {
            $notas = $em->getRepository('JAMNotasFrontendBundle:Nota')->
                    findByUsuarioAndEtiqueta($usuario, $busqueda_valor);
        } elseif ($busqueda_tipo == 'por_termino') {
            $notas = $em->getRepository('JAMNotasFrontendBundle:Nota')->
                    findByUsuarioAndTermino($usuario, $busqueda_valor);
        } else {
            $notas = $em->getRepository('JAMNotasFrontendBundle:Nota')->
                    findByUsuarioOrderedByFecha($usuario);
        }


        $nota_seleccionada = null;
        if (count($notas) > 0) {
            $nota_selecionada_id = $session->get('nota.seleccionada.id');
            if (!is_null($nota_selecionada_id) && $nota_selecionada_id != '') {
                $nota_seleccionada = $em
                        ->getRepository('JAMNotasFrontendBundle:Nota')
                        ->findOneById($nota_selecionada_id);
            } else {
                $nota_seleccionada = $notas[0];
            }
        }

        return array($etiquetas, $notas, $nota_seleccionada);
    }

    protected function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    protected function actualizaEtiquetas($nota, $tags, $usuario) {

        if (count($tags) == 0) {
            $tags = array();
        }
        $em = $this->getDoctrine()->getEntityManager();

        $nota->getEtiquetas()->clear();


        foreach ($tags as $tag) {
            $etiqueta = $em->getRepository('JAMNotasFrontendBundle:Etiqueta')->findOneByTextoAndUsuario($tag, $usuario);

            if (!$etiqueta instanceof Etiqueta) {
                $etiqueta = new Etiqueta();
                $etiqueta->setTexto($tag);
                $etiqueta->setUsuario($usuario);
                $em->persist($etiqueta);
            }

            $nota->addEtiqueta($etiqueta);
        }

        $em->flush();
    }

}
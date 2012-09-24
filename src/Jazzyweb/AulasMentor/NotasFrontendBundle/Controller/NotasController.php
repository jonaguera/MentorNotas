<?php

namespace Jazzyweb\AulasMentor\NotasFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jazzyweb\AulasMentor\NotasFrontendBundle\Form\Type\NotaType;
use Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\Nota;

class NotasController extends Controller {
    /* Ejercicio 6.3 */

    public function inspeccionarAction() {
        $request = $this->getRequest();
        $session = $this->get('session');
        echo '<pre>';
        print_r($_SESSION);
        print_r($this->get('session'));
        echo '</pre>';
        exit;
    }

    /* Ejercicio 6.2 */

    public function notasConFormatoAction() {
        $request = $this->getRequest(); // equivalente a $this->get('request');
        return $this->render('JAMNotasFrontendBundle:Notas:dameNotas.' . $request->getRequestFormat() . '.twig');
    }

    public function indexAction() {
        $request = $this->getRequest(); // equivalente a $this->get('request');
        $session = $this->get('session');

        $ruta = $request->get('_route');

        switch ($ruta) {
            case 'jamn_homepage':

                /* Ejercicio 6.1  */
                /*
                  $request = $this->getRequest(); // equivalente a $this->get('request');
                  echo '<pre>';
                  print_r($request);
                  echo $request->__toString();
                  echo "\n";
                  echo $request->getHttpHost();
                  echo "\n";
                  echo $request->getMethod();
                  echo "\n";
                  echo $request->getPort();
                  echo '</pre>';
                  exit;
                 */
                /*
                 * Fin ejericio 6.1
                 */
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

        list($etiquetas, $notas, $nota_seleccionada) = $this->dameEtiquetasYNotas();

        return $this->render('JAMNotasFrontendBundle:Notas:index.html.twig', array(
                    'etiquetas' => $etiquetas,
                    'notas' => $notas,
                    'nota_seleccionada' => $nota_seleccionada,
                ));
    }

    public function nuevaAction() {
        $request = $this->getRequest();
        $session = $this->get('session');

        if ($request->getMethod() == 'POST') {

            // si los datos que vienen en la request son buenos guarda la nota

            $session->setFlash('mensaje', 'Se debería guardar la nota:'
                    . $request->get('nombre') . '. Como aun no disponemos de un
                         servicio para persistir los datos, mostramos la nota 1');

            return $this->redirect($this->generateUrl('jamn_nota', array('id' => 1)));
        }

        list($etiquetas, $notas, $nota_seleccionada) = $this->dameEtiquetasYNotas();

        return $this->render('JAMNotasFrontendBundle:Notas:nueva.html.twig', array(
                    'etiquetas' => $etiquetas,
                    'notas' => $notas,
                    'nota_seleccionada' => $nota_seleccionada,
                ));
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

        // Se recupera la nota que viene en la request para ser editada

        $nota = array(
            'id' => $request->get('id'),
            'titulo' => 'nota',
        );


        if ($request->getMethod() == 'POST') {

            // si los datos que vienen en la request son buenos guarda la nota

            $session->setFlash('mensaje', 'Se debería editar la nota:'
                    . $request->get('titulo') .
                    '. Como aún no disponemos de un servicio para persistir los
                         datos, la nota permanece igual');

            return $this->redirect($this->generateUrl('jamn_nota', array('id' => $request->get('id'))));
        }

        list($etiquetas, $notas, $nota_seleccionada) = $this->dameEtiquetasYNotas();

        return $this->render('JAMNotasFrontendBundle:Notas:editar.html.twig', array(
                    'etiquetas' => $etiquetas,
                    'notas' => $notas,
                    'nota_a_editar' => $nota,
                ));
    }

    public function borrarAction() {
        $request = $this->getRequest();
        $session = $this->get('session');

        // borrado de la nota $request->get('id');

        $session->setFlash('mensaje', 'Se debería borrar la nota ' . $request->get('id'));
        $session->set('nota.seleccionada.id', '');

        return $this->forward('JAMNotasFrontendBundle:Notas:index');
    }

    public function miEspacioAction() {
        $params = 'Los datos de la página de inicio del espacio premium';
        return $this->render('JAMNotasFrontendBundle:Notas:index', array('params' => $params));
    }

    public function rssAction() {
        
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


        $nota_selecionada_id = $session->get('nota.seleccionada.id', '1');

        $nota_seleccionada = $em->getRepository('JAMNotasFrontendBundle:Nota')->
                findOneById($nota_selecionada_id);


        return array($etiquetas, $notas, $nota_seleccionada);
    }

}
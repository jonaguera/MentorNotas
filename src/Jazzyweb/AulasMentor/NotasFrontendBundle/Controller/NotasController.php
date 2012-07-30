<?php

namespace Jazzyweb\AulasMentor\NotasFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

    /**
     * Función Mock para poder desarrollar y probar la lógica de control.
     *
     * La función real que finalmente se implemente, utilizará el filtro almacenado
     * en la sesión y el modelo para calcular la etiquetas, notas y nota seleccionada
     * que en cada momento se deban pintar.
     */
    protected function dameEtiquetasYNotas() {
        $session = $this->get('session');

        $etiquetas = array(
            array(
                'id' => 1,
                'texto' => 'etiqueta 1',
            ),
            array(
                'id' => 2,
                'texto' => 'etiqueta 2',
            ),
            array(
                'id' => 3,
                'texto' => 'etiqueta 3',
            ),
        );

        $notas = array(
            array(
                'id' => 1,
                'titulo' => 'nota 1',
            ),
            array(
                'id' => 2,
                'titulo' => 'nota 2',
            ),
            array(
                'id' => 3,
                'titulo' => 'nota 3',
            ),
        );

        $nota_selecionada_id = $session->get('nota.seleccionada.id');
        if (!$nota_selecionada_id) {
            $nota_selecionada_id = 1;
        }

        $nota_seleccionada = array(
            'id' => $nota_selecionada_id,
            'titulo' => 'nota ' . $nota_selecionada_id,
        );
        return array($etiquetas, $notas, $nota_seleccionada);
    }

}
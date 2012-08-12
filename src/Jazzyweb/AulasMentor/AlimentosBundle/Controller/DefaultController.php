<?php

namespace Jazzyweb\AulasMentor\AlimentosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jazzyweb\AulasMentor\AlimentosBundle\Model\Model;
use Jazzyweb\AulasMentor\AlimentosBundle\Config\Config;
use Jazzyweb\AulasMentor\AlimentosBundle\Entity\alimentos;

class DefaultController extends Controller {

    public function indexAction() {
        $params = array(
            'mensaje' => 'Bienvenido al curso de Symfony2',
            'fecha' => date('d/m/Y'),
        );
        return $this->render('JazzywebAulasMentorAlimentosBundle:Default:index.html.twig', $params);
    }

    public function inicioAction() {
        $params = array(
            'mensaje' => 'Bienvenido al curso de Symfony2',
            'fecha' => date('d-m-yyy'),
        );
        require __DIR__ . '/templates/inicio.php';
    }

    /* ORMizado */

    public function listarAction() {
        $em = $this->getDoctrine()->getEntityManager();

        $alimentos = $em->getRepository('JazzywebAulasMentorAlimentosBundle:alimentos')->findAll();
        if (!$alimentos) {
            throw $this->createNotFoundException('No hay ningún alimento');
        }

        $params = array(
            'alimentos' => $alimentos,
            'alimentos_wikilink' => $this->get('jamab.wikilink')->addWikiLink($alimentos),
        );

        return $this->render('JazzywebAulasMentorAlimentosBundle:Default:mostrarAlimentos.html.twig', $params);
    }

    /* ORMizado */

    public function insertarAction() {
        $params = array(
            'nombre' => '',
            'energia' => '',
            'proteina' => '',
            'hc' => '',
            'fibra' => '',
            'grasa' => '',
        );

        $m = $this->get('jamab.model');


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // comprobar campos formulario
            if ($m->validarDatos($_POST['nombre'], $_POST['energia'], $_POST['proteina'], $_POST['hc'], $_POST['fibra'], $_POST['grasa'])) {
//                $m->insertarAlimento($_POST['nombre'], $_POST['energia'], $_POST['proteina'], $_POST['hc'], $_POST['fibra'], $_POST['grasa']);

                $alimento = new alimentos();
                $alimento->setNombre($_POST['nombre']);
                $alimento->setEnergia($_POST['energia']);
                $alimento->setProteina($_POST['proteina']);
                $alimento->setHidratocarbono($_POST['hc']);
                $alimento->setFibra($_POST['fibra']);
                $alimento->setGrasatotal($_POST['grasa']);


                // Ahora hay que persistirlo
                // solicitamos el servicio de persistencia (ORM)
                $em = $this->getDoctrine()->getEntityManager();

                // Le enviamos a dicho servicio el objeto que queremos persistir (no se
                // realiza query aún
                $em->persist($alimento);

                // Al final del proceso, cuando hayamos enviado a todos los objetos
                // al servicio de persistencia, lo enviamos efectivamente a la base de
                // datos (insert)
                $em->flush();



                header('Location: index.php?ctl=listar');
            } else {
                $params = array(
                    'nombre' => $_POST['nombre'],
                    'energia' => $_POST['energia'],
                    'proteina' => $_POST['proteina'],
                    'hc' => $_POST['hc'],
                    'fibra' => $_POST['fibra'],
                    'grasa' => $_POST['grasa'],
                );
                $params['mensaje'] = 'No se ha podido insertar el alimento. Revisa el formulario';
            }
        }

        return $this->render('JazzywebAulasMentorAlimentosBundle:Default:formInsertar.html.twig', $params);
    }

    /* ORMizado */

    public function buscarPorNombreAction() {
        $params = array(
            'nombre' => '',
            'alimentos' => '',
            'alimentos_wikilink' => '',
        );
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery("SELECT a FROM JazzywebAulasMentorAlimentosBundle:alimentos a WHERE a.nombre LIKE :nombre")->setParameters(array('nombre' => $_POST['nombre']));
            $alimentos = $query->getResult();
            $params = array(
                'nombre' => $_POST['nombre'],
                'alimentos' => $alimentos,
                'alimentos_wikilink' => $this->get('jamab.wikilink')->addWikiLink($alimentos),
            );
        }
        return $this->render('JazzywebAulasMentorAlimentosBundle:Default:buscarPorNombre.html.twig', $params);
    }

    /* ORMizado */

    public function buscarPorEnergiaAction() {
        $params = array(
            'energia_min' => '',
            'energia_max' => '',
            'alimentos' => '',
            'alimentos_wikilink' => '',
        );
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery("SELECT a FROM JazzywebAulasMentorAlimentosBundle:alimentos a WHERE a.energia >= :energia_min and a.energia <= :energia_max")->setParameters(array('energia_min' => $_POST['energia_min'], 'energia_max' => $_POST['energia_max'],));
            $alimentos = $query->getResult();
            $params = array(
                'energia_min' => $_POST['energia_min'],
                'energia_max' => $_POST['energia_max'],
                'alimentos' => $alimentos,
                'alimentos_wikilink' => $this->get('jamab.wikilink')->addWikiLink($alimentos),
            );
        }
        return $this->render('JazzywebAulasMentorAlimentosBundle:Default:buscarPorEnergia.html.twig', $params);
    }

    /* ORMizado */

    public function busquedaCombinadaAction() {
        $params = array(
            'energia_min' => '',
            'energia_max' => '',
            'proteina_min' => '',
            'proteina_max' => '',
            'hidratocarbono_min' => '',
            'hidratocarbono_max' => '',
            'fibra_min' => '',
            'fibra_max' => '',
            'grasatotal_min' => '',
            'grasatotal_max' => '',
            'alimentos' => '',
            'alimentos_wikilink' => '',
        );
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $em = $this->getDoctrine()->getEntityManager();
            $alimentos = $em->getRepository('JazzywebAulasMentorAlimentosBundle:alimentos');
            $qb = $alimentos->createQueryBuilder('alimentos');
            $qb->select('a')
                    ->from('JazzywebAulasMentorAlimentosBundle:alimentos', 'a')
                    ->orderBy('a.energia');

            if ($_POST['energia_min'])
                $qb->andWhere('a.energia >= ' . $_POST['energia_min']);
            if ($_POST['energia_max'])
                $qb->andWhere('a.energia <= ' . $_POST['energia_max']);
            if ($_POST['proteina_min'])
                $qb->andWhere('a.proteina >= ' . $_POST['proteina_min']);
            if ($_POST['proteina_max'])
                $qb->andWhere('a.proteina <= ' . $_POST['proteina_max']);
            if ($_POST['hidratocarbono_min'])
                $qb->andWhere('a.hidratocarbono >= ' . $_POST['hidratocarbono_min']);
            if ($_POST['hidratocarbono_max'])
                $qb->andWhere('a.hidratocarbono <= ' . $_POST['hidratocarbono_max']);
            if ($_POST['fibra_min'])
                $qb->andWhere('a.fibra >= ' . $_POST['fibra_min']);
            if ($_POST['fibra_max'])
                $qb->andWhere('a.fibra <= ' . $_POST['fibra_max']);
            if ($_POST['grasatotal_min'])
                $qb->andWhere('a.grasatotal >= ' . $_POST['grasatotal_min']);
            if ($_POST['grasatotal_max'])
                $qb->andWhere('a.grasatotal <= ' . $_POST['grasatotal_max']);

            $query = $qb->getQuery();
            $alimentos = $query->execute();


            $params = array(
                'energia_min' => $_POST['energia_min'],
                'energia_max' => $_POST['energia_max'],
                'proteina_min' => $_POST['proteina_min'],
                'proteina_max' => $_POST['proteina_max'],
                'hidratocarbono_min' => $_POST['hidratocarbono_min'],
                'hidratocarbono_max' => $_POST['hidratocarbono_max'],
                'fibra_min' => $_POST['fibra_min'],
                'fibra_max' => $_POST['fibra_max'],
                'grasatotal_min' => $_POST['grasatotal_min'],
                'grasatotal_max' => $_POST['grasatotal_max'],
                'alimentos' => $alimentos,
                'alimentos_wikilink' => $this->get('jamab.wikilink')->addWikiLink($alimentos),
            );
        }
        return $this->render('JazzywebAulasMentorAlimentosBundle:Default:busquedaCombinada.html.twig', $params);
    }

    /* ORMizado */

    public function verAction($id) {



        $em = $this->getDoctrine()->getEntityManager();

        $alimento = $em->getRepository('JazzywebAulasMentorAlimentosBundle:alimentos')->find($id);
        if (!$alimento) {
            throw $this->createNotFoundException('No existe alimento con id ' . $id);
        }


        return $this->render('JazzywebAulasMentorAlimentosBundle:Default:verAlimento.html.twig', array('alimento' => $alimento));
    }

    public function testInfoSenderAction() {
        $infosender = $this->get('jamab.infosender');

        $infosender->send('%cebolla%', 'jonaguera@gmail.com');

        return new \Symfony\Component\HttpFoundation\Response(
                        '<html><body><h2>Se ha enviado información a
              jonaguera@gmail.com</h2></body></html>');
    }

}
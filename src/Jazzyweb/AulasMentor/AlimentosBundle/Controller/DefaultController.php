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
        $params['mensaje'] = '';


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            // Nueva validación

            $validador = $this->get('validator');

            $alimento = new alimentos();
            $alimento->setNombre($_POST['form']['nombre']);
            $alimento->setEnergia($_POST['form']['energia']);
            $alimento->setProteina($_POST['form']['proteina']);
            $alimento->setHidratocarbono($_POST['form']['hidratocarbono']);
            $alimento->setFibra($_POST['form']['fibra']);
            $alimento->setGrasatotal($_POST['form']['grasatotal']);

            $errors = $validador->validate($alimento);

            if (!count($errors)) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($alimento);
                $em->flush();
            } else {
                $params['mensaje'] = 'No se ha podido insertar el alimento. Revisa el formulario para encontrar el problema';
            }
        }

        $alimento = new alimentos();

        $alimento->setNombre("Nombre del alimento");
        $alimento->setEnergia(0);
        $alimento->setProteina(0);
        $alimento->setHidratocarbono(0);
        $alimento->setFibra(0);
        $alimento->setGrasatotal(0);

        $form = $this->createFormBuilder($alimento)
                ->add('nombre', 'text')
                ->add('energia', 'text')
                ->add('proteina', 'text')
                ->add('hidratocarbono', 'text')
                ->add('fibra', 'text')
                ->add('grasatotal', 'text')
                ->getForm();
        $params['form'] = $form->createView();
        return $this->render('JazzywebAulasMentorAlimentosBundle:Default:formInsertar.html.twig', $params);
    }

    /* ORMizado */

    public function buscarPorNombreAction() {
        $params = array(
            'nombre' => '',
            'alimentos' => '',
            'alimentos_wikilink' => '',
            'form' => '',
        );
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery("SELECT a FROM JazzywebAulasMentorAlimentosBundle:alimentos a WHERE a.nombre LIKE :nombre")->setParameters(array('nombre' => $_POST['form']['nombre']));
            $alimentos = $query->getResult();
            $params = array(
                'nombre' => $_POST['form']['nombre'],
                'alimentos' => $alimentos,
                'alimentos_wikilink' => $this->get('jamab.wikilink')->addWikiLink($alimentos),
            );
        }

        $alimento = new alimentos();

        $alimento->setNombre("Introduce el nombre a buscar ...");

        $form = $this->createFormBuilder($alimento)
                ->add('nombre', 'text')
                ->getForm();
        $params['form'] = $form->createView();

        return $this->render('JazzywebAulasMentorAlimentosBundle:Default:buscarPorNombre.html.twig', $params);
    }

    /* ORMizado */

    public function buscarPorEnergiaAction() {
        $params = array(
            'alimentos' => '',
            'form' => '',
        );
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery("SELECT a FROM JazzywebAulasMentorAlimentosBundle:alimentos a WHERE a.energia >= :energia_min and a.energia <= :energia_max")->setParameters(array('energia_min' => $_POST['form']['energia_min'], 'energia_max' => $_POST['form']['energia_max'],));
            $alimentos = $query->getResult();
            $params = array(
                'energia_min' => $_POST['form']['energia_min'],
                'energia_max' => $_POST['form']['energia_max'],
                'alimentos' => $alimentos,
                'alimentos_wikilink' => $this->get('jamab.wikilink')->addWikiLink($alimentos),
            );
        }

        $alimento = new alimentos();
        $alimento->setEnergiaMin(0);
        $alimento->setEnergiaMax(999);


        $form = $this->createFormBuilder($alimento)
                ->add('energia_min', 'text')
                ->add('energia_max', 'text')
                ->getForm();
        $params['form'] = $form->createView();
        
        return $this->render('JazzywebAulasMentorAlimentosBundle:Default:buscarPorEnergia.html.twig', $params);
    }

    /* ORMizado */

    public function busquedaCombinadaAction() {
        $params = array(
            'alimentos' => '',
            'form' => '',
        );
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $em = $this->getDoctrine()->getEntityManager();
            $alimentos = $em->getRepository('JazzywebAulasMentorAlimentosBundle:alimentos');
            $qb = $alimentos->createQueryBuilder('alimentos');
            $qb->select('a')
                    ->from('JazzywebAulasMentorAlimentosBundle:alimentos', 'a')
                    ->orderBy('a.energia');

            if ($_POST['form']['energia_min'])
                $qb->andWhere('a.energia >= ' . $_POST['form']['energia_min']);
            if ($_POST['form']['energia_max'])
                $qb->andWhere('a.energia <= ' . $_POST['form']['energia_max']);
            if ($_POST['form']['proteina_min'])
                $qb->andWhere('a.proteina >= ' . $_POST['form']['proteina_min']);
            if ($_POST['form']['proteina_max'])
                $qb->andWhere('a.proteina <= ' . $_POST['form']['proteina_max']);
            if ($_POST['form']['hidratocarbono_min'])
                $qb->andWhere('a.hidratocarbono >= ' . $_POST['form']['hidratocarbono_min']);
            if ($_POST['form']['hidratocarbono_max'])
                $qb->andWhere('a.hidratocarbono <= ' . $_POST['form']['hidratocarbono_max']);
            if ($_POST['form']['fibra_min'])
                $qb->andWhere('a.fibra >= ' . $_POST['form']['fibra_min']);
            if ($_POST['form']['fibra_max'])
                $qb->andWhere('a.fibra <= ' . $_POST['form']['fibra_max']);
            if ($_POST['form']['grasatotal_min'])
                $qb->andWhere('a.grasatotal >= ' . $_POST['form']['grasatotal_min']);
            if ($_POST['form']['grasatotal_max'])
                $qb->andWhere('a.grasatotal <= ' . $_POST['form']['grasatotal_max']);

            $query = $qb->getQuery();
            $alimentos = $query->execute();


            $params = array(
                'energia_min' => $_POST['form']['energia_min'],
                'energia_max' => $_POST['form']['energia_max'],
                'proteina_min' => $_POST['form']['proteina_min'],
                'proteina_max' => $_POST['form']['proteina_max'],
                'hidratocarbono_min' => $_POST['form']['hidratocarbono_min'],
                'hidratocarbono_max' => $_POST['form']['hidratocarbono_max'],
                'fibra_min' => $_POST['form']['fibra_min'],
                'fibra_max' => $_POST['form']['fibra_max'],
                'grasatotal_min' => $_POST['form']['grasatotal_min'],
                'grasatotal_max' => $_POST['form']['grasatotal_max'],
                'alimentos' => $alimentos,
                'alimentos_wikilink' => $this->get('jamab.wikilink')->addWikiLink($alimentos),
            );
        }
        $alimento = new alimentos();


        $form = $this->createFormBuilder($alimento)
                ->add('energia_min', 'text')
                ->add('energia_max', 'text')
                ->add('proteina_min', 'text')
                ->add('proteina_max', 'text')
                ->add('hidratocarbono_min', 'text')
                ->add('hidratocarbono_max', 'text')
                ->add('fibra_min', 'text')
                ->add('fibra_max', 'text')
                ->add('grasatotal_min', 'text')
                ->add('grasatotal_max', 'text')
                ->getForm();
        $params['form'] = $form->createView();
        
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
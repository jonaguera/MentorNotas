<?php
namespace Jazzyweb\AulasMentor\NotasFrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\Contrato;

class ContratosController extends Controller
{
    public function tarifasPremiumAction()
    {
        $form = $this->createFormBuilder()->add('tarifa', 'entity', array('class' => 'JAMNotasFrontendBundle:Tarifa','expanded' => true, 'multiple' => false))->getForm();
        return $this->render('JAMNotasFrontendBundle:Contratos:tarifaspremium.html.twig', array('form' => $form->createView()));
    }

    public function contratarPremiumAction(Request $request)
    {
        $datos = $request->get('form');

        $em = $this->getDoctrine()->getEntityManager();

        $tarifa = $em->getRepository('JAMNotasFrontendBundle:Tarifa')->findOneById($datos['tarifa']);

        if (!$tarifa) {
            throw $this->createNotFoundException('Tarifa no encontrada');
        }

        $usuario = $this->get('security.context')->getToken()->getUser();
                
        $pagos_service = $this->get('jam_notas_frontend.pago');

        $pagos_service->pagar($usuario, $tarifa);

        return $this->render('JAMNotasFrontendBundle:Contratos:contrato_success.html.twig', array('usuario' => $usuario));
    }

}
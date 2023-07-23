<?php

// src/Controller/InvoiceLineController.php

use App\Entity\InvoiceLine;
use App\Form\InvoiceLineType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceLineController extends AbstractController
{
    /**
     * @Route("/invoice/line", name="app_invoice_line")
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/InvoiceLineController.php',
        ]);
    }

    /**
     * @Route("/invoice/line/add", name="app_invoice_line_add")
     */
    public function addInvoiceLine(Request $request): Response
    {
        $invoiceLine = new InvoiceLine();
        $form = $this->createForm(InvoiceLineType::class, $invoiceLine);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($invoiceLine);
            $entityManager->flush();

            // Redirect to a success page or perform any other action
        }

        return $this->render('invoice_line/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

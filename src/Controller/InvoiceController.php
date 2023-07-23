<?php 
namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{
    /**
     * @Route("/invoice", name="app_invoice")
     */
    public function index(): Response
    {
        // Implement code here for listing existing invoices or any other action
        // Return a response or render a template
    }

    /**
     * @Route("/invoice/create", name="app_invoice_create")
     */
    public function createInvoice(Request $request): Response
    {
        $invoice = new Invoice();
        $form = $this->createForm(InvoiceType::class, $invoice);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Save the invoice entity
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($invoice);
            $entityManager->flush();

            // Create and save associated invoice lines
            $invoiceLinesData = $form->get('invoiceLines')->getData();
            foreach ($invoiceLinesData as $lineData) {
                $line = new InvoiceLine();
                $line->setInvoice($invoice);
                $line->setDescription($lineData['description']);
                $line->setQuantity($lineData['quantity']);
                $line->setAmount($lineData['amount']);
                $line->setVatAmount($lineData['vatAmount']);
                $line->setTotalWithVat($lineData['totalWithVat']);

                $entityManager->persist($line);
            }
            $entityManager->flush();

            // Redirect to a success page or perform any other action
            // For example, redirect to the invoice list page
            return $this->redirectToRoute('app_invoice');
        }

        return $this->render('invoice/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

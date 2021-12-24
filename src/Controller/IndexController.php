<?php

namespace App\Controller;

use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Exception\SignatureVerificationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class IndexController extends AbstractController
{
    /**
     * @Route("/paypal", name="webhook_paypal_handler")
     * @param Request $request
     * @return Response
     */
    public function paypal(Request $request): Response
    {
        return new Response('Ok');
    }

    /**
     * @Route("/stripe", name="webhook_stripe_handler")
     * @param Request $request
     * @return Response
     */
    public function stripe(Request $request): Response
    {
        $payload = file_get_contents('php://input');
        $secret = $this->getParameter('stripe_secret_key');
        $signature = $request->headers->get('stripe-signature', null);

        var_dump([$payload, $signature]);

        try {
            $event = Webhook::constructEvent($payload, $signature, $secret);
        } catch (SignatureVerificationException $e) {
            throw new BadRequestException($e->getMessage());
        }

        return new Response(print_r($event->object, true));
    }
}

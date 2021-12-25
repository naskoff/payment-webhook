<?php

namespace App\Controller;

use Stripe\Stripe;
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
        $secret = $this->getParameter('stripe_webhook_key');
        $signature = $request->headers->get('stripe-signature');

        Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        try {
            $event = Webhook::constructEvent($request->getContent(), $signature, $secret);
        } catch (SignatureVerificationException $e) {
            throw new BadRequestException($e->getMessage());
        }

        return new Response(print_r($event, true));
    }
}

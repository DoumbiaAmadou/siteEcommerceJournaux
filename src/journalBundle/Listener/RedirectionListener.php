<?php

namespace journalBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

Class RedirectionListener {

    public function __construct(ContainerInterface $container, Session $session) {
        $this->session = $session;
        $this->router = $container->get('router');
        $this->securityContext = $container->get('security.context');
    }

    public function onKernelRequest(GetResponseEvent $event) {
        $route = $event->getRequest()->attributes->get('_route');
        
        if($route=='livraison' || $route =='validation'){
            if ($this->session->has('panier')) {
                if (count($this->session->get('panier')) == 0) {
                    $event->setResponse(new RedirectionListener($this->router->generate('panier')));
                }
            }

            if(!is_object($this->securityContext->getToken()->getUser())){
                $this->session->getFlashBag()->add('notification' ,'Vous devez vous indentifier  avant!');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login'))); 
                }
        }
    }

}

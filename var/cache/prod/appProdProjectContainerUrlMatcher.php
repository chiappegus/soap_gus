<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($rawPathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $trimmedPathinfo = rtrim($pathinfo, '/');
        $context = $this->context;
        $request = $this->request ?: $this->createRequest($pathinfo);
        $requestMethod = $canonicalMethod = $context->getMethod();

        if ('HEAD' === $requestMethod) {
            $canonicalMethod = 'GET';
        }

        // app_soap_hello
        if ('' === $trimmedPathinfo) {
            $ret = array (  '_controller' => 'AppBundle\\Controller\\SoapController::hello',  '_route' => 'app_soap_hello',);
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_app_soap_hello;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'app_soap_hello'));
            }

            return $ret;
        }
        not_app_soap_hello:

        // soap_hello
        if ('/soap/hello' === $pathinfo) {
            return array (  '_controller' => 'AppBundle\\Controller\\SoapController::hello',  '_route' => 'soap_hello',);
        }

        // pepe_hello
        if ('/soap/pepe' === $pathinfo) {
            return array (  '_controller' => 'AppBundle\\Controller\\SoapController::pepe',  '_route' => 'pepe_hello',);
        }

        // app_soap_pepe
        if ('' === $trimmedPathinfo) {
            $ret = array (  '_controller' => 'AppBundle\\Controller\\SoapController::pepe',  '_route' => 'app_soap_pepe',);
            if ('/' === substr($pathinfo, -1)) {
                // no-op
            } elseif ('GET' !== $canonicalMethod) {
                goto not_app_soap_pepe;
            } else {
                return array_replace($ret, $this->redirect($rawPathinfo.'/', 'app_soap_pepe'));
            }

            return $ret;
        }
        not_app_soap_pepe:

        if ('/' === $pathinfo && !$allow) {
            throw new Symfony\Component\Routing\Exception\NoConfigurationException();
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}

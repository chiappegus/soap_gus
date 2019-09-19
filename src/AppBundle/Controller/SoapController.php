<?php
/**
 * Simple SOAP Server - v1
 * 
 * Create a simple HelloWorld SOAP server. The main function (hello) is defined in HelloController 
 * which is a basic Controller. To publish a method of HelloController we've created this controller 
 * (SoapController) where we have one + two methods : 
 *  - First one  : how to publish all public methods of HelloController
 *  - Second one : how to generate the WSDL of the service
 *  - Third one  : how to call a method 
 * 
 * If you have a new controller to publish simply duplicate the first method and update these data : 
 *  - The route and it's name
 *  - The url
 *  - The instance of the new controller
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



// Needed to generate absolute URL
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

// Needed to create the SOAP server
use Zend\Soap;

class SoapController extends Controller
{  
    public $theUri;
    /**
     * To display the WSDL you have to call http://.../soap/hello?wsdl (see @Route)
     *
     * @Route("/soap/hello", name="soap_hello")
     */
    public function hello()
    {
        // This wil generate the absolute URL of the current action (end point) based on it's route name
        $theUri = $this->generateUrl('soap_hello', [], UrlGeneratorInterface::ABSOLUTE_URL);

        // This is the object to instanciate when the webservice is invoked, use any controller
        $theService = new HelloController();
        //$theUri =$this->theUri;

        // Check if we should disply WSDL or execute the call
        if (isset($_GET['wsdl']))
           
            return $this->handleWSDL($theUri, $theService);
        else
            
            return $this->handleSOAP($theUri, $theService);

         
    }
    

    /**
     * To display the WSDL you have to call http://.../soap/hello?wsdl (see @Route)
     *
     * @Route("/soap/pepe", name="pepe_hello")
     */
    public function pepe()
    {




        //$soapClient = new \SoapClient('https://cvnet.cpd.ua.es/servicioweb/publicos/pub_gestdocente.asmx?wsdl');

     //$theUri= $this->theUri;

      //$result = $soapclient ->call('ListaUsuariosMAGYP');
      //$params = array('CountryName' => 'Spain', 'CityName' => 'Alicante');
      //
      $client = new \SoapClient('http://autenticacionad.magyp.gob.ar/Service1.svc?wsdl');


    dump($client->__getFunctions()); 

    //https://stackoverflow.com/questions/11593623/how-to-make-a-php-soap-call-using-the-soapclient-class
    //
    dump($client->__getTypes()); 




      $params = array(
      "name" => "gato",
      "pass" => "2019"
       );
      $response = $client->__soapCall("usuarioValidoMAGYP", array($params)); 

       
      $response1 = $client->__soapCall("DNIusuarioValidoMAGYP",array($params)); 



    $response3 = $client->__soapCall("gruposONCCA",array($params));
    $response4 = $client->__soapCall("grupos",array($params));
    $response5 = $client->__soapCall("usuarioExistenteMAGYP",array($params));
    $response6 = $client->__soapCall("usuarioValidoONCCA",array($params));


    dump($response);
  /*  dump($response1);
    dump($response3);
    dump($response4);
    dump($response5);*/
    dump($response6);
    //dump($response2);
    //
    //
    //
   $soapClient1 = new \SoapClient('http://indicadoreseconomicos.bccr.fi.cr/indicadoreseconomicos/WebServices/wsIndicadoresEconomicos.asmx?WSDL');
   

    dump($soapClient1->__getFunctions()); 

    //https://stackoverflow.com/questions/11593623/how-to-make-a-php-soap-call-using-the-soapclient-class
    //
    dump($soapClient1->__getTypes()); 
  /*"318", Today.ToShortDateString, Today.ToShortDateString, "WebSite", "N"*/

    //$result = $soapClient1->call('hello', ['name' => 'Scott']);

   //dump($result);
     $client2 = new \SoapClient(
        'http://127.0.0.1:8000/soap/hello?wsdl');
     $response7 = $client2->__getFunctions();
    dump($response7); 
     $response9 = $client2->__soapCall("hello",array("GUSTAVO"));
   
     dump($response9);
    //$response = $client1->hello("John DOE");

         /* very important
    

   
  
    /*try {
        $response = $client1->hello("John DOE");
        echo "\n Response : $response \n";

    } catch (SoapFault $fault) {
        echo "Error: " . $fault->faultcode . ": " . $fault->getMessage() . "\n";
        var_dump($fault);
    }*/
          $status ='Hello , server time is ' . date ('H:i:s');
        dump($status);

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);


         
    }



    /**
     * return the WSDL
     */
    public function handleWSDL($uri, $class)
    {
        // Soap auto discover
        $autodiscover = new Soap\AutoDiscover();
        $autodiscover->setClass($class);
        $autodiscover->setUri($uri);

        // Response
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8'); // WSDL is a XML content
        
        // Start Output Buffering, nothing will be displayed ...
        ob_start();
        // Handle Soap
        $autodiscover->handle();
        // ... Stop Output Buffering and get content into variable
        $response->setContent(ob_get_clean());
        return $response;
    }

    /**
     * execute SOAP request
     */
    public function handleSOAP($uri, $class)
    {
        // Soap server
        $soap = new Soap\Server(null,
            array('location' => $uri,
                'uri' => $uri,
            ));
        $soap->setClass($class);

        // Response
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        // Handle Soap
        $soap->handle();
        $response->setContent(ob_get_clean());
        return $response;
    }
}

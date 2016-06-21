<?php
/**
 * Created by PhpStorm.
 * User: gurez
 * Date: 14.06.2016
 * Time: 14:39
 */

namespace ApiBundle\Controller\Api;


use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ApiBundle\Entity\User;
use ApiBundle\Entity\Task;
use ApiBundle\Entity\Tasklist;
use ApiBundle\Entity\Privileges;
use ApiBundle\Entity\Log;
use ApiBundle\Entity\Groups;
use ApiBundle\Entity\GroupsList;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ApiController extends Controller
{
    /**
     * @Route("/")
     * @Method("GET")
     */
    public function apiAction(){
        return $this->render('ApiBundle:Default:index.html.twig');
    }
    /**
     * @Route("/register")
     * @Method("POST")
     */
    public function registerUserAction(Request $request){
        $userManager  = $this->get('fos_user.user_manager');
        $user         = $userManager->createUser();
        $user->setEnabled(true);
        $name = $request->get("name");
        $password = $request->get("password");
        $email = $request->get("email");

        // We check if all parameters are set
        $code = 0;
        if ($name === null)                                        $code = 200;
        else if ($email    === null)                               $code = 201;
        else if ($password === null)                               $code = 202;
        else if ($userManager->findUserByEmail($email)   !== null) $code = 203;
        // We set parameters to user object
        if($code!=0){
            $response = new Response();
            $response->setContent( json_encode(["error"=>$code]));
            $response->setStatusCode(Response::HTTP_CONFLICT);
            $response->headers->set('Content-Type', 'application/json');
            return  $response;
        }
        $user->setUsername($name);
        $user->setEmail($email);
        $encoder = $this->get('security.encoder_factory')->getEncoder($user);
        $password_user = $encoder->encodePassword($password, $user->getSalt());
        $user->setPassword($password_user);

        $clientManager = $this->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        //$client->setRedirectUris(array('http://localhost:8888/app_dev.php'));
        $client->setAllowedGrantTypes(array('password'));
        $clientManager->updateClient($client);

        // We save the user in the database
        $userManager->updateUser($user);
        $client_id = $client->getPublicId();
        $data = array("client_id"=>$client_id,"client_secret"=>$client->getSecret(),"grant_type"=>"password","username"=>$name,"password"=>$password);
        $response = new Response();
        $response->setContent( json_encode($data));
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    
    /**
     * @Route("/api/logs/{id}")
     * @Method("GET")
     */
    public function getLogsAction($id) {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT l FROM ApiBundle:Log l WHERE l.listId='$id'");
        $logs=$query->getResult();
        $response = new Response();
        if(!is_null($logs)){
            $response->setContent(json_encode($logs));
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
}
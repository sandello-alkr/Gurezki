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

class UsersController extends Controller
{
    /**
     * @Route("/api/users")
     * @Method("GET")
     */
    public function usersAction() {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('ApiBundle:User')->findAll();
        $data = array();
        foreach ($users as $user){
            array_push($data,array("id"=>$user->getId(),"name"=>$user->getUsername(),"email"=>$user->getEmail()));
        }
        $response = new Response();
        $response->setContent(json_encode($data));
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/users/find")
     * @Method("GET")
     */
    public function userFindAction(){
        $name = $_GET['name'];
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('ApiBundle:User')->findBy(array('username'=>$name));
        $data = array();
        foreach ($users as $user){
            array_push($data,array("id"=>$user->getId(),"name"=>$user->getUsername(),"email"=>$user->getEmail()));
        }
        $response = new Response();
        $response->setContent(json_encode($data));
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/users/{id}")
     * @Method("GET")
     */
    public function usersIdAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ApiBundle:User')->find($id);
        $response = new Response();
        if(is_null($user)){
            $data = array();
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }else {
            $data = array("id"=>$user->getId(),"name"=>$user->getUsername(),"email"=>$user->getEmail());
            $response->setStatusCode(Response::HTTP_OK);
        }

        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/users")
     * @Method("PUT")
     */
    public function userPutAction(Request $request){
        $user = $this->get('security.context')->getToken()->getUser();
        $name = $request->get("name");
        $password = $request->get("password");
        $email = $request->get("email");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ApiBundle:User')->find($user->getId());
        $user->setEmail($email);
        $user->setUsername($name);
        $encoder = $this->get('security.encoder_factory')->getEncoder($user);
        $password_user = $encoder->encodePassword($password, $user->getSalt());
        $user->setPassword($password_user);
        $em->persist($user);
        $em->flush();
        $response = new Response();
        $response->setContent( json_encode(["name"=>$name,"email"=>$email,"password"=>$password]));
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return  $response;

    }

    /**
     * @Route("/api/users")
     * @Method("DELETE")
     */
    public function userDeleteAction(){//передеать в setEnable(false)
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $tokens = $em->getRepository('ApiBundle:AccessToken')->findBy(array('user' => $user));
        foreach ($tokens as $token){$em->remove($token);$em->flush();}
        $tokensRefresh = $em->getRepository('ApiBundle:RefreshToken')->findBy(array('user' => $user));
        foreach ($tokensRefresh as $token){$em->remove($token);$em->flush();}
        $userManager = $this->get('fos_user.user_manager');
        $userManager->deleteUser($user);
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
}
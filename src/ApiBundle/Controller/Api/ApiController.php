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
        if ($name === null)                                        $code = 201;
        else if ($email    === null)                               $code = 202;
        else if ($password === null)                               $code = 203;
        else if ($userManager->findUserByUsername($name) !== null) $code = 204;
        else if ($userManager->findUserByEmail($email)   !== null) $code = 205;
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
        $userManager->updateUser($user);
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT p FROM ApiBundle:Client p");
        $client=$query->getOneOrNullResult();
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


    public function generate_password($number)
    {
        $arr = array('a','b','c','d','e','f',

            'g','h','i','j','k','l',

            'm','n','o','p','r','s',

            't','u','v','x','y','z',

            'A','B','C','D','E','F',

            'G','H','I','J','K','L',

            'M','N','O','P','R','S',

            'T','U','V','X','Y','Z',

            '1','2','3','4','5','6',

            '7','8','9','0');

        // Генерируем пароль

        $pass = "";

        for($i = 0; $i < $number; $i++)

        {

            // Вычисляем случайный индекс массива

            $index = rand(0, count($arr) - 1);

            $pass .= $arr[$index];

        }

        return $pass;

    }

    /**
     * @Route("/resetpassord")
     * @Method("POST")
     */
    public function resetpasswordAction(Request $request){
        $email = $request->get('email');
        $userManager  = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByEmail($email);
        $response = new Response();
        if(!is_null($user)){
            $password = $this->generate_password(10);
            $em = $this->getDoctrine()->getManager();
            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $password_user = $encoder->encodePassword($password, $user->getSalt());
            $user->setPassword($password_user);
            $em->persist($user);
            $em->flush();
            $to=$email;
            $subject="Your new password";
            $body ="Your new password: ".$password;
            $headers  = "Content-type: text/html; charset=windows-1251 \r\n";
            $headers .= "From:  <".$_SERVER['SERVER_NAME'].">\r\n";
            $headers .= "Reply-To: ".$_SERVER['SERVER_NAME']."\r\n";
            $result = mail($to, $subject, $body, $headers);
            if($result)
            {
                $response->setStatusCode(Response::HTTP_OK);
            }
            else
            {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }else{
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }

}
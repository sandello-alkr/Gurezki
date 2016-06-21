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

class GroupsController extends Controller
{

    /**
     * @Route("/api/groups")
     * @Method("POST")
     */
    public function addGroupsAction(Request $request){
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $name = $request->get('name');
        $em = $this->getDoctrine()->getManager();
        $groups = new Groups();
        $groups->Add($userId,$name,$em);
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/groups")
     * @Method("GET")
     */
    public function getGroupsAction() {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT g.id, g.name FROM ApiBundle:Groups g WHERE g.userId='$userId'");
        $groups=$query->getResult();
        $response = new Response();
        if(!is_null($groups)){
            $response->setContent(json_encode($groups));
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/groups/{id}")
     * @Method("DELETE")
     */
    public function deleteGroupsAction($id) {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("DELETE ApiBundle:Groups g WHERE g.userId='$userId' AND g.id='$id'");
        $query->getResult();
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/groups/{id}")
     * @Method("POST")
     */
    public function addUsersGroupsAction($id,Request $request) {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $forId = $request->get("userId");
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT g FROM ApiBundle:Groups g WHERE g.userId='$userId' AND g.id='$id'");
        $gr = $query->getOneOrNullResult();
        $response = new Response();
        if(!is_null($gr)){
            $groupsList = new GroupsList();
            $groupsList->Add($forId,$id,$em);
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/groups/{id}")
     * @Method("PUT")
     */
    public function deleteUsersGroupsAction($id,Request $request) {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $forId = $request->get("userId");
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT g FROM ApiBundle:Groups g WHERE g.userId='$userId' AND g.id='$id'");
        $gr = $query->getOneOrNullResult();
        $response = new Response();
        if(!is_null($gr)){
            $query = $em->createQuery("DELETE ApiBundle:GroupsList g WHERE g.userId='$forId' AND g.groupId='$id'");
            $gr = $query->getOneOrNullResult();
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/groups/{id}")
     * @Method("GET")
     */
    public function getUserGroupsAction($id) {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT u.id, u.username FROM ApiBundle:User u JOIN ApiBundle:GroupsList g WHERE u.id=g.userId WHERE g.groupId='$id'");
        $groups=$query->getResult();
        $response = new Response();
        if(!is_null($groups)){
            $response->setContent(json_encode($groups));
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }

}
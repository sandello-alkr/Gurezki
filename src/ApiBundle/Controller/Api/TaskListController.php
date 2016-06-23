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


class TaskListController extends Controller
{
    /**
     * @Route("/api/tasklist")
     * @Method("POST")
     */
    public function postListAction(Request $request) {
        $name = $request->get('name');
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $taskList = new Tasklist();
        $taskList->CreateNewList($userId,$name);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($taskList);
        $em->flush();
        $response = new Response();
        if($taskList->getId()>0){
            $response->setContent(json_encode(array("id"=>$taskList->getId(),"name"=>$name)));
            $privileges = new Privileges();
            $privileges->AddPrivileges($userId,$taskList->getId(),3);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($privileges);
            $em->flush();
            $log = new Log();
            $log->Add($userId,$taskList->getId(),"Создание списка: ".$name,$em);
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $response->setStatusCode(Response::HTTP_CONFLICT);
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/tasklist")
     * @Method("GET")
     */
    public function getListAction(){
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        //$lists = $em->getRepository('ApiBundle:Tasklist')->findBy(array("userId"=>$userId));
        $query = $em->createQuery("SELECT t.id, t.name, p.level FROM ApiBundle:Tasklist t LEFT JOIN ApiBundle:Privileges p  WHERE t.id=p.taskListId WHERE p.userId='$userId' AND p.level>-1");
        $lists = $query->getResult();
        $response = new Response();
        $response->setContent(json_encode($lists));
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/tasklist/{id}")
     * @Method("GET")
     */
    public function getListIdAction($id){
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT t FROM ApiBundle:Tasklist t LEFT JOIN ApiBundle:Privileges p  WHERE t.id=p.taskListId WHERE p.userId='$userId' AND p.level>-1 AND t.id='$id'");
        $list = $query->getOneOrNullResult();
        $response = new Response();
        if(!is_null($list)){
            $query = $em->createQuery("SELECT t.id, t.name,t.checked FROM ApiBundle:Task t WHERE t.taskListId='$id'");
            $tasks = $query->getResult();
            $response->setContent(json_encode($tasks));
            $response->setStatusCode(Response::HTTP_OK);
            $log = new Log();
            $log->Add($userId,$id,"Получить список",$em);
        }else {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            $response->setContent(json_encode(""));
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/tasklist/{id}")
     * @Method("DELETE")
     */
    public function deleteListIdAction($id){
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT t FROM ApiBundle:Tasklist t LEFT JOIN ApiBundle:Privileges p  WHERE t.id=p.taskListId WHERE p.userId='$userId' AND p.level=3 AND t.id='$id'");
        $list = $query->getOneOrNullResult();
        $response = new Response();
        if(!is_null($list)){
            $name = $list->getName();
            $em->remove($list);
            $em->flush();
            $log = new Log();
            $log->Add($userId,$id,"Удаление списка: ".$name,$em);
            $response->setStatusCode(Response::HTTP_OK);
        }else {
            $response->setStatusCode(Response::HTTP_CONFLICT);
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }

}
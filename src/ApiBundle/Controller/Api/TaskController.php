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

class TaskController extends Controller
{
    /**
     * @Route("/api/task")
     * @Method("POST")
     */
    public function createTask(Request $request){
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $taskListId = $request->get("taskListId");
        $name = $request->get("name");
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT t FROM ApiBundle:Tasklist t LEFT JOIN ApiBundle:Privileges p  WHERE t.id=p.taskListId WHERE p.userId='$userId' AND p.level>1 AND t.id='$taskListId'");
        $list = $query->getOneOrNullResult();
        $response = new Response();
        if((!is_null($list))&&($taskListId==$list->getId())){
            $task = new Task();
            $task->Create($taskListId,$name);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($task);
            $em->flush();
            $log = new Log();
            $log->Add($userId,$taskListId,"Добавил задачу ".$name,$em);
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $response->setStatusCode(Response::HTTP_CONFLICT);
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/task")
     * @Method("DELETE")
     */
    public function deleteTaskAction(Request $request){
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $taskListId = $request->get('taskListId');
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT t FROM ApiBundle:Tasklist t LEFT JOIN ApiBundle:Privileges p  WHERE t.id=p.taskListId WHERE p.userId='$userId' AND p.level>1 AND t.id='$taskListId'");
        $list = $query->getOneOrNullResult();
        $response = new Response();
        if(!is_null($list)){

            $query = $em->createQuery("DELETE ApiBundle:Task t  WHERE t.id='$id' AND t.taskListId='$taskListId'");
            $query->getResult();
            $log = new Log();
            $log->Add($userId,$taskListId,"Задача ".$id." удалена",$em);
            $response->setStatusCode(Response::HTTP_OK);
        }else {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/task")
     * @Method("PUT")
     */
    public function putTaskAction(Request $request){
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $taskListId = $request->get('taskListId');
        $id = $request->get('id');
        $checked = $request->get('checked');
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT t FROM ApiBundle:Tasklist t LEFT JOIN ApiBundle:Privileges p  WHERE t.id=p.taskListId WHERE p.userId='$userId'  AND t.id='$taskListId'");
        $list = $query->getOneOrNullResult();
        $response = new Response();
        if(!is_null($list)){
            $query = $em->createQuery("UPDATE ApiBundle:Task t SET t.checked='$checked' WHERE t.id='$id' AND t.taskListId='$taskListId'");
            $query->getResult();
            $response->setStatusCode(Response::HTTP_OK);
            $log = new Log();
            $log->Add($userId,$taskListId,"Задача ".$id.".Состояние: ".$checked,$em);

        }else {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
}
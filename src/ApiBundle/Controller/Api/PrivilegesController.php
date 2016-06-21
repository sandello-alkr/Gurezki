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
use ApiBundle\Entity\Privileges;
use ApiBundle\Entity\Log;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class PrivilegesController extends Controller
{
    /**
     * @Route("/api/privileges")
     * @Method("POST")
     */
    public function createPrivilegiesAction(Request $request) {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $taskListId = $request->get("taskListId");
        $level = $request->get("level");
        $forId = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT t FROM ApiBundle:Tasklist t LEFT JOIN ApiBundle:Privileges p  WHERE t.id=p.taskListId WHERE p.userId='$userId' AND p.level>1 AND t.id='$taskListId'");
        $list = $query->getOneOrNullResult();
        $response = new Response();
        if((!is_null($list))&&($level<3)){
            $privileges = new Privileges();
            $privileges->AddPrivileges($forId,$taskListId,$level);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($privileges);
            $em->flush();
            $log = new Log();
            $log->Add($userId,$taskListId,"Установил привилегию для пользователя ".$forId." уровня: ".$level,$em);
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $response->setStatusCode(Response::HTTP_CONFLICT);
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/privileges")
     * @Method("DELETE")
     */
    public function deletePrivilegiesAction(Request $request) {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $taskListId = $request->get("taskListId");
        $forId = $request->get("id");
        $response = new Response();
        if($forId==$userId){
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("DELETE ApiBundle:Privileges p WHERE p.taskListId='$taskListId' AND p.userId='$forId'");
            $query->getResult();
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("SELECT p FROM ApiBundle:Privileges p WHERE p.taskListId='$taskListId' AND p.userId='$userId' AND p.level=3");
            $privilegies=$query->getOneOrNullResult();
            if(!is_null($privilegies)){
                $query = $em->createQuery("DELETE ApiBundle:Privileges p WHERE p.taskListId='$taskListId' AND p.userId='$forId'");
                $query->getResult();
                $log = new Log();
                $log->Add($userId,$taskListId,"Удалил привилегии у пользователя ".$forId,$em);

                $response->setStatusCode(Response::HTTP_OK);
            }else{
                $response->setStatusCode(Response::HTTP_CONFLICT);
            }
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/privileges")
     * @Method("GET")
     */
    public function getPrivilegiesAction() {
        $taskListId = $_GET['taskListId'];
        $forId = $_GET['id'];
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT p FROM ApiBundle:Privileges p WHERE p.taskListId='$taskListId' AND p.userId='$forId' ORDER BY p.level ASC");
        $privilegies=$query->getOneOrNullResult();
        $response = new Response();
        if(!is_null($privilegies)){
            $response->setContent(json_encode(array("level"=>$privilegies->getLevel())));
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/privileges")
     * @Method("PUT")
     */
    public function putPrivilegiesAction(Request $request) {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $taskListId = $request->get("taskListId");
        $level = $request->get("level");
        $forId = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT t FROM ApiBundle:Tasklist t LEFT JOIN ApiBundle:Privileges p  WHERE t.id=p.taskListId WHERE p.userId='$userId' AND p.level>1 AND t.id='$taskListId'");
        $list = $query->getOneOrNullResult();
        $response = new Response();
        if((!is_null($list))&&($level<3)){
            $privileges = $em->getRepository('ApiBundle:Privileges')->findBy(array("taskListId"=>$list->getId(),"userId"=>$forId));
            if(!is_null($privileges)){
                $privileges = $privileges[0];
                $privileges->AddPrivileges($forId,$taskListId,$level);
                $em->persist($privileges);
                $em->flush();
                $log = new Log();
                $log->Add($userId,$taskListId,"Изменил привилегии для пользователя ".$forId." уровня: ".$level,$em);

            }
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $response->setStatusCode(Response::HTTP_CONFLICT);
        }
        $response->headers->set('Content-Type', 'application/json');
        return  $response;
    }
    /**
     * @Route("/api/privileges/list/{id}")
     * @Method("GET")
     */
    public function getUsersPrivilegiesAction($id) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT DISTINCT (u.id) as id, u.username, u.email, p.level FROM  ApiBundle:User u JOIN  ApiBundle:Privileges p WHERE p.userId=u.id AND p.taskListId='$id'");
        $privilegies=$query->getResult();
        $response = new Response();
        $data = array();
        if(!is_null($privilegies)){
            $response->setContent(json_encode($privilegies));
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
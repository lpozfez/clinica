<?php

namespace App\Controller\Api;

use App\Entity\Renovacion;
use App\Repository\PrescripcionRepository;
use App\Repository\RenovacionRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('api/renovacion', name: 'app_renovacion_api')]
#[IsGranted('ROLE_MEDICO')]
class RenovacionApiController extends AbstractController
{
    private RenovacionRepository $repo;
    private PrescripcionRepository $prescripRepo;

    public function __construct(RenovacionRepository $repositorio, PrescripcionRepository $prescripRepo)
    {
        $this->repo=$repositorio;
        $this->prescripRepo=$prescripRepo;
    }

    //MÉTODO PARA AÑADIR UN NUEVO ELEMENTO
    #[Route(name:'add_renovacion', methods:['POST'])]
    public function addRenovacion(Request $request):JsonResponse
    {
        $renovacion=new Renovacion(); 

        try {
            //Cogemos los datos de la Request
            $data=json_decode($request->getContent(), true);
            $f = $data['fecha'];
            $fecha=DateTime::createFromFormat('d-m-Y', $f);
            $descripcion = $data['descripcion'];
            $prescrip=$data['prescripcion'];
            //Añadimos los datos al nuevo elemento
            if($fecha!=false){
                $renovacion->setFecha($fecha);
            }
            $renovacion->setdescripcion($descripcion);
            //Buscamos el paciente que corresponde al renovacion
            try {
                $prescripcion=$this->prescripRepo->find($prescrip);
                $renovacion->setPrescripcion($prescripcion);
                //Guardamos el nuevo elemento
                $this->repo->save($renovacion,true);
                //Construimos la response con el toArray y la url
                $data=[$renovacion->toArray(),'enlace'=>$request->getRequestUri()."/".$renovacion->getId()];
                return $this->json($data,$status=201);   
                
            } catch (Exception $e) {
                return $this->json(['Error' => $e->getMessage()], 500);
            }
        } catch (Exception $e) {
            return $this->json(['Error' => $e->getMessage()], 500);
        }
    }

    //MÉTODO PARA MODIFICAR UN ELEMENTO
    #[Route('/{id}',name:'edit_renovacion', methods:['PUT'])]
    public function editRenovacion(int $id, Request $request):JsonResponse
    {
        //Buscamos en BD
        $renovacion=$this->repo->find($id);
        //Comprobamos que exista
        if(!$renovacion){
            return $this->json('Elemento no encontrado', 404);
        }else{
            try {
                //Cogemos los datos de la Request
                $data=json_decode($request->getContent(), true);
                $f = $data['fecha'];
                $fecha=DateTime::createFromFormat('d-m-Y', $f);
                $descripcion = $data['descripcion'];
                $prescrip=$data['prescripcion'];
                //Añadimos los datos al nuevo elemento
                if($fecha!=false){
                    $renovacion->setFecha($fecha);
                }
                $renovacion->setdescripcion($descripcion);
                //Buscamos la prescripcion que corresponde a la renovacion
                try {
                    $prescripcion=$this->prescripRepo->find($prescrip);
                    $renovacion->setPrescripcion($prescripcion);
                    //Guardamos el nuevo elemento
                    $this->repo->save($renovacion,true);
                    //Construimos la response con el toArray y la url
                    $data=[$renovacion->toArray(),'enlace'=>$request->getRequestUri()];
                    return $this->json($data,$status=201);   
                    
                } catch (Exception $e) {
                    return $this->json(['Error' => $e->getMessage()], 500);
                }
            } catch (Exception $e) {
                return $this->json(['Error' => $e->getMessage()], 500);
            }

        }
    }

    //MÉTODO PARA BORRAR UN ELEMENTO
    #[Route('/{id}',name:'delete_renovacion', methods:['DELETE'])]
    public function deleteRenovacion(int $id):JsonResponse
    {
        //Buscamos la renovacion en BD
        $renovacion=$this->repo->find($id);
        if(!$renovacion){
            return $this->json('Elemento no encontrado', 404);
        }else{
            $this->repo->remove($renovacion, true);
            return $this->json('Elemento borrado', 200);
        }
    }
    
    //MÉTODO RECUPERAR TODOS LOS ELEMENTOS
    #[Route(name:'get_renovacions', methods:['GET'])]
    public function getRenovaciones(Request $request):JsonResponse
    {
        $renovaciones = $this->repo->findAll(); 
        $datos = []; 
    
        if($renovaciones)
        {
            foreach ($renovaciones as $renovacion) { 
                $datos[] = $renovacion->toArray();
            } 
            //Construimos la response con el toArray y la url
            $data=[$datos,'enlace'=>$request->getRequestUri()];
            return $this->json($data,$status=201);
            
        }else{
            return $this->json('Elementos no encontrados', $status=404);
        }
    }

    //MÉTODO PARA RECUPERAR UN ELEMENTO
    #[Route('/{id}',name:'getrenovacion', methods:['GET'])]
    public function getRenovacion(int $id, Request $request):JsonResponse
    {
        //Traemos el renovacion mediante la id.
       $renovacion=$this->repo->find($id);
       if(empty($renovacion)){
            return $this->json('Elemento no encontrado', $status=404);
        }else{
            //Construimos la response con el toArray y la url
            $data=[$renovacion->toArray(),'enlace'=>$request->getRequestUri()];
            return $this->json($data,$status=201);
        }
    }
}

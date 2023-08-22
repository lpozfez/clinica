<?php

namespace App\Controller\Api;

use App\Entity\TipoConsulta;
use App\Repository\TipoConsultaRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('api/tipoconsulta', name: 'app_tipo_consulta_api')]
//#[IsGranted('ROLE_MEDICO')]
class TipoConsultaApiController extends AbstractController
{
    private TipoConsultaRepository $repo;

    public function __construct(TipoConsultaRepository $repositorio)
    {
        $this->repo=$repositorio;
    }

    //MÉTODO PARA AÑADIR UN NUEVO ELEMENTO
    #[Route(name:'add_tipoConsulta', methods:['POST'])]
    public function addTipoConsulta(Request $request):JsonResponse
    {
        $tipoConsulta=new TipoConsulta(); 

        try {
            //Cogemos los datos de la Request
            $data=json_decode($request->getContent(), true);
            $descripcion=$data['descripcion'];
            $duracio=$data['duracion'];
            $duracion=DateTime::createFromFormat('H:i:s', $duracio);
            //Añadimos los datos al nuevo elemento
            $tipoConsulta->setDescripcion($descripcion);
            //Guardamos el nuevo elemento
            if(!empty($tipoConsulta)&&$duracion!=false){
                $tipoConsulta->setDuracion($duracion);
                $this->repo->save($tipoConsulta,true);
            }
            //Construimos la response con el toArray y la url
            $data=[$tipoConsulta->toArray(),'enlace'=>$request->getRequestUri().'/'.$tipoConsulta->getId()];
            return $this->json($data,$status=201);
            
        } catch (Exception $e) {
            return $this->json(['Error' => $e->getMessage()], 500);
        }
    }

    //MÉTODO PARA MODIFICAR UN ELEMENTO
    #[Route('/{id}',name:'edit_tipoConsulta', methods:['PUT'])]
    public function editTipoConsulta(int $id, Request $request):JsonResponse
    {
        //Buscamos en BD
        $tipoConsulta=$this->repo->find($id);
        //Comprobamos que exista
        if(!$tipoConsulta){
            return $this->json('Elemento no encontrado', 404);
        }else{
            try {
                //Cogemos los datos de la Request
                $data=json_decode($request->getContent(), true);
                $descripcion=$data['descripcion'];
                $duracio=$data['duracion'];
                $duracion=DateTime::createFromFormat('H:i:s', $duracio);
                //Añadimos los datos al nuevo elemento
                $tipoConsulta->setDescripcion($descripcion);
                //Guardamos el nuevo elemento
                if(!empty($tipoConsulta)&&$duracion!=false){
                    $tipoConsulta->setDuracion($duracion);
                    $this->repo->save($tipoConsulta,true);
                }
                //Construimos la response con el toArray y la url
                $data=[$tipoConsulta->toArray(),'enlace'=>$request->getRequestUri().'/'.$tipoConsulta->getId()];
                return $this->json($data,$status=201);
    
            } catch (Exception $e) {
                return $this->json(['Error' => $e->getMessage()], 500);
            }

        }
    }

    //MÉTODO PARA BORRAR UN ELEMENTO
    #[Route('/{id}',name:'delete_tipoConsulta', methods:['DELETE'])]
    public function deleteTipoConsulta(int $id):JsonResponse
    {
        //Buscamos la tipoConsulta en BD
        $tipoConsulta=$this->repo->find($id);
        if(!$tipoConsulta){
            return $this->json('Elemento no encontrado', 404);
        }else{
            $this->repo->remove($tipoConsulta, true);
            return $this->json('Elemento borrado', 200);
        }
    }
    
    //MÉTODO RECUPERAR TODOS LOS ELEMENTOS
    #[Route(name:'get_tipoConsultas', methods:['GET'])]
    public function getTipoConsultas(Request $request):JsonResponse
    {
        $tipoConsultas = $this->repo->findAll(); 
        $datos = []; 
    
        if(!empty($tipoConsultas))
        {
            foreach ($tipoConsultas as $tipoConsulta) { 
                $datos[] = $tipoConsulta->toArray();
            } 
    
            //Construimos la response con el toArray y la url
            $data=[$datos,'enlace'=>$request->getRequestUri()];
            return $this->json($data, $status=201);
        }else{
            return $this->json('Elementos no encontrados', $status=404);
        }
    }

    //MÉTODO PARA RECUPERAR UN ELEMENTO
    #[Route('/{id}',name:'gettipoConsulta', methods:['GET'])]
    public function getTipoConsulta(int $id, Request $request):JsonResponse
    {
        //Traemos el tipoConsulta mediante la id.
       $tipoConsulta=$this->repo->find($id);
       if(!$tipoConsulta){
            return $this->json('Elemento no encontrado', $status=404);
        }else{
            $datos[] = $tipoConsulta->toArray();
            //Construimos la response con el toArray y la url
            $data=[$datos,'enlace'=>$request->getRequestUri()];
            return $this->json($data,$status=201);
        }
    }
}

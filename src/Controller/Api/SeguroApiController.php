<?php

namespace App\Controller\Api;

use App\Entity\SeguroMedico;
use App\Repository\SeguroMedicoRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/seguro', name: 'app_seguro_api')]
#[IsGranted('ROLE_MEDICO')]
class SeguroApiController extends AbstractController
{
    
    private SeguroMedicoRepository $repo;

    public function __construct(SeguroMedicoRepository $repositorio)
    {
        $this->repo=$repositorio;
    }

    //MÉTODO PARA AÑADIR UN NUEVO ELEMENTO
    #[Route(name:'add_seguro', methods:['POST'])]
    public function addSeguro(Request $request):JsonResponse
    {
        $seguro=new SeguroMedico(); 

        try {
            //Cogemos los datos de la Request
            $data=json_decode($request->getContent(), true);
            $nombre=$data['nombre'];
            //Añadimos los datos al nuevo elemento
            $seguro->setNombre($nombre);
            //Guardamos el nuevo elemento
            if(!empty($seguro)){
                $this->repo->save($seguro,true);
            }
            //Construimos la response con el toArray y la url
            $data=[$seguro->toArray(),'enlace'=>$request->getRequestUri().'/'.$seguro->getId()];
            return $this->json($data,$status=201);
            
        } catch (Exception $e) {
            return $this->json(['Error' => $e->getMessage()], 500);
        }
    }

    //MÉTODO PARA MODIFICAR UN ELEMENTO
    #[Route('/{id}',name:'edit_seguro', methods:['PUT'])]
    public function editSeguro(int $id, Request $request):JsonResponse
    {
        //Buscamos en BD
        $seguro=$this->repo->find($id);
        //Comprobamos que exista
        if(!$seguro){
            return $this->json('Elemento no encontrado', 404);
        }else{
            try {
                //Cogemos los datos de la Request
                $data=json_decode($request->getContent(), true);
                $nombre=$data['nombre'];
                //Añadimos los datos al nuevo elemento
                $seguro->setNombre($nombre);
                //Guardamos el nuevo elemento
                if(!empty($seguro)){
                    $this->repo->save($seguro,true);
                }
                //Construimos la response con el toArray y la url
                $data=[$seguro->toArray(),'enlace'=>$request->getRequestUri()];
                return $this->json($data,$status=201);
    
            } catch (Exception $e) {
                return $this->json(['Error' => $e->getMessage()], 500);
            }

        }
    }

    //MÉTODO PARA BORRAR UN ELEMENTO
    #[Route('/{id}',name:'delete_seguro', methods:['DELETE'])]
    public function deleteSeguro(int $id):JsonResponse
    {
        //Buscamos la seguro en BD
        $seguro=$this->repo->find($id);
        if(!$seguro){
            return $this->json('Elemento no encontrado', 404);
        }else{
            $this->repo->remove($seguro, true);
            return $this->json('Elemento borrado', 200);
        }
    }
    
    //MÉTODO RECUPERAR TODOS LOS ELEMENTOS
    #[Route(name:'get_seguros', methods:['GET'])]
    public function getSeguros(Request $request):JsonResponse
    {
        $seguros = $this->repo->findAll(); 
        $datos = []; 
    
        if(!empty($seguros))
        {
            foreach ($seguros as $seguro) { 
                $datos[] = $seguro->toArray();
            } 
    
            //Construimos la response con el toArray y la url
            $data=[$datos,'enlace'=>$request->getRequestUri()];
            return $this->json($data, $status=201);
        }else{
            return $this->json('Elementos no encontrados', $status=404);
        }
    }

    //MÉTODO PARA RECUPERAR UN ELEMENTO
    #[Route('/{id}',name:'getseguro', methods:['GET'])]
    public function getSeguro(int $id, Request $request):JsonResponse
    {
        //Traemos el seguro mediante la id.
       $seguro=$this->repo->find($id);
       if(!$seguro){
            return $this->json('Elemento no encontrado', $status=404);
        }else{
            $datos[] = $seguro->toArray();
            //Construimos la response con el toArray y la url
            $data=[$datos,'enlace'=>$request->getRequestUri()];
            return $this->json($data,$status=201);
        }
    }
}

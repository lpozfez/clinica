<?php

namespace App\Controller\Api;

use App\Entity\Paciente;
use App\Repository\PacienteRepository;
use App\Repository\SeguroMedicoRepository;
use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/api/paciente', name: 'app_paciente_api')]
//#[IsGranted('ROLE_MEDICO')]
class PacienteApiController extends AbstractController
{
    private PacienteRepository $repo;
    private UserRepository $userRepo;
    private SeguroMedicoRepository $seguroRepo;

    public function __construct(PacienteRepository $repositorio, UserRepository $userRepo, SeguroMedicoRepository $seguroRepo)
    {
        $this->repo=$repositorio;
        $this->userRepo=$userRepo;
        $this->seguroRepo=$seguroRepo;
    }

    //MÉTODO PARA AÑADIR UN NUEVO ELEMENTO
    #[Route(name:'add_paciente', methods:['POST'])]
    public function addPaciente(Request $request):JsonResponse
    {
        $paciente=new Paciente(); 

        try {
            //Cogemos los datos de la Request
            $data=json_decode($request->getContent(), true);
            $nombre = $data['nombre'];
            $ap1 = $data['ap1'];
            $ap2 = $data['ap2'];
            $dni = $data['dni'];
            $tarjeta = $data['tarjeta'];
            $foto = $data['foto'];
            $seguro= $data['seguro_id'];
            $user = $data['user_id'];
            //Añadimos los datos al nuevo elemento
            $paciente->setNombre($nombre);
            $paciente->setAp1($ap1);
            $paciente->setAp2($ap2);
            $paciente->setDni($dni);
            $paciente->setTarjeta($tarjeta);
            $paciente->setFoto($foto);
            //Buscamos el seguro que corresponde al paciente
            if(!$seguro){
                $paciente->setSeguro(null);
            }else{
                $seguroMed=$this->seguroRepo->find($seguro);
                $paciente->setSeguro($seguroMed);
            }
            //Buscamos el usuario que corresponde al paciente
            try {
                $usuario=$this->userRepo->find($user);
                $paciente->setUser($usuario);
                //Guardamos el nuevo elemento
                $this->repo->save($paciente,true);
                //Construimos la response con el toArray y la url
                $data=[$paciente->toArray(),'enlace'=>$request->getRequestUri()."/".$paciente->getId()];
                return $this->json($data,$status=201);   
                
            } catch (Exception $e) {
                return $this->json(['Error' => $e->getMessage()], 500);
            }
        } catch (Exception $e) {
            return $this->json(['Error' => $e->getMessage()], 500);
        }
    }

    //MÉTODO PARA MODIFICAR UN ELEMENTO
    #[Route('/{id}',name:'edit_paciente', methods:['PUT'])]
    public function editPaciente(int $id, Request $request):JsonResponse
    {
        //Buscamos en BD
        $paciente=$this->repo->find($id);
        $seguroMed="";
        //Comprobamos que exista
        if(!$paciente){
            return $this->json('Elemento no encontrado', 404);
        }else{
            try {
                //Cogemos los datos de la Request
                $data=json_decode($request->getContent(), true);
                $nombre = $data['nombre'];
                $ap1 = $data['ap1'];
                $ap2 = $data['ap2'];
                $dni = $data['dni'];
                $tarjeta = $data['tarjeta'];
                $foto = $data['foto'];
                $seguro=$data['seguro_id'];
                $user = $data['user_id'];
                //Añadimos los datos al nuevo elemento
                $paciente->setNombre($nombre);
                $paciente->setAp1($ap1);
                $paciente->setAp2($ap2);
                $paciente->setDni($dni);
                $paciente->setTarjeta($tarjeta);
                $paciente->setFoto($foto);
                //Buscamos el seguro que corresponde al paciente
                if(!$seguro){
                    $paciente->setSeguro(null);
                }else{
                    $seguroMed=$this->seguroRepo->find($seguro);
                    $paciente->setSeguro($seguroMed);
                }
                //Buscamos el usuario que corresponde al paciente
                $usuario=$this->userRepo->find($user);
                $paciente->setUser($usuario);
                //Guardamos el nuevo elemento
                if(!empty($paciente)){
                    $this->repo->save($paciente,true);
                }
                //Construimos la response con el toArray y la url
                $data=[$paciente->toArray(),'enlace'=>$request->getRequestUri()];
                return $this->json($data,$status=201);
    
            } catch (Exception $e) {
                return $this->json(['Error' => $e->getMessage()], 500);
            }

        }
    }

    //MÉTODO PARA BORRAR UN ELEMENTO
    #[Route('/{id}',name:'delete_paciente', methods:['DELETE'])]
    public function deletePaciente(int $id):JsonResponse
    {
        //Buscamos la paciente en BD
        $paciente=$this->repo->find($id);
        if(!$paciente){
            return $this->json('Elemento no encontrado', 404);
        }else{
            //Borramos el user que corresponde al paciente user
            $user=$paciente->getUser();
            $this->repo->remove($paciente, true);
            $this->userRepo->remove($user,true);
            return $this->json('Elemento borrado', 200);
        }
    }
    
    //MÉTODO RECUPERAR TODOS LOS ELEMENTOS
    #[Route(name:'get_pacientes', methods:['GET'])]
    public function getPacientes(Request $request):JsonResponse
    {
        $pacientes = $this->repo->findAll(); 
        $datos = []; 
    
        if($pacientes)
        {
            foreach ($pacientes as $paciente) { 
                $datos[] = $paciente->toArray();
            } 
            //Construimos la response con el toArray y la url
            $data=[$datos,'enlace'=>$request->getRequestUri()];
            return $this->json($data,$status=201);
            
        }else{
            return $this->json('Elementos no encontrados', $status=404);
        }
    }

    //MÉTODO PARA RECUPERAR UN ELEMENTO
    #[Route('/{id}',name:'getpaciente', methods:['GET'])]
    public function getPaciente(int $id, Request $request):JsonResponse
    {
        //Traemos el paciente mediante la id.
       $paciente=$this->repo->find($id);
       if(empty($paciente)){
            return $this->json('Elemento no encontrado', $status=404);
        }else{
            //Construimos la response con el toArray y la url
            $data=[$paciente->toArray(),'enlace'=>$request->getRequestUri()];
            return $this->json($data,$status=201);
        }
    }
}

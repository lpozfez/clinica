<?php

namespace App\Controller\Api;

use App\Entity\Prescripcion;
use App\Repository\PacienteRepository;
use App\Repository\PrescripcionRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('api/prescripcion', name: 'app_prescripcion_api')]
#[IsGranted('ROLE_MEDICO')]
class PrescripcionApiController extends AbstractController
{
    private PrescripcionRepository $repo;
    private PacienteRepository $pacienteRepo;

    public function __construct(prescripcionRepository $repositorio, PacienteRepository $pacienteRepo)
    {
        $this->repo=$repositorio;
        $this->pacienteRepo=$pacienteRepo;
    }

    //MÉTODO PARA AÑADIR UN NUEVO ELEMENTO
    #[Route(name:'add_prescripcion', methods:['POST'])]
    public function addPrescripcion(Request $request):JsonResponse
    {
        $prescripcion=new Prescripcion(); 

        try {
            //Cogemos los datos de la Request
            $data=json_decode($request->getContent(), true);
            $f = $data['fecha'];
            $fecha=DateTime::createFromFormat('d-m-Y', $f);
            $medicamento = $data['medicamento'];
            $posologia = $data['posologia'];
            $suspensionFecha = $data['suspension'];
            $suspension=DateTime::createFromFormat('d-m-Y', $suspensionFecha);
            $motivo=$data['motivo'];
            $pacient = $data['paciente'];
            //Añadimos los datos al nuevo elemento
            if($fecha!=false){
                $prescripcion->setFecha($fecha);
            }
            $prescripcion->setmedicamento($medicamento);
            $prescripcion->setPosologia($posologia);
            if($suspension!=false){
                $prescripcion->setSuspension($suspension);
            }
            $prescripcion->setMotivo($motivo);
            //Buscamos el paciente que corresponde al prescripcion
            try {
                $paciente=$this->pacienteRepo->find($pacient);
                $prescripcion->setPaciente($paciente);
                //Guardamos el nuevo elemento
                $this->repo->save($prescripcion,true);
                //Construimos la response con el toArray y la url
                $data=[$prescripcion->toArray(),'enlace'=>$request->getRequestUri()."/".$prescripcion->getId()];
                return $this->json($data,$status=201);   
                
            } catch (Exception $e) {
                return $this->json(['Error' => $e->getMessage()], 500);
            }
        } catch (Exception $e) {
            return $this->json(['Error' => $e->getMessage()], 500);
        }
    }

    //MÉTODO PARA MODIFICAR UN ELEMENTO
    #[Route('/{id}',name:'edit_prescripcion', methods:['PUT'])]
    public function editPrescripcion(int $id, Request $request):JsonResponse
    {
        //Buscamos en BD
        $prescripcion=$this->repo->find($id);
        //Comprobamos que exista
        if(!$prescripcion){
            return $this->json('Elemento no encontrado', 404);
        }else{
            try {
                //Cogemos los datos de la Request
                $data=json_decode($request->getContent(), true);
                $f = $data['fecha'];
                $medicamento = $data['medicamento'];
                $posologia = $data['posologia'];
                $suspensionFecha = $data['suspension'];
                $suspension=DateTime::createFromFormat('d-m-Y', $suspensionFecha);
                $motivo=$data['motivo'];
                $pacient = $data['paciente'];
                //Añadimos los datos al nuevo elemento
                $fecha=DateTime::createFromFormat('d-m-Y', $f);
                if($fecha!=false){
                    $prescripcion->setFecha($fecha);
                }
                $prescripcion->setmedicamento($medicamento);
                $prescripcion->setPosologia($posologia);
                if($suspension!=false){
                    $prescripcion->setSuspension($suspension);
                }
                $prescripcion->setMotivo($motivo);
                //Buscamos el paciente que corresponde al prescripcion
                try {
                    $paciente=$this->pacienteRepo->find($pacient);
                    $prescripcion->setPaciente($paciente);
                    //Guardamos el nuevo elemento
                    $this->repo->save($prescripcion,true);
                    //Construimos la response con el toArray y la url
                    $data=[$prescripcion->toArray(),'enlace'=>$request->getRequestUri()."/".$prescripcion->getId()];
                    return $this->json($data,$status=201);   
                    
                } catch (Exception $e) {
                    return $this->json(['Error' => $e->getMessage()], 500);
                }
                //Guardamos el nuevo elemento
                if(!empty($prescripcion)){
                    $this->repo->save($prescripcion,true);
                }
                //Construimos la response con el toArray y la url
                $data=[$prescripcion->toArray(),'enlace'=>$request->getRequestUri()];
                return $this->json($data,$status=201);
    
            } catch (Exception $e) {
                return $this->json(['Error' => $e->getMessage()], 500);
            }

        }
    }

    //MÉTODO PARA BORRAR UN ELEMENTO
    #[Route('/{id}',name:'delete_prescripcion', methods:['DELETE'])]
    public function deletePrescripcion(int $id):JsonResponse
    {
        //Buscamos la prescripcion en BD
        $prescripcion=$this->repo->find($id);
        if(!$prescripcion){
            return $this->json('Elemento no encontrado', 404);
        }else{
            //Borramos el user que corresponde al paciente user
            //$paciente=$prescripcion->getPaciente();
            //$this->pacienteRepo->remove($paciente, true);
            $this->repo->remove($prescripcion, true);
            return $this->json('Elemento borrado', 200);
        }
    }
    
    //MÉTODO RECUPERAR TODOS LOS ELEMENTOS
    #[Route(name:'get_prescripcions', methods:['GET'])]
    public function getPrescripcions(Request $request):JsonResponse
    {
        $prescripciones = $this->repo->findAll(); 
        $datos = []; 
    
        if($prescripciones)
        {
            foreach ($prescripciones as $prescripcion) { 
                $datos[] = $prescripcion->toArray();
            } 
            //Construimos la response con el toArray y la url
            $data=[$datos,'enlace'=>$request->getRequestUri()];
            return $this->json($data,$status=201);
            
        }else{
            return $this->json('Elementos no encontrados', $status=404);
        }
    }

    //MÉTODO PARA RECUPERAR UN ELEMENTO
    #[Route('/{id}',name:'getprescripcion', methods:['GET'])]
    public function getPrescripcion(int $id, Request $request):JsonResponse
    {
        //Traemos el prescripcion mediante la id.
       $prescripcion=$this->repo->find($id);
       if(empty($prescripcion)){
            return $this->json('Elemento no encontrado', $status=404);
        }else{
            //Construimos la response con el toArray y la url
            $data=[$prescripcion->toArray(),'enlace'=>$request->getRequestUri()];
            return $this->json($data,$status=201);
        }
    }
}

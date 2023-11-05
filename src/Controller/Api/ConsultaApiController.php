<?php

namespace App\Controller\Api;

use App\Entity\Consulta;
use App\Repository\ConsultaRepository;
use App\Repository\PacienteRepository;
use App\Repository\TipoConsultaRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/consulta', name: 'app_consultaApi')]
//#[IsGranted('ROLE_MEDICO')]
class ConsultaApiController extends AbstractController
{
    private ConsultaRepository $repo;
    private PacienteRepository $pacienteRepo;
    private TipoConsultaRepository $tipoRepo;

    public function __construct(ConsultaRepository $repo, PacienteRepository $pacienteRepo, TipoConsultaRepository $tipoRepo)
    {
        $this->repo = $repo;
        $this->pacienteRepo = $pacienteRepo;
        $this->tipoRepo = $tipoRepo;
    }

    //MÉTODO PARA BORRAR UN ELEMENTO
    #[Route('/{id}', name: 'delete_consulta', methods: ['DELETE'])]
    public function deleteConsulta(int $id): JsonResponse
    {
        //Buscamos la consulta en BD
        $consulta = $this->repo->find($id);
        if (!$consulta) {
            return $this->json('Elemento no encontrado', 404);
        } else {
            //Borramos el user que corresponde al consulta user
            $this->repo->remove($consulta, true);
            return $this->json('Elemento borrado', 200);
        }
    }

    //MÉTODO PARA RECUPERAR UN ELEMENTOS POR DNI
    #[Route('/{id}', name: 'buscar_consulta', methods: ['GET'])]
    public function getConsulta(string $id, Request $request): JsonResponse
    {
        $consulta = $this->repo->find($id);

        // Si se encuentran consultas, devuélvelos en formato JSON
        if ($consulta) {
            $data = ['consulta' => $consulta->toArray(), 'enlace' => $request->getRequestUri()];
            return $this->json($data, $status = 201);
        } else {
            // Si no se encuentran consultas, devuelve un mensaje de error
            return $this->json('Elementos no encontrados', $status = 404);
        }
    }


    //MÉTODO RECUPERAR TODOS LOS ELEMENTOS
    #[Route(name: 'get_consultas', methods: ['GET'])]
    public function getConsultas(Request $request): JsonResponse
    {
        $consultas = $this->repo->findAll();
        $datos = [];

        if ($consultas) {
            foreach ($consultas as $consulta) {
                $datos[] = $consulta->toArray();
            }
            //Construimos la response con el toArray y la url
            $data = ['consulta' => $datos, 'enlace' => $request->getRequestUri()];
            return $this->json($data, $status = 201);
        } else {
            return $this->json('Elementos no encontrados', $status = 404);
        }
    }

    //MÉTODO PARA AÑADIR UN NUEVO ELEMENTO
    #[Route(name: 'add_consulta', methods: ['POST'])]
    public function addConsulta(Request $request): JsonResponse
    {
        $consulta = new Consulta();

        try {
            //Cogemos los datos de la Request
            $data = json_decode($request->getContent(), true);
            $notas = $data['notas_clinicas'];
            $pacienteId = $data['paciente_id'];
            $tipoId = $data['tipo_id'];
            $fecha = $data['fecha'];

            //Añadimos los datos al nuevo elemento
            if (!$notas) {
                $consulta->setNotasClinicas(null);
            } else {
                $consulta->setNotasClinicas($notas);
            }

            try {
                //Buscamos el consulta que corresponde a la consulta
                $paciente = $this->pacienteRepo->find($pacienteId);
                $consulta->setPaciente($paciente);
                //Buscamos el tipo de consulta
                $tipoConsulta = $this->tipoRepo->find($tipoId);
                $consulta->setTipo($tipoConsulta);
                //Tratamos la fecha
                $fechaHora = new DateTime($fecha);
                $consulta->setFecha($fechaHora);
                //Guardamos el nuevo elemento
                $this->repo->save($consulta, true);
                //Construimos la response con el toArray y la url
                $data = ['consulta' => $consulta->toArray(), 'enlace' => $request->getRequestUri() . "/" . $consulta->getId()];
                return $this->json($data, $status = 201);
            } catch (Exception $e) {
                return $this->json(['Error' => $e->getMessage()], 500);
            }
        } catch (Exception $e) {
            return $this->json(['Error' => $e->getMessage()], 500);
        }
    }

    //MÉTODO PARA MODIFICAR UN ELEMENTO
    #[Route('/{id}', name: 'edit_consultas', methods: ['PUT'])]
    public function editConsulta(int $id, Request $request): JsonResponse
    {
        $consulta = $this->repo->find($id);

        if (!$consulta) {
            return $this->json('Elemento no encontrado', 404);
        } else {
            try {
                //Traemos los datos de la request
                $data = json_decode($request->getContent(), true);
                $notas = $data['notas_clinicas'];
                $pacienteId = $data['paciente_id'];
                $tipoId = $data['tipo_id'];

                //Añadimos los nuevos datos
                if (!$notas) {
                    $consulta->setNotasClinicas(null);
                } else {
                    $consulta->setNotasClinicas($notas);
                }
                try {
                    //Buscamos el consulta que corresponde a la consulta
                    $paciente = $this->pacienteRepo->find($pacienteId);
                    $consulta->setPaciente($paciente);
                    //Buscamos el tipo de consulta
                    $tipoConsulta = $this->tipoRepo->find($tipoId);
                    $consulta->setTipo($tipoConsulta);

                    //Guardamos el nuevo elemento
                    $this->repo->save($consulta, true);
                    //Construimos la response con el toArray y la url
                    $data = ['consulta' => $consulta->toArray(), 'enlace' => $request->getRequestUri() . "/" . $consulta->getId()];
                    return $this->json($data, $status = 201);
                } catch (Exception $e) {
                    return $this->json(['Error' => $e->getMessage()], 500);
                }
            } catch (Exception $e) {
                return $this->json(['Error' => $e->getMessage()], 500);
            }
        }
    }
}

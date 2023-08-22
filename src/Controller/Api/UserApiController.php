<?php
//API PARA LA CLASE USUARIO
namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/api/user', name: 'app_user_api')]
#[IsGranted('ROLE_MEDICO')]
class UserApiController extends AbstractController
{
    private UserRepository $repo;
    public UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserRepository $repositorio, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->repo=$repositorio;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    //MÉTODO PARA AÑADIR UN NUEVO USUARIO
    #[Route(name:'add_user', methods:['POST'])]
    public function addUser(Request $request):JsonResponse
    {
        $user=new User(); 

        try {
            //Cogemos los datos de la Request
            $data=json_decode($request->getContent(), true);
            $email=$data['email'];
            $pass=$data['password'];
            $rol=$data['roles'];
            //Codificamos la contraseña
            $hashedPassword = $this->userPasswordHasher->hashPassword($user,$pass);
            //Añadimos los datos al nuevo usuario
            $user->setEmail($email);
            $user->setPassword($hashedPassword);
            $user->setRoles($rol);
            //Guardamos el nuevo usuario
            if(!empty($user)){
                $this->repo->save($user,true);
            }

            //Construimos la response con el toArray y la url
            $data=[$user->toArray(),'enlace'=>$request->getRequestUri()];
            return $this->json($data,$status=201);

        } catch (Exception $e) {
            return $this->json(['Error' => $e->getMessage()], 500);
        }
    }

    //MÉTODO PARA MODIFICAR UN USUARIO
    #[Route('/{id}',name:'edit_user', methods:['PUT'])]
    public function editUser(int $id, Request $request):JsonResponse
    {
        //Buscamos en BD
        $user=$this->repo->find($id);
        //Comprobamos que exista
        if(empty($user)){
            return $this->json('Elemento no encontrado', 404);
        }else{
            try {
                //Cogemos los datos de la Request
                $data=json_decode($request->getContent(), true);
                $email=$data['email'];
                $pass=$data['password'];
                $rol=$data['roles'];
                //Codificamos la contraseña
                $hashedPassword = $this->userPasswordHasher->hashPassword($user,$pass);
                //Añadimos los datos al nuevo usuario
                $user->setEmail($email);
                $user->setPassword($hashedPassword);
                $user->setRoles($rol);
                //Guardamos el nuevo usuario
                if(!empty($user)){
                    $this->repo->save($user,true);
                }
                //Construimos la response con el toArray y la url
                $data=[$user->toArray(),'enlace'=>$request->getRequestUri()];
                return $this->json($data,$status=201);
    
            } catch (Exception $e) {
                return $this->json(['Error' => $e->getMessage()], 500);
            }

        }
    }

    //MÉTODO PARA BORRAR UN USUARIO
    #[Route('/{id}',name:'delete_user', methods:['DELETE'])]
    public function deleteUser(int $id):JsonResponse
    {
        //Buscamos la user en BD
        $user=$this->repo->find($id);
        if(empty($user)){
            return $this->json('Elemento no encontrado', 404);
        }else{
            $this->repo->remove($user, true);
            return $this->json('Elemento borrado', 200);
        }
    }
    
    //MÉTODO RECUPERAR TODOS LOS USUARIOS
    #[Route(name:'get_users', methods:['GET'])]
    public function getUsers(Request $request):JsonResponse
    {
        $usuarios = $this->repo->findAll(); 
        $datos = []; 
    
        if(!empty($usuarios))
        {
            foreach ($usuarios as $usuario) { 
                $datos[] = $usuario->toArray();
            } 
        
            //Construimos la response con el toArray y la url
            $data=[$datos,'enlace'=>$request->getRequestUri()];
            return $this->json($data,$status=201);

        }else{
            return $this->json('Elementos no encontrados', $status=404);
        }
    }

    //MÉTODO PARA RECUPERAR UN USUARIO
    #[Route('/{id}',name:'getUser', methods:['GET'])]
    public function getUsuario(int $id, Request $request):JsonResponse
    {
        //Traemos el user mediante la id.
       $user=$this->repo->find($id);
       if(empty($user)){
            return $this->json('Elemento no encontrado', $status=404);
        }else{
            //Construimos la response con el toArray y la url
            $data=[$user->toArray(),'enlace'=>$request->getRequestUri()];
            return $this->json($data,$status=201);
        }
    }



}

<?php

namespace App\Controller;
use App\Entity\Utilisateur;
use App\Form\ForgetPassType;
use App\Form\UtilisateurType;
use App\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\UtilisateurRepository;
use App\Repository\RoleRepository;
use App\Service\MailerService;
use App\Service\QrCodeGenerator;
use InvalidArgumentException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class UtilisateurController extends AbstractController
{
    private $filesystem;
    private $roleRepository;
    private $utilisateurRepository;
    private $mailer;
    private $generetaQr;
    private $mailerInterface;
    private $qrCodeGenerator;
    public function __construct(RoleRepository $roleRepository,
    UtilisateurRepository $utilisateurRepository,MailerService $mailer,
    QrCodeGenerator $generetaQr,Filesystem $filesystem,MailerInterface $mailerInterface,
    QrCodeGenerator $qrCodeGenerator )
    {  $this->filesystem=$filesystem;
         $this->generetaQr=$generetaQr;
        $this->mailer = $mailer;
        $this->utilisateurRepository = $utilisateurRepository;
        $this->roleRepository = $roleRepository;
        $this->mailerInterface = $mailerInterface;
        $this->qrCodeGenerator=$qrCodeGenerator;
    }

    #[Route('/', name: 'firstpage' , methods: ['GET', 'POST'])]
    public function toLogin(AuthenticationUtils $authenticationUtils,Request $request): Response
    {
        return $this->redirect('login');
         
    }
    #[Route('/login', name: 'loginspace' , methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authenticationUtils,Request $request,Security $security ): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();        
        /*$user=$this->utilisateurRepository->findByemail($lastUsername);
        if($user && $user->getEtat()=='Disable'){
            $this->addFlash('error', 'Votre compte est bloqué');
            return $this->redirectToRoute('loginspace');
        }*/
     
           
        
        return $this->render('utilisateur/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    
    #[Route('/profile', name: 'profile_page' ,methods: ['GET', 'POST'])]
    public function profile(Request $request,UtilisateurRepository $utilisateurRepository ,UserPasswordHasherInterface $userPasswordHasher,UserInterface $userInterface): Response
    {
        try{
            $message='';
        $user = $this->getUser();
        $qrCode=$this->qrCodeGenerator->createQrCode($user);
        //$qrCode->setSize(300);
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->getClickedButton() && 'submit' === $form->getClickedButton()->getName()) {
         if($form->get('newmdp')->getData()==null){
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('mdp')->getData()
                )
            );
            $utilisateurRepository->save($user, true);
            return $this->redirectToRoute('profile_page');
         }
         else {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('newmdp')->getData()
                )
            );
            $utilisateurRepository->save($user, true);
            return $this->redirectToRoute('profile_page');
         }

           // if ($userPasswordHasher->isPasswordValid($userInterface, $form->get('mdp')->getData())) {
            } 
        
      //  }
      
    }
    if($form->getClickedButton() && 'delete' === $form->getClickedButton()->getName()) {  
        $this->deleteFile($user->getPhotoPersonel());
        $this->deleteFile($user->getPhotoPermis());
        $utilisateurRepository->remove($this->getUser(), true);
        $this->container->get('security.token_storage')->setToken(null);  
        
        return $this->redirectToRoute('loginspace');
    }
        }
        catch(AccessDeniedHttpException $ex){
        }

        catch(InvalidArgumentException $ex){
            $message='il y a des champs vides';
        }
      
        return $this->render('utilisateur/profile.html.twig', [
            'controller_name' => 'UtilisateurController',
             'form' => $form->createView(),
             'user'=>$user,
             'message'=>$message,
             'qrCode' => $qrCode->getDataUri()
        ]);
    }
   
   

    #[Route('/signup', name: 'signup', methods: ['GET', 'POST'])]
    public function signup(Request $request,SluggerInterface $slugger,UtilisateurRepository $utilisateurRepository,UserPasswordHasherInterface $userPasswordHasher ): Response
    {
        $message='';
        $message1='';
        $message2='';
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('mdp')->getData()
                )
            );
    
            $today = new \DateTime();
            $diff = $today->diff($user->getDateNaiss());
            $user->setAge($diff->format('%y'));
    
            $personelDirectory = $this->getParameter('personnel_directory');
            $permisDirectory = $this->getParameter('permis_directory');
    
            $photopersonnel = $form->get('photo_personel')->getData();
            $photopermis = $form->get('photo_permis')->getData();
    
            if ($photopersonnel && $photopermis) {
    
                try {
                    if ((!file_exists($personelDirectory))) {
                        mkdir($personelDirectory, 0777, true);
                    }
    
                    if ((!file_exists($permisDirectory))) {
                        mkdir($permisDirectory, 0777, true);
                    }
    
                    $photopersonnelname = pathinfo($photopersonnel->getClientOriginalName(), PATHINFO_FILENAME);
                    $photopermisname = pathinfo($photopermis->getClientOriginalName(), PATHINFO_FILENAME);
                    $slugger = new AsciiSlugger();
                    $safePersonnelname = $slugger->slug($photopersonnelname);
                    $safePermisname = $slugger->slug($photopermisname);
                    $newpersonnelname = 'personnel_directory' . '/' . $safePersonnelname . '-' . uniqid() . '.' . $photopersonnel->guessExtension();
                    $newpermisname = 'permis_directory' . '/' . $safePermisname . '-' . uniqid() . '.' . $photopermis->guessExtension();
                    $photopersonnel->move(
                        $this->getParameter('personnel_directory'),
                        $newpersonnelname
                    );
                    $photopermis->move(
                        $this->getParameter('permis_directory'),
                        $newpermisname
                    );
                } catch (FileException $e) {
                    echo $e;
                }
            }
            $user->setPhotoPersonel($newpersonnelname ?? "");
            $user->setPhotoPermis($newpermisname ?? "");
            $user->setRole($this->roleRepository->find(2));
            $user->setEtat('Bloqué');
            if($utilisateurRepository->findByemail($user->getLogin())){
                $message='email déja utilisé';
            }
            else if($utilisateurRepository->findBycin($user->getCin())){
                $message1='cin déja utilisé';
            }
            else if($utilisateurRepository->findBynumpermis($user->getNumPermis())){
                $message2='numéro de permis déja utilisé';
            }
            else {
            $utilisateurRepository->save($user, true);
            $this->mailer->sendRegistrationEmail($this->mailerInterface,$user->getLogin(),$user->getPrenom());
            return $this->redirectToRoute('loginspace');
            }
        }
       return $this->render('utilisateur/signup.html.twig', [      
           'form' => $form->createView(),'message'=>$message,'message1'=>$message1,'message2'=>$message2
         
       ]);
     

    }  


    #[Route('/delete/{id}', name: 'user_delete', methods: ['GET','POST'])]
    public function delete(UtilisateurRepository $utilisateurRepository,$id,Request $request): Response
    { $user=$utilisateurRepository->find($id);
       // if ($this->isCsrfTokenValid('delete'.$utilisateurRepository->find($id)->getId(), $request->request->get('_token'))) {
        $this->deleteFile($user->getPhotoPersonel());
        $this->deleteFile($user->getPhotoPermis());
            $utilisateurRepository->remove($user, true);
       //}

        return $this->redirectToRoute('liste_admin',[
            'm'=>$utilisateurRepository->find($id)
        ]);
    }

public function deleteFile(string $path)
{

     $this->filesystem->remove($path);

}

 #[Route("/search-users", name:"search_users",methods: ['GET'])]
 
public function searchUsers(Request $request, UtilisateurRepository $userRepository,NormalizerInterface $normalizer)
{
    $searchTerm = $request->query->get('term');

    $users = $userRepository->findBySearchTerm($searchTerm);
    $jsonContent = $normalizer->normalize($users,'json');
    $retour = json_encode($jsonContent);

    return new Response($retour);
}
#[Route('/liste', name: 'liste')]
public function liste(UtilisateurRepository $utilisateurRepository, RoleRepository $roleRepository)
{       
    $users = $utilisateurRepository->findByRoleId($roleRepository->find(2));

    return new JsonResponse($users);
}
}
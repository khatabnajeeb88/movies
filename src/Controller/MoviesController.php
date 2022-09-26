<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieFormType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class MoviesController extends AbstractController
{

    private $em;
    private $movieRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/movies', name: 'movies')]
    public function index(): Response
    {
        $repository = $this->em->getRepository(Movie::class);
        $movies = $repository->findAll();
        return $this->render('movies/index.html.twig', array(
            'movies' => $movies,
            'imageDir' => '/images/uploads/'
        ));
    }


    #[Route('/movies/create', name: 'create_movie')]
    public function create(Request $request): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $newMovie = $form->getData();
            $imagePath = $form->get('imagePath')->getData();
            if ($imagePath) {
                $newFileName = uniqid() . '.' . $imagePath->guessExtension();
                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/images/uploads',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }

                $newMovie->setImagePath($newFileName);
            }

            $this->em->persist($newMovie);
            $this->em->flush();

            return $this->redirectToRoute('movies');
        }

        return $this->render('movies/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/movies/edit/{id}', name: 'edit_movie')]
    public function edit(Request $request, $id): Response
    {
        $repository = $this->em->getRepository(Movie::class);
        $movie = $repository->find($id);
        $form = $this->createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $imagePath = $form->get('imagePath')->getData();
            if ($imagePath) {
                $newFileName = uniqid() . '.' . $imagePath->guessExtension();
                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/images/uploads',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }

                $movie->setImagePath($newFileName);
                $this->em->persist($movie);
                $this->em->flush();
                return $this->redirectToRoute('movies');
            } else {
                $movie->setTitle($form->get('title')->getData());
                $movie->setReleaseYear($form->get('releaseYear')->getData());
                $movie->setDescription($form->get('description')->getData());

                $this->em->flush();
                return $this->redirectToRoute('movies');
            }
        }

        return $this->render('movies/edit.html.twig', [
            'form' => $form->createView(),
            'movie' => $movie
        ]);
    }

    #[Route('/movies/delete/{id}', name: 'delete_movie',  methods:['GET', 'DELETE'])]
    public function delete($id): Response
    {
        $repository = $this->em->getRepository(Movie::class);
        $movie = $repository->find($id);
        $this->em->remove($movie);
        $this->em->flush();
        return $this->redirectToRoute('movies');
    }


    #[Route('/movies/{id}', name: 'show_movie', methods:['GET'])]
    public function show($id): Response
    {
        $repository = $this->em->getRepository(Movie::class);
        $movie = $repository->find($id);
        return $this->render('movies/show.html.twig', array(
            'movie' => $movie,
            'imageDir' => '/images/uploads/'
        ));
    }

    
    
    // #[Route('/movies', name: 'app_movies')]
    // public function index(): Response
    // {
    //     // findAll() - SELECT * FROM movies
    //     // find() - SELECT * FROM movies WHERE id = 5;
    //     // findBy() - SELECT * FROM movies ORDER BY id DESC;
    //     // findOneBy() - SELECT * FROM movies WHERE id = 5 AND title = 'UP' ORDER BY is DESC;
    //     // count() - SELECT COUNT() FROM movies WHERE id = 5;
    //     // getClassName - 

    //     $repository = $this->em->getRepository(Movie::class);
    //     // $movie = $repository->findAll();
    //     // $movie = $repository->find(6);
    //     // $movie = $repository->findBy([], ['id' => 'DESC']);
    //     // $movie = $repository->findOneBy(['id' => 5, 'title' => 'UP'], ['id' => 'DESC']);
    //     // $movie = $repository->getClassName();
    //     // dd($movie);
    //     return $this->render('index.html.twig');
    // }

    // #[Route('/movies', name: 'app_movies')]
    // public function index(): Response
    // {
    //     $movies = ["UP", "BEE", "ET", "LORD OF THE RINGS"];
    //     return $this->render('index.html.twig', array(
    //         'movies' => $movies
    //     ));
    // }

    // #[Route('/movies/{name}', name: 'app_movies', defaults: ['name' => null ], methods:['GET', 'HEAD'])]
    // public function index($name): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller! ' . $name,
    //         'path' => 'src/Controller/MoviesController.php',
    //     ]);
    // }
}

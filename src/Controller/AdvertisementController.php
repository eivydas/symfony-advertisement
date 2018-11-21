<?php

namespace App\Controller;

use App\Entity\Advertisement;
use App\Form\AdvertisementType;
use App\Repository\AdvertisementRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/advertisements")
 */
class AdvertisementController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, name="advertisements")
     * @param Request $request
     * @param AdvertisementRepository $advertisementRepository
     * @param int $page
     * @return Response
     */
    public function index(Request $request, AdvertisementRepository $advertisementRepository, int $page): Response
    {
        $advertisements = $advertisementRepository->findLatest($page);

        return $this->render('advertisement/index.html.twig', [
            'advertisements' => $advertisements,
        ]);
    }

    /**
     * @Route("/new", methods={"GET", "POST"}, name="advertisements_new")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $advertisement = new Advertisement();
        $advertisement->setUser($this->getUser());

        $form = $this->createForm(AdvertisementType::class, $advertisement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $advertisement->setIsActive(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($advertisement);
            $em->flush();

            return $this->redirectToRoute('my_advertisements');
        }

        return $this->render('advertisement/new.html.twig', [
            'advertisement' => $advertisement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="advertisements_show")
     * @param Advertisement $advertisement
     * @return Response
     */
    public function show(Advertisement $advertisement): Response
    {
        return $this->render('advertisement/show.html.twig', [
            'advertisement' => $advertisement,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\AdvertisementRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/my")
 * @IsGranted("ROLE_USER")
 */
class MyController extends AbstractController
{
    /**
     * @Route("/advertisements", defaults={"page": "1"}, name="my_advertisements")
     * @param Request $request
     * @param AdvertisementRepository $advertisementRepository
     * @param int $page
     * @return Response
     */
    public function my(Request $request, AdvertisementRepository $advertisementRepository, int $page): Response
    {
        $advertisements = $advertisementRepository->findLatestByUser($this->getUser());

        return $this->render('advertisement/index.html.twig', [
            'advertisements' => $advertisements,
        ]);
    }
}

<?php

namespace App\Controller;

use App\League\Action\CalculateScoreAction;
use App\League\Action\CreateAction;
use App\League\Dto\CalculateScoreActionInputDto;
use App\League\Type\CalculateScoreType;
use App\League\Type\LeagueCreateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class LeagueController extends AbstractController
{
    #[Route('/api/league/create', name: 'league_create', methods: ['POST'])]
    public function create(Request $request, CreateAction $action): Response
    {
        $form = $this->createForm(LeagueCreateType::class);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $leagueId = $form->get('id')->getData();

            return $this->json([
                'message' => 'ok',
                'league' => $action->execute($leagueId),
            ], Response::HTTP_CREATED);
        }

        return $this->json(['message' => 'fail'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/api/league/{id}/play', name: 'league_calculate', methods: ['POST'])]
    public function calculate(Request $request, CalculateScoreAction $action, SerializerInterface $serializer): Response
    {
        $form = $this->createForm(CalculateScoreType::class);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $league = $action->execute($form->getData());

            return $this->json([
                'message' => 'ok',
                'league' => $league,
            ], Response::HTTP_OK);
        }

        return $this->json(['message' => 'fail'], Response::HTTP_BAD_REQUEST);
    }
}

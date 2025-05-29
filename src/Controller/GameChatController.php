<?php
// src/Controller/GameChatController.php

namespace App\Controller;

use App\Entity\ChatRoom;
use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class GameChatController extends AbstractController
{
    #[Route('/game/chat', name: 'game_chat_interface')]
    public function chatInterface(EntityManagerInterface $em): Response
    {
        // Récupérer les différentes rooms disponibles
        $globalRoom = $em->getRepository(ChatRoom::class)->findOneBy(['type' => 'global']);
        $tradeRoom = $em->getRepository(ChatRoom::class)->findOneBy(['type' => 'trade']);
       
        // Créer les rooms par défaut si elles n'existent pas
        if (!$globalRoom) {
            $globalRoom = new ChatRoom();
            $globalRoom->setName('Chat Global')
                      ->setType('global')
                      ->setMaxUsers(1000);
            $em->persist($globalRoom);
        }
       
        if (!$tradeRoom) {
            $tradeRoom = new ChatRoom();
            $tradeRoom->setName('Commerce')
                     ->setType('trade')
                     ->setMaxUsers(500);
            $em->persist($tradeRoom);
        }
       
        $em->flush();

        return $this->render('game/chat.html.twig', [
            'globalRoom' => $globalRoom,
            'tradeRoom' => $tradeRoom,
        ]);
    }

    #[Route('/game/chat/messages/{roomId}', name: 'game_chat_messages')]
    public function getMessages(int $roomId, EntityManagerInterface $em): JsonResponse
    {
        $room = $em->getRepository(ChatRoom::class)->find($roomId);
        if (!$room) {
            return new JsonResponse(['error' => 'Room not found'], 404);
        }

        $messages = $em->getRepository(Message::class)->findBy(
            ['room' => $room],
            ['timestamp' => 'DESC'],
            50 // Limiter à 50 derniers messages
        );

        $formattedMessages = array_map(function($message) {
            return [
                'id' => $message->getId(),
                'content' => $message->getContent(),
                'sender' => $message->getSender(),
                'timestamp' => $message->getTimestamp()->format('H:i:s'),
                'type' => $message->getMessageType()
            ];
        }, array_reverse($messages));

        return new JsonResponse($formattedMessages);
    }

    #[Route('/game/chat/send/{roomId}', name: 'game_chat_send', methods: ['POST'])]
    public function sendMessage(
        int $roomId,
        Request $request,
        EntityManagerInterface $em,
        HubInterface $hub
    ): JsonResponse {
        $room = $em->getRepository(ChatRoom::class)->find($roomId);
        if (!$room) {
            return new JsonResponse(['error' => 'Room not found'], 404);
        }

        $content = trim($request->request->get('message'));
        $sender = $request->request->get('username');

        if (empty($content) || empty($sender)) {
            return new JsonResponse(['error' => 'Message or username empty'], 400);
        }

        // Filtrage des commandes de chat
        $messageType = 'normal';
        if (str_starts_with($content, '/trade ')) {
            $messageType = 'trade';
            $content = substr($content, 7); // Enlever "/trade "
        } elseif (str_starts_with($content, '/whisper ')) {
            $messageType = 'whisper';
            // Logique pour whisper...
        }

        $message = new Message();
        $message->setContent($content)
               ->setSender($sender)
               ->setTimestamp(new \DateTimeImmutable())
               ->setRoom($room)
               ->setMessageType($messageType);

        $em->persist($message);
        $em->flush();

        // Publication via Mercure
        $update = new Update(
            "/game/chat/{$roomId}",
            json_encode([
                'id' => $message->getId(),
                'content' => $message->getContent(),
                'sender' => $message->getSender(),
                'timestamp' => $message->getTimestamp()->format('H:i:s'),
                'type' => $messageType,
                'roomId' => $roomId
            ])
        );
        $hub->publish($update);

        return new JsonResponse(['success' => true]);
    }

    #[Route('/game/chat/private/create', name: 'game_chat_private_create', methods: ['POST'])]
    public function createPrivateRoom(
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        $targetUser = $request->request->get('targetUser');
        $currentUser = $request->request->get('currentUser');

        // Vérifier si une room privée existe déjà entre ces utilisateurs
        $existingRoom = $em->getRepository(ChatRoom::class)->createQueryBuilder('r')
            ->where('r.type = :type')
            ->andWhere('JSON_CONTAINS(r.allowedUsers, :users) = 1')
            ->setParameter('type', 'private')
            ->setParameter('users', json_encode([$currentUser, $targetUser]))
            ->getQuery()
            ->getOneOrNullResult();

        if ($existingRoom) {
            return new JsonResponse(['roomId' => $existingRoom->getId()]);
        }

        // Créer nouvelle room privée
        $privateRoom = new ChatRoom();
        $privateRoom->setName("Chat privé: {$currentUser} & {$targetUser}")
                   ->setType('private')
                   ->setAllowedUsers([$currentUser, $targetUser])
                   ->setMaxUsers(2);

        $em->persist($privateRoom);
        $em->flush();

        return new JsonResponse(['roomId' => $privateRoom->getId()]);
    }
}
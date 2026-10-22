<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ChatController extends BaseController
{
    protected $current_menu = 'chat';
    protected $title = 'Chat';

    protected $chatMessageModel;
    protected $userModel;
    public function __construct() {
        $this->chatMessageModel = model('ChatMessageModel');
        $this->userModel = model('UserModel');
    }
    public function index()
    {
        $users = $this->userModel->where('id !=', auth()->getUser()->id)->findAll();
        $final_array = array();
        foreach($users as $user) {
            $conversation = $this->chatMessageModel->getConversation($user->id, auth()->getUser()->id);
            $lastMessage = !empty($conversation['data']) ? end($conversation['data']) : null;
            $final_array[] = [
                'user' => $user,
                'last_message' => $lastMessage
            ];
        }
        return $this->render('front/chat/choice-receiver', ['users' => $final_array]);
    }

    public function conversation($receiver_username) {
        $receiver = $this->userModel->where('username', $receiver_username)->first();
        if(empty($receiver)) {
            $this->error('Utilisateur introuvable');
            return $this->redirect('/chat');
        }
        $id_receiver = $receiver->id;
        $id_sender = auth()->getUser()->id;
        $data = $this->chatMessageModel->getConversation($id_sender, $id_receiver);
        return $this->render('front/chat/chat', ['messages' => $data['data'], 'max_page' => $data['max_page'], 'receiver' => $receiver]);
    }

    public function send() {
        if(!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Requêtes invalide']);
        }
        $sender_id = auth()->getUser()->id;
        $receiver_id = $this->request->getPost('receiver_id');
        $message = $this->request->getPost('message');

        if(empty($message) || empty($receiver_id)) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Le message ou le destinataire est manquant',
            ]);
        }

        $data = [
            'id_sender' => $sender_id,
            'id_receiver' => $receiver_id,
            'message' => $message,
        ];

        $messageId = $this->chatMessageModel->insert($data);
        if($messageId) {
            $newMessage = $this->chatMessageModel->find($messageId);

            $htmlBubble = view_cell('BubbleMessageCell', [
                'chatMessage' => $newMessage,
                'sender_context' => true,
            ]);

            return $this->response->setJSON([
                'success' => true,
                'html' => $htmlBubble,
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'error' => 'Erreur lors de la sauvegarde'
        ]);
    }

    public function newMessages() {
        if(!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Requêtes invalide']);
        }
        $sender_id = auth()->getUser()->id;
        $receiver_id = $this->request->getGet('receiver_id');
        $lastDate = $this->request->getGet('last_date');

        if(empty($receiver_id) || empty($lastDate)) {
            return $this->response->setJSON([
                'success' => false,
                'messages' => []
            ]);
        }

        $newMessages = $this->chatMessageModel->getNewMessages($sender_id, $receiver_id, $lastDate);

        $htmlBubbles = '';
        $latestDate = $lastDate;
        foreach($newMessages as $message) {
            $htmlBubble = view_cell('BubbleMessageCell', [
                'chatMessage' => $message,
                'sender_context' => false,
            ]);
            $htmlBubbles .= $htmlBubble;
            $latestDate = $message->created_at;
        }

        return $this->response->setJSON([
            'success' => true,
            'html' => $htmlBubbles,
            'latest_date' => (string) $latestDate,
        ]);
    }
}
<?php

namespace App\Models;

use App\Entities\ChatMessage;
use CodeIgniter\Model;

class ChatMessageModel extends Model
{
    protected $table            = 'chat_messages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ChatMessage::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_sender', 'id_receiver', 'message'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getConversation($id_receiver, $id_sender, $page = 1)
    {
        $data = $this->groupStart()
            ->where('id_receiver', $id_receiver)
            ->where('id_sender', $id_sender)
            ->groupEnd()
            ->orGroupStart()
            ->where('id_receiver', $id_sender)
            ->where('id_sender', $id_receiver)
            ->groupEnd()
            ->orderBy('created_at', 'DESC')
            ->paginate(10, 'default', $page);

        return [
            'data'     => array_reverse($data),
            'max_page' => $this->pager->getPageCount(),
        ];
    }
    public function getNewMessages(int $sender,int$receiver_id,$data){
        $new_messages = $this->where('id_sender',$receiver_id)
            ->where('id_receiver',$sender_id)
            ->where('created_at >',$data)
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

}
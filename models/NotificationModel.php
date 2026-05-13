<?php 
declare(strict_types=1);

class NotificationModel extends BaseModel {

    protected string $table = "notifications";

    public function getUnread(int $userId): array {
        $stmt=$this->db->prepare("SELECT * FROM {$this->table} WHERE user_id=:uid AND is_read=0 ORDER BY created_at DESC LIMIT 20");
        $stmt->execute(["uid"=>$userId]); return $stmt->fetchAll();
    }

    public function markRead(int $id): bool { return $this->update($id,["is_read"=>1]); }

    public function createNotification(int $userId, string $type, string $message, ?string $entityType=null, ?int $entityId=null): int {
        $data=["user_id"=>$userId,"type"=>$type,"message"=>$message];
        return $this->create($data);
    }
}

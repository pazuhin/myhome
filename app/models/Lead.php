<?php


namespace app\models;


use core\base\Model;

class Lead extends Model
{
    public $attributes = [
        'regionName' => '',
        'groupName' => '',
        'typeName' => '',
        'message' => '',
        'userId' => '',
        'status' => 'registered',
    ];

    const STATUSES = [
        'registered' => 'Зарегистрирована',
        'accepted' => 'Принята',
        'denied' => 'Отклонена',
        'complited' => 'Завершена',
    ];

    /**
     * @param string $table
     */
    public function save(string $table)
    {
        $sql = 'INSERT INTO ' . $table . ' (region_name, group_name, type_name, message, user_id, created_at, status) VALUES (:region_name, :group_name, :type_name, :message, :user_id, now(), :status)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':region_name' => $this->attributes['regionName'],
            ':group_name' => $this->attributes['groupName'],
            ':type_name' => $this->attributes['typeName'],
            ':message' => $this->attributes['message'],
            ':user_id' => $this->attributes['userId'],
            ':status' => $this->attributes['status'],
        ]);

        return true;
    }

    /**
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function getList($limit = null, $offset = null)
    {
        $sql = "select l.id, l.region_name, l.group_name, l.type_name, l.message, l.created_at, l.status, u.name from leads l join users u on l.user_id = u.id limit $limit offset $offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @return mixed
     */
    public function getLeadsCount()
    {
        $sql = 'select count(*) from leads';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        $sql = "select l.id, l.region_name, l.group_name, l.type_name, l.message, l.created_at, l.status, u.name from leads l join users u on l.user_id = u.id where l.id=:leadId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':leadId' => $id]);

        return $stmt->fetchAll()[0];
    }

    /**
     * @param int $id
     * @param string $status
     */
    public function updateStatus(int $id, string $status)
    {
        $sql = 'UPDATE leads SET status=:status, updated_at=now() WHERE id=:id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':status' => $status, ':id' => $id]);
    }
}
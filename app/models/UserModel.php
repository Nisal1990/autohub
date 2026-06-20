<?php
/**
 * AutoHub LK — User Model
 */

class UserModel extends Model
{
    public function findByEmail(string $email): array|false
    {
        return $this->fetchOne('SELECT * FROM users WHERE email = ?', [$email]);
    }

    public function findById(int $id): array|false
    {
        return $this->fetchOne('SELECT * FROM users WHERE id = ?', [$id]);
    }

    public function create(array $data): int
    {
        $this->execute(
            'INSERT INTO users (name, email, phone, password_hash, role, district, city)
             VALUES (?, ?, ?, ?, ?, ?, ?)',
            [
                $data['name'],
                $data['email'],
                $data['phone'] ?? '',
                password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]),
                $data['role'] ?? 'user',
                $data['district'] ?? '',
                $data['city'] ?? '',
            ]
        );
        return (int) $this->lastInsertId();
    }

    public function updateProfile(int $id, array $data): void
    {
        $this->execute(
            'UPDATE users SET name=?, phone=?, district=?, city=?, updated_at=NOW()
             WHERE id=?',
            [$data['name'], $data['phone'], $data['district'], $data['city'], $id]
        );
    }

    public function updatePassword(int $id, string $newPassword): void
    {
        $this->execute(
            'UPDATE users SET password_hash=? WHERE id=?',
            [password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]), $id]
        );
    }

    public function verifyPassword(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash);
    }

    public function emailExists(string $email, int $excludeId = 0): bool
    {
        $sql = 'SELECT COUNT(*) FROM users WHERE email = ? AND id != ?';
        return $this->count($sql, [$email, $excludeId]) > 0;
    }

    // Admin — list all users
    public function listAll(int $page = 1, int $perPage = 20, string $search = ''): array
    {
        $offset = ($page - 1) * $perPage;
        $like   = '%' . $search . '%';
        $sql = 'SELECT id,name,email,phone,role,district,status,created_at
                FROM users WHERE (name LIKE ? OR email LIKE ?) AND role != "admin"
                ORDER BY created_at DESC LIMIT ? OFFSET ?';
        return $this->fetchAll($sql, [$like, $like, $perPage, $offset]);
    }

    public function countAll(string $search = ''): int
    {
        $like = '%' . $search . '%';
        return $this->count(
            'SELECT COUNT(*) FROM users WHERE (name LIKE ? OR email LIKE ?) AND role != "admin"',
            [$like, $like]
        );
    }

    public function suspend(int $id): void
    {
        $this->execute('UPDATE users SET status="suspended" WHERE id=?', [$id]);
    }

    public function activate(int $id): void
    {
        $this->execute('UPDATE users SET status="active" WHERE id=?', [$id]);
    }

    public function delete(int $id): void
    {
        $this->execute('DELETE FROM users WHERE id=? AND role != "admin"', [$id]);
    }
}

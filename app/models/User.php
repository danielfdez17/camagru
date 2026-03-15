<?php

class User
{
	private $db;

	public function __construct()
	{
		$this->db = new Database();
		$this->ensureUsersTable();
	}

	private function ensureUsersTable()
	{
		$this->db->query(
			"CREATE TABLE IF NOT EXISTS users (
				id SERIAL PRIMARY KEY,
				username VARCHAR(50) NOT NULL UNIQUE,
				email VARCHAR(255) NOT NULL UNIQUE,
				password_hash VARCHAR(255) NOT NULL,
				created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				active BOOLEAN NOT NULL DEFAULT TRUE
			)"
		);
		$this->db->execute();
	}

	public function findByUsernameOrEmail($identity)
	{
		$this->db->query("SELECT * FROM users WHERE username = :identity OR email = :identity LIMIT 1");
		$this->db->bind(':identity', $identity);
		return $this->db->result();
	}

	public function findById($id)
	{
		$this->db->query("SELECT id, username, email, created_at, active FROM users WHERE id = :id LIMIT 1");
		$this->db->bind(':id', $id);
		return $this->db->result();
	}

	public function usernameExists($username, $excludeId = null)
	{
		$sql = "SELECT id FROM users WHERE username = :username";
		if ($excludeId !== null) {
			$sql .= " AND id <> :exclude_id";
		}
		$sql .= " LIMIT 1";

		$this->db->query($sql);
		$this->db->bind(':username', $username);
		if ($excludeId !== null) {
			$this->db->bind(':exclude_id', $excludeId);
		}

		return (bool) $this->db->result();
	}

	public function emailExists($email, $excludeId = null)
	{
		$sql = "SELECT id FROM users WHERE email = :email";
		if ($excludeId !== null) {
			$sql .= " AND id <> :exclude_id";
		}
		$sql .= " LIMIT 1";

		$this->db->query($sql);
		$this->db->bind(':email', $email);
		if ($excludeId !== null) {
			$this->db->bind(':exclude_id', $excludeId);
		}

		return (bool) $this->db->result();
	}

	public function createUser($username, $email, $password)
	{
		$passwordHash = password_hash($password, PASSWORD_DEFAULT);

		$this->db->query("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)");
		$this->db->bind(':username', $username);
		$this->db->bind(':email', $email);
		$this->db->bind(':password_hash', $passwordHash);

		return $this->db->execute();
	}

	public function verifyCredentials($identity, $password)
	{
		$user = $this->findByUsernameOrEmail($identity);

		if (!$user || !$this->isActive($user['active'] ?? null)) {
			return false;
		}

		if (!password_verify($password, $user['password_hash'])) {
			return false;
		}

		return [
			'id' => $user['id'],
			'username' => $user['username'],
			'email' => $user['email'],
		];
	}

	private function isActive($value)
	{
		if (is_bool($value)) {
			return $value;
		}

		$normalized = strtolower((string) $value);
		return in_array($normalized, ['1', 't', 'true', 'y', 'yes', 'on'], true);
	}

	public function updateProfile($id, $username, $email, $newPassword = null)
	{
		if ($newPassword !== null && $newPassword !== '') {
			$passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
			$this->db->query(
				"UPDATE users
				SET username = :username,
					email = :email,
					password_hash = :password_hash
				WHERE id = :id"
			);
			$this->db->bind(':password_hash', $passwordHash);
		} else {
			$this->db->query(
				"UPDATE users
				SET username = :username,
					email = :email
				WHERE id = :id"
			);
		}

		$this->db->bind(':username', $username);
		$this->db->bind(':email', $email);
		$this->db->bind(':id', $id);

		return $this->db->execute();
	}
}


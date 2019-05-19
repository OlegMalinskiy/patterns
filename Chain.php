<?php

abstract class Middleware {

	private $nextMiddleware;

	public function link(Middleware $nextMiddleware): Middleware {

		$this->nextMiddleware = $nextMiddleware;
		return $this->nextMiddleware;
	}

	public function check(string $email): bool {

		if ($this->nextMiddleware) {
			return $this->nextMiddleware->check($email);
		}

		return true;
	}

}

class UserExistMiddleware extends Middleware {

	private $server;

	public function __construct(Server $server) {
		$this->server = $server;
	}

	public function check(string $email): bool {

		if (!$this->server->userExist($email)) {
			echo "<p>UserExistMiddleware: User with {$email} does not exist</p>";
			return false;
		}

		return parent::check($email);
	}
}

class UserAdminMiddleware extends Middleware {

	public function check(string $email): bool {

		if ($email != 'admin@example.com') {
			echo "<p>UserAdminMiddleware: User with {$email} is not an Admin</p>";
			return false;
		}

		return parent::check($email);
	}
}

class Server {

	private $users = [];

	public function setUser(string $email, string $password): void {

		$this->users[$email] = $password;
	}

	public function userExist(string $email): bool {

		return isset($this->users[$email]);
	}
}

$server = new Server;

$server->setUser('admin@example.com', '121212');
$server->setUser('guest@example.com', '232323');

$isExist = new UserExistMiddleware($server);
$isAdmin = new UserAdminMiddleware;

$isExist->link($isAdmin);

if ($isExist->check('admin@example.com')) {
	echo 'Hello Admin!';
} else {
	echo 'You are not an Admin!';
}



?>
<?php


interface Notification {
	public function send(string $title, string $message);
}

class EmailNotification implements Notification {

	private $email;

	public function __construct(string $email) {

		$this->email = $email;
	}

	public function send(string $title, string $message) {

		echo "<p>Send message with title: {$title} and message: {$message} to {$this->email}</p>";
	}
}

class SomeApi {

	private $api_key;

	public function __construct(string $api_key) {

		$this->api_key = $api_key;
	}

	public function login() {

		echo "<p>Login with API-KEY: {$this->api_key}</p>";
	}

	public function sendMessage(int $resource_id, string $title, string $message) {

		echo "<p>Send message with title: {$title} and message: {$message} to resource: {$resource_id}</p>";
	}
}

class SomeApiNotification implements Notification {

	private $some_api;
	private $resource_id;

	public function __construct(SomeApi $some_api, int $resource_id) {

		$this->some_api = $some_api;
		$this->resource_id = $resource_id;
	}

	public function send(string $title, string $message) {

		$this->some_api->login();
		$this->some_api->sendMessage($this->resource_id, $title, $message);
	}
}


function clientCode(Notification $notification) {

	$notification->send('Some title', 'Some text');
}

$notification = new EmailNotification('o.malinsky@infoflot.com');
clientCode($notification);

$some_api = new SomeApi('xhduwjk54ofnmd');
$notification = new SomeApiNotification($some_api, 25);
clientCode($notification);




?>
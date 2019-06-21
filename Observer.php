<?php

class ArticleRepository implements \SplSubject {

	/**
	 * @var array
	 */
	private $articles = [];

	/**
	 * @var array Observers
	 */
	private $observers = [];

	public function __construct() {

		$this->observers['*'] = [];
	}

	public function initEventGroup(string $event = '*'): void {

		if (!isset($this->observers[$event])) {
			$this->observers[$event] = [];
		}
	}

	public function getEventObservers(string $event = '*'): array {

		$this->initEventGroup($event);

		return array_merge($this->observers[$event], $this->observers['*']);
	}

	public function attach(\SplObserver $observer, string $event = '*'): void {

		$this->initEventGroup($event);

		$this->observers[$event][] = $observer;
	}

	public function detach(\SplObserver $observer, string $event = '*'): void {

		foreach ($this->getEventObservers($event) as $key => $obs) {
			if ($observer === $obs) {
				unset($this->observers[$event][$key]);
			}
		}
	}

	public function notify(string $event = '*', $data = null): void {

		foreach ($this->getEventObservers($event) as $obs) {
			$obs->update($this, $event, $data);
		}

	}

	public function addArticle(array $article_data): Article {

		$article = new Article;
		$article->update($article_data);

		$id = bin2hex(openssl_random_pseudo_bytes(16));

		$article->update([
			'id' => $id
		]);

		$this->articles[$id] = $article;

		$this->notify('Article:add', $article);

		return $article;
	}

	public function updateArticle(Article $article, array $article_data): Article {

		$id = $article->attr['id'];

		if (!isset($this->articles[$id])) {
			return null;
		}

		$this->article[$id]->update($article_data);

		$this->notify('Article:update', $article);

		return $article;
	}

	public function deleteArticle(Article $article): void {

		$id = $article->attr['id'];

		if (!isset($this->articles[$id])) {
			return;
		}

		unset($this->articles[$id]);

		$this->notify('Article:deleted', $article);
	}

}

class Article {

	public $attr = [];

	public function update(array $data) {

		$this->attr = array_merge($this->attr, $data);
	}
}

class Logger implements \SplObserver {

	/**
	 * @var array
	 */
	public $log = [];

	public function update(\SplSubject $subject, $event = null, $data = null): void {

		$date = date('d-m-Y H:i:s');
		$this->log[] = serialize([
			'time'   => $date,
			'event'  => $event,
			'data'   => $data
		]);
	}

	public function getLogList(): void {

		foreach ($this->log as $log) {
			echo '<pre>';
			print_r(unserialize($log));
			echo '</pre>';
		}
	}

}

class EmailNotification implements \SplObserver {

	/**
	 * @var array
	 */
	public $notification_log = [];

	/**
	 * @var array
	 */
	public $emails = [];

	public function addReceiver(string $email): void {

		$this->emails[$email] = $email;
	}

	public function update(\SplSubject $subject, $event = null, $data = null): void {

		foreach ($this->emails as $email) {
			// mail($email, $event, serialize($data));
			$this->notification_log[] = "Send message with subject '{$event}' to {$email}";
		}
	}

	public function getNotificationLogList(): void {

		foreach ($this->notification_log as $log) {
			echo "<p>{$log}</p>";
		}
	}
}

$repository = new ArticleRepository;
$logger = new Logger;
$repository->attach($logger, 'Article:add');
// $repository->attach($logger, 'Article:deleted');

$notification_logger = new EmailNotification;
$notification_logger->addReceiver('olegmalinskiy@gmail.com');
$notification_logger->addReceiver('olegmalinskiy@yandex.ru');

$repository->attach($notification_logger);

$first_article = $repository->addArticle([
	'title' => 'Some title',
	'text'  => 'Some text'
]);

$logger->getLogList();

$repository->deleteArticle($first_article);

echo '<hr>';

$logger->getLogList();

echo '<hr>';

$notification_logger->getNotificationLogList();


?>
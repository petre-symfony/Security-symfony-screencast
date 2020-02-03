<?php

namespace App\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Security\Core\Security;

class MarkdownHelper{
	private $cache;
	private $markdown;
	private $logger;
	private $isDebug;
	private $security;
	
	public function __construct(
		AdapterInterface $cache,
		MarkdownParserInterface $markdown,
		LoggerInterface $markdownLogger,
		bool $isDebug,
		Security $security
	){
		$this->cache = $cache;
		$this->markdown = $markdown;
		$this->logger = $markdownLogger;
		$this->isDebug = $isDebug;
		$this->security = $security;
	}

	public function parse(string $source): string{
		if (stripos($source, 'bacon') !== false) {
			$this->logger->info('They are talking about bacon again!', [
				'user' => $this->security->getUser()
			]);
		}

		// skip caching entirely in debug
		if ($this->isDebug) {
			return $this->markdown->transformMarkdown($source);
		}

		$item = $this->cache->getItem('markdown_'.md5($source));
		if (!$item->isHit()) {
			$item->set($this->markdown->transformMarkdown($source));
			$this->cache->save($item);
		}

		return $item->get();
	}
}

<?php

class Gzaas_Model_Twitter
{
	const MAX_TWITTER_MESSAGE_SIZE_WITHOUT_SUFFIX = 109;
	const MAX_TWITTER_MESSAGE_SIZE_WITH_SUFFIX = 106;
	const SUFFIX = '...';

	public function getTwitterMessageFromGzaasMessage($message)
	{
		if ($message > self::MAX_TWITTER_MESSAGE_SIZE_WITHOUT_SUFFIX){
			$twitterMessage = substr($message,0,self::MAX_TWITTER_MESSAGE_SIZE_WITH_SUFFIX).self::SUFFIX;
		} else {
			$twitterMessage = $message;
		}
	}

}
<?php

$hash_tag = $_POST[hash_tag];

//require_once 'db-functions.inc.php' ; 

function getHashtagTweets($hash_tag) {
	 $url = 'http://search.twitter.com/search.atom?q='.urlencode($hash_tag) ;
	 echo '<p>Results from <strong>'.$url.'</strong>&hellip;</p>';
	 echo '<p>not having cURL Creates the following error:</p>';
	 $ch = curl_init($url); //need to install cURL
	 curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
	 $xml = curl_exec ($ch);
	 curl_close ($ch);

	 echo '<p>Response:</p>';
	 echo '<pre>'.htmlspecialchars($xml).'</pre>';

    $affected = 0;
    $twelement = new SimpleXMLElement($xml);
    foreach ($twelement->entry as $entry) {
        $text = trim($entry->title);
        $author = trim($entry->author->name);
        $time = strtotime($entry->published);
        $id = $entry->id;
        echo '<p>Tweet from '.htmlspecialchars($author).': <strong>'.htmlspecialchars($text).'</strong>  <em>Posted '.date('n/j/y g:i a',$time).'</em></p>';
    }

    return true ;
}

getHashtagTweets($hash_tag);


?>
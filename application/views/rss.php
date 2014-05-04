<?php echo '<?xml version="1.0" encoding="iso-8859-2"?>' ?>
<rss version="2.0">
	<channel>
		<title>Gamelog movies corner</title>
		<link>http://gamelogmovies.pl/</link>
		<description>recenzje filmów zamieszczane przez użytkowników forum Gamelog.pl.</description>
		<language>en-us</language>
		<generator>Gamelog movies corner</generator>
		<lastBuildDate><?php echo $last_pub_date ?></lastBuildDate>
		<pubDate><?php echo $last_pub_date ?></pubDate>
		<?php foreach( $reviews as $r) : ?> 
		<item>
			<title><?php echo $r->UserName . ' - '.$r->MovieTitle . ' / Ocena ' . $r->Rating ?></title>			
			<description><![CDATA[<?php echo $r->Review . '<br /> '. $r->DatePosted   ?>]]> </description>
			<link>http://www.gamelogmovies.pl/index.php/movies/details/<?php echo $r->MovieID .'#'. $r->PostID ?></link>
			<pubDate><?php echo date(DATE_RFC822,strtotime($r->DatePosted)) ?></pubDate>
		</item>
	<?php endforeach ?>
	</channel>
</rss>
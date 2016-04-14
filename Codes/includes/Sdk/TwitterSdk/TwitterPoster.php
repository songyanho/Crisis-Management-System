<?php

# Define constants
define('TWITTER_USERNAME', 'TeamXtreme2016');
define('CONSUMER_KEY', 'S7AbJDCBhjTLOnIooGNmntWXd');
define('CONSUMER_SECRET', '96Wfe8SPjf59sJngXALWlHbI08h3d75MPTtRMU6KnEp4UDlLVh');
define('ACCESS_TOKEN', '710739994072100864-YeKNuUozQlIyEXXqskoJPbjLsdDdBUS');
define('ACCESS_TOKEN_SECRET', 'E3NzmMT1M3EKOPpntxQZz93Vno261JmDPt0wSSctlBIOD');
define('TWEET_LENGTH', 140);

class TwitterPoster {

    private static $library = 'TwitterOAuth';
    private static $twitter = NULL;
    private static $DBH = NULL;

    /**
     * connect: Create an object of the Twitter PHP API either TwitterOAuth
     * or twitter-api-php
     * @access private
     */
    private static function connect() {

        if(self::$library == 'TwitterOAuth') {

//            include('TwitterOAuth.php');

            # Create the connection
            self::$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

            # Migrate over to SSL/TLS
            self::$twitter->ssl_verifypeer = true;

        } else {

            include('TwitterAPIExchange.php');

            self::$twitter = new TwitterAPIExchange(array(
                'oauth_access_token' => ACCESS_TOKEN,
                'oauth_access_token_secret' => ACCESS_TOKEN_SECRET,
                'consumer_key' => CONSUMER_KEY,
                'consumer_secret' => CONSUMER_SECRET
            ));

        }

    }

    /**
     * setDatabase: Pass in a PDO connection, if you've already got one
     * @param $database PDO
     */
    public static function setDatabase($database) {
        self::$DBH = $database;
    }

    /**
     * tweet: Post a new status to Twitter
     * @param $message string
     * @access public
     */
    public static function tweet($message = '') {

        if(empty($message)) {
            return;
        }

        # Load the Twitter object
        if(is_null(self::$twitter)) {
            self::connect();
        }

        if(self::$library == 'TwitterOAuth') {
            $response = self::$twitter->post('statuses/update', array('status' => $message));
        } else {
            $url = 'https://api.twitter.com/1.1/statuses/update.json';
            $requestMethod = 'POST';
            $postData = array('status' => $message);
            $response = $twitter->buildOauth($url, $requestMethod)->setPostfields($postData)->performRequest();
        }

        return $response;

     }

     /**
      * randomTweet: Send a random tweet from your database connection
      * @access public
      */
     public function randomTweet() {

         # Do we already have a database connection?
         if(empty(self::$DBH)) {

             $host = '';
             $dbname = '';
             $user = '';
             $pass = '';

             /**
             * Setup our database instance.
             * Full details on why you should be using PDO: http://aljt.in/3j
            */
            try {

            	# MS SQL Server and Sybase with PDO_DBLIB
            	self::$DBH = new PDO("mssql:host=$host;dbname=$dbname, $user, $pass");
            	self::$DBH = new PDO("sybase:host=$host;dbname=$dbname, $user, $pass");

            	# MySQL with PDO_MYSQL
            	self::$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

            	# SQLite Database
            	self::$DBH = new PDO("sqlite:my/database/path/database.db");

            }
            catch(PDOException $e) {
            	echo $e->getMessage();
            }

        }

        # Let's query our data
        $statement = $DBH->prepare("SELECT * FROM data ORDER BY date DESC");
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);

        # Got a row?
        if($statement->rowCount() > 0) {

            # Get the single row
            $data = $statement->row();

            # The Twitter t.co short URL length
            # Can be queried from: https://dev.twitter.com/rest/reference/get/help/configuration
            $shortUrlLength = 23;
            $maxTweetLength = TWEET_LENGTH - $shortUrlLength - 3;

            # Shorten the Tweet
            if(strlen($data['title']) > $maxTweetLength) {
                $data['title'] = substr($data['title'], 0, $maxTweetLength - 2).'..';
            }

            # Status to Tweet
            $status = $data['title'].' - '.$data['url'];

            # Post it now
            self::tweet($status);

        }

     }

 }

?>

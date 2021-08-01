<?php /** @noinspection ALL */

require_once('Rental.php');
require_once('Accommodation.php');
require_once('User.php');

class RentalDatabase{
    /**
     * Connection to the local MySQL database, which contains a record of any
     * cards that have been sent.
     *
     * @var MySQLDatabase
     */
    var $db = null;


    /**
     * Class constructor. This will get run whenever an instance of this class
     * is created.
     *
     */
    function __construct(){

        // Create database connection
		$servername = "localhost";
		$username = "choco";
		$password = "chocoPass";
		$dbName = "rental_database";

		$statement = "SHOW DATABASES LIKE " . '\'' . "$dbName" . '\'';

		//TODO remove user_rental. Info is stored in rentals

		try {

		$this->db = new PDO("mysql:host=$servername", $username, $password);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if ($result = $this->db->query($statement)) {
				if($result->rowCount() != 1) {
					$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
					$this->db->exec($sql);
					$this->db=null;
					$this->db = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
				} else {
					$this->db=null;
					$this->db = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
				}
			}



			/*$this->db = new PDO("mysql:host=$servername;dbname=card_db", $username, $password);
			// set the PDO error mode to exception
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "CREATE DATABASE IF NOT EXISTS card_db";
			// use exec() because no results are returned
			$this->db->exec($sql);*/

		}catch(PDOException $e){
			echo $sql . "<br>" . $e->getMessage();
		}


        // Check if the database has been initialized. If not, create the
        // database schema.

		if ($result = $this->db->query("SHOW TABLES LIKE 'users'")) {
            if ($result->rowCount() != 1) {
                $stmt = $this->db->prepare('CREATE TABLE users (
                username VARCHAR(30) PRIMARY KEY NOT NULL, 
                pass VARCHAR(16) NOT NULL, 
                flname VARCHAR(30) NOT NULL, 
                avatar_path varchar(200), 
                email VARCHAR(30) NOT NULL)');
                $stmt->execute();
            }
        }

        if ($result = $this->db->query("SHOW TABLES LIKE 'accommodation'")) {
            if ($result->rowCount() != 1) {
                $stmt = $this->db->prepare('CREATE TABLE accommodation (
                housing_id INT PRIMARY KEY AUTO_INCREMENT,
                username varchar(30) not null,
                title VARCHAR(30) NOT NULL, 
                location VARCHAR(16) NOT NULL, 
                description VARCHAR(100) NOT NULL, 
                check_in DATE NOT NULL, 
                check_out DATE NOT NULL,
                availability BOOLEAN,
                FOREIGN KEY (username) REFERENCES users(username))');
                $stmt->execute();
            }
        }

        if ($result = $this->db->query("SHOW TABLES LIKE 'rental'")) {
			if($result->rowCount() != 1) {
                $stmt = $this->db->prepare('CREATE TABLE rental (
                rental_id INT PRIMARY KEY AUTO_INCREMENT,
                housing_id int not null,
                username varchar(30) not null,
                check_in DATE NOT NULL, 
                check_out DATE NOT NULL,
                FOREIGN KEY (housing_id) REFERENCES accommodation(housing_id),
                FOREIGN KEY (username) REFERENCES users(username))');
				$stmt->execute();
			}

		}

		if ($result = $this->db->query("SHOW TABLES LIKE 'images'")) {
            if ($result->rowCount() != 1) {
                $stmt = $this->db->prepare('CREATE TABLE images (
                image_id INT PRIMARY KEY AUTO_INCREMENT, 
                path VARCHAR(200) not null)');
                $stmt->execute();
            }
        }

		if ($result = $this->db->query("SHOW TABLES LIKE 'reviews'")) {
            if ($result->rowCount() != 1) {
                $stmt = $this->db->prepare('CREATE TABLE reviews (
                review_id INT PRIMARY KEY AUTO_INCREMENT,
                rating int not null, 
                reviewText VARCHAR(150) not null )');
                $stmt->execute();
            }
        }

		if ($result = $this->db->query("SHOW TABLES LIKE 'user_accomm'")) {
            if ($result->rowCount() != 1) {
                $stmt = $this->db->prepare('CREATE TABLE user_accomm (
                housing_id int not null,  
                username varchar(30) not null,
                FOREIGN KEY (housing_id) REFERENCES accommodation(housing_id),
                FOREIGN KEY (username) REFERENCES users(username),
                PRIMARY KEY (housing_id, username))');
                $stmt->execute();
            }
        }

		if ($result = $this->db->query("SHOW TABLES LIKE 'accomm_reviews'")) {
            if ($result->rowCount() != 1) {
                $stmt = $this->db->prepare('CREATE TABLE accomm_reviews (
                housing_id int not null ,  
                review_id int not null,
                FOREIGN KEY (housing_id) REFERENCES accommodation(housing_id),
                FOREIGN KEY (review_id) REFERENCES reviews(review_id),
                PRIMARY KEY (housing_id, review_id))');
                $stmt->execute();
            }
        }

		if ($result = $this->db->query("SHOW TABLES LIKE 'accomm_image'")) {
            if ($result->rowCount() != 1) {
                $stmt = $this->db->prepare('CREATE TABLE accomm_image (
                housing_id int not null ,  
                image_id int not null,
                FOREIGN KEY (housing_id) REFERENCES accommodation(housing_id),
                FOREIGN KEY (image_id) REFERENCES images(image_id),
                PRIMARY KEY (housing_id, image_id))');
                $stmt->execute();
            }
        }


    }

    public function userExists($username){
        $user = $this->retrieveUser($username);
        if($user->getUsername() == $username){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Check if the user gave valid credentials
     *
     * @param $user User
     */

    public function isValidUser($username, $password){
        $query = $this->db->prepare("select pass from users where username = :username");
        $query->bindParam(':username', $username);

        $query->execute();
        $result = $query->fetch();

        $pass = $result["pass"];
        if($pass === $password){
            return true;
        }
        return false;
    }

     /**
      * Create a new card and add it to the database.
      *
      * @param User $user The card data to inset.
      * @return integer The ID of the card in the database.
      */
    public function addUser($user){
        // Create a prepared statement to insert the specified values into the
        // database.
        $query = $this->db->prepare('INSERT INTO users (username,  pass,  flname,  avatar_path,  email) VALUES (:username, :pass, :flname, :avatar_path, :email)');

        $username = $user->getUsername();
		$password = $user->getPassword();
		$name = $user->getName();
		$avatar_path = $user->getAvatar();
		$email = $user->getEmail();

		$query->bindParam(':username',$username);
        $query->bindParam(':pass', $password);
        $query->bindParam(':flname', $name);
        $query->bindParam(':avatar_path', $avatar_path);
        $query->bindParam(':email', $email);

        // Execute statement
        $query->execute();

        // Retrieve the ID of the card that was just inserted
        return $this->db->lastInsertID();
    }

     /**
      * Create a new card and add it to the database.
      *
      * @param Accommodation $accomm The card data to inset.
      * @return integer The ID of the card in the database.
      */
    public function addAccommondation($accomm){

        $images = $accomm->getImages();
        $imageIds = array();
        foreach($images as $imagePath){
            array_push($imageIds, $this->addImage($imagePath));
        }
        // Create a prepared statement to insert the specified values into the
        // database.
        $query = $this->db->prepare('INSERT INTO accommodation (username, title, location, description, check_in, check_out, availability) VALUES (:username, :title, :location, :description, :check_in, :check_out, :availability)');

        $username = $accomm->getUsername();
        $title = $accomm->getTitle();
        $location = $accomm->getLocation();
        $description = $accomm->getDescription();
        $check_in = $accomm->getCheckIn();
        $check_out = $accomm->getCheckOut();
        $availability = $accomm->getAvailability();

        $query->bindParam(':username',$username);
        $query->bindParam(':title',$title);
        $query->bindParam(':location', $location);
        $query->bindParam(':description', $description);
        $query->bindParam(':check_in', $check_in);
        $query->bindParam(':check_out', $check_out);
        $query->bindParam(':availability', $availability);

//        print $query->queryString;
        // Execute statement
        $query->execute();

        $accomm->setId($this->db->lastInsertID());
        print "ID = $accomm->_id"."\n";

        $this->addUserAccomm($accomm);

        $this->addAccommImage($accomm->getId(), $imageIds);

        return $accomm->getId();

        // Retrieve the ID of the card that was just inserted
    }

    /**
      * Create a new card and add it to the database.
      *
      * @param Rental $rental The card data to inset.
      * @return integer The ID of the card in the database.
      */
    public function addRental($rental){

        // Create a prepared statement to insert the specified values into the
        // database.
        $query = $this->db->prepare('INSERT INTO rental (housing_id, username, check_in,  check_out) VALUES (:housing_id, :username, :check_in, :check_out)');

        $housing_id = $rental->getHousingId();
        $username = $rental->getUsername();
        $check_in = $rental->getCheckIn();
        $check_out = $rental->getCheckOut();

        $query->bindParam(':username', $username);
        $query->bindParam(':housing_id', $housing_id);
        $query->bindParam(':check_in', $check_in);
        $query->bindParam(':check_out', $check_out);
        // Execute statement
        $query->execute();

        return $this->db->lastInsertID();
    }

    /**
      * Create a new card and add it to the database.
      *
      * @param Review $review The card data to inset.
      * @return integer The ID of the card in the database.
      */
    public function addReview($review){
        // Create a prepared statement to insert the specified values into the
        // database.
        $query = $this->db->prepare('INSERT INTO reviews (rating, reviewText) VALUES (:rating, :reviewText)');

        $rating = $review->getRating();
        $reviewText = $review->getReviewText();

        $query->bindParam(':rating', $rating);
        $query->bindParam(':reviewText', $reviewText);
        // Execute statement
        $query->execute();

        // Retrieve the ID of the card that was just inserted
        return $this->db->lastInsertID();
    }

    /**
      * Create a new card and add it to the database.
      *
      * @param string $imagePath The card data to inset.
      * @return integer The ID of the card in the database.
      */
    public function addImage($imagePath){
        // Create a prepared statement to insert the specified values into the
        // database.
        $query = $this->db->prepare('INSERT INTO images (path) VALUES (:path)');

        $query->bindParam(':path', $imagePath);
        // Execute statement
        $query->execute();

        // Retrieve the ID of the card that was just inserted
        return $this->db->lastInsertID();
    }

    /**
      * Add a new accommodation-review association into the database.
      * NOTE !It does not check if the foreign keys exist!
      *
      * @param Review $review_id The card data to inset.
      * @return integer The ID of the card in the database.
      */
    public function addAccommReview($housing_id, $review_id){

        // Create a prepared statement to insert the specified values into the
        // database.
        $query = $this->db->prepare('INSERT INTO accomm_reviews (housing_id,   review_id) VALUES (:housing_id, :review_id)');

        $query->bindParam(':housing_id', $housing_id);
        $query->bindParam(':review_id', $review_id);
        // Execute statement
        $query->execute();

        // Retrieve the ID of the card that was just inserted
        return $this->db->lastInsertID();
    }

    /**
      * Create a new card and add it to the database.
      *
      * @param Rental $rental The card data to inset.
      * @return integer The ID of the card in the database.
      */
    public function addUserRental($rental, $rental_id){
        // Create a prepared statement to insert the specified values into the
        // database.
        $query = $this->db->prepare('INSERT INTO user_rental (username, rental_id, housing_id) VALUES (:username, :rental_id, :housing_id)');

        $username = $rental->getUsername();
        $housing_id = $rental->getHousingId();

        $query->bindParam(':username', $username);
        $query->bindParam(':rental_id', $rental_id);
        $query->bindParam(':housing_id', $housing_id);
        // Execute statement
        $query->execute();

        // Retrieve the ID of the card that was just inserted
        return $this->db->lastInsertID();
    }

    /**
      * Create a new card and add it to the database.
      *
      * @param Accommodation $accomm The card data to inset.
      * @return integer The ID of the card in the database.
      */
    public function addUserAccomm($accomm){
        // Create a prepared statement to insert the specified values into the
        // database.
        $query = $this->db->prepare('INSERT INTO user_accomm (housing_id, username) VALUES (:housing_id, :username)');

        $username = $accomm->getUsername();
        $housing_id = $accomm->getId();

        $query->bindParam(':housing_id', $housing_id);
        $query->bindParam(':username', $username);
        // Execute statement
        $query->execute();

        // Retrieve the ID of the card that was just inserted
        return $this->db->lastInsertID();
    }

    /**
      * Create a new card and add it to the database.
      *
      * @param Accommodation $accomm The card data to inset.
      * @return integer The ID of the card in the database.
      */
    public function addAccommImage($housing_id, $imageIds){
        foreach($imageIds as $imageId){
//            print $imageId."\n";
            $query = $this->db->prepare('INSERT INTO accomm_image (housing_id, image_id) VALUES (:housing_id, :image_id)');

            $query->bindParam(':housing_id', $housing_id);
            $query->bindParam(':image_id', $imageId);

//            var_dump($query->errorInfo());
            // Execute statement
            $query->execute();
        }
    }

    /**
     * Retrieve a card from the database by ID and return a CardModel object
     * with the given data.
     *
     * @param integer $id The card ID to retrieve from the database.
     * @return User|null The located data for the card, or null if $id
     *         isn't found in the database.
     */
    public function retrieveUser($username){
        // Create a prepared statement to retrieve a card from the database.
        $query = $this->db->prepare('SELECT * FROM users WHERE username = :username');
        $query->bindParam(':username', $username);

        // Retrieve result
        $query->execute();

        // We assume the result set only has one row (the record matching 
        // the given ID). Extract that as an associative array.
        $row = $query->fetch();

        // Convert result into an object that's nicer to work with
        $user = new User();
        $user->setUsername($row['username']);
        $user->setPassword($row['pass']);
        $user->setName($row['flname']);
        $user->setAvatar($row['avatar_path']);
        $user->setEmail($row['email']);

        return $user;
    }


    /**
     * Retrieve a card from the database by ID and return a CardModel object
     * with the given data.
     *
     * @param integer $id The card ID to retrieve from the database.
     * @return Accommodation|null The located data for the card, or null if $id
     *         isn't found in the database.
     */
    public function retrieveAccommodation($id){
        //DONE data are properly extracted from the db
        // Create a prepared statement to retrieve a card from the database.
        $query = $this->db->prepare('SELECT * FROM accommodation WHERE housing_id = :id');
        $query->bindParam(':id', $id);

        // Retrieve result
        $query->execute();

        // We assume the result set only has one row (the record matching
        // the given ID). Extract that as an associative array.
        $result = $query->fetchAll();
//        var_dump($result[0]);

        // Convert result into an object that's nicer to work with
        $accomm = new Accommodation($result[0]);

        //TODO get accomm images
        $query_accomm_image = $this->db->prepare('select i.path 
        from accomm_image as ai, images as i 
        where ai.housing_id = :id and ai.image_id = i.image_id');

        $accomm_id = $accomm->getId();
        $query_accomm_image->bindParam(':id', $accomm_id);

        $query_accomm_image->execute();

        $results = $query_accomm_image->fetchAll();

        $images = array();
        foreach($results as $row){
            array_push($images, $row["path"]);
        }

        $accomm->addImages($images);

//        var_dump($accomm);

        return $accomm;
    }

       /**
     * Retrieve a rental from the database by ID and return a CardModel object
     * with the given data.
     *
     * @param integer $id The rental ID to retrieve from the database.
     * @return Rental|null The located data for the card, or null if $id
     *         isn't found in the database.
     */
    public function retrieveRental($id){
        // Create a prepared statement to retrieve a card from the database.
        $query = $this->db->prepare('SELECT * FROM rental WHERE id = :id');
        $query->bindParam(':id', $id);

        // Retrieve result
        $query->execute();

        // We assume the result set only has one row (the record matching
        // the given ID). Extract that as an associative array.
        $row = $query->fetch();
        if ($row === false) {
            //No results returned, so the ID must have been invalid.
            return null;
        }

        // Convert result into an object that's nicer to work with
        $rental = new Rental();
        $rental->setId($row['id']);
        $rental->setCheckIn()($row['check_in']);
        $rental->setCheckOut()($row['check_out']);

        return $rental;
    }

    public function getAccomms(){
        //DONE works fine
        // Create a prepared statement to retrieve a card from the database.
        $query = $this->db->prepare('SELECT * FROM accommodation');

        // Retrieve result
        $query->execute();

        $result = $query->fetchAll();

        $accomms = array();

        foreach($result as $row){
            $accomm_args = array();
            for($i = 0; $i < $query->columnCount(); $i++){
                array_push($accomm_args, $row[$i]);
            }

            $accomm = new Accommodation($accomm_args);
            $accomm_id = $accomm->getId();

            $query_accomm_image = $this->db->prepare('select image_id from accomm_image where housing_id = :id');

            $query_accomm_image->bindParam(':id', $accomm_id);
            $query_accomm_image->execute();
            $result_accomm_images = $query_accomm_image->fetchAll();

            $image_ids = array();
            foreach ($result_accomm_images as $row_accomm_image){
                array_push($image_ids, $row_accomm_image["image_id"]);

            }

            $image_ids = array_reduce($image_ids, function ($res, $x){return $x.",".$res;});
            $image_ids = trim($image_ids, ',');
            $query_images = $this->db->prepare('select path from images where image_id in ('.$image_ids.')');

//            var_dump($image_ids);
//            var_dump($image_ids);
//            $query_images->bindParam(':images', trim($image_ids, ','));
            $query_images->execute();
//            print $query_images->debugDumpParams();
            $result_images = $query_images->fetchAll();

            $accomm_images = array();
//            var_dump($result_images);
            foreach ($result_images as $row_images){
//                var_dump($row_images);
                array_push($accomm_images, $row_images["path"]);

            }

            $accomm->addImages($accomm_images);
//            var_dump($accomm->getImages());

            array_push($accomms, $accomm);
        }

        return $accomms;
    }
}
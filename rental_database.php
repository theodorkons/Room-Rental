<?php /** @noinspection ALL */

require_once('Rental.php');
require_once('Accommodation.php');
require_once('User.php');
require_once('Review.php');

class RentalDatabase{

    var $db = null;


    function __construct(){

        // Create database connection
		$servername = "localhost";
		$username = "choco";
		$password = "chocoPass";
		$dbName = "rental_database";

		$statement = "SHOW DATABASES LIKE " . '\'' . "$dbName" . '\'';

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
		}catch(PDOException $e){
			echo $sql . "<br>" . $e->getMessage();
		}

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

    public function addUser($user){
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

        $query->execute();

        return $this->db->lastInsertID();
    }

    public function addAccommondation($accomm){

        $images = $accomm->getImages();
        $imageIds = array();
        foreach($images as $imagePath){
            array_push($imageIds, $this->addImage($imagePath));
        }
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

        $query->execute();

        $accomm->setId($this->db->lastInsertID());

        $this->addUserAccomm($accomm);

        $this->addAccommImage($accomm->getId(), $imageIds);

        return $accomm->getId();

    }

    public function addRental($rental){

        $query = $this->db->prepare('INSERT INTO rental (housing_id, username, check_in,  check_out) VALUES (:housing_id, :username, :check_in, :check_out)');

        $housing_id = $rental->getHousingId();
        $username = $rental->getUsername();
        $check_in = $rental->getCheckIn();
        $check_out = $rental->getCheckOut();

        $query->bindParam(':username', $username);
        $query->bindParam(':housing_id', $housing_id);
        $query->bindParam(':check_in', $check_in);
        $query->bindParam(':check_out', $check_out);
        $query->execute();

        return $this->db->lastInsertID();
    }

    public function addReview($review, $housing_id){
        $query = $this->db->prepare('INSERT INTO reviews (rating, reviewText) VALUES (:rating, :reviewText)');

        $rating = $review->getRating();
        $reviewText = $review->getReviewText();

        $query->bindParam(':rating', $rating);
        $query->bindParam(':reviewText', $reviewText);
        $query->execute();

        $review_id = $this->db->lastInsertID();

        $this->addAccommReview($housing_id, $review_id);
    }

    public function addImage($imagePath){
        $query = $this->db->prepare('INSERT INTO images (path) VALUES (:path)');

        $query->bindParam(':path', $imagePath);
        $query->execute();

        return $this->db->lastInsertID();
    }

    public function addAccommReview($housing_id, $review_id){

        $query = $this->db->prepare('INSERT INTO accomm_reviews (housing_id,   review_id) VALUES (:housing_id, :review_id)');

        $query->bindParam(':housing_id', $housing_id);
        $query->bindParam(':review_id', $review_id);
        $query->execute();

        return $this->db->lastInsertID();
    }

    public function addUserRental($rental, $rental_id){
        $query = $this->db->prepare('INSERT INTO user_rental (username, rental_id, housing_id) VALUES (:username, :rental_id, :housing_id)');

        $username = $rental->getUsername();
        $housing_id = $rental->getHousingId();

        $query->bindParam(':username', $username);
        $query->bindParam(':rental_id', $rental_id);
        $query->bindParam(':housing_id', $housing_id);
        $query->execute();

        return $this->db->lastInsertID();
    }

    public function addUserAccomm($accomm){
        $query = $this->db->prepare('INSERT INTO user_accomm (housing_id, username) VALUES (:housing_id, :username)');

        $username = $accomm->getUsername();
        $housing_id = $accomm->getId();

        $query->bindParam(':housing_id', $housing_id);
        $query->bindParam(':username', $username);
        $query->execute();

        return $this->db->lastInsertID();
    }

    public function addAccommImage($housing_id, $imageIds){
        foreach($imageIds as $imageId){
            $query = $this->db->prepare('INSERT INTO accomm_image (housing_id, image_id) VALUES (:housing_id, :image_id)');

            $query->bindParam(':housing_id', $housing_id);
            $query->bindParam(':image_id', $imageId);

            $query->execute();
        }
    }

    public function retrieveUser($username){
        $query = $this->db->prepare('SELECT * FROM users WHERE username = :username');
        $query->bindParam(':username', $username);

        $query->execute();

        $row = $query->fetch();

        $user = new User();
        $user->setUsername($row['username']);
        $user->setPassword($row['pass']);
        $user->setName($row['flname']);
        $user->setAvatar($row['avatar_path']);
        $user->setEmail($row['email']);

        return $user;
    }

    public function retrieveAccommodation($id){
        $query = $this->db->prepare('SELECT * FROM accommodation WHERE housing_id = :id');
        $query->bindParam(':id', $id);

        $query->execute();

        $result = $query->fetchAll();

        $accomm = new Accommodation($result[0]);

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

        return $accomm;
    }

    public function retrieveRental($username){
        $query = $this->db->prepare('SELECT * FROM rental WHERE username = :username');
        $query->bindParam(':username', $username);

        $query->execute();

        $result = $query->fetchAll();
        $results = array();

        foreach ($result as $r){
            $rental = new Rental();
            $rental->setId($row['id']);
            $rental->setCheckIn()($row['check_in']);
            $rental->setCheckOut()($row['check_out']);
            array_push($results, $r);
        }

        return $rentals;
    }

    public function getAccomms(){
        $query = $this->db->prepare('SELECT * FROM accommodation');

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

            $query_images->execute();
            $result_images = $query_images->fetchAll();

            $accomm_images = array();
            foreach ($result_images as $row_images){
                array_push($accomm_images, $row_images["path"]);

            }

            $accomm->addImages($accomm_images);

            array_push($accomms, $accomm);
        }

        return $accomms;
    }

    public function getLocations(){
        $query = $this->db->prepare("SELECT DISTINCT location from accommodation");
        $query->execute();
        $result = $query->fetchAll();
        $locations  = array();
        foreach ($result as $r){
            array_push($locations, $r["location"]);
        }
        return $locations;
    }

    function retrievePastRentals($username){
        $query = $this->db->prepare('SELECT * FROM rental WHERE username = :username AND check_out < CURDATE()');
        $query->bindParam(':username', $username);

        $query->execute();

        $result = $query->fetchAll();
        $rentals = array();

        foreach ($result as $row){
            $rental = new Rental();
            $rental->setHousingId($row['housing_id']);
            $rental->setCheckIn($row['check_in']);
            $rental->setCheckOut($row['check_out']);
            array_push($rentals, $rental);
        }

        return $rentals;
    }

    function retrieveFutureRentals($username){
        $query = $this->db->prepare('SELECT * FROM rental WHERE username = :username AND check_out > CURDATE()');
        $query->bindParam(':username', $username);

        $query->execute();

        $result = $query->fetchAll();
        $rentals = array();

        foreach ($result as $row){
            $rental = new Rental();
            $rental->setHousingId($row['housing_id']);
            $rental->setCheckIn($row['check_in']);
            $rental->setCheckOut($row['check_out']);
            array_push($rentals, $rental);
        }

        return $rentals;
    }

        function retrieveUserAccom($username){
        $query = $this->db->prepare('SELECT * FROM accommodation WHERE username = :username');
        $query->bindParam(':username', $username);

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

            $query_images->execute();
            $result_images = $query_images->fetchAll();

            $accomm_images = array();
            foreach ($result_images as $row_images){
                array_push($accomm_images, $row_images["path"]);

            }

            $accomm->addImages($accomm_images);

            array_push($accomms, $accomm);
        }

        return $accomms;
    }

    function getRating($housing_id){
        $query = $this->db->prepare('SELECT AVG(rating) FROM reviews, accomm_reviews WHERE reviews.review_id = accomm_reviews.review_id AND accomm_reviews.housing_id = :housing_id');
        $query->bindParam(':housing_id', $housing_id);

        $query->execute();

        $result = $query->fetchAll();
        if($result[0][0]) {
            return $result[0][0];
        }else{
            return 0;
        }

    }

    function retrieveAccommLoc($location){
        $query = $this->db->prepare('select * from accommodation where location = :location');
        $query->bindParam(':location', $location);

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

            $query_images->execute();
            $result_images = $query_images->fetchAll();

            $accomm_images = array();
            foreach ($result_images as $row_images){
                array_push($accomm_images, $row_images["path"]);

            }

            $accomm->addImages($accomm_images);

            array_push($accomms, $accomm);
        }

        return $accomms;
    }

    function retrieveReviews($housing_id){
        $query = $this->db->prepare('select rating, reviewText from accomm_reviews, reviews where reviews.review_id=accomm_reviews.review_id AND housing_id = :housing_id');
        $query->bindParam(':housing_id', $housing_id);

        $query->execute();

        $result = $query->fetchAll();

        $reviews = array();

        foreach($result as $r){
           $review = new Review();
           $review->setRating($r['rating']);
           $review->setReviewText($r['reviewText']);
           array_push($reviews, $review);
        }

        return $reviews;
    }
}
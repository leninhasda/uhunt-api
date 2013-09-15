<?php  
/**
 * uHunt API class
 *
 *
 */

class uHunt {
	private $userID;
	private $username;
	private $fullname;
	private $problemSolved;
	private $currentRank;
	private $error;

	/**
	 * constructor
	 * 
	 * @param 	string 	username 	- uva username
	 * @return 	void
	 */
	function __construct( $username = '' ) {
		$this->setError( '' );
		$this->setUsername( $username );
		$this->initAll();
	} /* end of constructor */

	/**
	 * sets userID
	 *
	 * @param 	int 	uid 	- uva userID
	 * @return 	void
	 */
	private function setUserID( $uid ) {
		$this->userID = ( int ) $uid;
	}

	/**
	 * retrive userID
	 *
	 * @param 	void
	 * @return 	int 	userID - uhunt userID
	 */
	public function getUserID() {
		return $this->userID;
	}

	/**
	 * sets username
	 *
	 * @param 	string 	uname 	- uva username
	 * @return 	void
	 */
	public function setUsername( $uname ) {
		$this->username = ( string ) $uname;
	}

	/**
	 * retrive username
	 *
	 * @param 	void
	 * @return 	string 	username - uva username
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * sets full name
	 *
	 * @param 	string 	fname 	- uva full name
	 * @return 	void
	 */
	private function setFullname( $fname ) {
		$this->fullname = ( string ) $fname;
	}

	/**
	 * retrive user full name
	 *
	 * @param 	void
	 * @return 	string 	fullname - user full name
	 */
	public function getFullname() {
		return $this->fullname;
	}

	/**
	 * sets number of problem solved by user
	 *
	 * @param 	int 	solved 	- number of problem solved
	 * @return 	void
	 */
	private function setProblemSolved( $solved ) {
		$this->problemSolved = ( int ) $solved;
	}

	/**
	 * retrive number of problem solved by user
	 *
	 * @param 	void
	 * @return 	int 	solved - number of problem solved
	 */
	public function getProblemSolved() {
		return $this->problemSolved;
	}

	/**
	 * sets current user rank
	 *
	 * @param 	int 	rank 	- user rank (by #no of solved)
	 * @return 	void
	 */
	private function setCurrentRank( $rank ) {
		$this->currentRank = ( int ) $rank;
	}

	/**
	 * retrive current user rank
	 *
	 * @param 	void
	 * @return 	int 	currentRank - current user rank
	 */
	public function getCurrentRank() {
		return $this->currentRank;
	}

	/**
	 * sets error message
	 * @param 	string 	msg 	- error message
	 * @return 	void
	 */
	private function setError( $msg ) {
		$this->error = ( string ) $msg;
	}

	/**
	 * retrive error message if any
	 *
	 * @param 	void
	 * @return 	mixed 	- error message if any otherwise false
	 */
	public function getError() {
		if( !empty( $this->error ) )
			return $this->error;
		return false;
	}


	/**
	 * initialize other variables data by calling different funcitons
	 *
	 * @param 	void
	 * @return 	void
	 */
	private function initAll() {
		if( empty( $this->username ) ) {
			$this->setError( 'Error: no username given!' );
		} else {
			$uid = getUserID( $this->username );
			if( $uid ) {
				$this->setUserID( $uid );
				$info = getUserSubmission( $this->userID );
				if( $info ) {
					$this->setFullname( $info->name );
					$count = 0;
					$solved = array();
					foreach ($info->subs as $sub) {
						if( 90 == $sub[2] && !in_array( $sub[1], $solved ) ) {
							$solved[] = $sub[1];
							$count++;
						}
					}
					$this->setProblemSolved( $count );
					$this->setCurrentRank( 0 );
				} else {
					$this->setError( 'Error: user info can not be retrived!' );
				}
			} else {
				$this->setError( 'Error: userID can not be retrived!' );
			}

		}
	}

} /* end of uHunt class */


/**
 * converts username to userID
 * @param 	string 	uname 	- uva username
 * @return 	int 	userID 	- uhunt userID
 */
function getUserID( $uname ) {
	$userID = file_get_contents( "http://uhunt.felix-halim.net/api/uname2uid/{$uname}" );
	return ( int )$userID;
} /* end of getUserID function */

/**
 * gets user submittions
 * @param 	int 	userID 	- uhunt userID
 * @return 	json {name, uname, subs[submissionID, problemID, verdictID(90), runtime, submissiontime(timestamp), language(1=ANSI C, 2=Java, 3=C++, 4=Pascal), submissionrank]}
 */
function getUserSubmission( $userID ) {
	$json = file_get_contents( "http://uhunt.felix-halim.net/api/subs-user/{$userID}" );
	return json_decode( $json );
}/* end of getUserSubmissin function */
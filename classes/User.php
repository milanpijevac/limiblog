<?php 


class User {
	private $db,
			$data = [],
			$isLoogedIn = false;


		public function __construct () {
			$this->db = Database::connect();
		}

		// login
		public function login($email, $password) {
			//provera mejla -->find metod
			if ($this->find($email)) {
			//provera lozinke
				if ( Hash::make($password) === $this->data->password) {
		// login
						Session::set('user',$this->data->id);
						return $this->isLoogedIn = true;
					}	
			}
		}

		// check

		public function checkLogin() {
			if (Session::exists('user')) {
				if ($this->find(Session::get('user'))) {
					return $this->isLoogedIn = true;
				}
			}
			return $this->isLoogedIn = false;
		}

		// logout
		public function logout() {
			Session::delete('user');
			return $this->isLoogedIn = false;
		}

		// create
		public function create($fields =[]) {
			if (!$this->db->insert('users', $fields)) {
				throw new Exception("Error Processing Request");
				
			}
		}

		// find - trazi po id ili email
		public function find($user = null) {
			if ($user) {
				$field = (is_numeric($user)) ? 'id' : 'email';
				$data = $this->db->find('users', $field, $user);

				if ($data->count()) {
					$this->data = $data->first();
					return $this;
				}
			}
			return null;
		}


		//pomocni metodi

		//vracanje podataka o korisniku
		public function data() {
			return $this->data;
		}

		public function isLoogedIn() {
			return $this->isLoogedIn;
		}

		public function exists() {
			return (!empty($this->data)) ? true : false;
		}

}	
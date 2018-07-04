<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Controller {

	var $data;

	public function index() {

		$this->data['isLoggedIn'] = false;

		if($this->session->userdata('email') != "" && $this->session->userdata('password') != ""){
			$this->data['isLoggedIn'] = true;
		}

		$this->load->view('media_form', $this->data);
	}

	public function login() {

		$email = $this->input->post('email', true);
		$password = $this->input->post('password', true);

		$this->session->set_userdata('email', $email);
		$this->session->set_userdata('password', $password);

		$apiPath = $this->config->item('apiPath').'check-credentials';

		$response = json_decode($this->httpRequest($apiPath));

		if($response->status != 'ok') {

			$user_data = $this->session->userdata();
			foreach ($user_data as $key => $value) {

				if ($key!='__ci_last_regenerate' && $key != '__ci_vars') {

					$this->session->unset_userdata($key);
				}
			}
			$this->session->set_flashdata('errors', ['Login inválido'] );
		}

		redirect(base_url());
	}

	public function logout() {

		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function save() {

		if (!isset($_FILES['file'])) return false;

		$file = $_FILES['file'];

		$errors = array();

		$allowed_ext= ['pdf', 'txt', 'doc', 'gif', 'jpg', 'jpeg', 'png'];
		$file_name = $file['name'];

		@$file_ext = strtolower(end(explode('.', $file_name)));

		$file_size= $file['size'];
		$file_tmp= $file['tmp_name'];

		$data = file_get_contents($file_tmp);
		$base64 = 'data:' . $file["type"] . ';base64,' . base64_encode($data);

		if(in_array($file_ext,$allowed_ext) === false)
		{
			$errors[]='Extensão não permitida!';
		}

		if($file_size > 1073741824)
		{
			$errors[]= 'O arquivo deve conter no máximo 20MB';

		}

		if(!empty($errors))
		{
			$this->session->set_flashdata('errors', $errors );
			redirect(base_url());
		}

		$apiPath = $this->config->item('apiPath').'media-files';

		$params = [
			"file" => $base64,
			"title" => $this->input->post('name')
		];

		$response = json_decode($this->httpRequest($apiPath, $params));

		if(isset($response->status) && $response->status == 'ok') {

			$this->session->set_flashdata('success', $response->message);
			redirect(base_url());
		}

	}

	private function httpRequest($url, $params = false) {

		$apiToken = 'auth-token:'.$this->config->item('apiToken');
		$apiEmail = 'auth-email:'.$this->session->userdata('email');
		$apiPassword = 'auth-password:'.$this->session->userdata('password');

		$headers = [
			$apiToken,
			$apiEmail,
			$apiPassword,
			'Content-Type: application/x-www-form-urlencoded'
		];

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		curl_setopt($curl, CURLOPT_POST, 1);
		if($params) {

			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
		}
		$response = curl_exec($curl);
		curl_close($curl);
		var_dump($response);
		return $response;
	}
}

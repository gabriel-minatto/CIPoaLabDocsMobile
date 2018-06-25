<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Controller {

	var $data;

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		$this->load->view('media_form');
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

		$apiToken = 'auth-token:'.$this->config->item('apiToken');
		$apiPath = $this->config->item('apiPath').'media-files';

		$header = [
			$apiToken,
			'Content-Type: application/x-www-form-urlencoded'
		];

		$params = [
			"file" => $base64,
			"title" => $this->input->post('name')
		];

		$response = json_decode($this->httpRequest($apiPath, $header, $params));

		if(isset($response->status) && $response->status == 'ok') {

			$this->session->set_flashdata('success', $response->message);
			redirect(base_url());
		}

	}

	private function httpRequest($url, $headers, $params) {
		print_r($url);
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
		$response = curl_exec($curl);
		curl_close($curl);
		var_dump($response);
		return $response;
	}
}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_login();
		is_admin();
		$this->load->model('admin_model', 'admin');
	}

	public function jabatan()
	{
		$data = [
			'title' => 'Data Jabatan',
			'page' => 'admin/jabatan/datajabatan',
			'subtitle' => 'Admin',
			'subtitle2' => 'Data Jabatan',
			'data' => $this->db->get('jabatan')->result()
		];

		$this->load->view('templates/app', $data, FALSE);
	}


	public function addjabatan()
	{

		$this->form_validation->set_rules('jabatan_nama', 'Nama Jabatan', 'required|trim', [
			'required' => 'Nama Jabatan tidak boleh kosong.'
		]);

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'title' => 'Tambah Data Jabatan',
				'page' => 'admin/jabatan/addjabatan',
				'subtitle' => 'Admin',
				'subtitle2' => 'Tambah Data Jabatan'
			];
			$this->load->view('templates/app', $data);
		} else {
			$data = [
				'jabatan_nama' 	=> $this->input->post('jabatan_nama'),
			];
			// var_dump($data);
			$this->admin->insertJabatan($data);
			$this->session->set_flashdata('message', 'swal("Berhasil!", "Data Jabatan Berhasil Ditambahkan!", "success");');

			redirect(base_url('data-jabatan'));
		}
	}


	public function deletejabatan($id)
	{
		$this->db->delete('jabatan', ['jabatan_id' => $id]);
		$this->session->set_flashdata('message', 'swal("Berhasil!", "Data Jabatan Berhasil Dihapus!", "success");');
		redirect(base_url('data-jabatan'));
	}

	public function editjabatan($id)
	{
		$this->form_validation->set_rules('jabatan_nama', 'Nama Jabatan', 'required|trim', [
			'required' => 'Nama Jabatan tidak boleh kosong.'
		]);

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'title' => 'Tambah Data Jabatan',
				'page' => 'admin/jabatan/editjabatan',
				'subtitle' => 'Admin',
				'subtitle2' => 'Edit Data Jabatan',
				'jabatan' => $this->admin->getDetailJabatan($id)
			];
			$this->load->view('templates/app', $data);
		} else {
			$data = [
				'jabatan_nama' 	=> $this->input->post('jabatan_nama'),
				'jabatan_id' => $this->input->post('jabatan_id')
			];

			$this->admin->editJabatan($id, $data);
			$this->session->set_flashdata('message', 'swal("Berhasil!", "Data Jabatan Berhasil Diedit!", "success");');
			redirect(base_url('data-jabatan'));
		}
	}



	public function index()
	{
		$data = [
			'title' => 'Data Karyawan',
			'page' => 'admin/karyawan/addkaryawan',
			'subtitle' => 'Admin',
			'subtitle2' => 'Data Daryawan',
			'data' => $this->db->get('users')->result()
		];

		$this->load->view('templates/app', $data, FALSE);
	}
}

/* End of file Karyawan.php */

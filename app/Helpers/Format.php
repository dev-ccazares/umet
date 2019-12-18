<?php
// Copyright (C) 2019 Grupo El Comercio. Todos los derechos reservados.
// Publicado bajo las condiciones de Licencia de Software Propietario.
namespace App\Helpers;

class Format {

	public function get_ok($data) {
		return array(
			'err' => FALSE,
			'title' => 'Notificación',
			'message' => 'Cargado correctamente',
			'data' => $data,
		);
	}

	public function get_err($message) {
		return array(
			'err' => TRUE,
			'title' => 'Error',
			'message' => $message,
			'data' => NULL,
		);
	}

	public function insert_ok($data) {
		return array(
			'err' => FALSE,
			'title' => 'Notificación',
			'message' => 'Registrado correctamente',
			'data' => $data,
		);
	}

	public function insert_err() {
		return array(
			'err' => TRUE,
			'title' => 'Error',
			'message' => 'Error al guardar los datos',
			'data' => null,
		);
	}

	public function update_ok($data) {
		return array(
			'err' => FALSE,
			'title' => 'Notificación',
			'message' => 'Actualizado correctamente',
			'data' => $data,
		);
	}

	public function update_err() {
		return array(
			'err' => TRUE,
			'title' => 'Error',
			'message' => 'Error al actualizar los datos',
			'data' => null,
		);
	}

	public function delete_ok($data) {
		return array(
			'err' => FALSE,
			'title' => 'Notificación',
			'message' => 'Eliminado correctamente',
			'data' => $data,
		);
	}

	public function delete_err() {
		return array(
			'err' => TRUE,
			'title' => 'Error',
			'message' => 'Error al eliminar los datos',
			'data' => null,
		);
	}

	public function insert_ok_custom($data, $message) {
		return array(
			'err' => FALSE,
			'title' => 'Notificación',
			'message' => $message,
			'data' => $data,
		);
	}

	public function insert_err_custom($data, $message) {
		return array(
			'err' => TRUE,
			'title' => 'Notificación',
			'message' => $message,
			'data' => $data,
		);
	}

	public function update_ok_custom($data, $message) {
		return array(
			'err' => FALSE,
			'title' => 'Notificación',
			'message' => $message,
			'data' => $data,
		);
	}

	public function update_err_custom($data, $message) {
		return array(
			'err' => TRUE,
			'title' => 'Notificación',
			'message' => $message,
			'data' => $data,
		);
	}

	public function get_ok_custom($data, $message) {
		return array(
			'err' => FALSE,
			'title' => 'Notificación',
			'message' => $message,
			'data' => $data,
		);
	}

	public function msg_err($msg) {
		return array(
			'err' => TRUE,
			'title' => 'Error',
			'message' => $msg,
			'data' => null,
		);
	}

	public function msg_err_erp($data, $msg) {
		return array(
			'err' => TRUE,
			'title' => 'Error',
			'message' => $msg,
			'data' => $data,
		);
	}

	public function msg_ok($msg) {
		return array(
			'err' => FALSE,
			'title' => 'Notificación',
			'message' => $msg,
			'data' => null,
		);
	}

}

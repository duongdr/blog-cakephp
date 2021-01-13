<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add', 'logout');
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
//				return $this->redirect($this->Auth->redirectUrl());
				return $this->redirect(
					array(
						'controller' => 'posts',
						'action' => 'index'
					));
			}
			$this->Flash->error(__('Invalid username or password, try again'));
		}
	}

	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

	public function index() {
		if ($this->isAuthorized($this->Auth->user())) {
			$this->paginate = array(
				'limit' => 2,
				'order' => array('id' => 'asc')
			);
			$users = $this->paginate('User');
//			$this->User->recursive = 0;
			$this->set('users', $users);
		} else {
			$this->Flash->error(__('You can not access.'));
		}

	}

	public function view($id = null) {
		if ($this->isAuthorized($this->Auth->user())) {
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			$this->set('user', $this->User->findById($id));
		} else {
			$this->Flash->error(__('You can not access.'));
		}
	}

	public function add() {
		if ($this->isAuthorized($this->Auth->user())) {
			if ($this->request->is('post')) {
				$this->User->create();
				if ($this->User->save($this->request->data)) {
					$this->Flash->success(__('The user has been saved'));
					return $this->redirect(array('action' => 'index'));
				}
				$this->Flash->error(
					__('The user could not be saved. Please, try again.')
				);
			}
		} else {
			$this->Flash->error(__('You can not access.'));
		}
	}

	public function edit($id = null) {
		if ($this->isAuthorized($this->Auth->user())) {
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			if ($this->request->is('post') || $this->request->is('put')) {
				if ($this->User->save($this->request->data)) {
					$this->Flash->success(__('The user has been saved'));
					return $this->redirect(array('action' => 'index'));
				}
				$this->Flash->error(
					__('The user could not be saved. Please, try again.')
				);
			} else {
				$this->request->data = $this->User->findById($id);
				unset($this->request->data['User']['password']);
			}
		} else {
			$this->Flash->error(__('You can not access.'));
		}

	}

	public function delete($id = null) {
		if ($this->isAuthorized($this->Auth->user())) {
			$this->request->allowMethod('post');
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			if ($this->User->delete()) {
				$this->Flash->success(__('User deleted'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Flash->error(__('User was not deleted'));
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Flash->error(__('You can not access.'));
		}
	}

}

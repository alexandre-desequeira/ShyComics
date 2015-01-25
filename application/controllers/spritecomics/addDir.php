<?php
	class Controller_spritecomics_addDir extends Controller_index
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Sprites Comics',
			]);
			
			$view	=	\Eliya\Tpl::get('spritecomics/index');
			$this->response->set($view);
		}
		
		public function post_index($name = null, $description = null, $parent_file = null)
		{
			if(isset($_SESSION['connected_user_id']) AND !empty($_SESSION['connected_user_id']))
			{
				$return = Model_Files::addDir($name, $description, $parent_file);
			}
			else
			{
				$return = Model_Files::ERROR_UPLOAD;
			}
			
			switch($return)
			{
				case Model_Files::ERROR_UPLOAD:
					$info = "Erreur &bull; Le dossier n'a pas, ou a mal, été créé. Une erreur est donc survenue. Veuillez réessayer.";
					$status = 'class="message infos error"';
				break;
				case Model_Files::ERROR_NAME:
					$info = "Erreur &bull; Le nom du dossier n'a pas ou a mal été inscrit. Veuillez réessayer.";
					$status = 'class="message infos error"';
				break;
				case Model_Files::PROCESS_OK:
					$info = "L'envoi a bien été effectué !";
					$status = 'class="message infos success"';
				break;
			}
			
			$member = Model_Users::getById($_SESSION['connected_user_id']);
			
			\Eliya\Tpl::set([
				'page_title'		=>	'Sprites Comics &bull; Galerie',
			]);
			
			if(!empty($member))
			{
				$data = [
					'user_id'		=> $member->prop('id'),
					'user_name'		=> $member->prop('username'),
					'user_files'	=> $member->getFiles(),
					'user_dirs'	    => $member->getFilesDirs(),
					'user_dirs_all'	=> $member->getFilesDirsAll(),
				];
			}
			else
			{
				$data = [
					'user_id'		=> null,
					'user_name'		=> null,
					'user_files'	=> null,
					'user_dirs'	    => null,
					'user_dirs_all'	=> null,
				];
			}
			
			$arrayInfo = [
				'infos_message' => $info,
				'infos_message_status' => $status,
			];
			$infos_message = \Eliya\Tpl::get('infos_message', $arrayInfo);
			$data['infos_message'] = $infos_message;
			
			$view	=	\Eliya\Tpl::get('spritecomics/gallery', $data);
			$this->response->set($view);
		}
	}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submit extends MY_Conference {
	public function __construct(){
		parent::__construct();
		$this->cinfo['show_confinfo'] = true;
		$this->user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		if( !$this->conf->confid_exists($this->conf_id,$this->user_sysop) ){
			$this->cinfo['show_confinfo'] = false;
			$this->conf->show_404conf();
		}
		$this->conf_config = $this->conf->conf_config($this->conf_id,$this->user_sysop);
	}

	public function index($conf_id=''){
		$data['conf_id']     = $conf_id;
		$data['body_class']  = $this->body_class;
		$data['_lang']       = $this->_lang;
		$data['spage']       = $this->spage;
		$data['conf_config'] = $this->conf_config;
		$data['conf_content']= $this->conf->conf_content($conf_id);
		//$data['schedule']=$this->conf->conf_schedule($conf_id);
		
		$this->load->view('common/header');
		$this->load->view('common/nav',$data);

		$this->load->view('conf/conf_nav',$data);
		//$this->load->view('conf/conf_schedule',$data);

		$this->load->view('conf/menu_submit',$data);
		$data['lists'] = $this->Submit->show_mypaper($this->user_login,$conf_id);
		$this->load->view('submit/list',$data);
		$this->load->view('common/footer');
		
	}

	public function add($conf_id=''){
		$data['conf_id']     = $conf_id;
		$data['body_class']  = $this->body_class;
		$data['_lang']       = $this->_lang;
		$data['spage']       = $this->spage;
		$data['conf_config'] = $this->conf_config;
		$data['conf_content']= $this->conf->conf_content($conf_id);
		//$data['schedule']=$this->conf->conf_schedule($conf_id);

		$step = $this->input->get("step");
		$this->load->view('common/header');
		$this->load->view('common/nav',$data);

		$this->load->view('conf/conf_nav',$data);
		//$this->load->view('conf/conf_schedule',$data);

		$this->load->view('conf/menu_submit',$data);
		if( !$this->conf->conf_hastopic($conf_id) ){
			$this->alert->js("尚未建立研討會主題，請洽研討會會議管理人員",get_url("main",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}	
		$schedule_submit = $this->conf->get_schedule($conf_id,"submit");
		$now = time();
		if( $now < $schedule_submit->start_value ){
			$this->alert->js("尚未開放投稿",get_url("main",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}

		if( $now > $schedule_submit->end_value ){
			$this->alert->js("投稿截止",get_url("main",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}
		switch ($step) {
			default:
			case 1:
				$data['step_class']=array(1=>"active",2=>"disabled",3=>"disabled",4=>"disabled",5=>"disabled",6=>"disabled");
				$data['filter'] = $this->conf->get_filter($conf_id);
				$this->load->view('submit/add/step',$data);
				$this->load->view('submit/add/step1',$data);
			break;
			case 2:
				$data['step_class']=array(1=>"completed",2=>"active",3=>"disabled",4=>"disabled",5=>"disabled",6=>"disabled");
				$num = $this->conf->get_filter_count($conf_id);
				if(count($this->input->post('list')) == ($num+2) ){
					$this->assets->add_css(asset_url().'style/chosen.css');
					$this->assets->add_js('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',true);
					$this->assets->add_js(asset_url().'js/repeatable.js',true);
					$this->assets->add_js(asset_url().'js/chosen.jquery.js');
					$country_list = config_item('country_list');
					$data['user'] =  $this->user->get_user_info($this->user_login);
					$data['country_list'] = $country_list['zhtw'];
					$data['topics'] = $this->conf->get_topic($conf_id);
					$this->load->view('submit/add/step',$data);
					$this->load->view('submit/add/step2',$data);
				}else{
					$this->alert->show("d",'<p>尚未選擇分類</p><p><a href="javascript:history.back();">返回上一頁</a></p>');
				}
			break;
			case 3:
				$data['step_class']=array(1=>"completed",2=>"completed",3=>"active",4=>"disabled",5=>"disabled",6=>"disabled");
				$data['show_file'] = false;
				if(is_null($this->input->get("upload"))){
					//author
					$this->form_validation->set_rules('user_fname[]', '名字', 'required');
					$this->form_validation->set_rules('user_lname[]', '姓氏', 'required');
					$this->form_validation->set_rules('user_email[]', '電子信箱', 'required|valid_email');
					$this->form_validation->set_rules('user_org[]', '所屬機構', 'required');
					$this->form_validation->set_rules('user_country[]', '國別', 'required');

					// paper info
					$this->form_validation->set_rules('sub_topic', '徵稿主題', 'required');
					$this->form_validation->set_rules('sub_title', '題目', 'required');
					$this->form_validation->set_rules('sub_summary', '摘要', 'required');
					$this->form_validation->set_rules(
				        'sub_keywords', '關鍵字',
				        'trim|required|min_length[1]',
				        array(
							'required'   => '您必須填寫%s.',
							'min_length' => '至少輸入一組%s'
				        )
					);
					$this->form_validation->set_rules('sub_lang', '語言', 'required');
					
					if ($this->form_validation->run()){
						$sub_title    =$this->input->post('sub_title');
						$sub_summary  =$this->input->post('sub_summary');
						$sub_keyword  =empty($this->input->post('sub_keywords'))?"":$this->input->post('sub_keywords');
						$sub_topic    =$this->input->post('sub_topic');
						$sub_lang     =$this->input->post('sub_lang');
						$sub_sponsor  =$this->input->post('sub_sponsor');
						
						$main_contact = $this->input->post('main_contact');
						$user_fname   = $this->input->post('user_fname');
						$user_lname   = $this->input->post('user_lname');
						$user_email   = $this->input->post('user_email');
						$user_org     = $this->input->post('user_org');
						$user_country = $this->input->post('user_country');

						$this->Submit->add_paper($sub_title,$sub_summary,$sub_keyword,$sub_topic,$sub_lang,$sub_sponsor,$conf_id);
            			$insert_id = $this->session->userdata($conf_id.'_insert_id');
            			$data['paper_id'] = $insert_id;
            			foreach ($user_fname as $key => $value) {
            				$contact_author = 0;
            				$user_login = NULL;
            				if($main_contact == $key+1){
            					$contact_author = 1;
            				}
            				$user_info = $this->user->email_find($user_email[$key]);
            				if( is_array($user_info) ){
            					$user_login = $user_info['user_login'];
            				}
            				$this->Submit->add_author($insert_id,$user_login,$user_fname[$key],$user_lname[$key],$user_email[$key],$user_org[$key],$user_country[$key],$contact_author,$key+1);
            			}
            		}
        		}else{
        			if(!$this->session->has_userdata($conf_id.'_insert_id') ){
						$this->alert->js("請以正常方式投稿或投稿逾時。",get_url("submit",$conf_id,"add"));
						$this->load->view('common/footer');
						$this->output->_display();
						exit;
					}else{
						$paper_id = $this->session->userdata($conf_id.'_insert_id');
						$data['paper_id'] = $paper_id;
						$this->Submit->add_time($conf_id,$paper_id);
					}
            		$config['upload_path']= $this->conf->get_paperdir($conf_id);
	                $config['allowed_types']= 'pdf';
	                $config['encrypt_name']= true;

	                $this->load->library('upload', $config);
	                
	                if ( $this->upload->do_upload('paper_file')){
                        $upload_data = $this->upload->data();
                        $data['upload_data'] = $upload_data;
                        $arrayLevel = arrayLevel($upload_data);
                        if( $arrayLevel >1 ){
							$this->alert->js("投稿檔案僅限一份");
                        }
                        if(!$this->session->has_userdata($conf_id.'_file_id')){
                       		$this->Submit->add_file($conf_id,$paper_id,$upload_data['client_name'],$upload_data['file_name'],"F");
                    	}else{
                    		$fid = $this->session->userdata($conf_id.'_file_id');
                    		$del_file = $this->Submit->get_otherfile($paper_id);
                    		//delete_files($this->conf->get_paperdir($conf_id).$del_file->file_system); //bug
                    		$this->Submit->update_file($conf_id,$paper_id,$fid,$upload_data['client_name'],$upload_data['file_name']);
                    	}
	                	$data['show_file'] = true;
	                	$data['otherfile'] = $this->Submit->get_otherfile($paper_id);
	                }
	            }
	            $this->load->view('submit/add/step',$data);
        		$this->load->view('submit/add/step3',$data);
			break;
			case 4:
				$data['step_class']=array(1=>"completed",2=>"completed",3=>"completed",4=>"active",5=>"disabled",6=>"disabled");
				if(!$this->session->has_userdata($conf_id.'_insert_id') ){
					$this->alert->js("請以正常方式投稿或投稿逾時。",get_url("submit",$conf_id,"add"));
					$this->load->view('common/footer');
					$this->output->_display();
					exit;
				}else{
					$paper_id = $this->session->userdata($conf_id.'_insert_id');
					$data['paper_id'] = $paper_id;
					$this->Submit->add_time($conf_id,$paper_id);
				}
                
				if(is_null($this->input->get("upload"))){

				}else{
					$config['upload_path']= $this->conf->get_paperdir($conf_id);
	                $config['allowed_types']= 'pdf';
	                $config['encrypt_name']= true;

	                $this->load->library('upload', $config);
	                if ( $this->upload->do_upload('paper_file')){
                        $upload_datas = $this->upload->data();
                        $arrayLevel = arrayLevel($upload_datas);
                        if( $arrayLevel ==1 ){
	                       	$this->Submit->add_file($conf_id,$paper_id,$upload_datas['client_name'],$upload_datas['file_name'],"O");
                        }else if($arrayLevel == 2){
                        	foreach ($upload_datas as $key => $upload_data) {
	                       		$this->Submit->add_file($conf_id,$paper_id,$upload_data['client_name'],$upload_data['file_name'],"O");
	                        }
                        }
                    }
				}
				$data['otherfiles'] = $this->Submit->get_otherfiles($paper_id);
				$this->load->view('submit/add/step',$data);
				$this->load->view('submit/add/step4',$data);
			break;
			case 5:
				$data['step_class']=array(1=>"completed",2=>"completed",3=>"completed",4=>"completed",5=>"active",6=>"disabled");
				if(!$this->session->has_userdata($conf_id.'_insert_id') ){
					$this->alert->js("請以正常方式投稿或投稿逾時。",get_url("submit",$conf_id,"add"));
					$this->load->view('common/footer');
					$this->output->_display();
					exit;
				}else{
					$paper_id = $this->session->userdata($conf_id.'_insert_id');
					$data['paper_id'] = $paper_id;
					$this->Submit->add_time($conf_id,$paper_id);
				}
				$data['paper'] = $this->Submit->get_paperinfo($conf_id,$paper_id,$this->user_login);
				
				$bool_paper["bool_paper"]     =false;
				$bool_otherfile               =false;
				$bool_authors["bool_authors"] =false;

				if(!empty($data['paper'])){
					$data['authors'] = $this->Submit->get_author($paper_id);
					$data['otherfile'] = $this->Submit->get_otherfile($paper_id);
					$data['otherfiles'] = $this->Submit->get_otherfiles($paper_id);

					$data['bool_paper'] = $this->Submit->check_paper($data['paper']);
					$data['bool_otherfile'] = $this->Submit->check_otherfile($data['otherfile']);
					$data['bool_authors'] = $this->Submit->check_authors($data['authors']);
				}
				$this->load->view('submit/add/step',$data);
				$this->load->view('submit/add/step5',$data);
			break;
			case 6:
				$data['step_class']=array(1=>"completed",2=>"completed",3=>"completed",4=>"completed",5=>"completed",6=>"active");
				if(!$this->session->has_userdata($conf_id.'_insert_id') ){
					$this->alert->js("請以正常方式投稿或投稿逾時。",get_url("submit",$conf_id,"add"));
					$this->load->view('common/footer');
					$this->output->_display();
					exit;
				}else{
					$paper_id = $this->session->userdata($conf_id.'_insert_id');
					$data['paper_id'] = $paper_id;
					$this->Submit->add_time($conf_id,$paper_id);
				}

				$this->load->view('submit/add/step',$data);

				$paper = $this->Submit->get_paperinfo($conf_id,$paper_id,$this->user_login);
				$bool_paper["bool_paper"]     =false;
				$bool_otherfile               =false;
				$bool_authors["bool_authors"] =false;
				if(!empty($paper)){
					$authors = $this->Submit->get_author($paper_id);
					$otherfile = $this->Submit->get_otherfile($paper_id);

					$bool_paper = $this->Submit->check_paper($paper);
					$bool_otherfile = $this->Submit->check_otherfile($otherfile);
					$bool_authors = $this->Submit->check_authors($authors);

					$this->form_validation->set_rules(
				        'submit', '送出審查',
				        'required',
				        array(
							'required'   => '請透過表單送出審查'
				        )
					);

					if ($this->form_validation->run()){
						if($bool_paper["bool_paper"] && $bool_otherfile && $bool_authors["bool_authors"]){
							if( $this->Submit->paper_to_review($conf_id,$paper_id) ){
								$this->alert->js("稿件已送出審查");
								$this->alert->show("s","稿件已送出審查",get_url("submit",$conf_id));
							}else{
								$this->alert->js("稿件送出審查失敗");
								$this->alert->show("d","稿件送出審查失敗",get_url("submit",$conf_id));
							}
						}else{
							$this->alert->js("稿件送審資格不符合，送審失敗");
							$this->alert->show("d","稿件送審資格不符合，送審失敗",get_url("submit",$conf_id));
						}
					}
				}else{
					$this->alert->js("查無本篇稿件資料",get_url("submit",$conf_id));
				}
			break;
		}
		//sp($this->session->all_userdata());
		$this->load->view('common/footer');
		
	
	}
	public function edit($conf_id='',$paper_id=''){
		if( empty($conf_id) || empty($paper_id) ){
			$this->alert->js("查本篇稿件",get_url("submit",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}
		$data['conf_id']     = $conf_id;
		$data['body_class']  = $this->body_class;
		$data['_lang']       = $this->_lang;
		$data['spage']       = $this->spage;
		$data['conf_config'] = $this->conf_config;
		$data['conf_content']= $this->conf->conf_content($conf_id);
		//$data['schedule']=$this->conf->conf_schedule($conf_id);

		$step = $this->input->get("step");
		
		$this->load->view('common/header');
		$this->load->view('common/nav',$data);
		
		$this->load->view('conf/conf_nav',$data);
		//$this->load->view('conf/conf_schedule',$data);

		$this->load->view('conf/menu_submit',$data);
		if( !$this->conf->conf_hastopic($conf_id) ){
			$this->alert->js("尚未建立研討會主題，請洽研討會會議管理人員",get_url("main",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}

		$schedule_submit = $this->conf->get_schedule($conf_id,"submit");
		$now = time();
		if( $now < $schedule_submit->start_value ){
			$this->alert->js("尚未開放投稿",get_url("main",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}

		if( $now > $schedule_submit->end_value ){
			$this->alert->js("投稿截止",get_url("main",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}
		
		if( $this->Submit->is_editable($paper_id, $this->user_login) ){
			$this->alert->js("稿件已送審，無法編輯",get_url("submit",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}

		if( !$this->Submit->is_author($paper_id, $this->user_login) ){
			$this->alert->js("非本篇作者或查無稿件",get_url("submit",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}
		switch ($step) {
			default:
			case 1:
				$data['step_class']=array(1=>"active",2=>"completed",3=>"completed",4=>"completed",5=>"completed",6=>"disabled");
				$data['filter'] = $this->conf->get_filter($conf_id);
				$this->load->view('submit/edit/step',$data);
				$this->load->view('submit/edit/step1',$data);
			break;
			case 2:
				$data['step_class']=array(1=>"completed",2=>"active",3=>"completed",4=>"completed",5=>"completed",6=>"disabled");
				$this->assets->add_css(asset_url().'style/chosen.css');
				$this->assets->add_js('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',true);
				$this->assets->add_js(asset_url().'js/repeatable.js',true);
				$this->assets->add_js(asset_url().'js/chosen.jquery.js');
				$country_list = config_item('country_list');
				$data['paper'] = $this->Submit->get_paperinfo($conf_id,$paper_id, $this->user_login);
				$data['country_list'] = $country_list['zhtw'];
				$data['topics'] = $this->conf->get_topic($conf_id);
				$data['authors'] = $this->Submit->get_author($paper_id);
				$this->load->view('submit/edit/step',$data);
				$this->load->view('submit/edit/step2',$data);
			break;
			case 3:
				$data['step_class']=array(1=>"completed",2=>"completed",3=>"active",4=>"completed",5=>"completed",6=>"disabled");
				$data['show_file'] = true;
				$data['otherfile'] = $this->Submit->get_otherfile($paper_id);
				//author
				$this->form_validation->set_rules('user_fname[]', '名字', 'required');
				$this->form_validation->set_rules('user_lname[]', '姓氏', 'required');
				$this->form_validation->set_rules('user_email[]', '電子信箱', 'required|valid_email');
				$this->form_validation->set_rules('user_org[]', '所屬機構', 'required');
				$this->form_validation->set_rules('user_country[]', '國別', 'required');

				// paper info
				$this->form_validation->set_rules('sub_topic', '徵稿主題', 'required');
				$this->form_validation->set_rules('sub_title', '題目', 'required');
				$this->form_validation->set_rules('sub_summary', '摘要', 'required');
				$this->form_validation->set_rules(
			        'sub_keywords', '關鍵字',
			        'trim|required|min_length[1]',
			        array(
						'required'   => '您必須填寫%s.',
						'min_length' => '至少輸入一組%s'
			        )
				);
				$this->form_validation->set_rules('sub_lang', '語言', 'required');
				
				if ($this->form_validation->run()){
					$sub_title    =$this->input->post('sub_title');
					$sub_summary  =$this->input->post('sub_summary');
					$sub_keyword  =empty($this->input->post('sub_keywords'))?"":$this->input->post('sub_keywords');
					$sub_topic    =$this->input->post('sub_topic');
					$sub_lang     =$this->input->post('sub_lang');
					$sub_sponsor  =$this->input->post('sub_sponsor');
					
					$main_contact = $this->input->post('main_contact');
					$user_fname   = $this->input->post('user_fname');
					$user_lname   = $this->input->post('user_lname');
					$user_email   = $this->input->post('user_email');
					$user_org     = $this->input->post('user_org');
					$user_country = $this->input->post('user_country');

					if( $this->Submit->update_paper($paper_id,$conf_id,$sub_title,$sub_summary,$sub_keyword,$sub_topic,$sub_lang,$sub_sponsor) ){
						$this->alert->show("s","更新成功");
					}
        			$this->Submit->del_author($paper_id);
        			
        			foreach ($user_fname as $key => $value) {
        				$contact_author = 0;
        				$user_login = NULL;
        				if($main_contact == $key+1){
        					$contact_author = 1;
        				}
        				$user_info = $this->user->email_find($user_email[$key]);
        				if( is_array($user_info) ){
        					$user_login = $user_info['user_login'];
        				}
        				$this->Submit->add_author($paper_id,$user_login,$user_fname[$key],$user_lname[$key],$user_email[$key],$user_org[$key],$user_country[$key],$contact_author,$key+1);
        			}
        		}
        		if(!is_null($this->input->get("upload"))){
        			$config['upload_path']= $this->conf->get_paperdir($conf_id);
	                $config['allowed_types']= 'pdf';
	                $config['encrypt_name']= true;

	                $this->load->library('upload', $config);
	                
	                if ( $this->upload->do_upload('paper_file')){
                        $upload_data = $this->upload->data();
                        $data['upload_data'] = $upload_data;
                        $arrayLevel = arrayLevel($upload_data);
                        if( $arrayLevel >1 ){
                        	$this->alert->js("投稿檔案僅限一份",get_url("submit",$conf_id));
                        }
                        if(empty($data['otherfile'])){
                       		$this->Submit->add_file($conf_id,$paper_id,$upload_data['client_name'],$upload_data['file_name'],"F");
                    	}else{
                    		$fid = $this->session->userdata($conf_id.'_file_id');
                    		$del_file = $this->Submit->get_otherfile($paper_id);
                    		delete_files($this->conf->get_paperdir($conf_id).$del_file->file_system);
                    		$this->Submit->update_file($conf_id,$paper_id,$fid,$upload_data['client_name'],$upload_data['file_name']);
                    	}
	                	$data['otherfile'] = $this->Submit->get_otherfile($paper_id);
	                }
        		}
        		if(!is_null($this->input->get("save"))){
        			//save and exit
				}
				$this->load->view('submit/edit/step',$data);
        		$this->load->view('submit/edit/step3',$data);
			break;
			case 4:	
				$data['step_class']=array(1=>"completed",2=>"completed",3=>"completed",4=>"active",5=>"completed",6=>"disabled");
				if(!is_null($this->input->get("upload"))){
					$config['upload_path']= $this->conf->get_paperdir($conf_id);
	                $config['allowed_types']= 'pdf';
	                $config['encrypt_name']= true;

	                $this->load->library('upload', $config);
	                if ( $this->upload->do_upload('paper_file')){
                        $upload_datas = $this->upload->data();
                        $arrayLevel = arrayLevel($upload_datas);
                        if( $arrayLevel ==1 ){
	                       	$this->Submit->add_file($conf_id,$paper_id,$upload_datas['client_name'],$upload_datas['file_name'],"O");
                        }else if($arrayLevel == 2){
                        	foreach ($upload_datas as $key => $upload_data) {
	                       		$this->Submit->add_file($conf_id,$paper_id,$upload_data['client_name'],$upload_data['file_name'],"O");
	                        }
                        }
                    }
				}
				$data['otherfiles'] = $this->Submit->get_otherfiles($paper_id);
				$this->load->view('submit/edit/step',$data);
				$this->load->view('submit/edit/step4',$data);
			break;
			case 5:
				$data['step_class']=array(1=>"completed",2=>"completed",3=>"completed",4=>"completed",5=>"active",6=>"disabled");
				$data['paper'] = $this->Submit->get_paperinfo($conf_id,$paper_id,$this->user_login);
				$bool_paper["bool_paper"]     =false;
				$bool_otherfile               =false;
				$bool_authors["bool_authors"] =false;

				if(!empty($data['paper'])){
					$data['authors'] = $this->Submit->get_author($paper_id);
					$data['otherfile'] = $this->Submit->get_otherfile($paper_id);
					$data['otherfiles'] = $this->Submit->get_otherfiles($paper_id);

					$data['bool_paper'] = $this->Submit->check_paper($data['paper']);
					$data['bool_otherfile'] = $this->Submit->check_otherfile($data['otherfile']);
					$data['bool_authors'] = $this->Submit->check_authors($data['authors']);
				}

				$this->load->view('submit/edit/step',$data);
				$this->load->view('submit/edit/step5',$data);
			break;
			case 6:
				$data['step_class']=array(1=>"completed",2=>"completed",3=>"completed",4=>"completed",5=>"completed",6=>"active");
				$this->load->view('submit/edit/step',$data);

				$paper = $this->Submit->get_paperinfo($conf_id,$paper_id,$this->user_login);
				$bool_paper["bool_paper"]     =false;
				$bool_otherfile               =false;
				$bool_authors["bool_authors"] =false;
				if(!empty($paper)){
					$authors = $this->Submit->get_author($paper_id);
					$otherfile = $this->Submit->get_otherfile($paper_id);

					$bool_paper = $this->Submit->check_paper($paper);
					$bool_otherfile = $this->Submit->check_otherfile($otherfile);
					$bool_authors = $this->Submit->check_authors($authors);

					$this->form_validation->set_rules(
				        'submit', '送出審查',
				        'required',
				        array(
							'required'   => '請透過表單送出審查'
				        )
					);
					if ($this->form_validation->run()){
						if($bool_paper["bool_paper"] && $bool_otherfile && $bool_authors["bool_authors"]){
							if( $this->Submit->paper_to_review($conf_id,$paper_id) ){
								$this->alert->js("稿件已送出審查");
								$this->alert->show("s","稿件已送出審查",get_url("submit",$conf_id));
							}else{
								$this->alert->js("稿件送出審查失敗");
								$this->alert->show("d","稿件送出審查失敗",get_url("submit",$conf_id));
							}
						}else{
							$this->alert->js("稿件送審資格不符合，送審失敗");
							$this->alert->show("d","稿件送審資格不符合，送審失敗",get_url("submit",$conf_id));
						}
					}
				}else{
					$this->alert->js("查無本篇稿件資料",get_url("submit",$conf_id));
				}
			break;
			
		}
		$this->load->view('common/footer');
		
	}
	public function files($conf_id='',$paper_id=''){
		if( empty($conf_id) || empty($paper_id) ){
			$this->alert->js("查無稿件檔案",get_url("submit",$conf_id));
		}
		$data['conf_id']     = $conf_id;

		if( is_null($this->input->get("fid") ) ){
			$this->alert->js("查無稿件檔案",get_url("submit",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}else{
			$fid = $this->input->get("fid");
			$this->db->from("paper");
			$this->db->join('paper_author', 'paper.sub_id = paper_author.paper_id');
			$this->db->join('paper_file', 'paper.sub_id = paper_file.paper_id');
			$this->db->where('paper_author.user_login', $this->user_login);
			$this->db->where("paper_author.paper_id",$paper_id);
			$this->db->where("fid",$fid);
			$query = $this->db->get();
			$file = $query->row();
			if(empty($file)){
				$this->alert->js("查無稿件檔案",get_url("submit",$conf_id));
				$this->load->view('common/footer');
				$this->output->_display();
				exit;
			}
			$this->load->helper('download');
			$do = $this->input->get("do");
			switch($do){
				case "download":
					force_download($file->file_name,file_get_contents($this->conf->get_paperdir($conf_id).$file->file_system));
				break;
				default:
				case "view":
					$this->output
						->set_content_type('pdf')
						->set_header("Content-Disposition: inline; filename=\"".$paper_id."-".$file->fid."-".$file->file_name."\"")
						->set_output(file_get_contents($this->conf->get_paperdir($conf_id).$file->file_system));
				break;
			}
		}
		
	}
	public function detail($conf_id='',$paper_id=''){
		if( empty($conf_id) || empty($paper_id) ){
			$this->alert->js("查本篇稿件",get_url("submit",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}
		$data['conf_id']     = $conf_id;
		$data['body_class']  = $this->body_class;
		$data['_lang']       = $this->_lang;
		$data['spage']       = $this->spage;
		$data['conf_config'] = $this->conf_config;
		$data['conf_content']= $this->conf->conf_content($conf_id);
		if( !$this->Submit->is_author($paper_id, $this->user_login) ){
			$this->alert->js("非本篇作者或查無稿件",get_url("submit",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}
		
		$data['spage']=$this->config->item('spage');
		$data['conf_config']=$this->conf->conf_config($conf_id);
		//$data['schedule']=$this->conf->conf_schedule($conf_id);
		$data['conf_content']=$this->conf->conf_content($conf_id);

		$data['paper'] = $this->Submit->get_paperinfo($conf_id,$paper_id,$this->user_login);
		if(!empty($data['paper'])){
			$data['authors'] = $this->Submit->get_author($paper_id);
			$data['otherfile'] = $this->Submit->get_otherfile($paper_id);
			$data['otherfiles'] = $this->Submit->get_otherfiles($paper_id);
			$data['reviewers'] = $this->topic->get_reviewer($paper_id);
		}
		$this->load->view('common/header');
		$this->load->view('common/nav',$data);
		$this->load->view('conf/conf_nav',$data);
		$this->load->view('conf/menu_submit',$data);
		$this->load->view('submit/detail',$data);
		$this->load->view('common/footer');
		
	}
	public function remove($conf_id='',$paper_id=''){
		if( empty($conf_id) || empty($paper_id) ){
			$this->alert->js("查本篇稿件",get_url("submit",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}
		$data['conf_id']     = $conf_id;
		$data['body_class']  = $this->body_class;
		$data['_lang']       = $this->_lang;
		$data['spage']       = $this->spage;

		if( !$this->Submit->is_author($paper_id, $this->user_login) ){
			$this->alert->js("非本篇作者或查無稿件",get_url("submit",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}
		
	}

	public function most($conf_id='',$act=''){
		// check $conf_config['conf_most'] == 1??
		$data['conf_id']     = $conf_id;
		$data['body_class']  = $this->body_class;
		$data['_lang']       = $this->_lang;
		$data['spage']       = $this->spage;
		$data['conf_config'] = $this->conf_config;
		$data['conf_content']= $this->conf->conf_content($conf_id);

		if( $this->conf_config['conf_most'] == 1 ){
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);

			$this->load->view('conf/conf_nav',$data);
			$this->load->view('conf/conf_schedule',$data);
			$this->load->view('conf/menu_submit',$data);
			switch($act){
				case "add":
	                $this->Submit->most_valid();
					if ($this->form_validation->run()){
						$most_method     = $this->input->post('most_method');
						$most_number     = $this->input->post('most_number');
						$most_name       = $this->input->post('most_name');
						$most_name_eng   = $this->input->post('most_name_eng');
						$most_uni        = $this->input->post('most_uni');
						$most_dept       = $this->input->post('most_dept');
						$most_host       = $this->input->post('most_host');

						$report_name     = $this->input->post('report_name');
						$report_uni      = $this->input->post('report_uni');
						$report_dept     = $this->input->post('report_dept');
						$report_title    = $this->input->post('report_title');
						$report_email    = $this->input->post('report_email');
						$report_phone    = $this->input->post('report_phone');
						$report_meal     = $this->input->post('report_meal');
						$report_mealtype = $this->input->post('report_mealtype');
						$most_id = $this->Submit->add_most($conf_id,$this->user_login,$most_method,$most_number,$most_name,$most_name_eng,$most_host,$most_uni,$most_dept);
						
						if( $most_id == false){
							$this->alert->js("新增失敗");
							$this->alert->refresh(2);
						}else{
							$this->Submit->add_most_report($most_id,$report_name,$report_uni,$report_dept,$report_title,$report_email,$report_phone,$report_meal,$report_mealtype);
							$bool_auth = false;
							$bool_result = false;
							$bool_poster = false;

							$config['upload_path']= $this->conf->get_mostdir($conf_id);
							$config['allowed_types']= 'pdf|doc|docx';
			                $config['encrypt_name']= true;
			                $this->load->library('upload', $config);

							$most_file = $_FILES['most']['name'];
							if( empty($most_file['auth']) ){
								$this->alert->show("d","授權同意書未上傳");
							}else{
								$bool_auth = true;
							}
							if( empty($most_file['result']) ){
								$this->alert->show("d","成果資料表未上傳");
							}else{
								$bool_result = true;
							}
							if( $most_method == "P" ){
								if( empty($most_file['poster']) ){
									$this->alert->show("d","成果海報電子檔未上傳");
								}else{
									$bool_poster = true;
								}
							}else{
								$bool_poster = true;
							}

							$array_auth = array();
							$array_result = array();
							$array_poster = array();

							if( $bool_auth && $bool_result && $bool_poster){
								if ( $this->upload->do_upload('most')){
									$most = $this->upload->data();
									$array_auth = $most[0];
									$array_result = $most[1];
									if( $most_method == "P" ){
										$array_poster = $most[2];
										$this->Submit->add_most_file($most_id,$conf_id,$array_auth['file_name'],$array_result['file_name'],$array_poster['file_name'],$array_auth['client_name'],$array_result['client_name'],$array_poster['client_name']);
										$this->alert->refresh(2);
									}else if( $most_method == "O" ){
										$this->Submit->add_most_file($most_id,$conf_id,$array_auth['file_name'],$array_result['file_name'],NULL,$array_auth['client_name'],$array_result['client_name'],NULL);
										$this->alert->refresh(2);
									}
								}
							}
						}
					}
					$this->load->view('submit/most/add',$data);
				break;
				case "edit":
					if( !empty( $this->input->get('id') ) ){
						$most_id = $this->input->get('id');
						$most = $this->Submit->get_most($conf_id,$this->user_login,$most_id);
						if( !$most->most_status == 0 ){
							$this->alert->js("報名資料已送出 無法再次編輯",get_url("submit",$conf_id,"most"));
							$this->output->_display();
							exit;
						}
						if( !empty($most) ){
							$data['most'] = $most;
							$report = $this->Submit->get_most_report($most_id);
							$mostfile = $this->Submit->get_most_file($conf_id,$most_id);
							$data['report'] = $report;
							$data['most_file'] = $mostfile;
							$do = $this->input->get('do');
							$can_empty = array("most_status");
							switch($do){
								case "submit":
									foreach ($most as $key => $m) {
										if( !in_array($key,$can_empty) ){
											if( empty($m) ){$this->alert->show("d","計畫資料不齊全",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);$this->output->_display();exit;}
										}
									}
									foreach ($report as $key => $r) {
										if( empty($r) ){$this->alert->show("d","發表者資料不齊全",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);$this->output->_display();exit;}
									}
									if( empty($mostfile->most_auth) ){
										$this->alert->show("d","授權同意書未上傳",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
										$this->output->_display();
										exit;
									}
									if( empty($mostfile->most_result) ){
										$this->alert->show("d","成果資料表未上傳",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
										$this->output->_display();
										exit;
									}
									if( $most->most_method == "P" ){
										if( empty($mostfile->most_poster) ){
											$this->alert->show("d","成果海報電子檔未上傳",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
											$this->output->_display();
											exit;
										}
									}
									if( $this->Submit->submit_most($conf_id,$most_id,$this->user_login) ){
										$this->alert->js("成功送出資料",get_url("submit",$conf_id,"most"));
					                }else{
										$this->alert->js("送出資料失敗",get_url("submit",$conf_id,"most"));
									}
									
								break;
								case "info":
									$this->Submit->most_valid();
									if ($this->form_validation->run()){
										$most_method     = $this->input->post('most_method');
										$most_number     = $this->input->post('most_number');
										$most_name       = $this->input->post('most_name');
										$most_name_eng   = $this->input->post('most_name_eng');
										$most_uni        = $this->input->post('most_uni');
										$most_dept       = $this->input->post('most_dept');
										$most_host       = $this->input->post('most_host');

										$report_name     = $this->input->post('report_name');
										$report_uni      = $this->input->post('report_uni');
										$report_dept     = $this->input->post('report_dept');
										$report_title    = $this->input->post('report_title');
										$report_email    = $this->input->post('report_email');
										$report_phone    = $this->input->post('report_phone');
										$report_meal     = $this->input->post('report_meal');
										$report_mealtype = $this->input->post('report_mealtype');
										$update_most = $this->Submit->update_most($conf_id,$this->user_login,$most_id,$most_method,$most_number,$most_name,$most_name_eng,$most_host,$most_uni,$most_dept);
										$update_most_report = $this->Submit->update_most_report($most_id,$report_name,$report_uni,$report_dept,$report_title,$report_email,$report_phone,$report_meal,$report_mealtype);
										if( $update_most && $update_most_report){
											$this->alert->js("更新成功",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
										}else{
											$this->alert->js("更新失敗",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
										}
									}
								break;
								case "file":
									$config['upload_path']= $this->conf->get_mostdir($conf_id);
									$config['allowed_types']= 'pdf|doc|docx';
					                $config['encrypt_name']= true;
					                $this->load->library('upload', $config);

					                $file = $this->input->post('file');
					                switch($file){
					                	case "auth":
					                		if ( $this->upload->do_upload('most_auth')){
								                $most_file  = $this->upload->data();
								                if( $this->Submit->update_most_file($most_id,"auth",$most_file['file_name'],$most_file['client_name']) ){
													$this->alert->js("更新成功",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
								                }else{
													$this->alert->js("更新失敗",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
												}
								            }else{
												$this->alert->js("更新失敗",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
								            }
							            break;
							            case "result":
							            	if ( $this->upload->do_upload('most_result')){
								            	$most_file  = $this->upload->data();
								            	if( $this->Submit->update_most_file($most_id,"result",$most_file['file_name'],$most_file['client_name']) ){
													$this->alert->js("更新成功",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
								                }else{
													$this->alert->js("更新失敗",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
												}
								            }else{
												$this->alert->js("更新失敗",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
								            }
							            break;
							            case "poster":
							            	if ( $this->upload->do_upload('most_poster')){
								                $most_file  = $this->upload->data();
								                if( $this->Submit->update_most_file($most_id,"poster",$most_file['file_name'],$most_file['client_name']) ){
													$this->alert->js("更新成功",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
								                }else{
													$this->alert->js("更新失敗",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
												}
								            }else{
												$this->alert->js("更新失敗",get_url("submit",$conf_id,"most","edit")."?id=".$most->most_id);
								            }
							            break;
					                }
								break;
							}
							$this->load->view("submit/most/edit",$data);
						}
					}else{
						$this->alert->js("找不到上傳資料");
					}
				break;
				case "detail":
					if( !empty( $this->input->get('id') ) ){
						$most_id = $this->input->get('id');
						$most = $this->Submit->get_most($conf_id,$this->user_login,$most_id);
						
						if( !empty($most) ){
							$data['most'] = $most;
							$data['most_file'] = $this->Submit->get_most_file($conf_id,$most_id);
							$data['report'] = $this->Submit->get_most_report($most_id);
							$this->load->view("submit/most/detail",$data);
						}
					}else{
						$this->alert->js("找不到上傳資料");
					}
				break;
				case "list":
				default:
					$data['mosts'] = $this->Submit->get_mosts($conf_id,$this->user_login);
					$this->load->view('submit/most/list',$data);
				break;
			}
			$this->load->view('common/footer');
		}else{
			$this->alert->js("本研討會未開啟科技部成果發表",get_url("main",$conf_id));
			$this->load->view('common/footer');
			$this->output->_display();
			exit;
		}
	}

	public function auth($conf_id=''){
		$data['conf_config'] = $this->conf_config;
		
		$schedule = $this->conf->get_schedule($conf_id,"hold");
		$data['schedule'] = array();
		$data['schedule']['start'] = "中華民國 ".(date("Y",$schedule->start_value) - 1911).date("年 m月 d日",$schedule->start_value);
		$data['schedule']['end'] = (date("Y",$schedule->end_value) - 1911).date("年 m月 d日",$schedule->end_value);

		
		header('Content-Type: application/msword');
		header("Expires: 0");
		header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
		header("Content-disposition: attachment; filename=".$this->conf_config['conf_name']."授權書.doc");/**/
		$this->load->view('submit/auth',$data);
	}
	private function _temp($conf_id=''){
		$data['conf_id']     = $conf_id;
		$data['body_class']  = $this->body_class;
		$data['_lang']       = $this->_lang;
		$data['spage']       = $this->spage;
		$data['conf_config'] = $this->conf_config;
		$data['conf_content']= $this->conf->conf_content($conf_id);

		$this->load->view('common/header');
		$this->load->view('common/nav',$data);

		$this->load->view('conf/conf_nav',$data);
		//$this->load->view('conf/conf_schedule',$data);
		$this->load->view('conf/menu_submit',$data);
		$this->load->view('common/footer');
	}

	private function _get_conf_info($conf_id){
		if( $this->cinfo['show_confinfo'] ){
			$user_login = $this->session->userdata('user_login');
			$user_sysop=$this->user->is_sysop()?$this->session->userdata('user_sysop'):0;
		}
	}
}

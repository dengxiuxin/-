<?php

	//����һ��dao ���ݿ������[����ģʽ] ��opp, mysqli�� ���˼�롿
	class DAOMySQLi {

		//dao Ӧ���е�����
		private $_host;
		private $_user;
		private $_pwd;
		private $_dbname;
		private $_port;		
		//�ַ���
		private $_charset;
		//��һ��mysqli����ʵ��
		private $_mySQLi;
		//�и���һ��Ψһʵ��������
		private static $_instance;
		
		//�ú������һ����ʼ����Ա���Ե�����
		private function _initOption(array $option = array()){	
			//������� ���� $option ��ֵ���� ��Ա���ԣ�  ����Ч��
			$this->_host = isset($option['host']) ? $option['host'] : '';
			$this->_user = isset($option['user']) ? $option['user'] : '';
			$this->_pwd = isset($option['pwd']) ? $option['pwd'] : '';
			$this->_dbname = isset($option['dbname']) ? $option['dbname'] : '';
			$this->_port = isset($option['port']) ? $option['port'] : '';
			$this->_charset = isset($option['charset']) ? $option['charset'] : '';
			
			if($this->_host == '' || $this->_user == '' || $this->_pwd == '' 
			|| $this->_dbname == '' || $this->_port == '' || $this->_charset == ''){
				die('�㴫��Ĳ�����������������');
			}
		}
		
		//дһ����������ɶԡ���mySQLi�����ʼ��
		private function _initMySQLi (){
			
			//����mysqli����ʵ��
			$this->_mySQLi = new MySQLi($this->_host,$this->_user,$this->_pwd,$this->_dbname, $this->_port);
			
			if($this->_mySQLi->connect_errno){
				die('����ʧ�ܣ�������Ϣ' .$this->_mySQLi->connect_error);
			}
			
			//�����ַ���
			$this->_mySQLi->set_charset($this->_charset);
		}
		
		//���캯�� ��ɳ�ʼ��
		private function __construct(array $option = array()){

			//echo '<pre> __construct'
			
			//�ú������һ����ʼ����Ա���Ե�����
			$this->_initOption($option);
			$this->_initMySQLi();
			
			
		}

		//�����ṩһ����̬��public���������Է���һ��Ψһ�Ķ���ʵ��
		public static function getSingleton(array $option = array()){
			
			//�����û�д����������ʵ��
			if(!(self::$_instance instanceof self)){
				//��������ʵ����������ǹ��캯��
				self :: $_instance = new self($option);
			}
			//���ض���ʵ��
			return self :: $_instance;
		}


			//��ֹ��¡
			private function __clone(){
			}

			//�����ṩһ���������ӿڣ�������һ����¼
			public function fetchRow($sql = ''){

				//Ϊ�˴ﵽ������Ŀ¼
				//1.�����ͷ�$res
				//2.��Ҫ�����������ظ������ļ�ʹ��
				//˼·�ǽ�$res ��¼��װ��һ�������У������鷵�ء�
				//����һ�������飬׼��װ��¼
				$arr = array();
				$res = $this->_mySQLi->query($sql);
				if($row = $res->fetch_assoc()){
					$arr = $row;
				}
				//�����ͷ� $res;
				$res->free();
				return $arr;

			}
			
			//�����ṩһ���������ӿڣ��� ��ɲ�ѯ����select��
			public function fetchAll($sql = ''){
				
				//Ϊ�˴ﵽ������Ŀ¼
				//1.�����ͷ�$res
				//2.��Ҫ�����������ظ������ļ�ʹ��
				//˼·�ǽ�$res ��¼��װ��һ�������У������鷵�ء�
				//����һ�������飬׼��װ��¼
				$arr = array();
				$res = $this->_mySQLi->query($sql);
				while($row = $res->fetch_assoc()){
					$arr[] = $row;
				}
				//�����ͷ� $res;
				$res->free();
				return $arr;
			}
			
			//�����ṩһ��dml�����ķ������ӿڣ�����ɣ�dml������
			public function query($sql = ''){
				
				$res = $this->_mySQLi->query($sql);
				if(!$res){
					echo '<br />ִ��sql���ʧ��';
					echo '������Ϣ'.$this->_mySQLi->error;
					exit;
				}
				return $res;
			}	
		

	}





?>
<?php
/*
Plugin Name: 评论推送
Version: Beta
Plugin URL: http://blog.qiyuuu.com
Description: 将评论推送到手机上。
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');
include dirname(__FILE__) . '/class/QiyuPluginBase.php';
class CommentPush extends QiyuPluginBase {
	const NAME = '评论推送';
	const BASE_API_URL = 'https://api.pushbullet.com/v2/';
	//钩子
	protected $_hooks = array(
		'comment_saved'=>array(
			'method'=>'hookCommentSaved',
		),
		'adm_sidebar_ext'=>array(
			'method'=>'hookAdminSidebar',
		),
	);
	//实例
	private static $_instance;

	public function hookAdminSidebar() {
		printf('<div class="sidebarsubmenu" id="%s"><a href="./plugin.php?plugin=%s">%s</a></div>', $this->_id, $this->_id, self::NAME);
	}

	public function hookCommentSaved() {
		$gid = $this->arrayGet($_POST, 'gid', -1);
		$comname = $this->arrayGet($_POST, 'comname', '');
		$comment = $this->arrayGet($_POST, 'comment', '');

		$Log_Model = new Log_Model();
		$logData = $Log_Model->getOneLogForHome($gid);
		$title = $logData['log_title'];
		if (ROLE !== ROLE_ADMIN) {
			$this->pushNotifaction($title, $comname, $comment);
		}
	}

	public function pushNotifaction($title, $name, $comment) {
		$title = "《${title}》收到了来自${name}的评论";
		$body = $comment;
		$option = $this->query('options', array(
			'option_name'=>$this->getId() . '_key',
		));
		if ($option === false) {
			return;
		}
		$key = $option['option_value'];
		$devices = $this->queryAll($this->getPluginTable('device'), 'push=1');
		$this->push($devices, $key, $title, $body);
	}

	public function push($devices, $key, $title, $body) {
		$success = $fail = 0;
		foreach ($devices as $device) {
			$result = $this->postUrl(self::BASE_API_URL . 'pushes', array(
				'type'=>'note',
				'device_iden'=>$device['iden'], 
				'title'=>$title,
				'body'=>$body,
			), array(
				'HTTPHEADER'=>array(
					'Authorization: Basic ' . base64_encode($key . ':'),
				),
			));
			if ($result === false) {
				$fail++;
				continue;
			}
			$result = json_decode($result, true);
			if (isset($result['error'])) {
				$fail++;
			} else {
				$success++;
			}
		}
		return compact('success', 'fail');
	}

	public function getDevices($key) {
		$result = $this->getUrl(self::BASE_API_URL . 'devices', array(), array(
			'HTTPHEADER'=>array(
				'Authorization: Basic ' . base64_encode($key . ':'),
			),
		));
		if ($result === false) {
			return array();
		}
		$result = json_decode($result, true);
		if (isset($result['error']) || !isset($result['devices'])) {
			return array();
		}
		$devices = array();
		foreach ($result['devices'] as $device) {
			$devices[$device['iden']] = $device;
		}
		return $devices;
	}

	/**
	 * 初始化
	 */
	public function init() {
		parent::init();
	}

	/**
	 * 插件设置
	 */
	public function setting() {
		$option = $this->query('options', array(
			'option_name'=>$this->getId() . '_key',
		));
		if ($option === false) {
			$key = '';
		} else {
			$key = $option['option_value'];
		}
		$devices = $this->queryAll($this->getPluginTable('device'));
		if (isset($_POST['action'])) {
			switch (trim($_POST['action'])) {
				case 'save_key':
					$key = isset($_POST['key']) ? trim($_POST['key']) : '';
					if (empty($key)) {
						$this->jsonReturn(array(
							'code'=>-1,
							'msg'=>'空的API Key',
						));
					}
					if ($option === false) {
						$otion = array(
							'option_name'=>$this->getId() . '_key',
							'option_value'=>$key,
						);
						$replace = false;
					} else {
						$option['option_value'] = $key;
						$replace = true;
					}
					$result = $this->insert('options', $option, $replace);
					$this->jsonReturn(array(
						'code'=>$result ? 0 : -1,
						'msg'=>$result ? '保存API Key成功' : '保存API Key失败',
					));
					break;

				case 'refresh_devices':
					$remoteDevices = $this->getDevices($key);
					$oldDevices = array();
					foreach ($devices as $device) {
						unset($device['id']);
						$oldDevices[$device['iden']] = $device;
					}
					foreach ($remoteDevices as $iden=>$device) {
						if (isset($oldDevices[$iden])) {
							$remoteDevices[$iden] = $oldDevices[$iden];
						} else {
							$remoteDevices[$iden] = array(
								'name'=>$device['model'],
								'iden'=>$iden,
								'push'=>0,
							);
						}
					}
					$remoteDevices = array_values($remoteDevices);
					$this->delete($this->getPluginTable('device'));
					$result = false;
					if (!empty($remoteDevices)) {
						$result = $this->insert($this->getPluginTable('device'), $remoteDevices);
					}
					$this->jsonReturn(array(
						'code'=>$result ? 0 : -1,
						'msg'=>$result ? '刷新成功' : '刷新失败',
						'devices'=>$remoteDevices,
					));
					break;

				case 'toggle_device':
					$enable = isset($_POST['enable']) ? trim($_POST['enable']) : true;
					$iden = isset($_POST['iden']) ? trim($_POST['iden']) : '';
					$device = $this->query($this->getPluginTable('device'), array(
						'iden'=>$iden,
					));
					if ($device === false) {
						$this->jsonReturn(array(
							'code'=>-1,
							'msg'=>'数据异常',
						));
					}
					if ($enable === 'false') {
						$enable = false;
					} else {
						$enable = true;
					}
					$result = $this->update($this->getPluginTable('device'), array(
						'push'=>$enable ? 1 : 0,
					), array(
						'iden'=>$iden,
					));
					$this->jsonReturn(array(
						'code'=>$result ? 0 : -1,
						'msg'=>$result ? '更新成功' : '更新失败',
					));
					break;
				case 'test_push':
					$title = isset($_POST['title']) ? trim($_POST['title']) : '';
					$content = isset($_POST['content']) ? trim($_POST['content']) : '';
					$devices = $this->queryAll($this->getPluginTable('device'), 'push=1');
					$result = $this->push($devices, $key, $title, $content);
					$this->jsonReturn(array(
						'code'=>$result['success'] > 0 ? 0 : -1,
						'msg'=>$result['success'] > 0 ? '推送成功' : '推送失败',
					));
					break;
			}
		}
		$this->view('index', array(
			'key'=>$key,
			'devices'=>$devices,
		));
	}

	/**
	 * 单例入口
	 * @return TplOptions
	 */
	public static function getInstance() {
		if (self::$_instance === null) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * 私有构造函数，保证单例
	 */
	private function __construct() {
	}
}
CommentPush::getInstance()->init();
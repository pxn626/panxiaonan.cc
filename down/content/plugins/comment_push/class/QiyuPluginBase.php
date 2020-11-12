<?php
!defined('EMLOG_ROOT') && exit('access deined!');

/**
 * 奇遇插件基础类，用以处理插件的基本操作，如数据库等
 * @author 奇遇
 * @version 1.0
 */
if (!class_exists('QiyuPluginBase', false)) {
	class QiyuPluginBase {
		//数据库连接实例
		private $_db;
		//id
		protected $_id;
		//插件模板目录
		protected $_viewPath;
		//插件前端资源路径
		protected $_assetsUrl;
		//插件钩子
		protected $_hooks = array();

		/**
		 * 初始化
		 */
		public function init() {
			//设置模板目录
			$dir = dirname(dirname(__FILE__));
			$this->_id = basename($dir);
			$this->_viewPath = $dir . '/views/';
			$this->_assetsUrl = BLOG_URL . 'content/plugins/' . $this->_id . '/assets/';
			//注册各个钩子
			$scriptBaseName = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
			foreach ($this->_hooks as $hook=>$data) {
				if ((!isset($data['script']) || $data['script'] === $scriptBaseName)
					&& is_callable(array($this, $data['method']))
				) {
					addAction($hook, array(
						$this,
						$data['method'],
					));
				}
			}
		}

		/**
		 * 插件设置
		 */
		public function setting() {

		}

		/**
		 * 获取ID
		 */
		public function getId() {
			return $this->_id;
		}
		/**
		 * 发起一个GET请求
		 * @param string $url
		 * @param mixed $vars
		 * @param array $options
		 * @return mixed
		**/
		public function getUrl($url, $vars = array(), $options = array()) {
			if (!empty($vars)) {
				$url .= (stripos($url, '?') !== false) ? '&' : '?';
				$url .= (is_string($vars)) ? $vars : http_build_query($vars, '', '&');
			}
			return $this->curl('GET', $url, array(), $options);
		}

		/**
		 * 发起一个POST请求
		 * @param string $url
		 * @param mixed $vars
		 * @param array $options
		 * @param mixed $enctype
		 * @return mixed
		**/
		public function postUrl($url, $vars = array(), $options = array(), $enctype = null) {
			return $this->curl('POST', $url, $vars, $options, $enctype);
		}

		/**
		 * 发起一个curl请求
		 * @param string $method
		 * @param string $url
		 * @param mixed $vars
		 * @param array $options
		 * @param mixed $enctype
		 * @return mixed
		**/
		public function curl($method, $url, $vars = array(), $options = array(), $enctype = null) {
			$ch = curl_init();
			if (is_array($vars) && $enctype != 'multipart/form-data') {
				$vars = http_build_query($vars, '', '&');
			}
			//设置请求方法
			switch (strtoupper($method)) {
				case 'HEAD':
					curl_setopt($ch, CURLOPT_NOBODY, true);
					break;
				case 'GET':
					curl_setopt($ch, CURLOPT_HTTPGET, true);
					break;
				case 'POST':
					curl_setopt($ch, CURLOPT_POST, true);
					break;
				default:
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			}
			//url
			curl_setopt($ch, CURLOPT_URL, $url);
			//post请求的参数
			if (!empty($vars)) {
				curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
			}
			//设置一些参数
			//curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'QiyuPluginBase/1.0 curl');
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			
			//设置自定义参数
			foreach ($options as $option => $value) {
				curl_setopt($ch, constant('CURLOPT_' . str_replace('CURLOPT_', '', strtoupper($option))), $value);
			}

			$response = curl_exec($ch);
			if (!$response) {
				return false;
			}
			curl_close($ch);
			return $response;
		}

		/**
		 * 渲染模板
		 * @param string $_view_ 模板名字
		 * @param array $_data_ 模板变量
		 * @param string $_ext_ 模板后缀，默认为.php
		 * @return mixed
		 */
		protected function view($_view_, $_data_ = array(), $_ext_ = '.php') {
			extract($_data_);
			return include $this->_viewPath . $_view_ . $_ext_;
		}

		/**
		 * 输出前端资源
		 * @param string $file 资源文件
		 * @param array $type 资源类型
		 * @return void
		 */
		protected function assets($file, $type = 'css') {
			switch ($type) {
				case 'css':
					printf('<link rel="stylesheet" href="%s%s.css" />', $this->_assetsUrl, $file);
					break;
				case 'js':
					printf('<script src="%s%s.js"></script>', $this->_assetsUrl, $file);
					break;
			}
		}

		/**
		 * 获取数据库连接
		 * @return MySql 数据库连接实例
		 */
		public function getDb() {
			if ($this->_db !== null) {
				return $this->_db;
			}
			if (class_exists('Database', false)) {
				$this->_db = Database::getInstance();
			} else {
				$this->_db = MySql::getInstance();
			}
			return $this->_db;
		}

		/**
		 * 给数据表加前缀
		 * @param string $table
		 * @return string
		 */
		public function getTable($table) {
			if (strpos($table, DB_PREFIX) !== 0) {
				$table = DB_PREFIX . $table;
			}
			return $table;
		}

		/**
		 * 给插件数据表加前缀
		 * @param string $table
		 * @return string
		 */
		public function getPluginTable($table) {
			return $this->getTable(strtolower($this->_id) . '_' . $table);
		}

		/**
		 * 从表中查询出所有数据
		 * @param string $table 表名缩写
		 * @param mixed $condition 字符串或数组条件
		 * @return array 结果数据
		 */
		public function queryAll($table, $condition = '') {
			$table = $this->getTable($table);
			$condition = $this->handleCondition($condition);
			extract($condition);
			$where = $this->buildQuerySql($condition);
			$sql = "SELECT $select FROM `$table`";
			if ($where) {
				$sql .= " WHERE $where";
			}
			if (isset($group)) {
				$sql .= " GROUP BY $group";
			}
			if (isset($having)) {
				$sql .= "HAVING $having";
			}
			if (isset($order)) {
				$sql .= " ORDER BY $order";
			}
			if (isset($limit)) {
				$sql .= " LIMIT $limit";
				if (isset($offset)) {
					$sql .= " OFFSET $offset";
				}
			}
			$query = $this->getDb()->query($sql);
			$data = array();
			while ($row = $this->getDb()->fetch_array($query)) {
				$data[] = $row;
			}
			return $data;
		}

		/**
		 * 从表中查询出一条数据
		 * @param string $table 表名缩写
		 * @param mixed $condition 字符串或数组条件
		 * @return mixed 结果数据
		 */
		public function query($table, $condition = '') {
			$condition = array(
				'condition' => $condition,
			);
			$condition['limit'] = 1;
			$data = $this->queryAll($table, $condition);
			return current($data);
		}

		/**
		 * 将数据插入数据表
		 * @param string $table 表名缩写
		 * @param array $data 数据
		 * @return boolean 插入结果
		 */
		public function insert($table, $data, $replace = false) {
			$table = $this->getTable($table);
			$subSql = $this->buildInsertSql($data);
			if ($replace) {
				$sql = "REPLACE INTO `$table`";
			} else {
				$sql = "INSERT INTO `$table`";
			}
			$sql .= $subSql;
			return $this->getDb()->query($sql) !== false;
		}

		/**
		 * 从表中更新数据
		 * @param string $table 表名缩写
		 * @param array $data 数据
		 * @param mixed $condition 字符串或数组条件
		 * @return boolean 更新结果
		 */
		public function update($table, $data, $condition = '') {
			if (empty($data)) {
				return false;
			}
			$table = $this->getTable($table);
			$condition = array(
				'condition' => $condition,
			);
			$condition = $this->handleCondition($condition);
			extract($condition);
			$where = $this->buildQuerySql($condition);
			$sql = "UPDATE `$table` SET ";
			$subSql = array();
			foreach ($data as $key=>$value) {
				$subSql[] = "`$key`='" . $this->escape($value) . "'";
			}
			$subSql = implode(',', $subSql);
			$sql .= $subSql;
			if ($where) {
				$sql .= " WHERE $where";
			}
			return $this->getDb()->query($sql) !== false;
		}

		/**
		 * 从表中删除数据
		 * @param string $table 表名缩写
		 * @param mixed $condition 字符串或数组条件
		 * @return boolean 删除结果
		 */
		public function delete($table, $condition = '') {
			$table = $this->getTable($table);
			$condition = $this->handleCondition($condition);
			extract($condition);
			$where = $this->buildQuerySql($condition);
			$sql = "DELETE FROM `$table`";
			if ($where) {
				$sql .= " WHERE $where";
			}
			return $this->getDb()->query($sql) !== false;
		}

		/**
		 * 处理数据库查询条件
		 * @param mixed $condition 字符串或数组条件
		 * @return array
		 */
		private function handleCondition($condition) {
			if (!is_array($condition)) {
				$condition = array(
					'condition' => $condition,
				);
			}
			if (!isset($condition['select'])) {
				$condition['select'] = '*';
			}
			return $condition;
		}

		/**
		 * 根据条件构造WHERE子句
		 * @param mixed $condition 字符串或数组条件
		 * @return string 根据条件构造的查询子句
		 */
		private function buildQuerySql($condition) {
			if (is_string($condition)) {
				return $condition;
			}
			$subSql = array();
			foreach ($condition as $key => $value) {
				if (is_string($value)) {
					$value = $this->escape($value);
					$subSql[] = "(`$key`='$value')";
				} elseif (is_array($value)) {
					$subSql[] = "(`$key` IN (" . $this->implodeSqlArray($value) . '))';
				}
			}
			return implode(' AND ', $subSql);
		}

		/**
		 * 根据数据构造INSERT/REPLACE INTO子句
		 * @param array $data 数据
		 * @return string 根据数据构造的子句
		 */
		private function buildInsertSql($data) {
			$subSql = array();
			if (array_key_exists(0, $data)) {
				$keys = array_keys($data[0]);
			} else {
				$keys = array_keys($data);
				$data = array(
					$data
				);
			}
			foreach ($data as $key => $value) {
				$subSql[] = '(' . $this->implodeSqlArray($value) . ')';
			}
			$subSql = implode(',', $subSql);
			$keys = '(`' . implode('`,`', $keys) . '`)';
			$subSql = "$keys VALUES $subSql";
			return $subSql;
		}

		/**
		 * 将数组展开为可以供SQL使用的字符串
		 * @param array $data 数据
		 * @return string 形如('value1', 'value2')的字符串
		 */
		private function implodeSqlArray($data) {
			$data = array_map(array(
				$this,
				'escape'
			), $data);
			return "'" . implode("','", $data) . "'";
		}

		/**
		 * escape字符串
		 * @param string $string
		 * @return string
		 */
		private function escape($string) {
			return @mysql_escape_string($string);
		}

		/**
		 * 以json输出数据并结束
		 * @param mixed $data
		 * @return void
		 */
		public function jsonReturn($data) {
			ob_clean();
			echo json_encode($data);
			exit;
		}

		/**
		 * 从数组里取出数据，支持key.subKey的方式
		 * @param array $array
		 * @param string $key
		 * @param mixed $default 默认值
		 * @return mixed
		 */
		public function arrayGet($array, $key, $default = null) {
			if (array_key_exists($key, $array)) {
				return $array[$key];
			}
			foreach (explode('.', $key) as $segment) {
				if (!is_array($array) || !array_key_exists($segment, $array)) {
					return $default;
				}
				$array = $array[$segment];
			}
			return $array;
		}
	}
}

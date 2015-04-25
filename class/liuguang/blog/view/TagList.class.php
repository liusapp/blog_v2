<?php

namespace liuguang\blog\view;

use liuguang\mvc\Application;

/**
 * 某个tag下的文章列表
 *
 * @author liuguang
 *        
 */
class TagList implements TopicListInter {
	private $db;
	private $tablePre;
	private $t_id;
	public function __construct(\PDO $db, $tablePre,$t_id) {
		$this->db = $db;
		$this->tablePre = $tablePre;
		$this->t_id=$t_id;
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \liuguang\blog\view\TopicListInter::getTopicCount()
	 *
	 */
	public function getTopicCount() {
		$stm = $this->db->query ( 'SELECT COUNT(*) AS topic_num FROM ' . $this->tablePre . 'topic_tag WHERE tag_id='.$this->t_id );
		$rst = $stm->fetch ();
		return $rst ['topic_num'];
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \liuguang\blog\view\TopicListInter::getUrlTpl()
	 *
	 */
	public function getUrlTpl() {
		$app = Application::getApp ();
		$urlHandler = $app->getUrlHandler ();
		return $urlHandler->createUrl ( 'web/Tag', 'index', array (
				't_id'=>$this->t_id,
				'page' => '--page--' 
		) );
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \liuguang\blog\view\TopicListInter::getTablePre()
	 *
	 */
	public function getTablePre() {
		return $this->tablePre;
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \liuguang\blog\view\TopicListInter::getPerPage()
	 *
	 */
	public function getPerPage() {
		return 12;
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \liuguang\blog\view\TopicListInter::getSelectSql()
	 *
	 */
	public function getSelectSql($page) {
		$limit = $this->getPerPage ();
		$limit0=($page - 1) * $limit;
		//当前使用的MySQL版本，不支持在in内使用limit，只好嵌套一层
		$sql='SELECT t_id,t_title,t_prev_text,post_time FROM ' . $this->tablePre . 'topic WHERE t_id IN(SELECT t1.topic_id FROM (SELECT topic_id FROM ' . $this->tablePre . 'topic_tag WHERE tag_id='.$this->t_id.' ORDER BY topic_id DESC LIMIT '.$limit0.', '.$limit.') AS t1) ORDER BY t_id DESC';
		return $sql;
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \liuguang\blog\view\TopicListInter::getStr()
	 *
	 */
	public function getStr($page) {
		$stm=$this->db->query('SELECT t_name FROM ' . $this->tablePre . 'tag WHERE t_id='.$this->t_id);
		$rst=$stm->fetch();
		$str.=($rst['t_name'].'-第'.$page.'页');
		return $str;
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \liuguang\blog\view\TopicListInter::getDb()
	 *
	 */
	public function getDb() {
		return $this->db;
	}
}
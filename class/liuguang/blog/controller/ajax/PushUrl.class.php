<?php

namespace liuguang\blog\controller\ajax;

use liuguang\mvc\DataMap;
use liuguang\mvc\Application;
use liuguang\blog\view\BlogIndex;
use liuguang\blog\view\BlogList;
use liuguang\blog\view\TypesArchs;
use liuguang\blog\view\AdminSets;
use liuguang\blog\view\PostTopic;
use liuguang\blog\view\AdminTags;
use liuguang\blog\view\AdminFiles;
use liuguang\blog\view\AdminEnv;
use liuguang\blog\view\BlogAbout;
use liuguang\blog\view\TopicPage;
use liuguang\blog\view\Liuyan;
use liuguang\blog\view\TopicList;
use liuguang\blog\view\TocType;
use liuguang\blog\view\TocArch;
use liuguang\blog\view\TagList;
use liuguang\blog\view\EditTopic;
use liuguang\blog\model\User;
use liuguang\blog\controller\BaseController;
use liuguang\blog\view\AdminLinks;

/**
 * 处理pushState提交过来的URL
 *
 * @author liuguang
 *        
 */
class PushUrl extends BaseController {
	public function indexAction() {
		$postData = new DataMap ( $_POST );
		$app = Application::getApp ();
		$appConfig = $app->getAppConfig ();
		$cKey = $appConfig->get ( 'cKey' );
		$aKey = $appConfig->get ( 'aKey' );
		$defaultC = $appConfig->get ( 'defaultC' );
		$defaultA = $appConfig->get ( 'defaultA' );
		$urlHandler = $app->getUrlHandler ();
		$urlData = $urlHandler->parseUrl ( $postData->get ( 'url', '/' ) );
		$cname = $urlData->get ( $cKey, $defaultC );
		$aname = $urlData->get ( $aKey, $defaultA );
		$url_key = $cname . '/' . $aname;
		header ( 'Content-Type: application/json' );
		$db = $this->getDb ();
		$tablePre = $this->getTablePre ();
		$result = array ();
		$admin_str = 'web/BlogAdmin/';
		$admin_str_length = strlen ( $admin_str );
		if (strlen ( $url_key ) > $admin_str_length) {
			$user = new User ();
			$isAdmin = $user->checkAdmin ( $db, $tablePre );
			if ((substr ( $url_key, 0, $admin_str_length ) == $admin_str) && (! $isAdmin)) {
				// 需要验证权限
				$result ['title'] = '无权访问';
				$result ['blog_center'] = '<div class="alert alert-danger" role="alert">只有博主有权限访问当前页面</div>';
				echo json_encode ( $result );
				return;
			}
		}
		switch ($url_key) {
			case 'Index/index' :
				$vModel = new BlogIndex ( $db, $tablePre );
				$result ['nIndex'] = 0;
				$result ['title'] = $vModel->getTitle ();
				$result ['blog_center'] = $vModel->getHtml ();
				break;
			case 'web/BlogList/index' :
				$vModel0 = new BlogList ( $db, $tablePre );
				$vModel = new TopicList ( $vModel0 );
				$page = ( int ) $urlData->get ( 'page', 1 );
				$result ['nIndex'] = 1;
				$result ['title'] = $vModel->getTitle ( $page );
				$result ['blog_center'] = $vModel->getHtml ( $page );
				break;
			case 'web/TocType/index' :
				$t_id = ( int ) $urlData->get ( 't_id', 1 );
				$vModel0 = new TocType ( $db, $tablePre, $t_id );
				$vModel = new TopicList ( $vModel0 );
				$page = ( int ) $urlData->get ( 'page', 1 );
				$result ['nIndex'] = 2;
				$result ['title'] = $vModel->getTitle ( $page );
				$result ['blog_center'] = $vModel->getHtml ( $page );
				break;
			case 'web/Tag/index' :
				$t_id = ( int ) $urlData->get ( 't_id', 1 );
				$vModel0 = new TagList ( $db, $tablePre, $t_id );
				$vModel = new TopicList ( $vModel0 );
				$page = ( int ) $urlData->get ( 'page', 1 );
				$result ['nIndex'] = 2;
				$result ['title'] = $vModel->getTitle ( $page );
				$result ['blog_center'] = $vModel->getHtml ( $page );
				break;
			case 'web/TocArch/index' :
				$t_id = ( int ) $urlData->get ( 't_id', '19700101' );
				if (! preg_match ( '/^\d{6}$/', $t_id ))
					$t_id = 19700101;
				$vModel0 = new TocArch ( $db, $tablePre, $t_id );
				$vModel = new TopicList ( $vModel0 );
				$page = ( int ) $urlData->get ( 'page', 1 );
				$result ['nIndex'] = 3;
				$result ['title'] = $vModel->getTitle ( $page );
				$result ['blog_center'] = $vModel->getHtml ( $page );
				break;
			case 'web/BlogTypes/index' :
				$vModel = new TypesArchs ( $db, $tablePre, true );
				$page = ( int ) $urlData->get ( 'page', 1 );
				$result ['nIndex'] = 2;
				$result ['title'] = $vModel->getTitle ( $page );
				$result ['blog_center'] = $vModel->getHtml ( $page );
				break;
			case 'web/BlogArchs/index' :
				$vModel = new TypesArchs ( $db, $tablePre, false );
				$page = ( int ) $urlData->get ( 'page', 1 );
				$result ['nIndex'] = 3;
				$result ['title'] = $vModel->getTitle ( $page );
				$result ['blog_center'] = $vModel->getHtml ( $page );
				break;
			case 'web/BlogAdmin/sets' :
				$vModel = new AdminSets ( $db, $tablePre );
				$result ['nIndex'] = 0;
				$result ['title'] = $vModel->getTitle ();
				$result ['blog_center'] = $vModel->getHtml ();
				break;
			case 'web/BlogAdmin/postTopic' :
				$vModel = new PostTopic ( $db, $tablePre );
				$result ['nIndex'] = 0;
				$result ['title'] = $vModel->getTitle ();
				$result ['blog_center'] = $vModel->getHtml ();
				break;
			case 'web/BlogAdmin/editTopic' :
				$t_id = ( int ) $urlData->get ( 't_id', 1 );
				$vModel = new EditTopic ( $db, $tablePre, $t_id );
				$result ['nIndex'] = 0;
				$result ['title'] = $vModel->getTitle ();
				$result ['blog_center'] = $vModel->getHtml ();
				break;
			case 'web/BlogAdmin/types' :
				$vModel = new AdminTags ( $db, $tablePre, false );
				$result ['nIndex'] = 0;
				$result ['title'] = $vModel->getTitle ();
				$result ['blog_center'] = $vModel->getHtml ();
				break;
			case 'web/BlogAdmin/tags' :
				$vModel = new AdminTags ( $db, $tablePre, true );
				$result ['nIndex'] = 0;
				$result ['title'] = $vModel->getTitle ();
				$result ['blog_center'] = $vModel->getHtml ();
				break;
			case 'web/BlogAdmin/files' :
				$vModel = new AdminFiles ( $db, $tablePre, $this->getFs () );
				$page = ( int ) $urlData->get ( 'page', 1 );
				$result ['nIndex'] = 0;
				$result ['title'] = $vModel->getTitle ( $page );
				$result ['blog_center'] = $vModel->getHtml ( $page );
				break;
			case 'web/BlogAdmin/links' :
				$vModel = new AdminLinks ( $db, $tablePre );
				$page = ( int ) $urlData->get ( 'page', 1 );
				$result ['nIndex'] = 0;
				$result ['title'] = $vModel->getTitle ( $page );
				$result ['blog_center'] = $vModel->getHtml ( $page );
				break;
			case 'web/BlogAdmin/env' :
				$vModel = new AdminEnv ( $db, $tablePre, $this->getFs () );
				$result ['nIndex'] = 0;
				$result ['title'] = $vModel->getTitle ();
				$result ['blog_center'] = $vModel->getHtml ();
				break;
			case 'web/BlogAbout/index' :
				$result ['nIndex'] = 5;
				$vModel = new BlogAbout ( $db, $tablePre );
				$result ['title'] = $vModel->getTitle ();
				$result ['blog_center'] = $vModel->getHtml ();
				break;
			case 'web/Topic/index' :
				$t_id = ( int ) $urlData->get ( 't_id', 0 );
				$vModel = new TopicPage ( $db, $tablePre, $t_id );
				$result ['nIndex'] = 1;
				$result ['blog_center'] = $vModel->getHtml ();
				$result ['title'] = $vModel->getTitle ();
				break;
			case 'web/BlogLiuyan/index' :
				$page = ( int ) $urlData->get ( 'page', 0 );
				$vModel = new Liuyan ( $db, $tablePre );
				$result ['nIndex'] = 4;
				$result ['blog_center'] = $vModel->getHtml ( $page );
				$result ['title'] = $vModel->getTitle ( $page );
				break;
			default :
				$result ['nIndex'] = 0;
				$result ['title'] = '未知页面';
				$result ['blog_center'] = '当前页面还不支持pushState';
		}
		echo json_encode ( $result );
	}
}
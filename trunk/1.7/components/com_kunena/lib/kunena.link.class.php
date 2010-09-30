<?php
/**
 * @version $Id$
 * Kunena Component
 * @package Kunena
 *
 * @Copyright (C) 2008 - 2010 Kunena Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.com
 *
 * Based on FireBoard Component
 * @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.bestofjoomla.com
 **/

// Dont allow direct linking
defined ( '_JEXEC' ) or die ();
kimport ('route');

class CKunenaLink {
	//
	// Basic universal href link
	//
	function GetHrefLink($link, $name, $title = '', $rel = 'nofollow', $class = '', $anker = '', $attr = '') {
		return '<a ' . ($class ? 'class="' . $class . '" ' : '') . 'href="' . $link . ($anker ? ('#' . $anker) : '') . '" title="' . $title . '"' . ($rel ? ' rel="' . $rel . '"' : '') . ($attr ? ' ' . $attr : '') . '>' . $name . '</a>';
	}

	//
	// Basic universal href link
	//
	function GetSefHrefLink($link, $name, $title = '', $rel = 'nofollow', $class = '', $anker = '', $attr = '') {
		return '<a ' . ($class ? 'class="' . $class . '" ' : '') . 'href="' . KunenaRoute::_ ( $link ) . ($anker ? ('#' . $anker) : '') . '" title="' . $title . '"' . ($rel ? ' rel="' . $rel . '"' : '') . ($attr ? ' ' . $attr : '') . '>' . $name . '</a>';
	}

	// Simple link is a barebones href link used for e.g. Jscript links
	function GetSimpleLink($id, $name = '', $class = '', $attr = '') {
		return '<a ' . ($class ? 'class="' . $class . '" ' : '') . ' href="' . $id . '" ' . ($attr ? ' ' . $attr : '') . '>' . $name . '</a>';
	}

	//
	// Central Consolidation of all internal href links
	//


	function GetCreditsLink() {
		return self::GetHrefLink ( 'http://www.kunena.com', 'Kunena', 'Kunena', 'follow', NULL, NULL, 'target="_blank"' );
	}

	function GetTeamCreditsLink($catid, $name = '') {
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view=credits&catid={$catid}", $name, '', 'follow' );
	}

	function GetKunenaLink($name, $rel = 'follow') {
		return self::GetSefHrefLink ( self::GetKunenaURL(), $name, '', $rel );
	}

	function GetKunenaURL($xhtml = true) {
		return KunenaRoute::_ ( 'index.php?option=com_kunena', $xhtml );
	}

	function GetAttachmentLink($folder,$filename,$name,$title = '', $rel = 'nofollow') {
		return self::GetHrefLink ( JURI::ROOT()."{$folder}/{$filename}", $name, $title, $rel );
	}

	function GetRSSLink($name, $rel = 'follow', $params = '') {
		return self::GetSefHrefLink ( self::GetRSSURL($params), $name, '', $rel, '', '', 'target="_blank"' );
	}

	function GetRSSURL($params = '', $xhtml = true) {
		return KunenaRoute::_ ( "index.php?option=com_kunena&view=rss{$params}", $xhtml );
	}

	function GetCategoryLink($view, $catid, $catname, $rel = 'follow', $class = '', $title = '') {
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view={$view}&catid={$catid}", $catname, $title, $rel, $class );
	}

	function GetCategoryActionLink($view, $catid, $catname, $rel = 'follow', $class = '', $title = '', $extra = '') {
		$token = '&' . JUtility::getToken() . '=1';
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view={$view}&catid={$catid}{$extra}{$token}", $catname, $title, $rel, $class );
	}

	function GetCategoryURL($view, $catid = '', $xhtml = true) {
		if ($catid != '')
			$catid = "&catid={$catid}";
		return KunenaRoute::_ ( "index.php?option=com_kunena&view={$view}{$catid}", $xhtml );
	}

	function GetCategoryPageLink($view, $catid, $page, $pagename, $rel = 'follow', $class = '') {
		if ($page == 1 || ! is_numeric ( $page )) {
			// page 1 is identical to a link to the regular category link
			$pagelink = self::GetCategoryLink ( $view, $catid, $pagename, $rel, $class );
		} else {
			$pagelink = self::GetSefHrefLink ( "index.php?option=com_kunena&view={$view}&catid={$catid}&page={$page}", $pagename, '', $rel, $class );
		}
		return $pagelink;
	}

	function GetReviewLink($name, $rel = 'nofollow', $class = '') {
		return self::GetSefHrefLink ( 'index.php?option=com_kunena&view=review', $name, '', $rel, $class );
	}

	function GetReviewURL($xhtml = true) {
		return KunenaRoute::_ ( 'index.php?option=com_kunena&view=review', $xhtml );
	}

	function GetCategoryReviewListLink($catid, $catname, $rel = 'nofollow', $class = '') {
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view=review&action=list&catid={$catid}", $catname, '', $rel, $class );
	}

	function GetThreadLink($view, $catid, $id, $threadname, $title, $rel = 'follow', $class = '') {
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view={$view}&catid={$catid}&id={$id}", $threadname, $title, $rel, $class );
	}

	function GetThreadPageLink($view, $catid, $id, $page, $limit, $name, $anker = '', $rel = 'follow', $class = '') {
		return self::GetSefHrefLink ( self::GetThreadPageURL($view, $catid, $id, $page, $limit), $name, '', $rel, $class, $anker );
	}

	function GetThreadPageURL($view, $catid, $id, $page, $limit = '', $anker = '', $xhtml = true) {
		$limitstart = (($page - 1) * $limit);
		if ($page == 1 || ! is_numeric ( $page ) || ! is_numeric ( $limit )) {
			// page 1 is identical to a link to the top of the thread
			$pageURL = "index.php?option=com_kunena&view={$view}&catid={$catid}&id={$id}";
		} else {
			$pageURL = "index.php?option=com_kunena&view={$view}&catid={$catid}&id={$id}&limitstart={$limitstart}&limit={$limit}";
		}
		return KunenaRoute::_ ( $pageURL, $xhtml ) . ($anker ? ('#' . $anker) : '');
	}

	function GetSamePageAnkerLink($anker, $name, $rel = 'nofollow', $class = '') {
		jimport ( 'joomla.environment.request' );
		return self::GetHrefLink ( htmlspecialchars(JRequest::getURI (), ENT_COMPAT, 'UTF-8'), $name, '', $rel, $class, $anker );
	}

	function GetReportURL($xhtml = true) {
		return KunenaRoute::_ ( 'index.php?option=com_kunena&view=report', $xhtml );
	}

	function GetReportMessageLink($catid, $id, $name, $rel = 'nofollow') {
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view=report&catid={$catid}&id={$id}", $name, '', $rel );
	}

	function GetMessageIPLink($msg_ip, $rel = 'nofollow') {
		if (! empty ( $msg_ip )) {
			$iplink = '<a href="http://whois.domaintools.com/' . $msg_ip . '" target="_blank">';
			$iplink .= 'IP: ' . $msg_ip . '</a>';
		} else {
			$iplink = '&nbsp;';
		}

		return $iplink;
	}

	// Returns always link to Kunena profile
	function GetMyProfileLink($userid, $name = null, $rel = 'nofollow', $task = '') {
		if (!$name) {
			$profile = KunenaFactory::getUser($userid);
			$name = htmlspecialchars($profile->getName(), ENT_COMPAT, 'UTF-8');
		}
		return self::GetHrefLink ( self::GetMyProfileURL ( $userid, $task ), $name, '', $rel );
	}

	// Returns always url to Kunena profile
	function GetMyProfileURL($userid = 0, $task = '', $xhtml = true, $extra = '') {
		if (!$task) {
			// Workaround for menu redirect: be more verbose
			kimport('integration.integration');
			$profileIntegration = KunenaIntegration::detectIntegration('profile', true);
			if ($profileIntegration != 'kunena') $task='summary';
		}
		$my = JFactory::getUser();
		if ($userid && $userid!=$my->id) $userid = "&userid=$userid";
		else $userid = '';
		if ($task) $task = "&do=$task";
		return KunenaRoute::_ ( "index.php?option=com_kunena&view=profile{$userid}{$task}{$extra}", $xhtml );
	}

	function GetProfileLink($userid, $name = null, $title ='', $rel = 'nofollow', $class = '') {
		$profile = KunenaFactory::getUser($userid);
		If (!$name) {
			$name = htmlspecialchars($profile->getName(), ENT_COMPAT, 'UTF-8');
		}
		if ($userid == 0) {
			$uclass = 'kwho-guest';
		} else if ($profile->isAdmin ()) {
			$uclass = 'kwho-admin';
		} else if ($profile->isModerator ( null )) {
			$uclass = 'kwho-globalmoderator';
		} else if ($profile->isModerator ()) {
			$uclass = 'kwho-moderator';
		} else {
			$uclass = 'kwho-user';
		}
		if ($userid > 0) {
			$link = self::GetProfileURL ( $userid );
			if (! empty ( $link ))
				return self::GetHrefLink ( $link, $name, $title, $rel, $uclass );
		}
		return "<span class=\"{$uclass}\">{$name}</span>";
	}

	function GetProfileURL($userid, $xhtml = true) {
		$profile = KunenaFactory::getProfile ();
		return $profile->getProfileURL ( $userid, '', $xhtml );
	}

	function GetUserlistURL($action = '', $xhtml = true) {
		$profile = KunenaFactory::getProfile ();
		return $profile->getUserListURL ( $action, $xhtml );
	}

	function GetUserlistPostURL($xhtml = true) {
		return KunenaRoute::_ ( 'index.php?option=com_kunena&view=userlist', $xhtml );
	}

	function GetModerateUserLink($userid, $name = null, $title ='', $rel = 'nofollow', $class = '') {
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view=moderateuser&userid={$userid}", $name, $title, $rel, $class );
	}

	function GetUserlistLink($action, $name, $rel = 'nofollow', $class = '') {
		$link = self::GetUserlistURL ( $action );
		if ($link) {
			return self::GetHrefLink ( $link, $name, '', $rel, $class );
		}
		return $name;
	}

	function GetShowLatestLink($name, $do = '', $rel = 'follow') {
		if ($do) $do = "&do=$do";
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view=latest{$do}", $name, '', $rel );
	}

	// Function required to support default template
	function GetLatestPageLink($view, $page, $rel = 'follow', $class = '', $sel = '') {
		$sel = $sel ? '&sel=' . $sel : '';
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view={$view}&page={$page}{$sel}", $page, '', $rel, $class );
	}

	function GetPostURL($catid = '', $xhtml = true) {
		if ($catid != '')
			$catid = "&catid={$catid}";
		return KunenaRoute::_ ( "index.php?option=com_kunena&view=post{$catid}", $xhtml );
	}

	function GetPostNewTopicLink($catid, $name, $rel = 'nofollow', $class = '', $title = '') {
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view=post&do=new&catid={$catid}", $name, $title, $rel, $class );
	}

	// Get actions: favorite, subscribe, delete, approve etc
	function GetTopicPostLink($do, $catid, $id, $name, $rel = 'nofollow', $class = '', $title = '', $attr = '') {
		$token = '&'.JUtility::getToken().'=1';
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view=post&do={$do}&catid={$catid}&id={$id}{$token}", $name, $title, $rel, $class, '', $attr );
	}

	// Post actions: post, edit, moderate etc
	function GetTopicPostReplyLink($do, $catid, $id, $name, $rel = 'nofollow', $class = '', $title = '', $attr = '') {
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view=post&do={$do}&catid={$catid}&id={$id}", $name, $title, $rel, $class, '', $attr );
	}

	function GetKarmaLink($do, $catid, $pid, $userid, $name, $rel = 'nofollow') {
		$token = '&'.JUtility::getToken().'=1';
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view=karma&do={$do}&userid={$userid}&catid={$catid}&pid={$pid}{$token}", $name, '', $rel );
	}

	function GetThankYouLink( $catid, $pid, $targetuserid, $name, $title, $class) {
		$token = '&'.JUtility::getToken().'=1';
		return self::GetSefHrefLink ("index.php?option=com_kunena&view=thankyou&catid={$catid}&pid={$pid}{$token}", $name, $title, 'nofollow', $class);
	}

	function GetSearchLink($view, $searchword, $limitstart, $limit, $name, $params = '', $rel = 'nofollow') {
		return self::GetSefHrefLink ( self::GetSearchURL($view, $searchword, $limitstart, $limit, $params), $name, '', $rel );
	}

	function GetSearchURL($view, $searchword='', $limitstart=0, $limit=0, $params = '') {
		$config = KunenaFactory::getConfig ();
		$limitstr = "";
		if ($limitstart > 0)
			$limitstr .= "&limitstart=$limitstart";
		if ($limit > 0 && $limit != $config->messages_per_page_search)
			$limitstr .= "&limit=$limit";
		if ($searchword)
			$searchword = '&q=' . urlencode ( $searchword );
		return KunenaRoute::_ ( "index.php?option=com_kunena&view={$view}{$searchword}{$params}{$limitstr}" );
	}

	function GetAnnouncementLink($do, $id = NULL, $name, $title, $rel = 'nofollow') {
		$idstring = '';
		if ($id)
			$idstring .= "&id=$id";
		return self::GetSefHrefLink ( self::GetAnnouncementURL($do, $id), $name, $title, $rel );
	}

	function GetAnnouncementURL($do, $id = NULL, $xhtml = true) {
		$idstring = '';
		if ($id)
			$idstring .= "&id=$id";
		return KunenaRoute::_ ( "index.php?option=com_kunena&view=announcement&do={$do}{$idstring}", $xhtml );
	}

	function GetPollURL($do, $id = NULL, $catid) {
		$idstring = '';
		if ($id)
			$idstring .= "&id=$id";
		$catidstr = "&catid=$catid";
		return KunenaRoute::_ ( "index.php?option=com_kunena&view=poll&do={$do}{$catidstr}{$idstring}" );
	}

	function GetPollsURL($do, $catid) {
		$catidstr = "&catid=$catid";
		return KunenaRoute::_ ( "index.php?option=com_kunena&view=polls&do={$do}{$catidstr}" );
	}

	function GetJsonURL($action='', $do = '', $xhtml = false) {
		if ($action) $action = "&action=$action";
		if ($do) $do = "&do=$do";
		return KunenaRoute::_ ( "index.php?option=com_kunena&view=json{$action}{$do}", $xhtml );
	}

	function GetMarkThisReadLink($catid, $name, $rel = 'nofollow', $title = '') {
		return self::GetSefHrefLink ( "index.php?option=com_kunena&view=markThisRead&catid={$catid}", $name, $title, $rel );
	}

	function GetWhoIsOnlineLink($name, $class, $rel = 'follow') {
		return self::GetSefHrefLink ( 'index.php?option=com_kunena&view=who', $name, '', $rel, $class );
	}

	function GetStatsLink($name, $class = '', $rel = 'follow') {
		return self::GetSefHrefLink ( self::GetStatsURL(), $name, '', $rel, $class );
	}

	function GetStatsURL() {
		return KunenaRoute::_ ( 'index.php?option=com_kunena&view=stats' );
	}

	//
	//Some URL functions for the discuss bot
	//
	function GetContentView($id, $Itemid) {
		return JRoute::_ ( "index.php?option=com_content&task=view&id={$id}&Itemid={$Itemid}" );
	}

	function GetLatestPageAutoRedirectURL($pid, $limit = 0, $catid = 0, $xhtml = false) {
		kimport ('error');
		$config = KunenaFactory::getConfig ();
		$myprofile = KunenaFactory::getUser ();
		if ($myprofile->ordering != '0') {
			$topic_ordering = $myprofile->ordering == '1' ? true : false;
		} else {
			$topic_ordering = $config->default_sort == 'asc' ? false : true;
		}
		if (!$limit) $limit = $config->messages_per_page;
		$db = JFactory::getDBO ();
		// First determine the thread, latest post and number of posts for the post supplied
		$where = '';
		if ($catid > 0)
			$where .= " AND a.catid = {$db->Quote($catid)} ";
		$db->setQuery ( "SELECT a.thread AS thread, MAX(a.id) AS latest_id, MAX(a.catid) AS catid, COUNT(*) AS totalmessages
                             FROM #__kunena_messages AS a,
                                (SELECT MAX(thread) AS thread FROM #__kunena_messages WHERE id={$db->Quote($pid)}) AS b
                             WHERE a.thread = b.thread AND a.hold='0' {$where}
                             GROUP BY a.thread" );
		$result = $db->loadObject ();
		if (KunenaError::checkDatabaseError()) return;
		if (! is_object ( $result ))
			return KunenaRoute::_ ( "index.php?option=com_kunena&view=showcat&catid={$catid}" , $xhtml );

		// Now Calculate the number of pages for this particular thread
		if($topic_ordering) $threadPages = 1;
		else $threadPages = ceil ( $result->totalmessages / $limit );

		// Finally build output block
		return self::GetThreadPageURL ( 'view', $result->catid, $result->thread, $threadPages, $limit, $result->latest_id, $xhtml );
	}

	function GetMessageURL($pid, $catid=0, $limit = 0, $xhtml = true) {
		kimport ('error');
		$config = KunenaFactory::getConfig ();
		$myprofile = KunenaFactory::getUser ();
		if ($myprofile->ordering != '0') {
			$topic_ordering = $myprofile->ordering == '1' ? '>=' : '<=';
		} else {
			$topic_ordering = $config->default_sort == 'asc' ? '<=' : '>=';
		}
		$maxmin = $topic_ordering == '<=' ? 'MAX' : 'MIN';
		if ($limit < 1) $limit = $config->messages_per_page;
		$access = KunenaFactory::getAccessControl();
		$hold = $access->getAllowedHold($myprofile, $catid);
		$db = JFactory::getDBO ();
		// First determine the thread, latest post and number of posts for the post supplied
		$db->setQuery ( "SELECT a.thread AS thread, {$maxmin}(a.id) AS latest_id, MAX(a.catid) AS catid, COUNT(*) AS totalmessages
                             FROM #__kunena_messages AS a, (SELECT thread FROM #__kunena_messages WHERE id={$db->Quote($pid)}) AS b
                             WHERE a.thread = b.thread AND a.hold IN ({$hold}) AND a.id {$topic_ordering} {$db->Quote($pid)}
                             GROUP BY a.thread" );
		$result = $db->loadObject ();
		if (KunenaError::checkDatabaseError()) return;
		if (! is_object ( $result ))
			return KunenaRoute::_ ( "index.php?option=com_kunena&view=showcat&catid={$result->catid}", $xhtml );
		return self::GetThreadPageURL ( 'view', $result->catid, $result->thread, ceil ( $result->totalmessages / $limit ), $limit, $result->latest_id, $xhtml );
	}

	function GetAutoRedirectHTML($url, $timeout) {
		$url = htmlspecialchars_decode ( $url );
		$Output = "\n<script type=\"text/javascript\">\n// <![CDATA[\n";
		$Output .= "kunenaRedirectTimeout('$url', $timeout);";
		$Output .= "\n// ]]>\n</script>\n";

		return $Output;
	}
}
<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->viewdata["sidebar"] = $this->sidebar();
	}

	function sidebar_val() {
		return $sidebar = array(
	"dashboard" => array(
		"name" => _("Dashboard"),
		"level" => "members",
		"content" => array(
			"index" => array("level" => "members", "name" => "Dashboard"),
		)
	),
	"comics" => array(
		"name" => _("Comics"),
		"level" => "mod",
		"content" => array(
			"manage" => array("level" => "mod", "name" => _("Manage")),
			"add_new" => array("level" => "mod", "name" => _("Add new"))
		)
	),
	"members" => array(
		"name" => _("Members"),
		"level" => "mod",
		"content" => array(
			"member" => array("level" => "mod", "name" => _("Member list")),
			"you" => array("level" => "member", "name" => _("Your profile")),
			"teams" => array("level" => "mod", "name" => _("Team list")),
			"home_team" => array("level" => "mod", "name" => _("Home team"))
		)
	),
	"preferences" => array(
		"name" => _("Preferences"),
		"level" => "admin",
		"content" => array(
			"general" => array("level" => "admin", "name" => _("General")),
			"advertising" => array("level" => "admin", "name" => _("Advertising")),
			"server" => array("level" => "admin", "name" => _("Server"))
		)
	)
		);
	}

	public function sidebar() {
		if(!$this->tank_auth->is_logged_in()) return false;
		$result = "";
		foreach ($this->sidebar_val() as $key => $item) {
			if (($this->tank_auth->is_admin() || $this->tank_auth->is_group($item["level"])) && !empty($item)) {
				$result .= '<div class="collection">';
				$result .= '<div class="group">' . $item["name"] . '</div>';
				foreach ($item["content"] as $subkey => $subitem) {
					if (($this->tank_auth->is_admin() || $this->tank_auth->is_group($subitem["level"]))) {
						//if($subitem["name"] == $_GET["location"]) $is_active = " active"; else $is_active = "";
						$is_active = "";
						$result .= '<a href="' . site_url(array("admin", $key, $subkey)) . '"><div class="element' . $is_active . '">' . $subitem["name"] . '</div></a>';
					}
				}
				$result .= '</div>';
			}
		}
		return $result;
	}

}
<?php
namespace Nodefortytwo\Editable\Roles;

trait RoledTrait {

	function roles(){
		return $this->hasMany('Role');
	}
}
<?php
if( $state->count() )
	switch ($state->status)
	{
		case 1:
			if(   is_null($state->application_id) ) $labelType = 'info';
			if( ! is_null($state->application_id) ) $labelType = 'success';
			break;
		case 2:
			$labelType = 'info';
			break;
		case 3:
			$labelType = 'info';
			break;
		case 4:
			$labelType = 'info';
			break;
		case 5:
			$labelType = 'info';
			break;
		case 6:
			$labelType = 'info';
			break;
		case 0:
			$labelType = 'normal';
			break;
		default:
			$labelType = 'normal';
	}

	echo Label::{$labelType}($state->present()->statusText);
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('label_condition'))
{
	function label_condition($cond, $true = 'lang:yes', $false = 'lang:no')
	{
		// Prepare the empty label.
		$label = '<span class="label label-%s">%s</span>';

		// Should strings be translated?
		if (sscanf($true, 'lang:%s', $true_line))
		{
			$true = lang($true_line);
		}
		if (sscanf($false, 'lang:%s', $false_line))
		{
			$false = lang($false_line);
		}

		return ($cond === true)
			? sprintf($label, 'success', $true)
			: sprintf($label, 'danger', $false);
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address_model extends CI_Model
{
	public function __construct()
	{
		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function get_countries($inclusion_list = FALSE, $prepend_us = FALSE)
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		if ($inclusion_list !== FALSE)
		{
			$query = $this->db->where_in('code', $inclusion_list)->order_by('name')->get('master_countries');
		}
		else
		{
			$query = $this->db->order_by('name')->get('master_countries');
		}

		if ($query->num_rows() < 1)
		{
			return array();
		}
		else
		{
			$countries = $query->result_array();

			if ($prepend_us)
			{
				$us = $this->get_country('US');

				return array_merge(array(0 => $us), $countries);
			}
			else
			{
				return $countries;
			}
		}
	}

	public function get_country($code)
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$query = $this->db->where(array('code' => $code))->get('master_countries');

		if ($query->num_rows() < 1)
		{
			return array();
		}
		else
		{
			return $query->row_array();
		}

	}

	public function get_country_name($country_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$query = $this->db->where(array('country_id' => $country_id))->get('master_countries');

		if ($query->num_rows() < 1)
		{
			return "";
		}

		$country = $query->row_array();

		return $country['name'];
	}

	public function get_state_abbreviation($id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$query = $this->db->where(array('id' => $id))->get('master_states');

		if ($query->num_rows() < 1)
		{
			return "";
		}

		$state = $query->row_array();

		return $state['abbreviation'];
	}

	public function get_states()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$query = $this->db->order_by('abbreviation ASC')->get('master_states');

		if ($query->num_rows() < 1)
		{
			return array();
		}

		return $query->result_array();
	}
}

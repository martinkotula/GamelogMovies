<?php
	function get_data(&$query, &$data)
		{
			if($query->num_fields()>0)
  			{
  				foreach($query->result() as $r)
  				{
  					$data[]=$r;
  				}
  			}
  			$query->free_result();			
		}			
?>

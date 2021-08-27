<?php if(count($dbdata)>0){ ?>
	<?php $i=1;foreach ($dbdata as $row){ ?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $row['vehicle_registration']?></td>
			<td><?php echo $row['driver']?></td>
			<td><?php echo $row['time_of_entry']?></td>
			<td><?php echo $row['time_of_exit']?></td>						
			<td><a title="Edit" href="<?php echo base_url('edit-entry/').$row['id'];?>" class="btn btn-rounded btn-sm btn-icon btn-info "><i class="fa fa-edit"></i></a></td>						
		</tr>		
	<?php } ?>
<?php }else{?>
	<tr><td colspan="6" align="center">No record found.</td></tr>
<?php }?>
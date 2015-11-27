<div class="mail-option">
	<div class="btn-group">
		<a class="btn mini tooltips" href="<?php echo base_url().$this->session->userdata('userType').'/news_subscription_email/mail_history_list'; ?>"><i class=" fa fa-refresh"></i>
		</a>
	</div>
	<ul class="unstyled inbox-pagination">
		<li></li>
		<li class="pagination">
		<?php
		if($result['links'])
		{
			echo $result['links']; 
		}
		?>
		</li>
	</ul>
</div>

<div id="accordion">
	<?php
	if(!empty($result['list']))
	{
		$i = $result['page']+1;
		foreach($result['list'] as $row)
		{
			$evenOdd = $i%2;
		?>
		<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i; ?>">
			<table class="table table-inbox table-hover">
            	<tbody>
					<tr <?php if($evenOdd){?> class="unread" <?php } ?>>
                    	<td class="inbox-small-cells" width="5%">
							<?php echo $i; ?>
						</td>
						<td class="view-message  dont-show" width="20%">
						<?php /*?>	<?php //echo $row->email; ?>
						</td>
						<td class="view-message">
						<?php */?>	<?php echo $row->subject; ?>
						</td>
						<td class="view-message text-right">
							<?php echo $row->createDt; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</a>
		<div id="collapseOne<?php echo $i; ?>" class="panel-collapse collapse" style="border-left: 1px solid #ddd;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd; min-height:500px !important;max-height:500px !important; overflow-y:scroll;">
			<div class="panel-body">
				<?php echo $row->message; ?>
			</div>
		</div>
	<?php
			$i++;
		}
	}
	else
	{?>
      
		<div class="data-notfoun alert alert-warning fade in">Data not found </div>
	 <?php
	}
	?>
</div>	

<style>
.pagination strong {background:#ff6c60;
	border:1px solid #ff6c60;
	border-radius:3px;
}

.pagination a{color:#ff6c60;
	border:1px solid #ddd;
	border-radius:3px;
}

.pagination a:hover{background:#ff6c60;
	border:1px solid #ff6c60;
}

.data-notfount{color:#ff6c60;
	font-size:15px;
}
</style>					
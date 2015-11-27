<div class="mail-option">
	<div class="btn-group">
		<a class="btn mini tooltips" href="<?php echo base_url().$this->session->userdata('userType').'/news_subscription_email/unsubscribe_list'; ?>">
			<i class="fa fa-refresh"></i>
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

<table class="table table-inbox table-hover">
	<tbody>
		<?php
		if(!empty($result['list']))
		{
			$i = $result['page']+1;
			foreach($result['list'] as $row)
			{
				$evenOdd = $i%2;
		?>
		<tr <?php if($evenOdd){?> class="unread" <?php } ?>>
			<td class="inbox-small-cells" width="2%"><?php echo $i; ?></td>
			<td class="view-message  dont-show">
				<?php echo $row->subscription_email; ?>
			</td>
		</tr>
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
	</tbody>
</table>


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
<?php
/**
 * Newsletter
 * Author: Fernando Oliveira
 * Version: 2.0 
 * Open Source Contribution :- mailchimp.com, tinyMce, phpMailer, Aman Virk
 * 
**/

$page_title = "Dashboard";
?>
<h1>Newsletter Dashboard</h1>
<h2><span>Newsletters Enviados Recentemente:</span></h2>
<div class="box">
	<table cellpadding="5" class="stats">
		<tr>
			<th>Data de Envio</th>
			<th>Assunto do Email</th>
			<th>Enviado de</th>
			<th>Enviado para</th>
			<th>Aberto por</th>
			<th>Desinscritos</th>
			<th>Pulados</th>
			<th>Ação</th>
		</tr>
		<?php
		$past_sends = $newsletter->get_past_sends($db);
		$x=0;
		foreach($past_sends as $send){ 
			if($x++>5)break;
			$n = $newsletter->get_newsletter($db,$send['newsletter_id']);
			$send = $newsletter->get_send($db,$send['send_id']);
			?>
		<tr>
			<td>
				<?php echo date("d/m/Y H:i:s",$send['start_time']);?>
			</td>
			<td>
				<?php echo $n['subject'];?>
			</td>
			<td>
				&lt;<?php echo $n['from_name'];?>&gt; <?php echo $n['from_email'];?> 
			</td>
			<td>
				<?php echo count($send['sent_members']);?> membro(s)
			</td>
			<td>
				<?php echo count($send['opened_members']);?> membro(s)
			</td>
			<td>
				<?php echo count($send['unsub_members']);?> membro(s)
			</td>
			<td>
				<?php echo count($send['bounce_members']);?> membro(s)
			</td>
			<td>
				<a href="?p=open&newsletter_id=<?php echo $n['newsletter_id'];?>" class="submit gray">Abrir Newsletter</a>
				<a href="?p=stats&newsletter_id=<?php echo $n['newsletter_id'];?>&send_id=<?php echo $send['send_id'];?>" class="submit orange">Ver Status</a>
			</td>
		</tr>
		<?php } ?>
		
	</table>
</div>


<h2><span>Membros Recentes:</span></h2>

<div class="box">
	<table cellpadding="5" class="stats">
		<tr>
			<th>Endereco de Email</th>
			<th>Nome</th>
			<th>Sobrenome</th>
			<th>Data Cadastro</th>
			<th>Número Envios</th>
			<th>Número Abertos</th>
			<th>Número Pulados</th>
			<th>Grupo</th>
			<th>Campanha</th>
			<th>Ação</th>
		</tr>
		<?php
		$groups = $newsletter->get_groups($db);
		$members = $newsletter->get_members($db,false,true,5);
		//foreach($members as $member){ 
		while($member = mysql_fetch_assoc($members)){ 
			$member = $newsletter->get_member($db,$member['member_id']);
			?>
		<tr>
				<td>
					<?php echo _shl($member['email'],$search['email']);?>
				</td>
				<td>
					<?php echo _shl($member['first_name'],$search['name']);?>
				</td>
				<td>
					<?php echo _shl($member['last_name'],$search['name']);?>
				</td>
				<td>
					<?php echo date('d/m/Y', strtotime($member['join_date']));?>
				</td>
				<td>
					<?php echo count($member['sent']);?> newsletter(s)
				</td>
				<td>
					<?php echo count($member['opened']);?> newsletter(s)
				</td>
				<td>
					<?php echo count($member['bounces']);?> vez(es)
				</td>
				<td>
					<?php
					$print = '';
					foreach($member['groups'] as $group_id){
						$print .=  '<a href="?p=groups&edit_group_id='.$group_id.'">';
						if(isset($search['group_id'][$group_id])){
							$print .= '<span style="background-color:#FFFF66">';
							$print .= $groups[$group_id]['group_name'];
							$print .= '</span>';
						}else{
							$print .= $groups[$group_id]['group_name']."";
						}
						$print .= '</a>,';
					}
					echo rtrim($print,",");
					?>
				</td>
				<td>
					<?php
					$print = '';
					foreach($member['campaigns'] as $campaign){
						$print .=  '<a href="?p=campaign_open&campaign_id='.$campaign['campaign_id'].'">';
						$print .= $campaign['campaign_name']."";
						$print .= '</a>,';
					}
					echo rtrim($print,",");
					?>
				</td>
				<td>
					<a href="?p=members&edit_member_id=<?php echo $member['member_id'];?>" class="submit gray">Editar Membro</a>
					<a href="?p=members&delete_member_id=<?php echo $member['member_id'];?>" onclick="if(confirm('Deseja mesmo deletar esse membro?'))return true;else return false;" class="submit orange">Deletar</a>
				</td>
			</tr>
		<?php } ?>
		
	</table>
</div>



<h2><span>Envios Pendentes:</span></h2>

<div class="box">
	<table cellpadding="5" class="stats">
		<tr>
			<th>Newsletter</th>
			<th>Enviando</th>
			<th>Progresso</th>
			<th>Ação</th>
		</tr>
		<?php
		$sends = $newsletter->get_pending_sends($db);
		foreach($sends as $send){
			?>
			<tr>
				<td><?php echo $send['subject'];?></td>
				<td><?php echo $send['start_date'];?></td>
				<td><?php echo $send['progress'];?></td>
				<td><a href="?p=send&send_id=<?php echo $send['send_id'];?>">Continuar Envio</a></td>
			</tr>
			<?php
		}
		?>
	</table>
</div>
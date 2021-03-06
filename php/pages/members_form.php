<?php
/**
 * Newsletter
 * Author: Fernando Oliveira
 * Version: 2.0 
 * Open Source Contribution :- mailchimp.com, tinyMce, phpMailer, Aman Virk
 * 
**/

// shared between members.php and members_add.php
if(!$member_data)$member_data = array();
$groups = $newsletter->get_groups($db);
$campaigns = $newsletter->get_campaigns($db);
$member_fields = $newsletter->get_member_fields($db);

?>
<!--  Hate tables but need them -->
<table cellpadding="5">
		<tr>
			<td width="200px;">
				<label>Email</label>
			</td>
			<td width="300px;">
				<div class="form_field"><input type="text" name="mem_email" id="email" value="<?php echo $member_data['email'];?>"></div>
			</td>
		</tr>
		<tr>
			<td>
				<label>Nome</label>
			</td>
			<td>
				<div class="form_field"><input type="text" name="mem_first_name" id="first_name" value="<?php echo $member_data['first_name'];?>"></div>
			</td>
		</tr>
		<tr>
			<td>
				<label>Sobrenome</label>
			</td>
			<td>
				<div class="form_field"><input type="text" name="mem_last_name" id="last_name" value="<?php echo $member_data['last_name'];?>"></div>
			</td>
		</tr>
                <tr>
                    <td><label>Campos Personalizados:</label></td>
                    <td>(Obs: Somente se extremo necessário)</td>
                </tr>
		<tr>
			<td>
				Nome do Campo:
			</td>
			<td>
				Valor do Campo:
			</td>
		</tr>
		<?php
		foreach($member_fields as $member_field){
			?>
			<tr>
				<td>
					<b><?php echo $member_field['field_name'];?>
					<?php if($member_field['required']){ ?></b>
					<span class="required">*</span>
					<?php } ?>
				</td>
				<td>
					<div class="form_field"><input type="text" name="mem_custom_val[<?php echo $member_field['field_name'];?>]" value="<?php echo $member_data['custom'][$member_field['member_field_id']]['value'];?>"></div>
				</td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td>
				<div class="form_field"><input type="text" name="mem_custom_new_key" value=""></div>
			</td>
			<td>
				<div class="form_field"><input type="text" name="mem_custom_new_val" value=""></div>
			</td>
		</tr>
		<tr>
			<td>
				<label>Grupos</label>
			</td>
			<td>
				<?php
				foreach($groups as $group){ ?>
				<input type="checkbox" name="group_id[]" value="<?php echo $group['group_id'];?>" <?php echo ($member_data['groups'][$group['group_id']])?'checked':'';?>> <?php echo $group['group_name'];?> <br>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td>
				<label>Campanhas</label>
			</td>
			<td>
				<?php
				foreach($campaigns as $campaign){ ?>
				<input type="checkbox" name="campaign_id[]" value="<?php echo $campaign['campaign_id'];?>" <?php echo ($member_data['campaigns'][$campaign['campaign_id']])?'checked':'';?>> <?php echo $campaign['campaign_name'];?> <br>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td>
				
			</td>
			<td>
				 <input type="submit" name="save" value="Salvar Detalhes" class="submit green">
			</td>
		</tr>
	</table>
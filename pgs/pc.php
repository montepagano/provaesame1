<?php 
	$msg='';
	$id = (!empty($_REQUEST['id'])) ? intval($_REQUEST['id']) : false;
	$macchina=(empty($_REQUEST['id'])) ?  R::dispense('pc') : R::load('pc', intval($_REQUEST['id']));
	if (!empty($_REQUEST['hostname'])) : 
		$macchina->hostname=$_POST['hostname'];
		$macchina->marche_id=$_POST['marche_id'];
		$macchina->modello=$_POST['modello'];
		$macchina->sn=$_POST['sn'];
		
		try {
			R::store($macchina);
			$msg='Dati salvati correttamente ('.json_encode($macchina).') ';
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;	
	
	if (!empty($_REQUEST['del'])) : 
		$macchina=R::load('pc', intval($_REQUEST['del']));
		try{
			R::trash($macchina);
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;
	if(!($id))$pin=true; else $pin=$id;
	$pc=R::findAll('pc', 'ORDER by id ASC LIMIT 999');
	$marche=R::findAll('marche');
	$interventi=R::findAll('listainterventi','where id='.$pin);
	
	$new=!empty($_REQUEST['create']);
	
?>

<h1>
	<a href="index.php">
		<?=($id) ? ($new) ? 'Nuovo macchina' : 'Macchina n. '.$id : 'PC';?>
	</a>
</h1>
<?php if ($id || $new) : ?>
		<form method="post" action="?p=pc">
			<?php if ($id) : ?>
				<input type="hidden" name="id" value="<?=$macchina->id?>" />
			<?php endif; ?>
			<label for="hostname">
				Hostname
			</label>
			<input name="hostname"  value="<?=$macchina->hostname?>" autofocus required  />

			<label for="modello">
				Modello
			</label>
			<input name="modello"  value="<?=$macchina->modello?>" autofocus required />
			
			<label for="marche_id">
				Marche
			</label>
			<select name="marche_id">
				<option />
				<?php foreach ($marche as $a) : ?>
					<option value="<?=$a->id?>" <?=($a->id==$id) ? 'selected' :'' ?> >
						<?=$a->marca?>
					</option>
				<?php endforeach; ?>
			</select>
			<label for="sn">
				sn
			</label>			
			<input name="sn"  value="<?=$macchina->sn?>" />			
			
			<button type="submit" tabindex="-1">
				Salva
			</button>
			
			<a href="?p=pc" >
				Elenco
			</a>	
			<h3>Interventi eseguiti sul pc</h3>

			<div class="tablecontainer">
		<table style="table-layout:fixed">
			<colgroup>
				<col style="width:150px" />
			</colgroup>
			<thead>
				<tr>
				
					<th>Data e ora</th>
					<th>Descrizione</th>
					<th>ore</th>
					<th>Spesa</th>
				</tr>
			</thead>
			<tbody>
					<?php foreach ($interventi as $r) : ?>
				<tr>
					<td>
							<?=($r->pc_id) ? $r->pc->sn : ''?>
					</td>			
					<td>
						<?=date('d/m/Y',strtotime($r->dataintervento))?>
					</td>
					<td>
						<?=$r->descrizione?>
					</td>
					<td style="text-align:right" >
						<?=$r->ore?>
					</td>	
					<td style="text-align:right" >
						<?=$r->spesa?>
					</td>								
				</tr>		
			<?php endforeach; ?>
			</tbody>
		</table>
		<h4 class="msg">
			<?=$msg?>
		</h4>	
	</div>			
<?php else : ?>
	<div class="tablecontainer">
		<table style="table-layout:fixed">
			<colgroup>
				<col style="width:150px" />
			</colgroup>
			<thead>
				<tr>
					<th>Marche</th>
					<th>Hostname</th>
					<th>Modello</th>
					<th>sn</th>
					<th style="width:60px;text-align:center">Modifica</th>
					<th style="width:60px;text-align:center">Cancella</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($pc as $r) : ?>
				<tr>
					<td>
							<?=($r->marche_id) ? $r->marche->marca : ''?>
					</td>			
					<td>
						<?=$r->hostname?>
					</td>
					<td>
						<?=$r->modello?>
					</td>
					<td style="text-align:right" >
						<?=$r->sn?>
					</td>					
					<td style="text-align:center" >
						<a href="?p=pc&id=<?=$r['id']?>">
							Mod.
						</a>
					</td>
					<td style="text-align:center" >
						<a href="?p=pc&del=<?=$r['id']?>" tabindex="-1">
							x
						</a>
					</td>							
				</tr>		
			<?php endforeach; ?>
			</tbody>
		</table>
		<h4 class="msg">
			<?=$msg?>
		</h4>	
	</div>
	<a href="?p=pc&create=1">Inserisci nuovo</a>		
<?php endif; ?>

<script>
	var chg=function(e){
		console.log(e.name,e.value)
		document.forms.frm.elements[e.name].value=(e.value) ? e.value : null
	}	
</script>
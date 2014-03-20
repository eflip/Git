<div id="git_tools">
	<h3>Tools</h3>
	<form action="%appurl%" method="post">
		<a title="Click to manage your repositories" href="%appurl%repo">Repo</a>: 
		<select name="newgitpath" />
			<?php if(is_dir(ROOT.'../.git')) : ?>
			<optgroup label="System">
				<option value="<?=ROOT;?>..">LittlefootCMS</option>
			</optgroup>
			<?php endif; ?>
			<optgroup label="Apps"><?=$app_options;?></optgroup>
			<optgroup label="Skins"><?=$skin_options;?></optgroup>
		</select> 
		<input type="submit" value="Change Repo" />
	</form>
	<form action="%appurl%pushpull" method="post">
		<a href="%appurl%remotes">Remotes</a>: <select name="remote" id=""><?=$remotes;?></select> 
			/ <input type="text" name="branch" placeholder="master" />
			<input type="submit" name="direction" value="pull" />
			<input type="submit" name="direction" value="push" /> 
	</form>
	<form action="%appurl%tag" method="post">
		<a href="%appurl%tags">Tag</a>: <input type="text" name="tag" placeholder="Tag (STABLE, DEV)" />
	</form>
</div>

<h3>Branches</h3>
<form action="%appurl%create" method="post">
	Create a new branch: <input type="text" name="newbranch" placeholder="New branch name"/> 
	<input type="submit" value="Create" />
</form>
<ul>
	<?php if($current == NULL): ?>
	<li><form action="%appurl%commit" method="post"><strong>Not currently on any branch</strong> <input type="text" name="commit_text" placeholder="Commit text"/> <input type="submit" value="Commit" /><?=$pull;?> <span><?=$branch;?><span></form></li>
	<?php endif; 
	
	foreach($branches as $branch)
	{
		$pull = ''; 
		$parts = explode('/', $branch);
		$branch = substr($branch, 0, 7);
		/*if($parts[2] != 'master') $pull = '
			<form action="%appurl%pullrequest/'.$parts[2].'">
				<input type="text" name="ticketid" placeholder="Ticket ID" />
				<input type="submit" value="Submit pull request" />
			</form>';*/
		
		if($parts[2] == $current) 
		{
			?><li class="git_current_branch">
				<form action="%appurl%commit" method="post">
					<strong><?=$parts[2];?></strong> 
					<input type="text" name="commit_text" placeholder="Commit text"/> 
					<input type="submit" value="Commit" /><?=$pull;?>
					<span style="float: right">(<a href="%appurl%history">view history</a>) <?=$branch;?></span></form>
					<div class="git_current_tools"><?=$update;?></div>
			</li><?php
		}
		else
		{
			$delete = '';
			if($parts[2] != 'master') 
				$delete = ' [<a '.jsprompt('Are you sure you want to delete ['.$parts[2].']?').'  href="%appurl%rm/'.$parts[2].'">Delete</a>]';
			echo '<li><a href="%appurl%checkout/'.$parts[2].'">'.$parts[2].'</a> '.$delete.$pull.'<span style="float: right">'.$branch.'</span></li>';
		}
	}?>
</ul>
		
<h4>Status</h4>
<?php 
echo nl2br($status);

// print any message set before last call, then unset
if(isset($_SESSION['git_msg']))
{
	echo '<span class="git_msg">';
	echo nl2br($_SESSION['git_msg']);
	echo '</span>';
	unset($_SESSION['git_msg']);
}?>
<?php
// so we use the paginator object the shorter way.
// instead of using '$this->Paginator' everytime, we'll use '$paginator'
$paginator = $this->Paginator;
?>
<div class="row">
	<div class="col-md-6">
		<h3>BLOG POST</h3>
	</div>
</div>
<div class="col-md-6 text-left">
	<div>
		<?php echo $this->Html->link(
				'Add Post', ['action' => 'add'],['class' => 'btn btn-primary']
		); ?>
	</div>
</div>
<br>
<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Author</th>
		<th>Action</th>
		<th>Created</th>
	</tr>
	</thead>
	<tbody>
	<!-- Here is where we loop through our $posts array, printing out post info -->
	<?php foreach ($posts as $post): ?>
		<tr>
			<td><?php echo $post['Post']['id']; ?></td>
			<td>
				<?php echo $this->Html->link($post['Post']['title'],
					array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?>
			</td>
			<td><?php echo $post['Author']['username']; ?> </td>
			<td>
				<?php
				echo $this->Form->postLink(
					'Delete',
					array('action' => 'delete', $post['Post']['id']),
					array('confirm' => 'Are you sure?')
				);
				?>
				<?php
				echo $this->Html->link(
					'Edit',
					array('action' => 'edit', $post['Post']['id'])
				);
				?>
			</td>
			<td><?php echo $post['Post']['created']; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php
echo "<div class='paging'>";

// the 'first' page button
echo $paginator->first("First");

// 'prev' page button,
// we can check using the paginator hasPrev() method if there's a previous page
// save with the 'next' page button
if($paginator->hasPrev()){
	echo $paginator->prev("Prev");
}

// the 'number' page buttons
echo $paginator->numbers(array('modulus' => 2));

// for the 'next' button
if($paginator->hasNext()){
	echo $paginator->next("Next");
}

// the 'last' page button
echo $paginator->last("Last");

echo "</div>";
?>

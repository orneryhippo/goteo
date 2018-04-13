<ul class="filters list-inline center-block text-center">
	<?php foreach ($this->blog_sections as $key => $section_value) : ?>
		<?php $icon= $key=='matchfunding' ? 'icon-call' : 'icon-'.$key ?>
		<?php if($this->section == $key): ?>
			<?php $description= $section_value.'-description'; ?>
		<?php endif; ?>
	    <a href="<?= '/blog-section/' . $key ?>" >
	        <li class="<?php if ($this->section == $key) echo 'active' ?>">
	        	<span class="block icon icon-3x <?= $icon ?>"></span>
	        	<br>
	            <span><?= $this->text($section_value) ?></span>
	        </li>
	    </a>
	<?php endforeach; ?>
</ul>
 <div class="section list-posts container">
 	<div class="description">
 		<?= $this->text($description) ?>
 	</div>
 	<div class="row">
	 	<?php foreach($this->list_posts as $post): ?>
	 	<div class="col-md-4">
	 		<?= $this->insert('post/widgets/normal', [
	            'post' => $post
	        ]) ?>
	 	</div>
	 	<?php endforeach; ?>
 	</div>
 </div>
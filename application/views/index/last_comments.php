<?php foreach($view->comments as $comment): ?>
	<?= 'Par <b><a href="' . $view->base_url . 'profile/' . $comment->getUser()->getId() . '">' . $comment->getUser()->prop('username') . '</a></b> : ' . $comment->prop('content') . ' &bull; <a href="' . $view->base_url . 'spritecomics/gallery/details/' . $comment->getFile()->getId() . '">' . $comment->getFile()->prop('name') . '</a><br />'; ?>
<?php endforeach; ?>
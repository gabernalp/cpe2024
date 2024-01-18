<tr>
<td class="header">
<a href="<?php echo e($url); ?>" style="display: inline-block;">
<?php if(trim($slot) === 'Laravel'): ?>
<div align="center"><img src="<?php echo e(env('APP_URL')); ?>/images/logoseo.png" class="logo" alt="Logo Conectar para educar"></div>
<?php else: ?>
<p><img src="<?php echo e(env('APP_URL')); ?>/images/logoseo.png" class="logo" alt="Logo Conectar para educar"></p>
<?php echo e($slot); ?>

<?php endif; ?>
</a>
</td>
</tr>
<?php /**PATH C:\inetpub\wwwroot\icbf\resources\views/vendor/mail/html/header.blade.php ENDPATH**/ ?>
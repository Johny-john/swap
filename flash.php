<?php
/*
Syntaxe alternatif:
    <?php sturture () : ?>
        .....
        <?php endstruture; ?>
        
     A n'utiliser que pour du templating ( Dans le HTML)
        */ 
?>

<?php foreach(recupererFlash() as $message): ?>
<div class="alert alert-<?= $message['type']; ?>">
    <?= $message['message']; ?>
</div>
<?php endforeach; ?>
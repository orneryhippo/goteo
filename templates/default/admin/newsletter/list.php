<?php $this->layout('admin/layout') ?>

<?php $this->section('admin-content') ?>

<?php

$list = $this->list;
$templates = $this->templates;

?>
<div class="widget board">
    <p>Seleccionar la plantilla. Se utilizará el contenido traducido, quizás quieras <a href="/admin/templates?group=massive" target="_blank">revisarlas</a></p>
    <p><strong>NOTA:</strong> con este sistema no se pueden añadir variables en el contenido, se genera el mismo contenido para todos los destinatarios.<br/>
    Para contenido personalizado hay que usar la funcionalidad <a href="/admin/mailing" >Comunicaciones</a>.</p>

    <form action="/admin/newsletter/init" method="post" onsubmit="return confirm('El envio NO se activará automáticamente. Puedes revisar el contenido y destinatarios y enviarlo después');">

    <p>
        <label>Plantillas masivas:
            <select id="template" name="template" >
            <?php foreach ($templates as $tplId=>$tplName) : ?>
                <option value="<?php echo $tplId; ?>" <?php if ( $tplId == $tpl) echo 'selected="selected"'; ?>><?php echo $tplName; ?></option>
            <?php endforeach; ?>
            </select>
        </label>
    </p>
    <p>
        <label><input type="checkbox" name="test" value="1" checked="checked"/> Es una prueba (se envia a los destinatarios de pruebas)</label>
    </p>

    <p>
        <label><input type="checkbox" name="nolang" value="1" checked="checked"/>Solo en español (no tener en cuenta idioma preferido de usuario)</label>
    </p>

    <p>
        <input type="submit" name="init" value="Iniciar" />
    </p>

    </form>
</div>

<?php if ($list) : ?>
<div class="widget board">
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Fecha</th>
                <th>Asunto</th>
                <th>Estado</th>
                <th>% envío</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $item) : ?>
            <tr>
                <td><a href="/admin/newsletter/detail/<?php echo $item->id; ?>">[Detalles]</a></td>
                <td><?php echo $item->date; ?></td>
                <td><?php echo $item->subject; ?></td>
                <td><?php echo $item->active ? '<span style="color:green;font-weight:bold;">Activo</span>' : '<span style="color:red;font-weight:bold;">Inactivo</span>'; ?></td>
                <td><span class="mailing_status" data-id="<?= $item->id ?>" <?= $item->blocked ? ' style="color:red;font-weight:bold;"' : '' ?>><?= number_format($item->getStatus()->percent,2,',','') ?> %</span></td>
                <td><a href="<?php echo $item->getLink(); ?>" target="_blank">[Visualizar]</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>


<?php $this->replace() ?>

<?php $this->section('footer') ?>
<script type="text/javascript">
    $(function(){
        var reloadPage = function() {
            $('#admin-content').load('/admin/newsletter/list/ #admin-content');
            setTimeout(reloadPage, 2000);
        };
        setTimeout(reloadPage, 2000);
    });
</script>
<?php $this->append() ?>

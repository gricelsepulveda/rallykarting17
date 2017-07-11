<table border="1">
<?php //print_r($drivers);
foreach($drivers as $key => $value)
{
?>
    <tr>
    <td><?php echo $key; ?></td>
    <?php
    foreach($value as $k => $v) {
    ?>
        <td>
            Mejor Tiempo: <?php echo substr($v->duration, 0,11); ?> <br>
            Total Vueltas: <?php echo $v->total_laps; ?> <br>
            Tiempo Total: <?php echo substr($v->total_time->total, 0, 6); ?>
        </td>
    <?php
    }
    ?>
    </tr>
<?php
}
?>
</table>

<br><br>

<?php
if(isset($me) && !empty($me))
{
?>
    <table border="1">
        <tr>
            <?php
            foreach($me as $k => $v) {
            ?>
                <td><?php echo $k; ?></td>
                <td>
                    Mejor Tiempo: <?php echo $v[0]->duration; ?> <br>
                    Total Vueltas: <?php echo $v[0]->total_laps; ?> <br>
                    Tiempo Total: <?php echo $v[0]->total_time; ?>
                </td>
            <?php
            }
            ?>
        </tr>
    </table>
<?php
}
?>

<?php
    require_once 'secure.php';

    $header = 'Главная: Ваше расписание занятий.';
    $userIdentity = (new UserMap())->identity($_SESSION['id']);
    if ($userIdentity == UserMap::TEACHER) {
        $schedules = (new ScheduleMap())->findByTeacherId($_SESSION['id']);
    } 
    elseif ($userIdentity == UserMap::STUDENT) {
        //здесь должен быть ваш код
        $schedules = (new ScheduleMap())->findByUserId($_SESSION['id']);
        // print_r($schedules);
    } 
    else {
        $schedules = null;
    }

    require_once 'template/header.php';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <section class="box-body">
                <h3><?= $header; ?></h3>
            </section>
            <div class="box-body">
                <?php if ($schedules) : ?>
                    <table class="table table-bordered table-hover">
                        <?php foreach ($schedules as $day) : ?>
                            <tr>
                                <th colspan="3">
                                    <h4 class="center-block">
                                        <?= $day['name']; ?>
                                    </h4>
                                </th>
                            </tr>
                            <?php if ($day['gruppa']) : ?>
                                <?php foreach ($day['gruppa'] as $gruppa) : ?>
                                    <tr>
                                        <th colspan="3"><?= $gruppa['name']; ?></th>
                                    </tr>
                                    <?php foreach ($gruppa['schedule'] as $schedule) : ?>
                                        <tr>
                                            <td><?= $schedule['lesson_num']; ?></td>
                                            <td><?= $schedule['subject']; ?></td>
                                            <td><?= $schedule['classroom']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            
                            <?php elseif ($day['lesson']) : ?>
                                <?php foreach ($day['lesson'] as $lesson) : ?>
                                        <tr>
                                            <td><?= $lesson['lesson_num']; ?></td>
                                            <td><?= $lesson['subject']; ?></td>
                                            <td><?= $lesson['classroom']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                            <?php else : ?>
                                <tr>
                                    <td colspan="3">Отcутствует расписание на этот день</td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </table>
                <?php else : ?>
                    <p>Для Вас расписание отcутствует</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
    require_once 'template/footer.php';
?>
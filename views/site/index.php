<?php

/**
 * @var yii\web\View $this
 * @var $data
 * @var $depth
 * @var $background
 */

$this->title = 'My Yii Application';
?>


<div class="site-index">

    <div class="body-content">

        <div class="row">
            <ul id="list" style="<?= $background ?>;">
                <?php foreach ($data as $item) { ?>
                    <li>
                        <?= $item['name'] ?>
                        <ul>
                            <li>
                                <?= $item['value']['type'] ?>
                            </li>
                            <?php if ($depth > 1) { ?>
                                <li>
                                    <ul>
                                        <li><?= $item['value']['depth']['value'] ?></li>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php
                } ?>
            </ul>
        </div>

    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#list > li').click(function (event) {
            $(this).children("ul").slideToggle();
            event.stopPropagation();
        });
    });
</script>

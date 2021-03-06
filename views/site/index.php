<?php

/**
 * @var yii\web\View $this
 * @var $data
 * @var $depth
 * @var $background
 */

$this->title = 'Test';
?>


<div class="site-index">

    <div class="body-content">

        <div class="row">
            <ul id="list" style="<?= $background ?>;">
                <?php foreach ($data as $item) { ?>
                    <li>
                        <?= $item['name'] ?>
                        <?php if ($depth > 0) { ?>
                        <ul>
                            <li>
                                <?= $item['value']['type'] ?>
                            </li>
                            <?php if ($depth > 1 && $depth < 3) { ?>
                                <li>
                                    <ul>
                                        <li><?= $item['value']['depth']['value'] ?></li>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </li>
                    <?php
                } ?>
            </ul>
        </div>

    </div>
</div>

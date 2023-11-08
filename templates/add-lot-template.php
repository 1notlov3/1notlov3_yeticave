
<main>
    <nav class="nav">
        <ul class="nav__list container">
            <li class="nav__item">
                <a href="all-lots.html">Доски и лыжи</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Крепления</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Ботинки</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Одежда</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Инструменты</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Разное</a>
            </li>
        </ul>
    </nav>
    <form class="form form--add-lot container <?php if(count($errors)): ?>form--invalid<?php endif; ?>" action="add-lot.php" enctype="multipart/form-data" method="POST">
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item <?= isset($errors['title']) ? "form__item--invalid" : "" ?>">
                <label for="lot-name">Наименование <sup>*</sup></label>
                <input id="lot-name" type="text" name="title" placeholder="Введите наименование лота" value="<?=getPostVal('title');?>">
                <?php if(isset($errors['title'])): ?>
                    <span class="form__error"><?= $errors['title'] ?></span>
                <?php endif; ?>
            </div>
            <div class="form__item <?php if(isset($errors['category_id'])): ?>form__item--invalid<?php endif; ?>">
                <label for="category">Категория <sup>*</sup></label>
                <select id="category" name="category_id">
                    <option value="0">Выберите категорию</option>
                    <?php foreach ($categories as $category):?>
                        <option value="<?= $category['id']?>"<?php echo getPostVal('category_id') == $category['id']? 'selected' : '' ?>><?= $category['title']?></option>
                    <?php endforeach;?>
                </select>
                <?php if(isset($errors['category_id'])): ?>
                    <span class="form__error"><?= $errors['category_id'] ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="form__item form__item--wide <?php if(isset($errors['description'])): ?>form__item--invalid<?php endif; ?>">
            <label for="message">Описание <sup>*</sup></label>
            <textarea id="message" name="description" placeholder="Напишите описание лота"><?=getPostVal('description');?></textarea>
            <?php if(isset($errors['description'])): ?>
                <span class="form__error"><?= $errors['description'] ?></span>
            <?php endif; ?>
        </div>
        <div class="form__item form__item--file <?php if(isset($errors['photo'])): ?>form__item--invalid<?php endif; ?>">
            <label for="lot-img">Изображение <sup>*</sup></label>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="lot-img" name="photo">
                <label for="lot-img">
                    Добавить
                </label>
                <?php if(isset($errors['photo'])): ?>
                    <span class="form__error"><?= $errors['photo'] ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="form__container-three">
            <div class="form__item form__item--small <?php if(isset($errors['price'])): ?>form__item--invalid<?php endif; ?>">
                <label for="lot-rate">Начальная цена <sup>*</sup></label>
                <input id="lot-rate" type="text" name="price" placeholder="0" value="<?=getPostVal('price')?>">
                <?php if(isset($errors['price'])): ?>
                    <span class="form__error"><?= $errors['price'] ?></span>
                <?php endif; ?>
            </div>
            <div class="form__item form__item--small <?php if(isset($errors['step'])): ?>form__item--invalid<?php endif; ?>">
                <label for="lot-step">Шаг ставки <sup>*</sup></label>
                <input id="lot-step" type="text" name="step" placeholder="0" value="<?=getPostVal('step')?>">
                <?php if(isset($errors['step'])): ?>
                    <span class="form__error"><?= $errors['step'] ?></span>
                <?php endif; ?>
            </div>
            <div class="form__item <?php if(isset($errors['date_end'])): ?>form__item--invalid<?php endif; ?>">
                <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
                <input class="form__input-date" id="lot-date" type="text" name="date_end" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=getPostVal('date_end')?>">
                <?php if(isset($errors['date_end'])): ?>
                    <span class="form__error"><?= $errors['date_end'] ?></span>
                <?php endif; ?>
            </div>
        </div>
        <?php if(count($errors)): ?>
            <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <?php endif; ?>
        <button type="submit" class="button">Добавить лот</button>
    </form>

</main>
